<?php include( './admin/inc/db.php' );
?>
<?php include( './includes/globalFunctions.php' );
?>
<?php include( './includes/globalSessions.php' );
?>

<?php
if ( isset( $_SESSION[ 'UserId' ] ) ) {
    Redirect_to( 'admin-dashboard.php' );
}
?>

<?php

if ( isset( $_POST[ 'LoginUser' ] ) ) {
    $UserName = filter_var( $_POST[ 'Username' ], FILTER_UNSAFE_RAW );
    $Password = md5( filter_var( $_POST[ 'Password' ], FILTER_UNSAFE_RAW ) );

    if ( empty( $UserName ) || empty( $Password ) ) {
        $_SESSION[ 'ErrorMessage' ] = 'All fields must be filled out';
        Redirect_to( 'login.php' );
    } else {
        $FoundAccount = LoginAttempt( $UserName, $Password );
        if ( $FoundAccount ) {
            $_SESSION[ 'UserId' ] = $FoundAccount[ 'id' ];
            $_SESSION[ 'UserName' ] = $FoundAccount[ 'username' ];
            $_SESSION[ 'AdminName' ] = $FoundAccount[ 'aname' ];
            $_SESSION[ 'SuccessMessage' ] = 'Welcome '.$_SESSION[ 'AdminName' ].'!';
            if ( isset( $_SESSION[ 'TrackingURL' ] ) ) {
                Redirect_to( $_SESSION[ 'TrackingURL' ] );
            } else {
                Redirect_to( 'admin-dashboard.php' );
            }
        } else {
            $_SESSION[ 'ErrorMessage' ] = 'Incorrect Username/Password';
            Redirect_to( 'login.php' );
        }
    }
}

?>

<?php include( './includes/head.php' );
?>
<?php include( './includes/loginNavbar.php' );
?>

<section class='container py-2 mb-6 custom_main_login_form_container'>
  <div class='row'>
    <div class='offset-sm-3 col-sm-6' style='min-height:500px;'>
      <br><br><br>
      <?php
echo ErrorMessage();
echo SuccessMessage();
?>
      <div class='card text-white global_login_register_form_box' style='background:#dc3545;'>
        <div class='card-header'>
          <h4>Welcome Back !</h4>
        </div>
        <div class='card-body' style='background: #0f0f3e;'>
          <form class='' action='login.php' method='POST'>
            <div class='form-group'>
              <label for='username'><span class='FieldInfo text-white'>Username:</span></label>
              <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                  <span class='input-group-text text-white bg-danger'> <i class='fas fa-user'></i> </span>
                </div>
                <input type='text' class='form-control' name='Username' id='username' autocomplete='off' value=''>
              </div>
            </div>
            <div class='form-group'>
              <label for='password'><span class='FieldInfo text-white'>Password:</span></label>
              <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                  <span class='input-group-text text-white bg-danger'> <i class='fas fa-lock'></i> </span>
                </div>
                <input type='password' class='form-control' name='Password' id='password' autocomplete='off' value=''>
              </div>
            </div>
            <input type='submit' name='LoginUser' class='btn btn-danger text-white btn-block global_btn_margin_top'
              value='Login'>
          </form>

        </div>

      </div>

    </div>

  </div>

</section>