<?php

include "header.php";
include "config.php";
include "add-filters.php";

if (isset($_FILES['fileToUpload'])) {
  $uploadedFile = $_FILES['fileToUpload'];
  $errors = [];

  $fileName = $uploadedFile['name'];
  $fileSize = $uploadedFile['size'];
  $fileTmp = $uploadedFile['tmp_name'];
  $fileType = $uploadedFile['type'];

  // $fileExt = strtolower($fileName);
  // $fileExt = explode('.', $fileExt);
  // $fileExt = end($fileExt);
  // $extensions = ['jpg', 'jpeg', 'png'];

  $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

  // if(in_array($fileExt, $extensions) == false) {  // or given below if condition
  if ($fileExt != 'jpg' && $fileExt != 'jpeg' && $fileExt != 'png') {
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
  } else {
    foreach ($errors as $er) {
      echo "<div class='alert alert-danger text-center' style='margin-top:10px; font-size:18px;'>{$er} <br></div>";
    }
    die();
  }
}

$title = my_filter($_POST['post_title']);
$description = my_filter($_POST['post_desc']);
$category = my_filter($_POST['category']);
$date = date("d M, Y");
$author = $_SESSION['userId'];

$savePostQuery = "INSERT INTO post (title, description, category, post_date, author, post_img)
                  VALUES ('{$title}', '{$description}', '{$category}', '{$date}', '{$author}', '{$fileName}');";
$savePostQuery .= "UPDATE category SET post = post + 1 WHERE category_id = '{$category}';";

$resultSavePostQuery = mysqli_multi_query($connection, $savePostQuery);
if ($resultSavePostQuery) {
  header("Location: {$hostName}/admin/post.php");
} else {
  echo "<div class='alert alert-danger' style='margin-top:10px; font-size:16px;'>Query Failed: <br> {$savePostQuery}</div>";
}
