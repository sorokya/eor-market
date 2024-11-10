$(function() {
  $.ajaxSetup({
    xhrFields: {
      withCredentials: true
    },
    dataType: 'json'
  });

  $('#btn-logout').click(function() {
    $.post('/api/logout.php', function() {
      window.location = '/';
    });
  });

  setupLoginForm();
  setupSignupModal();
  setupAddModal();

  if (window.location.pathname === '/') {
    loadItems();
  }

  if (window.location.pathname === '/manage.php') {
    loadMyItems();
  }
});

function loadItems() {
  const $results = $('#results');
  $results.html('<h1>No items yet</h1>');


  $.get('/api/list-items.php', function(res) {
    if (res.error) {
      if (res.error !== 'No results') {
        showError(res.error);
      }
      return;
    }

    $results.empty();

    res.data.forEach(function(item) {
      const $item = $(document.createElement('div'));
      $item.addClass('item');

      $item.append(`<strong class="item-name">${item.name}</strong>`);
      $item.append(`<img src="https://eor-api.exile-studios.com/api/items/${item.id}/graphic/ground"/>`);
      $item.append(`<p>Available: <strong>${item.amount}</strong></p>`);
      $item.append(`<p>Price: <strong>${item.price}</strong></p>`);

      $item.click(function() {
        window.location = `/listings.php?id=${item.id}`;
      });

      $results.append($item);
    });
  });
}

function loadMyItems() {
  const $results = $('#results');
  $results.html('<h1>No items yet</h1>');

  const $dialog = $('#dialog-update');
  const $preview = $dialog.find('#add-item-preview');

  const $saleForm = $dialog.find('#form-make-sale');
  const $saleBuyName = $saleForm.find('[name="buy-name"]');
  const $saleAmount = $saleForm.find('[name="buy-amount"]');
  const $saleTotal = $saleForm.find('[name="buy-total"]');

  const $updateForm = $dialog.find('#form-update-item');
  const $updateAmount = $updateForm.find('[name="amount"]');
  const $updatePrice = $updateForm.find('[name="price"]');

  const $btnDeleteItem = $dialog.find('#btn-delete-item');
  const $btnUpdateItem = $dialog.find('#btn-update-item');

  $.get('/api/list-my-items.php', function(res) {
    if (res.error) {
      if (res.error !== 'No results') {
        showError(res.error);
      }
      return;
    }

    $results.empty();

    res.data.forEach(function(item) {
      const $item = $(document.createElement('div'));
      $item.addClass('item');

      $item.append(`<strong class="item-name">${item.name}</strong>`);
      $item.append(`<img src="https://eor-api.exile-studios.com/api/items/${item.id}/graphic/ground"/>`);
      $item.append(`<p>Amount: <strong>${item.amount}</strong></p>`);
      $item.append(`<p>Price: <strong>${item.price}</strong></p>`);

      $item.click(function() {
        $preview.find('img').attr('src', `https://eor-api.exile-studios.com/api/items/${item.id}/graphic/ground`);
        $preview.find('.item-name').text(item.name);

        $saleAmount.val(item.amount);
        $saleTotal.val(item.amount * item.price);
        $saleBuyName.val('');

        $updateAmount.val(item.amount);
        $updatePrice.val(item.price);

        $btnDeleteItem.unbind('click').click(function(e) {
          e.preventDefault();
          Swal.fire({
            title: 'Are you sure?',
            text: `Your ${item.name} will be removed from the market`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it!',
          }).then(function(result) {
            if (result.isConfirmed) {
              $.post('/api/remove-item.php', {
                id: item.id,
              }, function(res) {
                if (res.error) {
                  showError(res.error);
                  return;
                }

                $dialog.dialog('close');

                loadMyItems();
              });
            }
          });
        });

        $btnUpdateItem.unbind('click').click(function(e) {
          e.preventDefault();

          updateSubmit({
            id: item.id,
            price: parseInt($updatePrice.val().trim(), 10),
            amount: parseInt($updateAmount.val().trim(), 10),
          });

          return;
        });

        $saleForm.unbind('submit').submit(function(e) {
          e.preventDefault();

          saleSubmit({
            id: item.id,
            buyer: $saleBuyName.val().trim(),
            amount: parseInt($saleAmount.val().trim(), 10),
            total: parseInt($saleTotal.val().trim(), 10),
          });
        });

        $dialog.dialog({
          title: 'Manage Listing',
          modal: true,
          width: 700,
          height: 420,
        });
      });

      $results.append($item);
    });
  });

  function updateSubmit(item) {
    if (!item.price || item.price < 1) {
      showError('Price can not be less than 1');
      return;
    }

    if (!item.amount || item.amount < 1) {
      showError('Amount can not be less than 1');
      return;
    }

    $.post('/api/update-item.php', item, function(res) {
      if (res.error) {
        showError(res.error);
        return;
      }

      showSuccess('Your item has been updated. Good luck!');
      loadMyItems();
      $dialog.dialog('close');
    });
  }

  function saleSubmit(sale) {
    if (sale.buyer.length < 3 || sale.buyer.length > 12) {
      showError('Buyer name must be between 3 and 12 characters');
      return;
    }

    if (!sale.amount || sale.amount < 1) {
      showError('Amount can not be less than 1');
      return;
    }

    if (!sale.total || sale.total < 1) {
      showError('Total can not be less than 1');
      return;
    }

    $.post('/api/make-sale.php', sale, function(res) {
      if (res.error) {
        showError(res.error);
        return;
      }

      showSuccess('Your sale has been submitted!');
      loadMyItems();
      $dialog.dialog('close');
    });
  }
}

