<?php
include 'header.php';
include "config.php";

if (isset($_GET['userIdUrl'])) {
   $userIdUrl = $_GET['userIdUrl'];
} else {
   die("<div class='alert alert-danger text-center h4 mt-5'>Cannot Access This Page From URL</div>");
}

// For Pagination
if (isset($_GET['pageNo'])) {
   $currentPageNumber = $_GET['pageNo'];
} else {
   $currentPageNumber = 1;
}
$limitOffset = ($currentPageNumber - 1) * $recordsLimitPerPage;

$fetchPostQuery = "SELECT p.post_id, p.title, p.post_date, p.post_img, p.description, p.category, c.category_name, c.category_id, u.user_id, u.username FROM post p
                  INNER JOIN category c
                  ON p.category = c.category_id
                  INNER JOIN user u
                  ON p.author = u.user_id
                  WHERE p.author = {$userIdUrl}
                  ORDER BY post_id DESC LIMIT {$limitOffset}, {$recordsLimitPerPage}";

$resultFetchPostQuery = mysqli_query($connection, $fetchPostQuery) or die("Query Failed: $fetchPostQuery");

?>
<div id="main-content">
   <div class="container">
      <div class="row">
         <div class="col-md-8">
            <!-- post-container -->
            <div class="post-container">
               <?php
               if (mysqli_num_rows($resultFetchPostQuery) > 0) {
                  while ($postRow = mysqli_fetch_assoc($resultFetchPostQuery)) {
               ?>
                     <h2 class="page-heading"><?php echo $postRow['username'] ?></h2>
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
                  $totalRecordsQuery = "SELECT * FROM post WHERE author = {$userIdUrl}";

                  $resultTotalRecordsQuery = mysqli_query($connection, $totalRecordsQuery) or die("Query Error: $totalRecordsQuery");
                  $totalRecords = mysqli_num_rows($resultTotalRecordsQuery);
                  if ($totalRecords > $recordsLimitPerPage) {
                     $totalPages = ceil($totalRecords / $recordsLimitPerPage);
                  ?>
                     <ul class='pagination admin-pagination'>
                  <?php
                     if ($currentPageNumber > 1) {
                        echo '<li><a href="author.php?pageNo=' . ($currentPageNumber - 1) . '&userIdUrl=' . $userIdUrl . '">Prev</a></li>';
                     }
                     for ($p = 1; $p <= $totalPages; $p++) {
                        if ($p == $currentPageNumber) {
                           $cssClass = "active";
                        } else {
                           $cssClass = "";
                        }
                        echo "<li class='{$cssClass}'><a href='author.php?pageNo={$p}&userIdUrl={$userIdUrl}'> $p </a></li>";
                     }
                     if ($currentPageNumber < $totalPages) {
                        echo '<li><a href="author.php?pageNo=' . ($currentPageNumber + 1) . '&userIdUrl=' . $userIdUrl . '">Next</a></li>';
                     }
                  }
               } else {
                  echo "<div class='alert alert-success mt-5 h3 text-center'>No Posts From This Author For The Moment.</div>";
               }
                  ?>
            </div><!-- /post-container -->
         </div>
         <?php include 'sidebar.php'; ?>
      </div>
   </div>
</div>
<?php
include 'footer.php';
mysqli_close($connection);
?>