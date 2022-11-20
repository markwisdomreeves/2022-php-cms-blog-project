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
if ( isset( $_POST[ 'createAdmin' ] ) ) {
    $UserName = filter_var( $_POST[ 'Username' ], FILTER_UNSAFE_RAW );
    $Name = filter_var( $_POST[ 'Name' ], FILTER_UNSAFE_RAW );
    $Password = md5( filter_var( $_POST[ 'Password' ], FILTER_UNSAFE_RAW ) );
    $ConfirmPassword = md5( filter_var( $_POST[ 'ConfirmPassword' ], FILTER_UNSAFE_RAW ) );

    $AddedByTheAdminName = $_SESSION[ 'UserName' ];

    // PHP timezone
    date_default_timezone_set( 'Europe/Rome' );
    $CurrentTime = time();
    $DateTime = strftime( '%B-%d-%Y %H:%M:%S', $CurrentTime );
    // End of PHP timezone

    if ( strlen( $Password ) < 5 ) {
        $_SESSION[ 'ErrorMessage' ] = 'Password must be greater than 4 characters';
        Redirect_to( 'manage-admins.php' );
    } elseif ( $Password !== $ConfirmPassword ) {
        $_SESSION[ 'ErrorMessage' ] = 'Password and confirm password should match';
        Redirect_to( 'manage-admins.php' );
    } elseif ( CheckIfUserNameExistsOrNot( $UserName ) ) {
        $_SESSION[ 'ErrorMessage' ] = 'Username already exist. Please try a new one!';
        Redirect_to( 'manage-admins.php' );
    } else {
        // Query to insert a new admin in the DB when everything is OK
        global $conn;
        $sql = 'INSERT INTO admin (datetime,username,password,aname,addedby)';
        $sql .= 'VALUES(:dateTime,:userName,:userPassword,:adminName,:addedByTheAdminName)';
        $stmt = $conn->prepare( $sql );
        $stmt->bindValue( ':dateTime', $DateTime );
        $stmt->bindValue( ':userName', $UserName );
        $stmt->bindValue( ':userPassword', $Password );
        $stmt->bindValue( ':adminName', $Name );
        $stmt->bindValue( ':addedByTheAdminName', $AddedByTheAdminName );
        $Execute = $stmt->execute();
        if ( $Execute ) {
            $_SESSION[ 'SuccessMessage' ] = 'New Admin with the name of '.$UserName.' added successfully';
            Redirect_to( 'manage-admins.php' );
        } else {
            $_SESSION[ 'ErrorMessage' ] = 'Something went wrong. Please try again';
            Redirect_to( 'manage-admins.php' );
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

  <title>Admin Page</title>
</head>

<body>

  <!-- Admin Navbar section -->
  <?php include ( './admin/inc/AdminNavbar.php' );
?>

  <!-- Header section -->
  <header class='bg-dark text-white py-3'>
    <div class='container'>
      <div class='row'>
        <div class='col-md-12 text-info'>
          <h1 class='global_text_size_on_small_screen_dashboard_title'><i class='fas fa-user'></i> Manage
            Admins</h1>
        </div>
      </div>
    </div>
  </header>
  <!-- End of header section -->

  <!-- Main categories section -->
  <section class='container py-2 mb-4'>
    <div class='row'>
      <div class='offset-lg-1 col-lg-10' style='min-height:400px;'>
        <?php
echo ErrorMessage();
echo SuccessMessage();
?>
        <form class='' action='manage-admins.php' method='POST'>
          <div class='card bg-secondary text-light mb-3'>
            <div class='card-header'>
              <h1 class='global_text_size_on_small_screen_dashboard_title'>Add New Admin</h1>
            </div>
            <div class='card-body bg-dark'>
              <div class='form-group'>
                <label for='username'> <span class='FieldInfo'> Username: </span></label>
                <input class='form-control' type='text' name='Username' id='username' placeholder='Add username'
                  value='' autocomplete='off' required>
              </div>
              <div class='form-group'>
                <label for='name'> <span class='FieldInfo'> Name: </span></label>
                <input class='form-control' type='text' name='Name' id='name' placeholder='Add name' autocomplete='off'
                  value='' required>
              </div>
              <div class='form-group'>
                <label for='password'> <span class='FieldInfo'> Password: </span></label>
                <input class='form-control' type='password' name='Password' id='password' placeholder='Add password'
                  value='' autocomplete='off' required>
              </div>
              <div class='form-group'>
                <label for='confirmPassword'> <span class='FieldInfo'> Confirm Password: </span></label>
                <input class='form-control' type='password' name='ConfirmPassword' id='confirmPassword'
                  placeholder='Add Confirm Password' autocomplete='off' value='' required>
              </div>
              <div class='row'>
                <div class='col-lg-6 mb-2'>
                  <a href='admin-dashboard.php' class='btn btn-warning btn-block'><i class='fas fa-arrow-left'></i>
                    Back To
                    Dashboard</a>
                </div>
                <div class='col-lg-6 mb-2'>
                  <button type='submit' name='createAdmin' class='btn btn-success btn-block'>
                    <i class='fas fa-check'></i> Submit
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
        <h2 class='global_text_size_on_small_screen_dashboard_title'>Existing Admins</h2>
        <div class='global_responsive_table_container'>
          <table class='table table-striped table-hover'>
            <thead class='thead-dark'>
              <tr>
                <th>No. </th>
                <th>Date</th>
                <th>Username</th>
                <th>Admin</th>
                <th>AddedBy</th>
                <th>Action</th>
              </tr>
            </thead>

            <?php
global $conn;
$sql = 'SELECT * FROM admin ORDER BY id DESC';
$Execute = $conn->query( $sql );
$SrNo = 0;
while ( $DataRows = $Execute->fetch() ) {
    $AdminId = $DataRows[ 'id' ];
    $DateAndTime = $DataRows[ 'datetime' ];
    $AdminUserName = $DataRows[ 'username' ];
    $AdminName = $DataRows[ 'aname' ];
    $AddedBy = $DataRows[ 'addedby' ];
    $SrNo++;
    ?>
            <tbody>
              <tr>
                <td><?php echo htmlentities( $SrNo );
    ?></td>
                <td>
                  <?php if ( strlen( $DateAndTime ) > 10 ) {
        $DateAndTime = substr( $DateAndTime, 0, 12 ).'...';
    }
    echo htmlentities( $DateAndTime );
    ?>
                </td>
                <td><?php echo htmlentities( $AdminUserName );
    ?></td>
                <td><?php echo htmlentities( $AdminName );
    ?></td>
                <td><?php echo htmlentities( $AddedBy );
    ?></td>
                <td> <a href="delete-admin.php?id=<?php echo $AdminId; ?>" class='btn btn-danger'>Delete</a> </td>
            </tbody>
            <?php }
    ?>
          </table>
        </div>
      </div>
    </div>
  </section>
  <!-- End of main categories section -->

  <!-- Footer section -->
  <?php include ( './admin/inc/footer.php' );
    ?>