<?php
include 'header.php';
include "config.php";

// For Pagination
if (isset($_GET['pageNo'])) {
   $currentPageNumber = $_GET['pageNo'];
} else {
   $currentPageNumber = 1;
}
$limitOffset = ($currentPageNumber - 1) * $recordsLimitPerPage;

$allPostsQuery = "SELECT p.post_id, p.title, p.post_date, p.post_img, p.description, c.category_name, c.category_id, u.username, u.user_id FROM post p
                  INNER JOIN category c
                  ON p.category = c.category_id
                  INNER JOIN user u
                  ON p.author = u.user_id
                  ORDER BY post_id DESC LIMIT {$limitOffset}, {$recordsLimitPerPage}";

$resultAllPostsQuery = mysqli_query($connection, $allPostsQuery) or die("Query Failed: $allPostsQuery");
?>
<div id="main-content">
   <div class="container">
      <div class="row">
         <div class="col-md-8">
            <!-- post-container -->
            <div class="post-container">

               <?php
               if (mysqli_num_rows($resultAllPostsQuery) > 0) {
                  while ($postRow = mysqli_fetch_assoc($resultAllPostsQuery)) {
               ?>

                     <div class="post-content">
                        <div class="row">
                           <div class="col-md-4">
                              <a class="post-img" href="single.php?postIdUrl=<?php echo $postRow['post_id'] ?>"><img src="admin/upload/<?php echo $postRow['post_img'] ?>" alt="<?php echo $postRow['post_img'] ?>" /></a>
                           </div>
                           <div class="col-md-8">
                              <div class="inner-content clearfix">
                                 <h3><a href='single.php?postIdUrl=<?php echo $postRow['post_id'] ?>'><?php echo $postRow['title'] ?></a></h3>
                                 <div class="post-information">
                                    <span>
                                       <i class="fa fa-tags" aria-hidden="true"></i>
                                       <a href='category.php?catIdUrl=<?php echo $postRow['category_id'] ?>'><?php echo $postRow['category_name'] ?></a>
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
                                 <p class="description"><?php echo substr($postRow['description'], 0, 50) . "..." ?></p>
                                 <a class='read-more pull-right' href='single.php?postIdUrl=<?php echo $postRow['post_id'] ?>'>read more</a>
                              </div>
                           </div>
                        </div>
                     </div>
                  <?php
                  }
               }
               $totalRecordsQuery = "SELECT * FROM post";

               $resultTotalRecordsQuery = mysqli_query($connection, $totalRecordsQuery) or die("Query Error: $totalRecordsQuery");
               $totalRecords = mysqli_num_rows($resultTotalRecordsQuery);
               if ($totalRecords > $recordsLimitPerPage) {
                  $totalPages = ceil($totalRecords / $recordsLimitPerPage);
                  ?>
                  <ul class='pagination admin-pagination'>
                  <?php
                  if ($currentPageNumber > 1) {
                     echo '<li><a href="index.php?pageNo=' . ($currentPageNumber - 1) . '">Prev</a></li>';
                  }
                  for ($p = 1; $p <= $totalPages; $p++) {
                     if ($p == $currentPageNumber) {
                        $cssClass = "active";
                     } else {
                        $cssClass = "";
                     }
                     echo "<li class='$cssClass'><a href='index.php?pageNo=$p'> $p </a></li>";
                  }
                  if ($currentPageNumber < $totalPages) {
                     echo '<li><a href="index.php?pageNo=' . ($currentPageNumber + 1) . '">Next</a></li>';
                  }
               }
                  ?>
            </div>
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