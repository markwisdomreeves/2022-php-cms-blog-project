<?php include( './admin/inc/db.php' );
?>
<?php include( './includes/globalFunctions.php' );
?>
<?php include( './includes/globalSessions.php' );
?>

<?php
if ( isset( $_GET[ 'id' ] ) ) {
    $SearchQueryParam = $_GET[ 'id' ];
    global $conn;
    $sql = "DELETE FROM admin WHERE id='$SearchQueryParam'";
    $Execute = $conn->query( $sql );
    if ( $Execute ) {
        $_SESSION[ 'SuccessMessage' ] = 'Admin Deleted Successfully !';
        Redirect_to( 'manage-admins.php' );
    } else {
        $_SESSION[ 'ErrorMessage' ] = 'Something went wrong. Please try again';
        Redirect_to( 'manage-admins.php' );
    }

}

?>