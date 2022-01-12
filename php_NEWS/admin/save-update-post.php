<?php
include "config.php";
session_start();

if (isset($_POST['submit'])) {
  $postId = $_POST['post_id'];
  $title = $_POST['post_title'];
  $description = $_POST['postdesc'];
  $categoryId = $_POST['category'];
  $fileName = $_POST['old-image'];
  $oldCategoryId = $_POST['oldCategoryId'];
  // var_dump((($_FILES['new-image']['name']) != ''));
  // echo "OLD: $fileName <br>";
  // echo "NEW: {$_FILES['new-image']['name']}";
  // die();

  // Image Uploading code.
  if ((($_FILES['new-image']['name']) !== $fileName) &&
    ($_FILES['new-image']['name'] !== '')
  ) {
    $uploadedFile = $_FILES['new-image'];
    $errors = [];

    $fileName = $uploadedFile['name'];
    $fileSize = $uploadedFile['size'];
    $fileTmp = $uploadedFile['tmp_name'];
    $fileType = $uploadedFile['type'];

    $fileExt = strtolower($fileName);
    $fileExt = explode('.', $fileName);
    $fileExt = end($fileExt);
    $extensions = ['jpg', 'jpeg', 'png'];

    if (in_array($fileExt, $extensions) == false) {
      array_push($errors, 'This type of file is not allowed. Please choose JPG, JPEG or PNG files.');
    }
    if ($fileSize > 2097152) {
      array_push($errors, 'File size must not be greater than 2 MB.');
    }

    /*
      1 KB = 1024 B
      1 MB = 1000 KB
      1 MB = 1024 B * 1024 B = 1,048,576 Bytes
      2 MB = 1000 KB * 1000 KB = 2,097,152 Bytes
      */

    $fileName = time() . "_" . $fileName;

    if (empty($errors) == true) {
      move_uploaded_file($fileTmp, "upload/" . $fileName);
      unlink("upload/{$_POST['old-image']}");   // Delete the old image from server.
    } else {
      foreach ($errors as $er) {
        echo "<div class='alert alert-danger text-center' style='margin-top:10px; font-size:18px;'>{$er} <br></div>";
      }
      die();
    }
  } else {
    $fileName = $_POST['old-image'];
  }

  // Updating Data of post.php 
  $updatePostQuery = "UPDATE post SET title = '{$title}', description = '{$description}', category = '{$categoryId}', post_img = '{$fileName}' WHERE post_id = '{$postId}';";
  $resultUpdatePostQuery = mysqli_query($connection, $updatePostQuery) or die("Query Failed: $updatePostQuery");

  // Updating Number of Posts in category.php
  if ($oldCategoryId !== $categoryId) {
    $updatePostsCountQuery = "UPDATE category SET post = post + 1 WHERE category_id = {$categoryId};";
    $updatePostsCountQuery .= "UPDATE category SET post = post - 1 WHERE category_id = {$oldCategoryId};";

    $resultUpdatePostsCountQuery = mysqli_multi_query($connection, $updatePostsCountQuery) or die("Query Failed: $updatePostsCountQuery");

    if ($resultUpdatePostsCountQuery && $resultUpdatePostQuery) {
      header("Location: {$hostName}/admin/post.php");
    }
  }

  if ($resultUpdatePostQuery) {
    header("Location: {$hostName}/admin/post.php");
  }
}
