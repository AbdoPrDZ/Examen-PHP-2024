<?php

// define the app database information
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'examen_auth');

/**
 * Create pdo connection for app database
 *
 * @return PDO the pdo connection
 */
function connect() {
  $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
  $user = DB_USER;
  $password = DB_PASS;

  try {
    $con = new PDO($dsn,$user,$password);
    return $con;
  } catch (Exception $e) {
    logError("Connection failed: " . $e->getMessage());
  }
}