let ITEM_LIST = [];
function getItemList(callback) {
  if (ITEM_LIST.length > 0) {
    return callback(ITEM_LIST);
  }

  $.get({
    url: '/api/get-item-list.php',
    xhrFields: {
      withCredentials: false
    },
    dataType: 'json',
    success: function(res) {
      if (res.error) {
        showError(res.error);
      } else {
        ITEM_LIST = res.data;
        callback(ITEM_LIST);
      }
    }
  });
}

function setupAddModal() {
  const $dialog = $('#dialog-add');
  const $btnAdd = $('#btn-add');
  const $search = $dialog.find('[name="item-name"]');
  const $results = $dialog.find('#add-item-search-results');
  const $searchForm = $dialog.find('#dialog-item-search');
  const $addForm = $dialog.find('#dialog-item-add');
  const $imgAddItem = $addForm.find('img');
  const $nameAddItem = $addForm.find('.item-name');
  const $amount = $addForm.find('[name="amount"]');
  const $price = $addForm.find('[name="price"]');
  const $btnCancel = $addForm.find('[type="button"]');

  function renderResults() {
    $results.empty();
    getItemList(function(items) {
      let filteredItems = items.filter(function(item) {
        return item.name.indexOf('-res') === -1 && item.id > 2 && item.name.toLowerCase().includes($search.val().toLowerCase());
      });

      if (filteredItems.length === 0) {
        $results.append('<p>No results</p>');
        return;
      }

      if (filteredItems.length > 20) {
        filteredItems = filteredItems.slice(0, 20);
      }

      filteredItems.forEach(function(item) {
        const $item = $(document.createElement('div'));
        $item.addClass('add-item-search-item');

        const $img = $(document.createElement('img'));
        $img.attr('src', `https://eor-api.exile-studios.com/api/items/${item.id}/graphic/ground`);

        const $name = $(document.createElement('span'));
        $name.text(item.name);

        $item.append($img);
        $item.append($name);

        $item.click(function() {
          setItem(item);
        })

        $results.append($item);
      });
    });
  }

  function setItem(item) {
    $searchForm.addClass('hidden');
    $addForm.removeClass('hidden');

    $imgAddItem.attr('src', `https://eor-api.exile-studios.com/api/items/${item.id}/graphic/ground`);
    $nameAddItem.text(item.name);

    $dialog.dialog({
      title: 'Add item',
      modal: true,
      width: 400,
      height: 200,
    });

    $amount.val('');
    $price.val('');

    $addForm.unbind('submit').submit(function(e) {
      e.preventDefault();
      onSubmit({
        id: item.id,
        price: parseInt($price.val().trim()),
        amount: parseInt($amount.val().trim()),
      });
      return;
    });
  }

  function onSubmit(item) {
    if (!item.price || item.price < 1) {
      showError('Price can not be less than 1');
      return;
    }

    if (!item.amount || item.amount < 1) {
      showError('Amount can not be less than 1');
      return;
    }

    $.post('/api/add-item.php', item, function(res) {
      if (res.error) {
        showError(res.error);
        return;
      }

      showSuccess('Your item has been added. Good luck!');

      loadItems();

      $dialog.dialog('close');
    });
  }

  $search.keyup(renderResults);

  $btnAdd.click(function(e) {
    e.preventDefault();

    $searchForm.removeClass('hidden');
    $addForm.addClass('hidden');
    $search.val('');

    renderResults();

    $dialog.dialog({
      title: 'Add item',
      modal: true,
      width: 800,
      height: 600,
    });

    return;
  });

  $btnCancel.click(function() {
    $dialog.dialog('close');
  });
}

