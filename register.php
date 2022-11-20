<!-- <?php include( './admin/inc/db.php' );
?>
<?php include( './includes/globalFunctions.php' );
?>
<?php include( './includes/globalSessions.php' );
?> -->

<?php
// if ( isset( $_SESSION[ 'UserId' ] ) ) {
//     Redirect_to( 'manage-dashboard.php' );
// }
// ?>

<?php

// if ( isset( $_POST[ 'LoginUser' ] ) ) {
//     $UserName = filter_var( $_POST[ 'Username' ], FILTER_UNSAFE_RAW );
//     $Password = md5( filter_var( $_POST[ 'Password' ], FILTER_UNSAFE_RAW ) );

//     if ( empty( $UserName ) || empty( $Password ) ) {
//         $_SESSION[ 'ErrorMessage' ] = 'All fields must be filled out';
//         Redirect_to( 'login.php' );
//     } else {
//         $FoundAccount = LoginAttempt( $UserName, $Password );
//         if ( $FoundAccount ) {
//             $_SESSION[ 'UserId' ] = $FoundAccount[ 'id' ];
//             $_SESSION[ 'UserName' ] = $FoundAccount[ 'username' ];
//             $_SESSION[ 'AdminName' ] = $FoundAccount[ 'aname' ];
//             $_SESSION[ 'SuccessMessage' ] = 'Welcome '.$_SESSION[ 'AdminName' ].'!';
//             if ( isset( $_SESSION[ 'TrackingURL' ] ) ) {
//                 Redirect_to( $_SESSION[ 'TrackingURL' ] );
//             } else {
//                 Redirect_to( 'manage-dashboard.php' );
//             }
//         } else {
//             $_SESSION[ 'ErrorMessage' ] = 'Incorrect Username/Password';
//             Redirect_to( 'login.php' );
//         }
//     }
// }

?>

<!-- <?php include( './includes/head.php' );
?>
<?php include( './includes/loginNavbar.php' );
?> -->

<!-- <section class = 'container py-2 mb-6 custom_main_register_form_container'>
<div class = 'row'>
<div class = 'col offset-sm-3 col-sm-6' style = 'min-height:500px;'>
<br><br><br>
<?php
echo ErrorMessage();
echo SuccessMessage();
?>
<div class = 'card text-white global_login_register_form_box' style = 'background:#17a2b8;'>
<div class = 'card-header'>
<h4>Create a new account</h4>
</div>
<div class = 'card-body bg-dark'>
<form class = '' action = 'register.php' method = 'POST'>
<div class = 'form-group'>
<label for = 'name'><span class = 'FieldInfo'>Name:</span></label>
<div class = 'input-group mb-3'>
<div class = 'input-group-prepend'>
<span class = 'input-group-text text-white bg-info'> <i class = 'fas fa-user'></i> </span>
</div>
<input type = 'text' class = 'form-control' name = 'Name' id = 'name' autocomplete = 'off' value = ''>
</div>
</div>
<div class = 'form-group'>
<label for = 'username'><span class = 'FieldInfo'>Username:</span></label>
<div class = 'input-group mb-3'>
<div class = 'input-group-prepend'>
<span class = 'input-group-text text-white bg-info'> <i class = 'fas fa-user'></i> </span>
</div>
<input type = 'text' class = 'form-control' name = 'Username' id = 'username' autocomplete = 'off' value = ''>
</div>
</div>
<div class = 'form-group'>
<label for = 'email'><span class = 'FieldInfo'>Email:</span></label>
<div class = 'input-group mb-3'>
<div class = 'input-group-prepend'>
<span class = 'input-group-text text-white bg-info'> <i class = 'fa fa-envelope' aria-hidden = 'true'></i>
</span>
</div>
<input type = 'email' class = 'form-control' name = 'Email' id = 'email' autocomplete = 'off' value = ''>
</div>
</div>
<div class = 'form-group'>
<label for = 'password'><span class = 'FieldInfo'>Password:</span></label>
<div class = 'input-group mb-3'>
<div class = 'input-group-prepend'>
<span class = 'input-group-text text-white bg-info'> <i class = 'fa fa-key' aria-hidden = 'true'></i>
</span>
</div>
<input type = 'password' class = 'form-control' name = 'Password' id = 'password' autocomplete = 'off' value = ''>
</div>
</div>
<div class = 'form-group'>
<label for = 'confirmPassword'><span class = 'FieldInfo'>Confirm Password:</span></label>
<div class = 'input-group mb-3'>
<div class = 'input-group-prepend'>
<span class = 'input-group-text text-white bg-info'> <i class = 'fa fa-key' aria-hidden = 'true'></i>
</span>
</div>
<input type = 'password' class = 'form-control' name = 'ConfirmPassword' id = 'confirmPassword'
autocomplete = 'off' value = ''>
</div>
</div>
<input type = 'submit' name = 'RegisterUser' class = 'btn btn-info btn-block global_btn_margin_top'
value = 'Register'>
</form>

<div class = 'global_login_register_text_box'>
<p> Already have an account? <a href = 'login.php'>Login</a> </p>
</div>

</div>

</div>

</div>

</div>

</section> -->