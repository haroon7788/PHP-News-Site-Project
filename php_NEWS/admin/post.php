<?php

include "header.php";
include "config.php";

// For Pagination
if (isset($_GET['pageNo'])) {
   $currentPageNumber = $_GET['pageNo'];
} else {
   $currentPageNumber = 1;
}
$limitOffset = ($currentPageNumber - 1) * $recordsLimitPerPage;

if ($_SESSION['role'] == '1') {
   $allPostsQuery = "SELECT p.post_id, p.title, c.category_name, c.category_id, p.post_date, u.username FROM post p
                     INNER JOIN category c
                     ON p.category = c.category_id
                     INNER JOIN user u
                     ON p.author = u.user_id
                     ORDER BY post_id DESC LIMIT {$limitOffset}, {$recordsLimitPerPage}";
} else if ($_SESSION['role'] == '0') {
   $allPostsQuery = "SELECT p.post_id, p.title, c.category_name, c.category_id, p.post_date, u.username FROM post p
                     INNER JOIN category c
                     ON p.category = c.category_id
                     INNER JOIN user u
                     ON p.author = u.user_id
                     WHERE p.author = '{$_SESSION['userId']}'
                     ORDER BY post_id DESC LIMIT {$limitOffset}, {$recordsLimitPerPage}";
}

$resultAllPostsQuery = mysqli_query($connection, $allPostsQuery) or die("Query Failed: $allPostsQuery");

?>
<div id="admin-content">
   <div class="container">
      <div class="row">
         <div class="col-md-10">
            <h1 class="admin-heading">All Posts</h1>
         </div>
         <div class="col-md-2">
            <a class="add-new" href="add-post.php">add post</a>
         </div>
         <div class="col-md-12">
            <?php
            if (mysqli_num_rows($resultAllPostsQuery) > 0) {
            ?>
               <table class="content-table">
                  <thead>
                     <th>S.No.</th>
                     <th>Title</th>
                     <th>Category</th>
                     <th>Date</th>
                     <th>Author</th>
                     <th>Edit</th>
                     <th>Delete</th>
                  </thead>
                  <tbody>
                     <?php
                     $serialNumber = $limitOffset;
                     while ($postRow = mysqli_fetch_assoc($resultAllPostsQuery)) {
                     ?>
                        <tr>
                           <td class='id'> <?php echo ++$limitOffset ?> </td>
                           <td> <?php echo $postRow['title'] ?> </td>
                           <td> <?php echo $postRow['category_name'] ?> </td>
                           <td> <?php echo $postRow['post_date'] ?> </td>
                           <td> <?php echo $postRow['username'] ?> </td>
                           <td class='edit'><a href='update-post.php?postIdUrl=<?php echo $postRow['post_id'] ?>'><i class='fa fa-edit'></i></a></td>
                           <td class='delete'>
                              <a href='delete-post.php?categoryIdUrl=<?php echo $postRow['category_id'] ?>&postIdUrl=<?php echo $postRow['post_id'] ?>&postUserNameUrl=<?php echo $postRow['username'] ?>'>
                                 <i class='fa fa-trash-o'></i>
                              </a>
                           </td>
                        </tr>
                     <?php
                     }
                     ?>
                  </tbody>
               </table>
            <?php
            }

            // For Pagination
            if ($_SESSION['role'] == '1') {
               $totalRecordsQuery = "SELECT * FROM post";
            } else if ($_SESSION['role'] == '0') {
               $totalRecordsQuery = "SELECT * FROM post WHERE author = '{$_SESSION['userId']}'";
            }
            $resultTotalRecordsQuery = mysqli_query($connection, $totalRecordsQuery) or die("Query Error: $totalRecordsQuery");
            $totalRecords = mysqli_num_rows($resultTotalRecordsQuery);
            if ($totalRecords > $recordsLimitPerPage) {
               $totalPages = ceil($totalRecords / $recordsLimitPerPage);
            ?>
               <ul class='pagination admin-pagination'>
               <?php
               if ($currentPageNumber > 1) {
                  echo '<li><a href="post.php?pageNo=' . ($currentPageNumber - 1) . '">Prev</a></li>';
               }
               for ($p = 1; $p <= $totalPages; $p++) {
                  if ($p == $currentPageNumber) {
                     $cssClass = "active";
                  } else {
                     $cssClass = "";
                  }
                  echo "<li class='$cssClass'><a href='post.php?pageNo=$p'> $p </a></li>";
               }
               if ($currentPageNumber < $totalPages) {
                  echo '<li><a href="post.php?pageNo=' . ($currentPageNumber + 1) . '">Next</a></li>';
               }
            }
               ?>
         </div>
      </div>
   </div>
</div>
<?php
include "footer.php";
mysqli_close($connection);
?>