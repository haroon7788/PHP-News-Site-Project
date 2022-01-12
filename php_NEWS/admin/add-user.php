<?php

include "header.php";
include "config.php";
include "add-filters.php";

if ($_SESSION['role'] == '0') {
   header("Location: {$hostName}/admin/post.php");
   die();
}

if (isset($_POST['save'])) {

   $firstName = my_filter($_POST['fname']);
   $lastName = my_filter($_POST['lname']);
   $user = my_filter($_POST['user']);
   $role = my_filter($_POST['role']);
   $password = mysqli_real_escape_string($connection, sha1($_POST['password']));

   $checkUserExistanceQuery = "SELECT * FROM user WHERE username = '{$user}'";
   $resultCheckUserExistanceQuery = mysqli_query($connection, $checkUserExistanceQuery) or die("Invalid Query: ");

   if (mysqli_num_rows($resultCheckUserExistanceQuery) > 0) {
      echo "<h4 style='background-color:red; text-align:center; margin:12px auto'>User Name already exists. Please choose a unique User Name.</h4>";
   } else {
      $insertUserQuery = "INSERT INTO user (first_name, last_name, username, password, role) VALUES ('{$firstName}' , '{$lastName}', '{$user}', '{$password}', '{$role}')";
      $resultInsertUserQuery = mysqli_query($connection, $insertUserQuery);

      header("Location: {$hostName}/admin/users.php");
   }
}

?>
<div id="admin-content">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <h1 class="admin-heading">Add User</h1>
         </div>
         <div class="col-md-offset-3 col-md-6">
            <!------------------------ Form Start ------------------------>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
               <div class="form-group">
                  <label>First Name</label>
                  <input type="text" name="fname" class="form-control" placeholder="First Name" required>
               </div>
               <div class="form-group">
                  <label>Last Name</label>
                  <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
               </div>
               <div class="form-group">
                  <label>User Name</label>
                  <input type="text" name="user" class="form-control" placeholder="Username" required>
               </div>

               <div class="form-group">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control" placeholder="Password" required>
               </div>
               <div class="form-group">
                  <label>User Role</label>
                  <select class="form-control" name="role">
                     <option value="0">Normal User</option>
                     <option value="1">Admin</option>
                  </select>
               </div>
               <input type="submit" name="save" class="btn btn-primary" value="Save" required />
            </form>
            <?php

            mysqli_close($connection);

            ?>
            <!------------------------ Form End ------------------------>
         </div>
      </div>
   </div>
</div>
<?php include "footer.php"; ?>