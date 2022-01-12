<?php

include "config.php";
if (isset($_GET['catIdUrl'])) {
   $categoryIdUrl = $_GET['catIdUrl'];
}

$fetchSettingsQuery = "SELECT * FROM settings";
$resultFetchSettingsQuery = mysqli_query($connection, $fetchSettingsQuery) or die("Query Failed: $fetchSettingsQuery");

if (mysqli_num_rows($resultFetchSettingsQuery) > 0) {
   while ($setting = mysqli_fetch_assoc($resultFetchSettingsQuery)) {
      $_SESSION['web-name'] = $setting['webname'];
      $_SESSION['web-logo'] = $setting['logo'];
   }
}

// Dynamic Page Title Code.
$pageTitle = basename($_SERVER['PHP_SELF']);

switch ($pageTitle) {
   case 'single.php':
      if (isset($_GET['postIdUrl'])) {
         $titleQuery = "SELECT title FROM post WHERE post_id = {$_GET['postIdUrl']}";
         $resultTitleQuery = mysqli_query($connection, $titleQuery) or die("Query Failed");

         while ($title = mysqli_fetch_assoc($resultTitleQuery))
            $pageTitle = $title['title'] . " | " . $_SESSION['web-name'];
      } else {
         $pageTitle = 'No Post Found';
      }
      break;
   case 'category.php':
      if (isset($_GET['catIdUrl'])) {
         $titleQuery = "SELECT category_name FROM category WHERE category_id = {$_GET['catIdUrl']}";
         $resultTitleQuery = mysqli_query($connection, $titleQuery) or die("Query Failed");

         while ($title = mysqli_fetch_assoc($resultTitleQuery))
            $pageTitle = "All Posts Of " . $title['category_name'] . " Category" . " | " . $_SESSION['web-name'];
      } else {
         $pageTitle = 'No Post Found';
      }
      break;
   case 'author.php':
      if (isset($_GET['userIdUrl'])) {
         $titleQuery = "SELECT username FROM user WHERE user_id = {$_GET['userIdUrl']}";
         $resultTitleQuery = mysqli_query($connection, $titleQuery) or die("Query Failed");

         while ($title = mysqli_fetch_assoc($resultTitleQuery))
            $pageTitle = "All Posts By " . $title['username'] . " | " . $_SESSION['web-name'];
      } else {
         $pageTitle = 'No Post Found';
      }
      break;
   case 'search.php':
      if (isset($_GET['search'])) {
         $pageTitle = "Search: " . $_GET['search'] . " | " . $_SESSION['web-name'];
      } else {
         $pageTitle = 'No Search Result Found';
      }
      break;
   default:
      $pageTitle = $_SESSION['web-name'];
      break;
}
// Dynamic Page Title Code End.

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
   <title><?php echo $pageTitle ?></title>
   <!-- Bootstrap -->
   <link rel="stylesheet" href="css/bootstrap.min.css" />
   <!-- Font Awesome Icon -->
   <link rel="stylesheet" href="css/font-awesome.css">
   <!-- Custom stlylesheet -->
   <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <!-- HEADER -->
   <div id="header">
      <!-- container -->
      <div class="container">
         <!-- row -->
         <div class="row">
            <!-- LOGO -->
            <div class=" col-md-offset-4 col-md-4">
               <a href="index.php" id="logo"><img src="admin/images/<?php echo $_SESSION['web-logo'] ?>"></a>
            </div>
            <!-- /LOGO -->
         </div>
      </div>
   </div>
   <!-- /HEADER -->
   <!-- Menu Bar -->
   <div id="menu-bar">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <ul class='menu'>
                  <li><a href="<?php echo $hostName . '/index.php' ?>">Home</a></li>
                  <?php
                  $categoryMenuQuery = "SELECT * FROM category WHERE post > 0";
                  $ResultCategoryMenuQuery = mysqli_query($connection, $categoryMenuQuery) or die("Query Failed: $categoryMenuQuery");
                  if (mysqli_num_rows($ResultCategoryMenuQuery) > 0) {
                     $cssClass = '';
                     while ($category = mysqli_fetch_assoc($ResultCategoryMenuQuery)) {
                        if (isset($_GET['catIdUrl'])) {
                           if ($category['category_id'] == $categoryIdUrl) {
                              $cssClass = 'active';
                           } else {
                              $cssClass = '';
                           }
                        }
                        echo "<li>
                                 <a class='{$cssClass}' href='category.php?catIdUrl={$category['category_id']}'>
                                    {$category['category_name']}
                                 </a>
                              </li>
                           ";
                     }
                     echo "</ul>";
                  }
                  ?>
            </div>
         </div>
      </div>
   </div>
   <!-- /Menu Bar -->