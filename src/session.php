<?php

// start the app session
session_start();

/**
 * Get if the current client is auth from session
 *
 * @return boolean true if is auth, false if not
 */
function isAuth() {
  if (!isset($_SESSION['IS_AUTH']))
    $_SESSION['IS_AUTH'] = false;

  return $_SESSION['IS_AUTH'];
}

/**
 * Check the current page and redirect to right page
 *
 * @param string $page the current page
 * @return void
 */
function checkPage(string $page) {
  $isAuth = isAuth();

  if ($isAuth && in_array($page, ['login', 'register']))
    redirect('user.php');
  else if (!$isAuth && in_array($page, ['user', 'users']))
    redirect('login.php');
}