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
    $sql = "DELETE FROM category WHERE id='$SearchQueryParam'";
    $Execute = $conn->query( $sql );
    if ( $Execute ) {
        $_SESSION[ 'SuccessMessage' ] = 'Category Deleted Successfully !';
        Redirect_to( 'view-all-categories.php' );
    } else {
        $_SESSION[ 'ErrorMessage' ] = 'Something went wrong. Please try again';
        Redirect_to( 'view-all-categories.php' );
    }

}

?>
