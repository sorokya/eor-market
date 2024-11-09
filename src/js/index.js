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
});

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

    $submit.attr('disabled', 'disabled');
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
