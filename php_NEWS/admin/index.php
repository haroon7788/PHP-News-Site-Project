<?php

include "config.php";
session_start();

if (isset($_SESSION['userName']) && isset($_SESSION['userId']) && isset($_SESSION['role'])) {
   header("Location: {$hostName}/admin/post.php");
}

?>

<!doctype html>
<html>

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>ADMIN | Login</title>
   <link rel="stylesheet" href="../css/bootstrap.min.css" />
   <link rel="stylesheet" href="font/font-awesome-4.7.0/css/font-awesome.css">
   <link rel="stylesheet" href="../css/style.css">
</head>

<body>
   <div id="wrapper-admin" class="body-content">
      <div class="container">
         <div class="row">
            <div class="col-md-offset-4 col-md-4">
               <?php
               $selectLogo = "SELECT logo FROM settings";
               $resultSelectLogo = mysqli_query($connection, $selectLogo) or die("Query Failed: $selectLogo");
               if (mysqli_num_rows($resultSelectLogo) > 0) {
                  while ($image = mysqli_fetch_assoc($resultSelectLogo)) {
               ?>
                     <img class="logo" src="images/<?php echo $image['logo'] ?>">
               <?php
                  }
               }
               ?>
               <h3 class="heading">Admin</h3>
               <!-- Form Start -->
               <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                  <div class="form-group">
                     <label>Username</label>
                     <input type="text" name="username" class="form-control" placeholder="" required>
                  </div>
                  <div class="form-group">
                     <label>Password</label>
                     <input type="password" name="password" class="form-control" placeholder="" required>
                  </div>
                  <input type="submit" name="login" class="btn btn-primary" value="login" />
               </form>
               <!-- /Form  End -->
               <?php

               if (isset($_POST['login'])) {
                  if (empty($_POST['username']) && empty($_POST['password'])) {
                     echo "<div class='alert alert-danger text-center' style='margin-top:10px; font-size:18px;'>All Fields Must Be Filled!</div>";
                     die();
                  }

                  $username = mysqli_real_escape_string($connection, $_POST['username']);
                  $password = mysqli_real_escape_string($connection, sha1($_POST['password']));

                  $loginQuery = "SELECT user_id, username, role FROM user WHERE username = '{$username}' AND password = '{$password}'";
                  $resultLoginQuery = mysqli_query($connection, $loginQuery) or die("Query Failed: $loginQuery");

                  if (mysqli_num_rows($resultLoginQuery) == 1) {
                     while ($userRow = mysqli_fetch_assoc($resultLoginQuery)) {
                        $_SESSION['userId'] = $userRow['user_id'];
                        $_SESSION['userName'] = $userRow['username'];
                        $_SESSION['role'] = $userRow['role'];
                     }
                     header("Location: {$hostName}/admin/post.php");
                  } else {
                     echo "<div class='alert alert-danger text-center' style='margin-top:10px; font-size:18px;'>Invalid UserName or Password!</div>";
                  }
               }

               mysqli_close($connection);

               ?>
            </div>
         </div>
      </div>
   </div>
</body>

</html>