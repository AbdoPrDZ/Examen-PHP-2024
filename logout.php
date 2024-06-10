<?php

// include required php files
require 'src/config.php';

// destroy the session
session_destroy();

// redirect to login page
redirect('./login.php');
