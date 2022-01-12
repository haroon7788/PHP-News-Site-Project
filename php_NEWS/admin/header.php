<?php

include "config.php";
session_start();

if(!isset($_SERVER['web-name'])){
   $_SESSION['web-name'] = $_SESSION['userName'];
}
$pageTitle = basename($_SERVER['PHP_SELF']);

switch ($pageTitle) {
   case 'post.php':
      $pageTitle = 'POST';
      break;
   case 'category.php':
      $pageTitle = 'CATEGORY';
      break;
   case 'users.php':
      $pageTitle = 'USERS';
      break;
   case 'settings.php':
      $pageTitle = 'SETTINGS';
      break;
   case 'add-post.php':
      $pageTitle = 'ADD POST';
      break;
   case 'add-category.php':
      $pageTitle = 'ADD CATEGORY';
      break;
   case 'add-user.php':
      $pageTitle = 'ADD USER';
      break;
   case 'update-user.php':
      $pageTitle = 'UPDATE USER';
      break;
   case 'update-post.php':
      $pageTitle = 'UPDATE POST';
      break;
   case 'update-category.php':
      $pageTitle = 'UPDATE CATEGORY';
      break;
   default:
      $pageTitle = $_SESSION['userName'];
      break;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
   <title><?php echo $pageTitle . " | " . $_SESSION['web-name'] ?></title>
   <!-- Bootstrap -->
   <link rel="stylesheet" href="../css/bootstrap.min.css" />
   <!-- Font Awesome Icon -->
   <link rel="stylesheet" href="../css/font-awesome.css">
   <!-- Custom stlylesheet -->
   <link rel="stylesheet" href="../css/style.css">
</head>

<body>
   <!-- HEADER -->
   <div id="header-admin">
      <!-- container -->
      <div class="container">
         <!-- row -->
         <div class="row">
            <!-- LOGO -->
            <?php
            $fetchSettingsQuery = "SELECT * FROM settings";
            $resultFetchSettingsQuery = mysqli_query($connection, $fetchSettingsQuery) or die("Query Failed: $fetchSettingsQuery");

            if (mysqli_num_rows($resultFetchSettingsQuery) > 0) {
               while ($setting = mysqli_fetch_assoc($resultFetchSettingsQuery)) {
                  $_SESSION['web-name'] = $setting['webname'];
            ?>
                  <div class="col-md-2">
                     <a href="post.php"><img class="logo" src="images/<?php echo $setting['logo'] ?>"></a>
                  </div>
            <?php
               }
            }
            ?>
            <!-- /LOGO -->
            <!-- LOGO-Out -->
            <div class="col-md-offset-9  col-md-3">
               <a href="logout.php" class="admin-logout">Hello <?php echo $_SESSION['userName'] ?>, logout</a>
            </div>
            <!-- /LOGO-Out -->
         </div>
      </div>
   </div>
   <!-- /HEADER -->
   <!-- Menu Bar -->
   <div id="admin-menubar">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <ul class="admin-menu">
                  <li>
                     <a href="post.php">Post</a>
                  </li>
                  <?php
                  if ($_SESSION['role'] == '1') {
                  ?>
                     <li>
                        <a href="category.php">Category</a>
                     </li>
                     <li>
                        <a href="users.php">Users</a>
                     </li>
                     <li>
                        <a href="settings.php">Settings</a>
                     </li>
                  <?php
                  }
                  ?>
               </ul>
            </div>
         </div>
      </div>
   </div>
   <!-- /Menu Bar -->