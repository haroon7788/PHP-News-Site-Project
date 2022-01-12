<?php
include "config.php";
$recentPostsLimit = 3;

$recentPostsQuery = "SELECT p.post_id, p.title, p.post_date, p.post_img, p.description, c.category_name, c.category_id FROM post p
                     INNER JOIN category c
                     ON p.category = c.category_id
                     ORDER BY post_id DESC LIMIT {$recentPostsLimit}";

$resultRecentPostsQuery = mysqli_query($connection, $recentPostsQuery) or die("Query Failed: $recentPostsQuery");

?>

<div id="sidebar" class="col-md-4">
   <!-- search box -->
   <div class="search-box-container">
      <h4>Search</h4>
      <form class="search-post" action="search.php" method="GET">
         <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search .....">
            <span class="input-group-btn">
               <button type="submit" class="btn btn-danger">Search</button>
            </span>
         </div>
      </form>
   </div>
   <!-- /search box -->
   <!-- recent posts box -->
   <div class="recent-post-container">
      <h4>Recent Posts</h4>
      <div class="recent-post">
         <?php
         if (mysqli_num_rows($resultRecentPostsQuery) > 0) {
            while ($postRow = mysqli_fetch_assoc($resultRecentPostsQuery)) {
         ?>
               <a class="post-img" href="single.php?postIdUrl=<?php echo $postRow['post_id'] ?>">
                  <img src="admin/upload/<?php echo $postRow['post_img'] ?>" alt="<?php echo $postRow['post_img'] ?>" />
               </a>
               <div class="post-content">
                  <h5><a href="single.php?postIdUrl=<?php echo $postRow['post_id'] ?>"><?php echo $postRow['title'] ?></a></h5>
                  <span>
                     <i class="fa fa-tags" aria-hidden="true"></i>
                     <a href='category.php?catIdUrl=<?php echo $postRow['category_id'] ?>'><?php echo $postRow['category_name'] ?></a>
                  </span>
                  <span>
                     <i class="fa fa-calendar" aria-hidden="true"></i>
                     <?php echo $postRow['post_date'] ?>
                  </span>
                  <a class="read-more" href="single.php?postIdUrl=<?php echo $postRow['post_id'] ?>">read more</a>
               </div>
         <?php
            }
         }
         ?>
      </div>
   </div>
   <!-- /recent posts box -->
</div>