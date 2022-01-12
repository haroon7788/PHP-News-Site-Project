<?php

include "header.php";
include "config.php";

if ($_SESSION['role'] == '0') {
   header("Location: {$hostName}/admin/post.php");
   die();
}

$userIdUrl = $_GET['idUrl'];

if (isset($_POST['submit'])) {

   $firstName = mysqli_real_escape_string($connection, $_POST['f_name']);
   $lastName = mysqli_real_escape_string($connection, $_POST['l_name']);
   $userName = mysqli_real_escape_string($connection, $_POST['username']);
   $userRole = mysqli_real_escape_string($connection, $_POST['role']);

   $updateUserQuery = "UPDATE user SET first_name='{$firstName}', last_name='{$lastName}', username='{$userName}', role='{$userRole}' WHERE user_id = '{$userIdUrl}'";
   $resultUpdateUserQuery = mysqli_query($connection, $updateUserQuery) or die("Query Failed: $updateUserQuery");

   header("Location: {$hostName}/admin/users.php");
}

?>
<div id="admin-content">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <h1 class="admin-heading">Modify User Details</h1>
         </div>
         <div class="col-md-offset-4 col-md-4">
            <!------------------------ Form Start ------------------------>
            <?php

            $printUserQuery = "SELECT * FROM user WHERE user_id = '{$userIdUrl}'";
            $resultPrintUserQuery = mysqli_query($connection, $printUserQuery) or die("Query Failed: $printUserQuery");

            while ($userRow = mysqli_fetch_assoc($resultPrintUserQuery)) {

            ?>
               <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                  <div class="form-group">
                     <input type="hidden" name="user_id" class="form-control" value=" <?php echo $userRow['user_id'] ?> " placeholder="">
                  </div>
                  <div class="form-group">
                     <label>First Name</label>
                     <input type="text" name="f_name" class="form-control" value=" <?php echo $userRow['first_name'] ?> " placeholder="" required>
                  </div>
                  <div class="form-group">
                     <label>Last Name</label>
                     <input type="text" name="l_name" class="form-control" value=" <?php echo $userRow['last_name'] ?> " placeholder="" required>
                  </div>
                  <div class="form-group">
                     <label>User Name</label>
                     <input type="text" name="username" class="form-control" value=" <?php echo $userRow['username'] ?> " placeholder="" required>
                  </div>
                  <div class="form-group">
                     <label>User Role</label>
                     <select class="form-control" name="role" value=" <?php echo $userRow['role'] ?> ">
                        <?php
                        if ($userRow['role'] == 0) {
                           echo "<option value='0' selected> Normal User </option>;
                                 <option value='1'> Admin </option>";
                        } else {
                           echo "<option value='0'> Normal User </option>;
                                 <option value='1' selected> Admin </option>";
                        }
                        ?>
                     </select>
                  </div>
                  <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
               </form>
            <?php
            }
            ?>
            <!------------------------ Form End ------------------------>
         </div>
      </div>
   </div>
</div>
<?php
include "footer.php";
mysqli_close($connection);
?>