<?php
include "header.php";
include "config.php";
?>

<div id="admin-content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="admin-heading">Website Settings</h1>
      </div>
      <div class="col-md-offset-3 col-md-6">

        <?php
        $fetchSettingsQuery = "SELECT * FROM settings";
        $resultFetchSettingsQuery = mysqli_query($connection, $fetchSettingsQuery) or die("Query Failed: $fetchSettingsQuery");

        if (mysqli_num_rows($resultFetchSettingsQuery) > 0) {
          while ($setting = mysqli_fetch_assoc($resultFetchSettingsQuery)) {
        ?>
            <!-- Form Starts -->
            <form action="save-settings.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label for="website_name">Website Name</label>
                <input type="text" name="website_name" value="<?php echo $setting['webname'] ?>" class="form-control" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="logo">Website Logo</label>
                <input type="file" name="logo">
                <img src="images/<?php echo $setting['logo'] ?>" class="logo" alt="LOGO Image">
                <input type="hidden" name="old_logo" value="<?php echo $setting['logo'] ?>">
              </div>
              <div class="form-group">
                <label for="footer_desc">Footer Description</label>
                <textarea name="footer_desc" class="form-control" rows="5" required><?php echo $setting['footerdesc'] ?></textarea>
              </div>
              <input type="submit" name="submit" class="btn btn-primary" value="Save">
            </form>
            <!-- Form End -->
        <?php
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