<?php

// include required php files
require "src/config.php";
require "models/User.php";

// check the current page
checkPage('user');

// get the id from parameter or from session
$id = getParameter("id", isset($_SESSION['UID']) ? $_SESSION['UID'] : null);

// set the user to null
$user = null;

// check for the id and find the user by id
if ($id) {
  $user = User::find(CON, $id); // find the user

  // check for the user if is null
  if ($user == null)
    logError("Invalid id " . $id); // log the error
} else
  logError("id is required"); // log the error

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>User - <?= $id ?></title>

  <link href="resources/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
  <div class="container">
    <?php
      include 'views/menu.php';
    ?>

    <h1>User Details: </h1>
    <h2>ID: <?= $user->id ?></h2>
    <h2>First name: <?= $user->first_name ?></h2>
    <h2>Last name: <?= $user->last_name ?></h2>
    <h2>Gender: <?= $user->gender ?></h2>
    <h2>Birth date: <?= $user->birth_date ?></h2>
  </div>

  <script src="resources/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
