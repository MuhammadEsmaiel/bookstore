<?php
include_once('model/user.php');

session_start();
if (isset($_SESSION['user'])) {
  header('Location: home.php');
  exit;
}

if (!empty($_POST)) {
  if (User::exists($_POST['email'])) {
    $user = User::fromEmail($_POST['email']);
    if ($user->passwordMatch($_POST['password'])) {
      $_SESSION['user'] = $user;
      header('Location: home.php');
      exit;
    } else {
      header('Location: login.php?invalid_password&email=' . urlencode($_POST['email']), TRUE, 303);
    }
  } else {
    header('Location: login.php?invalid_email&email=' . urlencode($_POST['email']), TRUE, 303);
  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" rel="stylesheet">
    <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/form.css" rel="stylesheet">
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
  </head>
  <body>
    <header>
      <i class="material-icons">menu_book</i>
      <h1>Bookstore</h1>
    </header>
    <form method="POST">
      <div class="mdc-text-field text-field">
        <input type="email" class="mdc-text-field__input" id="email-input" name="email"
          value="<?php echo $_GET['email'] ?? '' ?>" required>
        <label class="mdc-floating-label" for="email-input">Email</label>
        <div class="mdc-line-ripple"></div>
      </div>
      <div class="mdc-text-field text-field">
        <input type="password" class="mdc-text-field__input" id="password-input" name="password" required minlength="8">
        <label class="mdc-floating-label" for="password-input">Password</label>
        <div class="mdc-line-ripple"></div>
      </div>
      <div class="button-container">
        <a href="register.php" class="mdc-button">
          <div class="mdc-button__ripple"></div>
          <span class="mdc-button__label">
            Register
          </span>
        </a>
        <button class="mdc-button mdc-button--raised">
          <div class="mdc-button__ripple"></div>
          <span class="mdc-button__label">
            Login
          </span>
        </button>
      </div>
      <?php if (isset($_GET['invalid_email'])) { ?>
      <h6 class="mdc-typography mdc-typography--overline error">Invalid email.</h6>
      <?php } elseif (isset($_GET['invalid_password'])) { ?>
      <h6 class="mdc-typography mdc-typography--overline error">Invalid password.</h6>
      <?php } ?>
      <script>
        document.querySelectorAll(".text-field").forEach(e => new mdc.textField.MDCTextField(e));
        document.querySelectorAll("button").forEach(e => new mdc.ripple.MDCRipple(e));
      </script>
    </form>
  </body>
</html>
