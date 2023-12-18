<?php
// enable sessions
session_start();

require_once 'functions.php'; // include functions

mysqli_report(MYSQLI_REPORT_OFF); // handle mysqli error

// Database credentials
define('DB_SERVER', 'mariadb'); // database server address
define('DB_USERNAME', 'root'); // database username
define('DB_PASSWORD', 'rootpwd'); // database password
define('DB_NAME', 'cw2'); // database name

// Connect to database
global $db;
$db = connectToDatabase(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


// session
$_SESSION['loggedin'] = false;
// $_SESSION['username'] = null;
// $_SESSION['role'] = null;
?>