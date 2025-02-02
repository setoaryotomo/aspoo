<?php
require 'config.php';
setcookie($cookie_name, "", time() - 3600, "/");
setcookie($cookie_name, "", time() - 3600, "/");

if (is_null($_SESSION['role'])) header("Location: login.php");
$id = $_SESSION['data']['user_id'];

$logout = $conn->query("UPDATE user SET user_status=0 WHERE user_id='$id'");
handleError($logout);
setcookie($cookie_name, "", time() - 3600);

session_destroy();
header("Location: login.php");