function setupLoginForm() {
  const $form = $('.login-form');
  const $username = $form.find('[name="username"]');
  const $password = $form.find('[name="password"]');

  $form.submit(onSubmit);

  function onSubmit(e) {
    e.preventDefault();

    const username = $username.val().trim();
    const password = $password.val().trim();

    if (!username || username.length < 4 || username.length > 12) {
      return;
    }

    if (!password || password.length < 8) {
      return;
    }


    $.post('/api/login.php', {
      username,
      password,
    }, function(res) {
      if (res.error) {
        showError(res.error);
      } else {
        window.location = '/';
      }
    });

    return;

  }
}

function setupSignupModal() {
  const $dialog = $('#dialog-signup');
  const $username = $dialog.find('[name="username"]');
  const $password = $dialog.find('[name="password"]');
  const $confirmPassword = $dialog.find('[name="confirm-password"]');
  const $form = $dialog.find('form');
  const $submit = $dialog.find('[type="submit"]');
  const $success = $dialog.find('#signup-success');
  const $pre = $success.find('pre');
  const $btnCopy = $success.find('button[name="copy"]');
  const $btnClose = $dialog.find('button[name="close"]');

  $username.keyup(function(e) {
    if (e.key === 'Enter') {
      $form.submit();
    }
  });

  $password.keyup(function(e) {
    if (e.key === 'Enter') {
      $form.submit();
    }
  });

  $confirmPassword.keyup(function(e) {
    if (e.key === 'Enter') {
      $form.submit();
    }
  });

  $('.signup-link').click(function() {
    $username.val('');
    $password.val('');
    $confirmPassword.val('');
    $success.addClass('hidden');
    $submit.removeClass('hidden');
    $dialog.dialog({
      title: 'Sign up',
      modal: true,
    });
  });

  $form.submit(onSubmit);

  $btnCopy.click(function(e) {
    e.preventDefault();
    navigator.clipboard.writeText($pre.text());
  });

  $btnClose.click(function(e) {
    e.preventDefault();
    $dialog.dialog('close');
  });

  function onSubmit(e) {
    e.preventDefault();

    const username = $username.val().trim();
    const password = $password.val().trim();
    const confirmPassword = $confirmPassword.val().trim();

    if (!username || username.length < 4 || username.length > 12) {
      showError('Username must be 4-12 characters');
      return;
    }

    if (!password || password.length < 8) {
      showError('Password must be at least 8 characters');
      return;
    }

    if (password !== confirmPassword) {
      showError('Passwords do not match');
      return;
    }

    $submit.attr('disabled', 'disabled');
    $.post('/api/signup.php', {
      username,
      password,
    }, function(res) {
      $submit.removeAttr('disabled');
      if (res.error) {
        showError(res.error);
      } else {
        $pre.text(`!marketplace register ${res.data.code}`);
        $submit.addClass('hidden');
        $success.removeClass('hidden');
      }
    });

    return;
  }
}

function showError(message) {
  Swal.fire({
    title: 'Error',
    text: message,
    icon: 'error',
  });
}

function showSuccess(message) {
  Swal.fire({
    title: 'Success',
    text: message,
    icon: 'success',
  });
}

function buyItem(itemId, sellerName, price, amount) {
  const $dialog = $('#dialog-buy');
  const $pre = $dialog.find('pre');
  const $amount = $dialog.find('[name="amount"]');
  const $txtAmount = $dialog.find('[name="txt-amount"]');
  const $btn = $dialog.find('button');

  $amount.attr('max', amount);
  $amount.unbind('input').on('input', function() {
    $txtAmount.val($amount.val());
    updateText();
  });

  $txtAmount.unbind('input').on('input', function() {
    $amount.val($txtAmount.val());
    updateText();
  });

  $amount.val(amount);
  $txtAmount.val(amount);

  function updateText() {
    const totalAmount = $amount.val();
    getItemList(function(items) {
      const item = items.find(function(item) {
        return item.id == itemId;
      });

      if (totalAmount == 1) {
        $pre.text(`!${sellerName} Hey! I would like to buy your ${item.name} from EO Market. You have it listed for ${price} eon`);
      } else {
        $pre.text(`!${sellerName} Hey! I would like to buy ${totalAmount} ${item.name}s from EO Market. ${totalAmount} x ${price} = ${totalAmount * price} eon`);
      }
    });

    $dialog.dialog({
      title: 'Buy item',
      width: 800,
      modal: true,
    });
  }

  $btn.click(function() {
    navigator.clipboard.writeText($pre.text());
  });

  updateText();
}
