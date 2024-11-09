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
});

let ITEM_LIST = [];
function getItemList(callback) {
  if (ITEM_LIST.length > 0) {
    return callback(ITEM_LIST);
  }

  $.get({
    url: 'https://eor-api.exile-studios.com/api/items',
    xhrFields: {
      withCredentials: false
    },
    dataType: 'json',
    success: function(res) {
      if (res.error) {
        Swal.fire({
          title: 'Error',
          text: res.error,
          icon: 'error',
        });
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
        $img.attr('src', item.graphic_url);

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

    $imgAddItem.attr('src', item.graphic_url);
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
    if (item.price < 1) {
      Swal.fire({
        title: 'Error',
        text: 'Price can not be less than 1',
        icon: 'error',
      });
      return;
    }

    if (item.amount < 1) {
      Swal.fire({
        title: 'Error',
        text: 'Amount can not be less than 1',
        icon: 'error',
      });
      return;
    }

    $.post('/api/add-item.php', item, function(res) {
      if (res.error) {
        Swal.fire({
          title: 'Error',
          text: res.error,
          icon: 'error',
        });
        return;
      }

      Swal.fire({
        title: 'Success',
        text: 'Your item has been added. Good luck!',
        icon: 'success',
      });

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
        Swal.fire({
          title: 'Error',
          text: res.error,
          icon: 'error',
        });
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

  $('.signup-link').click(function() {
    $username.val('');
    $password.val('');
    $confirmPassword.val('');
    $dialog.dialog({
      title: 'Sign up',
      modal: true,
    });
  });

  $form.submit(onSubmit);

  function onSubmit(e) {
    e.preventDefault();

    const username = $username.val().trim();
    const password = $password.val().trim();
    const confirmPassword = $confirmPassword.val().trim();

    if (!username || username.length < 4 || username.length > 12) {
      Swal.fire({
        title: 'Error',
        text: 'Username must be 4-12 characters',
        icon: 'error',
      });
      return;
    }

    if (!password || password.length < 8) {
      Swal.fire({
        title: 'Error',
        text: 'Password must be at least 8 characters',
        icon: 'error',
      });
      return;
    }

    if (password !== confirmPassword) {
      Swal.fire({
        title: 'Error',
        text: 'Passwords do not match',
        icon: 'error',
      });
      return;
    }

    $submit.attr('disabled', 'disabled');
    $.post('/api/signup.php', {
      username,
      password,
    }, function(res) {
      $submit.removeAttr('disabled');
      if (res.error) {
        Swal.fire({
          title: 'Error',
          text: res.error,
          icon: 'error',
        });
      } else {
        $dialog.dialog('close');
        Swal.fire({
          title: 'Success',
          text: res.data.message,
          icon: 'success',
        });
      }
    });

    return;
  }
}
