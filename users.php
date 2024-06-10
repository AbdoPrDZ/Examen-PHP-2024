<?php

// include required php files
require "src/config.php";
require "models/User.php";

// check the current page
checkPage('users');

// get parameters from request
$search    = getParameter("search"); // the search text
$orderBy   = getParameter("order_by", "id"); // the order by column
$orderType = getParameter("order_type", "ASC"); // the order type (ASC, DESC)

// check for the order by column
if (!in_array($orderBy, ["id", "first_name", "last_name", "gender", "birth_date"]))
  logError("Invalid order by: " . $orderBy);
// check for the order type
else if (!in_array($orderType, ["ASC", "DESC"]))
  logError("Invalid order type: " . $orderType);

// set the users array to empty array
$users = [];

// check if search text is not null
if ($search)
  // search for the users
  $users = User::search(CON, $search, $orderBy, $orderType);
else
  // get all the users
  $users = User::all(CON, $orderBy, $orderType);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users</title>

  <link href="resources/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

  <div class="container">

    <?php
      include 'views/menu.php';
    ?>

    <form action="" method="get">
      <label for="search" class="form-label">Search: </label>
      <input type="text" name="search" id="search" class="form-control">
      <input type="submit" value="Search" class="btn btn-primary">
    </form>

    <hr>

    <form action="" method="get">
      <label for="order-by" class="form-label">Order By</label>
      <select name="order_by" id="order-by" class="form-select">
        <option value="id" class="form-select" <?= $orderBy == 'id' ? 'selected' : '' ?>>
          Id
        </option>
        <option value="first_name" class="form-select" <?= $orderBy == 'first_name' ? 'selected' : '' ?>>
          First name
        </option>
        <option value="last_name" class="form-select" <?= $orderBy == 'last_name' ? 'selected' : '' ?>>
          Last name
        </option>
        <option value="gender" class="form-select" <?= $orderBy == 'gender' ? 'selected' : '' ?>>
          Gender
        </option>
        <option value="birth_date" class="form-select" <?= $orderBy == 'birth_date' ? 'selected' : '' ?>>
          Birth date
        </option>
      </select><br>
      <label for="order-type" class="form-label">Order Type:</label>
      <div id="order-type" class="form-check">
        <input type="radio" name="order_type" id="order-type-asc" value="ASC" <?= $orderType == 'ASC' ? 'checked' : '' ?> class="form-check-input">
        <label for="order-type-asc" class="form-check-label">ASC</label><br>
        <input type="radio" name="order_type" id="order-type-desc" value="DESC" <?= $orderType == 'DESC' ? 'checked' : '' ?> class="form-check-input">
        <label for="order-type-desc" class="form-check-label">DESC</label>
      </div>
      <input type="submit" value="Sort" class="btn btn-primary">
    </form>

    <hr>

    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">First name</th>
          <th scope="col">Last name</th>
          <th scope="col">Gender</th>
          <th scope="col">Birth date</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($users as $user) {?>
        <tr>
          <td scope="row"><?= $user->id ?></td>
          <td><?= $user->first_name ?></td>
          <td><?= $user->last_name ?></td>
          <td><?= $user->gender ?></td>
          <td><?= $user->birth_date ?></td>
          <td>
            <a href="./user.php?id=<?= $user->id?>">View</a>
          </td>
        </tr>
        <?php }?>
      </tbody>
    </table>
  </div>

  <script src="resources/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>