<?php
include_once('model/user.php');

session_start();
if (isset($_SESSION['user'])) {
  header('Location: home.php');
  exit;
}

if (!empty($_POST)) {
  if (User::exists($_POST['email'])) {
    header('Location: register.php?invalid&name='
      . urlencode($_POST['name']) . '&email=' . urlencode($_POST['email']), TRUE, 303);
  } else {
    $user = User::fromArray($_POST);
    $user->register();
    header('Location: login.php?email=' . urlencode($_POST['email']));
    exit;
  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Register</title>
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
    <form method="post">
      <div class="mdc-text-field text-field">
        <input type="text" class="mdc-text-field__input" id="name-input" name="name"
          value="<?php echo $_GET['name'] ?? '' ?>" required>
        <label class="mdc-floating-label" for="email-input">Name</label>
        <div class="mdc-line-ripple"></div>
      </div>
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
        <a href="login.php" class="mdc-button">
          <div class="mdc-button__ripple"></div>
          <span class="mdc-button__label">
            Login
          </span>
        </a>
        <button class="mdc-button mdc-button--raised">
          <div class="mdc-button__ripple"></div>
          <span class="mdc-button__label">
            Register
          </span>
        </button>
      </div>
      <?php if (isset($_GET["invalid"])) { ?>
      <h6 class="mdc-typography mdc-typography--overline error">This email already exists.</h6>
      <?php } ?>
      <script>
        document.querySelectorAll(".text-field").forEach(e => new mdc.textField.MDCTextField(e));
        document.querySelectorAll("button").forEach(e => new mdc.ripple.MDCRipple(e));
      </script>
    </form>
  </body>
</html>
