<?php

// include required php files
require "./src/config.php";
require "./models/User.php";

// check the current page
checkPage('login');

// get parameters from request
$username = getParameter('username', '');
$password = getParameter('password', '');

/**
 * @var User | null $user the user
 */
$user = null;

// set all the request errors to null
$errors = [
  'username' => null,
  'password' => null,
];

// check if the current request method is POST
if (getMethod() == 'POST') {
  // set the request validation to true
  $valid = true;

  // validate the username
  if ($username == null || $username == "") {
    $errors['username'] = "The username is required";
    $valid = false;
  } else {
    // check if the username if exists
    $user = User::find(CON, $username, 'username');

    // set error if not exists
    if ($user == null) {
      $errors['username'] = "Invalid username";
      $valid = false;
    }
  }

  // validate the password
  if ($password == null || $password == "") {
    $errors['password'] = "The password is required";
    $valid = false;
  } else if ($user && hash('md5', $password) != $user->password) { // hash the sended password and compare it with the right password
    $errors['password'] = "Invalid password";
    $valid = false;
  }

  // check if the request is valid
  if ($valid) {
    $_SESSION['IS_AUTH'] = true; // set the auth to true
    $_SESSION['UID'] = $user->id; // set the user id

    // redirect to the user page
    redirect("./user.php");
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Login</title>

  <link href="resources/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

  <div class="container">

    <?php
      include_once 'views/menu.php';
    ?>

    <h1>Login</h1>

    <form action="" method="post">

      <div class="mb-3">
        <label for="username" class="form-label">Username:</label>
        <input type="text" name="username" id="username" value="<?= $username ?>" class="form-control <?= $errors['username'] ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
          <?php if ($errors['username']) echo $errors['username'] ?>
        </div>
      </div>
      
      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" name="password" id="password" value="<?= $password ?>" class="form-control <?= $errors['password'] ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
          <?php if ($errors['password']) echo $errors['password'] ?>
        </div>
      </div>

      <div class="mb-3">
        <input type="submit" value="Login" class="btn btn-primary">
      </div>

    </form>

  </div>

  <script src="resources/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>