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

$allUsersQuery = "SELECT * FROM user ORDER BY user_id DESC LIMIT {$limitOffset}, {$recordsLimitPerPage}";
$resultAllUsersQuery = mysqli_query($connection, $allUsersQuery) or die("Query Failed: $allUsersQuery");

?>
<div id="admin-content">
   <div class="container">
      <div class="row">
         <div class="col-md-10">
            <h1 class="admin-heading">All Users</h1>
         </div>
         <div class="col-md-2">
            <a class="add-new" href="add-user.php">add user</a>
         </div>
         <div class="col-md-12">

            <?php
            if (mysqli_num_rows($resultAllUsersQuery) > 0) {
            ?>
               <table class="content-table">
                  <thead>
                     <th>S.No.</th>
                     <th>Full Name</th>
                     <th>User Name</th>
                     <th>Role</th>
                     <th>Edit</th>
                     <th>Delete</th>
                  </thead>
                  <tbody>
                     <?php
                     $serialNumber = $limitOffset;
                     while ($userRow = mysqli_fetch_assoc($resultAllUsersQuery)) {
                        if ($userRow['role'] == 1) {
                           $userRole = "Admin";
                        } else {
                           $userRole = "Normal User";
                        }
                     ?>
                        <tr>
                           <td class='id'> <?php echo ++$serialNumber ?> </td>
                           <td> <?php echo $userRow['first_name'] . ' ' . $userRow['last_name'] ?> </td>
                           <td> <?php echo $userRow['username'] ?> </td>
                           <td> <?php echo $userRole ?> </td>
                           <td class='edit'><a href='update-user.php?idUrl=<?php echo $userRow['user_id'] ?>'><i class='fa fa-edit'></i></a></td>
                           <td class='delete'><a href='delete-user.php?idUrl=<?php echo $userRow['user_id'] ?>'><i class='fa fa-trash-o'></i></a></td>
                        </tr>
                     <?php
                     }
                     ?>
                  </tbody>
               </table>
            <?php
            }
            $TotalRecordsQuery = "SELECT * FROM user";
            $resultTotalRecordsQuery = mysqli_query($connection, $TotalRecordsQuery) or die("Query Error: $query");
            $totalRecords = mysqli_num_rows($resultTotalRecordsQuery);

            if ($totalRecords > $recordsLimitPerPage) {
               $totalPages = ceil($totalRecords / $recordsLimitPerPage);
            ?>
               <ul class='pagination admin-pagination'>
                  <?php
                  if ($currentPageNumber > 1) {
                     echo '<li><a href="users.php?pageNo=' . ($currentPageNumber - 1) . '">Prev</a></li>';
                  }
                  for ($p = 1; $p <= $totalPages; $p++) {
                     if ($p == $currentPageNumber) {
                        $cssClass = "active";
                     } else {
                        $cssClass = "";
                     }
                     echo "<li class='$cssClass'><a href='users.php?pageNo=$p'> $p </a></li>";
                  }
                  if ($currentPageNumber < $totalPages) {
                     echo '<li><a href="users.php?pageNo=' . ($currentPageNumber + 1) . '">Next</a></li>';
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