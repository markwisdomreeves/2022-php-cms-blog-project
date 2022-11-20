<?php include( './admin/inc/db.php' );
?>
<?php include( './includes/globalFunctions.php' );
?>
<?php include( './includes/globalSessions.php' );
?>
<?php $_SESSION[ 'TrackingURL' ] = $_SERVER[ 'PHP_SELF' ];
?>
<?php ConfirmIfUserIsLoginOrNot();
?>

<?php
// Start of fetching existing Admin data when they login
$AdminId = $_SESSION[ 'UserId' ];
global $conn;
$sql = "SELECT * FROM admin WHERE id='$AdminId'";
$stmt = $conn->query( $sql );
while ( $DataRows = $stmt->fetch() ) {
    $ExistingAdminName = $DataRows[ 'aname' ];
    $ExistingAdminUsername = $DataRows[ 'username' ];
    $ExistingAdminHeadline = $DataRows[ 'aheadline' ];
    $ExistingAdminBio = $DataRows[ 'abio' ];
    $ExistingAdminImage = $DataRows[ 'aimage' ];
}

// End of fetching existing Admin data when they login
if ( isset( $_POST[ 'CreateMyProfile' ] ) ) {
    $AdminName = filter_var($_POST[ 'Name' ], FILTER_UNSAFE_RAW );
    $AdminHeadline = filter_var($_POST[ 'Headline' ], FILTER_UNSAFE_RAW );
    $AdminBio = filter_var($_POST[ 'Bio' ], FILTER_UNSAFE_RAW );
    $Image = $_FILES[ 'Image' ][ 'name' ];

    $Target = 'images/'.basename( $_FILES[ 'Image' ][ 'name' ] );

    if ( strlen( $AdminHeadline ) > 300 ) {
        $_SESSION[ 'ErrorMessage' ] = 'Headline should be less than 300 characters';
        Redirect_to( 'my-profile.php' );
    } elseif ( strlen( $AdminBio ) > 5000 ) {
        $_SESSION[ 'ErrorMessage' ] = 'Bio should be less than 5000 characters';
        Redirect_to( 'my-profile.php' );
    } elseif ( empty( $AdminBio ) && empty( $AdminHeadline ) ) {
        $_SESSION[ 'ErrorMessage' ] = 'All fields must be fill out';
        Redirect_to( 'my-profile.php' );
    } else {
        // Query to update Admin data in DB when everything is ok.
        global $conn;
        if ( !empty( $_FILES[ 'Image' ][ 'name' ] ) ) {
            $sql = "UPDATE admin SET aname='$AdminName', aheadline='$AdminHeadline', abio='$AdminBio', aimage='$Image' WHERE id='$AdminId'";
        } else {
            $sql = "UPDATE admin SET aname='$AdminName', aheadline='$AdminHeadline', abio='$AdminBio' WHERE id='$AdminId'";
        }

        $Execute = $conn->query( $sql );

        move_uploaded_file( $_FILES[ 'Image' ][ 'tmp_name' ], $Target );

        if ( $Execute ) {
            $_SESSION[ 'SuccessMessage' ] = 'Details have been updated successfully';
            Redirect_to( 'my-profile.php' );
        } else {
            $_SESSION[ 'ErrorMessage' ] = 'Something went wrong. Try Again!';
            Redirect_to( 'my-profile.php' );
        }
    }
}

?>

<!-- PHP CODE SECTION ABOVE -->
<!DOCTYPE html>
<html lang='en'>

<head>
  <!-- Head section -->
  <?php include ( './includes/head.php' );
?>

  <title>My profile Page</title>
</head>

<body>

  <!-- Admin Navbar section -->
  <?php include ( './admin/inc/AdminNavbar.php' );
?>

  <!-- Start of Header -->
  <header class='text-white py-3' style='background:#0f0f3e;'>
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h1 class='global_text_size_on_small_screen_dashboard_title'>
            <i class='fas fa-user text-white mr-2'>
              @<?php echo $ExistingAdminUsername;
?>
            </i>
          </h1>
          <small><?php echo $ExistingAdminHeadline;
?></small>
        </div>
      </div>
    </div>
  </header>
  <!-- End of Header -->

  <!-- Main my profile section -->
  <section class='container py-2 mb-4'>
    <div class='row'>
      <!-- Left Area section -->
      <div class='col-md-4'>
        <div class='card'>
          <div class='card-header bg-dark text-light text-center'>
            <h3 class='global_text_size_on_small_screen_admin_name'> <?php echo $ExistingAdminName;
?></h3>
          </div>
          <div class='card-body'>
            <img src="./images/<?php echo $ExistingAdminImage; ?>" class='img-fluid mb-3 my_custom_profile_image'
              alt='admin-image'>
            <div class='my_custom_profile_paragraph'>
              <?php echo $ExistingAdminBio;
?>
            </div>
          </div>

        </div>
      </div>

      <!-- Right Area section -->
      <div class='col-md-8' style='min-height:400px;'>
        <?php
echo ErrorMessage();
echo SuccessMessage();
?>
        <form class='' action='my-profile.php' method='POST' enctype='multipart/form-data'>
          <div class='card bg-dark text-light mb-3'>
            <div class='card-header'>
              <h1 class='global_text_size_on_small_screen_dashboard_title'>Add or Update Admin's Profile</h1>
            </div>
            <div class='card-body bg-dark'>
              <div class='form-group'>
                <input class='form-control' type='text' name='Name' id='Name' placeholder='Add your name' value=''
                  autocomplete='off'>
              </div>
              <div class='form-group'>
                <input class='form-control mb-2' type='text' name='Headline' id='Headline' placeholder='Add your title'
                  autocomplete='off' value=''>
                <span class='text-muted'> Add a professional headline like, 'Teacher' work at XYZ Company.
                </span>
                <span class='text-danger'>Not more then 30 characters</span>
              </div>
              <div class='form-group'>
                <textarea class='form-control' name='Bio' id='Bio' cols='80' rows='8'
                  placeholder='Briefly explain about yourself'></textarea>
              </div>
              <div class='form-group'>
                <div class='custom-file'>
                  <input type='file' class='custom-file-input' name='Image' id='imageSelect' value=''>
                  <label for='imageSelect' class='custom-file-label'>Select Image</label>
                </div>
              </div>
              <div class='row'>
                <div class='col-lg-6 mb-2'>
                  <a href='admin-dashboard.php' class='btn btn-warning btn-block'><i class='fas fa-arrow-left'></i>
                    Back To
                    Dashboard</a>
                </div>
                <div class='col-lg-6 mb-2'>
                  <button type='submit' name='CreateMyProfile' class='btn btn-success btn-block'>
                    <i class='fas fa-check'></i> Submit
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
  <!-- End of main my profile section -->

  <!-- Footer section -->
  <?php include ( './admin/inc/footer.php' );
?>