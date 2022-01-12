<?php

include "config.php";
session_start();
$postIdUrl = $_GET['postIdUrl'];
$categoryIdUrl = $_GET['categoryIdUrl'];
$postUserName = $_GET['postUserNameUrl'];

if (
   $_SESSION['userName'] == $postUserName ||
   $_SESSION['role'] == 1
) {
   // Delete Image from Root Folder
   $selectImage = "SELECT * FROM post WHERE post_id = '{$postIdUrl}'";
   $resultSelectImage = mysqli_query($connection, $selectImage) or die("Query Failed: $selectImage");
   $row = mysqli_fetch_assoc($resultSelectImage);

   unlink("upload/" . $row['post_img']);

   // Delete and Update post data.
   $postDeletionQuery = "DELETE FROM post WHERE post_id = '{$postIdUrl}';";
   $postDeletionQuery .= "UPDATE category SET post = post - 1 WHERE category_id = '{$categoryIdUrl}';";

   $resultPostDeletionQuery = mysqli_multi_query($connection, $postDeletionQuery);
   if ($resultPostDeletionQuery) {
      header("Location: {$hostName}/admin/post.php");
   } else {
      echo "<div class='alert alert-danger' style='margin-top:10px; font-size:16px;'>Query Failed: $postDeletionQuery</div>";
      die();
   }
} else {
   echo "<div class='alert alert-danger' style='margin-top:10px; font-size:16px;'>Record Not Found.</div>";
}
