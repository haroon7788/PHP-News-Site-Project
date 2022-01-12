<?php

include "config.php";

session_start();
if ($_SESSION['role'] == '0') {
   header("Location: {$hostName}/admin/post.php");
   die();
}

$idUrl = $_GET['idUrl'];

// First Delete The Images Uploaded By That Category.
$selectImageName = "SELECT post_img FROM post WHERE category = {$idUrl}";
$resultSelectImageName = mysqli_query($connection, $selectImageName) or die("Query Failed: $selectImageName");

if (mysqli_num_rows($resultSelectImageName) > 0) {
   while ($imgName = mysqli_fetch_assoc($resultSelectImageName)) {
      unlink("upload/{$imgName['post_img']}");
   }
}

// Then Delete That Category And All Posts Related That Category
$deleteCategoryQuery = "DELETE FROM category WHERE category_id = {$idUrl};";
$deleteCategoryQuery .= "DELETE FROM post WHERE category = {$idUrl}";

$resultDeleteCategoryQuery = mysqli_multi_query($connection, $deleteCategoryQuery) or die("Query Failed: $deleteCategoryQuery");

if ($resultDeleteCategoryQuery) {
   header("Location: {$hostName}/admin/category.php");
}

mysqli_close($connection);
