<?php include( './admin/inc/db.php' );
?>
<?php include( './includes/globalSessions.php' );
?>

<?php require_once( './includes/globalFunctions.php' );
?>

<?php
$_SESSION[ 'UserId' ] = null;
$_SESSION[ 'UserName' ] = null;
$_SESSION[ 'AdminName' ] = null;
session_destroy();
Redirect_to( 'login.php' );
?>