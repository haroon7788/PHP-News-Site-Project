<?php

include 'header.php';
include "config.php";

if (isset($_GET['postIdUrl'])) {
   $postIdUrl = $_GET['postIdUrl'];
}

$printPostQuery = "SELECT p.post_id, p.title, p.post_date, p.post_img, p.description, c.category_name, c.category_id, u.username, u.user_id FROM post p
                  INNER JOIN category c
                  ON p.category = c.category_id
                  INNER JOIN user u
                  ON p.author = u.user_id
                  WHERE p.post_id = {$postIdUrl}";

$resultPrintPostQuery = mysqli_query($connection, $printPostQuery) or die("Query Failed: $allPostsQuery");

?>
<div id="main-content">
   <div class="container">
      <div class="row">
         <div class="col-md-8">
            <!-- post-container -->
            <?php
            if (mysqli_num_rows($resultPrintPostQuery) > 0) {
               while ($postRow = mysqli_fetch_assoc($resultPrintPostQuery)) {
            ?>
                  <div class="post-container">
                     <div class="post-content single-post">
                        <h3><?php echo $postRow['title'] ?></h3>
                        <div class="post-information">
                           <span>
                              <i class="fa fa-tags" aria-hidden="true"></i>
                              <a href="category.php?catIdUrl=<?php echo $postRow['category_id'] ?>"><?php echo $postRow['category_name'] ?></a>
                           </span>
                           <span>
                              <i class="fa fa-user" aria-hidden="true"></i>
                              <a href='author.php?userIdUrl=<?php echo $postRow['user_id'] ?>'><?php echo $postRow['username'] ?></a>
                           </span>
                           <span>
                              <i class="fa fa-calendar" aria-hidden="true"></i>
                              <?php echo $postRow['post_date'] ?>
                           </span>
                        </div>
                        <img class="single-feature-image" src="admin/upload/<?php echo $postRow['post_img'] ?>" alt="" />
                        <p class="description">
                           <?php echo $postRow['description'] ?> </p>
                     </div>
                  </div>
            <?php
               }
            }
            ?>
            <!-- /post-container -->
         </div>
         <?php include 'sidebar.php'; ?>
      </div>
   </div>
</div>
<?php
include 'footer.php';
mysqli_close($connection);
?>