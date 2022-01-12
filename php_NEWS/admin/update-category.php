<?php

include "header.php";
include "config.php";

if ($_SESSION['role'] == '0') {
  header("Location: {$hostName}/admin/post.php");
  die();
}

$idUrl = $_GET['idUrl'];
$printCategoryQuery = "SELECT * FROM category WHERE category_id = '{$idUrl}'";
$resultPrintCategoryQuery = mysqli_query($connection, $printCategoryQuery) or die("Query Failed: $printCategoryQuery");

if (isset($_POST['submit'])) {
  $updateName = mysqli_real_escape_string($connection, $_POST['cat_name']);

  $updateCategoryQuery = "UPDATE category SET category_name = '{$updateName}' WHERE category_id = '{$idUrl}'";
  $resultUpdateCategoryQuery = mysqli_query($connection, $updateCategoryQuery) or die("Query Failed: $$updateCategoryQuery");

  header("Location: {$hostName}/admin/category.php");
}

?>
<div id="admin-content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="adin-heading"> Update Category</h1>
      </div>
      <div class="col-md-offset-3 col-md-6">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
          <?php
          while ($printRow = mysqli_fetch_assoc($resultPrintCategoryQuery)) {
          ?>
            <div class="form-group">
              <input type="hidden" name="cat_id" class="form-control" value="<?php echo $printRow['category_id'] ?>" placeholder="">
            </div>

            <?php

            if (isset($resultPrintCategoryQuery) > 0) {
            ?>
              <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="cat_name" class="form-control" value="<?php echo $printRow['category_name'] ?>" placeholder="" required>
              <?php
            }
              ?>
              </div>
            <?php
          }
            ?>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
        </form>
      </div>
    </div>
  </div>
</div>
<?php

include "footer.php";
mysqli_close($connection);

?>