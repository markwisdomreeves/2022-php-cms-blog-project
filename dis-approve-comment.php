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
    $AdminName = $_SESSION[ 'AdminName' ];
    $sql = "UPDATE comments SET status = 'OFF', approvedby='$AdminName' WHERE id='$SearchQueryParam'";
    $Execute = $conn->query( $sql );
    if ( $Execute ) {
        $_SESSION[ 'SuccessMessage' ] = 'Comment Dis-Approved Successfully !';
        Redirect_to( 'view-all-comments.php' );
    } else {
        $_SESSION[ 'ErrorMessage' ] = 'Something went wrong. Please try again';
        Redirect_to( 'view-all-comments.php' );
    }

}

?>
