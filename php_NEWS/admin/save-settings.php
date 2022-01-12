<?php
include "header.php";
include "config.php";
include "add-filters.php";

// Page can only be make changes if submit button is clicked.
if (isset($_POST['submit'])) {
   $webName = my_filter($_POST['website_name']);
   $footerDescription = my_filter($_POST['footer_desc']);
   $logo = $_POST['old_logo'];
   $newLogo = $_FILES['logo'];

   // Image validation code
   if (($newLogo['name'] !== $logo) && ($newLogo['name'] !== '')) {
      $errors = [];

      $logoName = $newLogo['name'];
      $logoSize = $newLogo['size'];
      $logoTemp = $newLogo['tmp_name'];
      $logoExt = $newLogo['type'];

      // Separating .extension and name from Image Name
      $logoExt = strtolower($logoName);
      $logoExt = explode('.', $logoExt);
      $logoExt = end($logoExt);
      $extensions = ['png', 'jpg', 'jpeg'];

      if ($logoSize > 2097152) {
         array_push($errors, 'Image size must not be greater than 2 MB');
      }
      if (!(in_array($logoExt, $extensions))) {
         array_push($errors, 'Extension Error. Please choose a JPG, JPEG or PNG image file.');
      }

      $logoName = time() . "_" . $logoName;

      if (empty($errors)) {
         move_uploaded_file($logoTemp, "images/" . $logoName);
         unlink("images/" . $logo);  // Delete old image from server.
         $logo = $logoName;   // Replace old image if no errors occur while uploading image.
      } else {
         foreach ($errors as $er) {
            echo "<div class='alert alert-danger h4 mt-5 text-center'>{$er} <br> </div>";
            die();
         }
      }
   } else {
      $logoName = $logo;
   }

   $_SESSION['main-logo'] = $logoName;

   // Image validation code End.
   $updateSettingsQuery = "UPDATE settings SET webname = '{$webName}', footerdesc = '{$footerDescription}', logo = '{$logoName}'";
   $resultUpdateSettingsQuery = mysqli_query($connection, $updateSettingsQuery) or die("Query Failed: $updateSettingsQuery");

   $_SESSION['web-name'] = $_POST['website_name'];
   header("Location: {$hostName}/admin/post.php");
}

mysqli_close($connection);
?>