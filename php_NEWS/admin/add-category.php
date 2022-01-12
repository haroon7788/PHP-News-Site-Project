<?php

include "header.php";
include "config.php";
include "add-filters.php";

if ($_SESSION['role'] == '0') {
   header("Location: {$hostName}/admin/post.php");
}

if (isset($_POST['save'])) {
   $addCategoryName = my_filter($_POST['cat']);
   $checkUniqueCategoryQuery = "SELECT category_name FROM category";
   $resultCheckUniqueCategoryQuery = mysqli_query($connection, $checkUniqueCategoryQuery) or die("Query Failed: $checkUniqueCategoryQuery");
   if (mysqli_num_rows($resultCheckUniqueCategoryQuery) > 0) {
      while ($check = mysqli_fetch_assoc($resultCheckUniqueCategoryQuery)) {
         if ($addCategoryName == $check['category_name']) {
            die("<div class='alert alert-danger' style='margin:10px auto; text-align:center;'>Category Name must be Unique!</div>");
         }
      }
   }
   $addCategoryQuery = "INSERT INTO category (category_name) VALUES ('{$addCategoryName}')";
   $resultAddCategoryQuery = mysqli_query($connection, $addCategoryQuery) or die("Query Failed: $addCategoryQuery");
   header("Location: {$hostName}/admin/category.php");
}

?>
<div id="admin-content">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <h1 class="admin-heading">Add New Category</h1>
         </div>
         <div class="col-md-offset-3 col-md-6">
            <!-- Form Start -->
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
               <div class="form-group">
                  <label>Category Name</label>
                  <input type="text" name="cat" class="form-control" placeholder="Category Name" required>
               </div>
               <input type="submit" name="save" class="btn btn-primary" value="Save" required />
            </form>
            <!-- /Form End -->
         </div>
      </div>
   </div>
</div>
<?php
include "footer.php";
mysqli_close($connection);
?>