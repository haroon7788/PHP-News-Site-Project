<?php

include "header.php";
include "config.php";

if ($_SESSION['role'] == '0') {
   header("Location: {$hostName}/admin/post.php");
   die();
}

if (isset($_GET['pageNo'])) {
   $currentPageNumber = $_GET['pageNo'];
} else {
   $currentPageNumber = 1;
}

$limitOffset = ($currentPageNumber - 1) * $recordsLimitPerPage;
$allCategoriesQuery = "SELECT * FROM category ORDER BY category_id DESC LIMIT {$limitOffset}, {$recordsLimitPerPage}";
$resultAllCategoriesQuery = mysqli_query($connection, $allCategoriesQuery) or die("Query Failed: $allCategoriesQuery");


?>
<div id="admin-content">
   <div class="container">
      <div class="row">
         <div class="col-md-10">
            <h1 class="admin-heading">All Categories</h1>
         </div>
         <div class="col-md-2">
            <a class="add-new" href="add-category.php">add category</a>
         </div>
         <div class="col-md-12">

            <?php
            if (mysqli_num_rows($resultAllCategoriesQuery) > 0) {
            ?>

               <table class="content-table">
                  <thead>
                     <th>S.No.</th>
                     <th>Category Name</th>
                     <th>No. of Posts</th>
                     <th>Edit</th>
                     <th>Delete</th>
                  </thead>
                  <tbody>
                     <?php
                     $serialNumber = $limitOffset;
                     while ($catRow = mysqli_fetch_assoc($resultAllCategoriesQuery)) {
                     ?>
                        <tr>
                           <td class='id'> <?php echo ++$serialNumber ?> </td>
                           <td> <?php echo $catRow['category_name'] ?> </td>
                           <td> <?php echo $catRow['post'] ?> </td>
                           <td class='edit'><a href="update-category.php?idUrl=<?php echo $catRow['category_id'] ?>"><i class='fa fa-edit'></i></a></td>
                           <td class='delete'><a href="delete-category.php?idUrl=<?php echo $catRow['category_id'] ?>"><i class='fa fa-trash-o'></i></a></td>
                        </tr>
                     <?php
                     }
                     ?>
                  </tbody>
               </table>
            <?php
            }

            $totalCategoriesQuery = "SELECT * FROM category";
            $resultTotalCategoriesQuery = mysqli_query($connection, $totalCategoriesQuery) or die("Query Failed: $totalCategoriesQuery");
            $totalRecords = mysqli_num_rows($resultTotalCategoriesQuery);

            if ($totalRecords > $recordsLimitPerPage) {
               $totalPages = ceil($totalRecords / $recordsLimitPerPage);
            ?>
               <ul class='pagination admin-pagination'>
                  <?php
                  if ($currentPageNumber > 1) {
                  ?>
                     <li><a href='category.php?pageNo=<?php echo ($currentPageNumber - 1) ?>'>Prev</a></li>
                  <?php
                  }
                  for ($p = 1; $p <= $totalPages; $p++) {
                     if ($p == $currentPageNumber) {
                        $cssClass = "active";
                     } else {
                        $cssClass = "";
                     }
                     echo "<li class='$cssClass'><a href='category.php?pageNo=$p'>$p</a></li>";
                  }
                  if ($currentPageNumber < $totalPages) {
                  ?>
                     <li><a href='category.php?pageNo=<?php echo ($currentPageNumber + 1) ?>'>Next</a></li>
                  <?php
                  }
                  ?>
               </ul>
            <?php
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