<ul>
<?php if (isAuth()) { ?>
  <li>
    <a href="./user.php">User</a>
  </li>
  <li>
    <a href="./users.php">Users</a>
  </li>
  <li>
    <a href="./logout.php">Logout</a>
  </li>
<?php } else { ?>
  <li>
    <a href="./register.php">Register</a>
  </li>
  <li>
    <a href="./login.php">Login</a>
  </li>
<?php } ?>
</ul>
<hr>