<?php

include "header.php";
include "config.php";
$postIdUrl = $_GET['postIdUrl'];

if ($_SESSION['role'] == 0) {
  $findUserQuery = "SELECT author FROM post WHERE post_id = '{$postIdUrl}'"; // Get the author who posted that post with $postIdUrl.
  $resultFindUserQuery = mysqli_query($connection, $findUserQuery) or die("Query Failed: $findUserQuery");

  if (mysqli_num_rows($resultFindUserQuery) > 0) {
    while ($user = mysqli_fetch_assoc($resultFindUserQuery)) {
      if ($user['author'] !== $_SESSION['userId']) {
        echo "<div class='alert alert-danger h4 mt-5 text-center'>You Cannot Delete or Update Others Posts.</div>";
        die();
      }
    }
  }
}

?>
<div id="admin-content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
      </div>
      <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->

        <?php
        $printPostQuery = "SELECT * FROM post WHERE post_id = {$postIdUrl}";
        $resultPrintPostQuery = mysqli_query($connection, $printPostQuery) or die("Query Failed: $printPostQuery");

        if (mysqli_num_rows($resultPrintPostQuery) > 0) {
          while ($post = mysqli_fetch_assoc($resultPrintPostQuery)) {
        ?>
            <form action="save-update-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
              <div class="form-group">
                <input type="hidden" name="post_id" class="form-control" value="<?php echo $post['post_id'] ?>" placeholder="">
              </div>
              <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title" class="form-control" id="exampleInputUsername" value="<?php echo $post['title'] ?>">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control" required rows="5"><?php echo $post['description'] ?></textarea>
              </div>
              <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                <select class="form-control" name="category">
                  <option disabled>Select Option</option>
                  <?php
                  $allCategoriesQuery = "SELECT * FROM category";
                  $resultAllCategoriesQuery = mysqli_query($connection, $allCategoriesQuery) or die("Query Failed: $allCategoriesQuery");

                  if (mysqli_num_rows($resultAllCategoriesQuery) > 0) {
                    while ($option = mysqli_fetch_assoc($resultAllCategoriesQuery)) {
                      if ($option['category_id'] == $post['category']) {
                        $cssClass = "selected";
                      } else {
                        $cssClass = "";
                      }
                      echo "<option {$cssClass} value='{$option['category_id']}'> {$option['category_name']} </option>";
                      $_SESSION['old-category-id'] = $option['category_id'];
                    }
                  }
                  ?>
                </select>
                <input type="hidden" name="oldCategoryId" value="<?php echo $post['category'] ?>"> <!-- // will be used to update no of posts in category. -->
              </div>
              <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new-image">
                <img src="upload/<?php echo $post['post_img'] ?>" height="150px">
                <input type="hidden" name="old-image" value="<?php echo $post['post_img'] ?>">
              </div>
              <input type="submit" name="submit" class="btn btn-primary" value="Update" />
            </form>
        <?php
          }
        }
        ?>
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php
include "footer.php";
mysqli_close($connection);
?>