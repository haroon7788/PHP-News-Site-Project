<?php

include 'config.php';

session_start();
if ($_SESSION['role'] == '0') {
   header("Location: {$hostName}/admin/post.php");
   die();
}

$userIdUrl = $_GET['idUrl'];

$deletionQuery = "DELETE FROM user WHERE user_id = '{$userIdUrl}'";
$resultDeletionQuery = mysqli_query($connection, $deletionQuery) or die("Query Failed: $deletionQuery");

if ($resultDeletionQuery) {
   header("Location: $hostName/admin/users.php");
} else {
   echo "<div class='alert danger-alert' margin: 12px auto; text-align: center;'>Cannot Delete the user record which already does not exist.<div/>";
}

mysqli_close($connection);
