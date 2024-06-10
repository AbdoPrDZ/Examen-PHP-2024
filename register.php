<?php

// include required php files
require "src/config.php";
require "models/User.php";

// check the current page
checkPage('register');

// get parameters from request
$firstName = getParameter('first_name', '');
$lastName  = getParameter('last_name', '');
$gender    = getParameter('gender', 'male');
$birthDate = getParameter('birth_date', '');
$username  = getParameter('username', '');
$password  = getParameter('password', '');
$confirm   = getParameter('confirm', '');

// set all the request errors to null
$errors = [
  'first_name' => null,
  'last_name'  => null,
  'gender'     => null,
  'birth_date' => null,
  'username'   => null,
  'password'   => null,
  'confirm'    => null,
];

// check if the current request method is POST
if (getMethod() == 'POST') {
  // set the request validation to true
  $valid = true;

  // validate the first name
  if ($firstName == null || $firstName == "") {
    $errors['first_name'] = "The first name is required";
    $valid = false;
  } else { // check if the first name is already used
    $item = User::find(CON, $firstName, 'first_name');

    if ($item != null) {
      $errors['first_name'] = "The first name already exists";
      $valid = false;
    }
  }

  // validate the last name
  if ($lastName == null || $lastName == "") {
    $errors['last_name'] = "The last name is required";
    $valid = false;
  } else { // check if the last name is already used
    $item = User::find(CON, $lastName, 'last_name');

    if ($item != null) {
      $errors['last_name'] = "The last name already exists";
      $valid = false;
    }
  }

  // validate the gander
  if ($gender == null || $gender == "") {
    $errors['gender'] = "The gender is required";
    $valid = false;
  } else if (!in_array($gender, ['male', 'female'])){
    $errors['gender'] = "Invalid gender";
    $valid = false;
  }

  // validate the birth date
  if ($birthDate == null || $birthDate == "") {
    $errors['birth_date'] = "The birth date is required";
    $valid = false;
  }

  // validate the username
  if ($username == null || $username == "") {
    $errors['username'] = "The username is required";
    $valid = false;
  } else { // check if the username is already used
    $item = User::find(CON, $username, 'username');

    if ($item != null) {
      $errors['username'] = "The username already exists";
      $valid = false;
    }
  }

  // validate the username
  if ($password == null || $password == "") {
    $errors['password'] = "The password is required";
    $valid = false;
  }

  // validate the username
  if ($confirm == null || $confirm == "") {
    $errors['confirm'] = "The confirm is required";
    $valid = false;
  }

  // check if the password and confirm is the same
  if ($password != null && $password != '' && $confirm != null && $confirm != '' && $password != $confirm) {
    $errors['password'] = "The password and confirm must be the same";
    $errors['confirm']  = "The password and confirm must be the same";
    $valid = false;
  }

  // check if the request is valid
  if ($valid) {
    // create an User instance for the new user without id
    $user = new User(
      null,
      $firstName,
      $lastName,
      $gender,
      $birthDate,
      $username,
      $password,
    );

    // insert the new user
    $id = User::create(CON, $user);

    // check for the inserted id
    if ($id) {
      $_SESSION['IS_AUTH'] = true; // set the auth to true
      $_SESSION['UID'] = $id; // set the registered user id

      // redirect to the user page
      redirect("./user.php");
    } else
      logError("can't register the new user, some things wrong");
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Register</title>

  <link href="resources/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

  <div class="container">

    <?php
      include 'views/menu.php';
    ?>

    <h1>Register</h1>

    <form action="" method="post">

      <div class="mb-3">
        <label for="first-name" class="form-label">First name:</label>
        <input type="text" name="first_name" id="first-name" value="<?= $firstName ?>" class="form-control <?= $errors['first_name'] ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
          <?php if ($errors['first_name']) echo $errors['first_name'] ?>
        </div>
      </div>

      <div class="mb-3">
        <label for="last-name" class="form-label">Last name:</label>
        <input type="text" name="last_name" id="last-name" value="<?= $lastName ?>" class="form-control <?= $errors['last_name'] ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
          <?php if ($errors['last_name']) echo $errors['last_name'] ?>
        </div>
      </div>

      <div class="mb-3">
        <label for="gender" class="form-label">Gender:</label>
        <div id="gender" class="form-check">
          <input type="radio" name="gender" id="gender-male" value="male" <?= $gender == 'male' ? 'checked' : '' ?> class="form-check-input">
          <label for="gender-male" class="form-check-label">Male</label>
          <br>
          <input type="radio" name="gender" id="gender-female" value="female" <?= $gender == 'female' ? 'checked' : '' ?> class="form-check-input">
          <label for="gender-female" class="form-check-label">Female</label>
        </div>
        <div class="invalid-feedback">
          <?php if ($errors['gender']) echo $errors['gender'] ?>
        </div>
      </div>

      <div class="mb-3">
        <label for="birth-date" class="form-label">Birth date:</label>
        <input type="date" name="birth_date" id="birth-date" value="<?= $birthDate ?>" class="form-control <?= $errors['birth_date'] ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
          <?php if ($errors['birth_date']) echo $errors['birth_date'] ?>
        </div>
      </div>

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
        <label for="confirm" class="form-label">Confirm:</label>
        <input type="password" name="confirm" id="confirm" value="<?= $confirm ?>" class="form-control <?= $errors['confirm'] ? 'is-invalid' : '' ?>">
        <div class="invalid-feedback">
          <?php if ($errors['confirm']) echo $errors['confirm'] ?>
        </div>
      </div>

      <div class="mb-3">
        <input type="submit" value="Register" class="btn btn-primary">
      </div>

    </form>

  </div>

  <script src="resources/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>