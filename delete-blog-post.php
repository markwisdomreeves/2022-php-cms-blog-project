<?php include( './admin/inc/db.php' );
?>
<?php include( './includes/globalFunctions.php' );
?>
<?php include( './includes/globalSessions.php' );
?>

<?php ConfirmIfUserIsLoginOrNot();
?>

<?php
$SearchQueryParams = $_GET[ 'id' ];
global $conn;
$sql = "SELECT * FROM posts WHERE id = '$SearchQueryParams'";
$stmt = $conn->query( $sql );
while ( $DataRows = $stmt->fetch() ) {
    $PostTitleToBeDeleted = $DataRows[ 'title' ];
    $PostCategoryToBeDeleted = $DataRows[ 'category' ];
    $PostImageToBeDeleted = $DataRows[ 'image' ];
    $PostDescriptionToBeDeleted = $DataRows[ 'description' ];
}
if ( isset( $_POST[ 'deletePost' ] ) ) {
    // Than query to delete Post from the database if everything is fine
    global $conn;
    $sql = "DELETE FROM posts WHERE id='$SearchQueryParams'";
    $Execute = $conn->query( $sql );
    if ( $Execute ) {
        $Targeted_image_path_to_the_folder_to_be_deleted = "uploads/$PostImageToBeDeleted";
        unlink( $Targeted_image_path_to_the_folder_to_be_deleted );
        $_SESSION[ 'SuccessMessage' ] = 'Post has been deleted successfully';
        Redirect_to( 'view-blog-posts.php' );
    } else {
        $_SESSION[ 'ErrorMessage' ] = 'Something went wrong. Please try again';
        Redirect_to( 'view-blog-posts.php' );
    }
}

?>

<!DOCTYPE html>
<html lang = 'en'>

<head>
<!-- Head section -->
<?php include ( './includes/head.php' );
?>
<title>Delete Post</title>
</head>

<body>
<!-- Admin Navbar section -->
<?php include ( './admin/inc/AdminNavbar.php' );
?>

<!-- Start of deader section -->
<header class = 'bg-dark text-white py-3'>
<div class = 'container'>
<div class = 'row'>
<div class = 'col-md-12'>
<h1 class = 'global_text_size_on_small_screen_dashboard_title'><i class = 'fa fa-trash text-info'></i> Delete
Post</h1>
</div>
</div>
</div>
</header>
<!-- End of header section-->

<!-- Main Post section -->
<section class = 'container py-2 mb-4' id = 'custom_margin_bottom'>
<div class = 'row'>
<div class = 'offset-lg-1 col-lg-10' style = 'min-height: 400px;'>
<?php
echo ErrorMessage();
echo SuccessMessage();
?>

<form action = "delete-blog-post.php?id=<?php echo $SearchQueryParams; ?>" method = 'POST'
enctype = 'multipart/form-data'>
<div class = 'card bg-secondary text-light mb-3'>
<div class = 'card-body bg-dark'>
<div class = 'form-group'>
<label for = 'PostTitle'>
<span class = 'FieldInfo'> Post Title: </span>
</label>
<input type = 'text' class = 'form-control' name = 'PostTitle' id = 'PostTitle' placeholder = 'Type post title'
value = "<?php echo $PostTitleToBeDeleted; ?>" disabled>
</div>
<div class = 'form-group'>
<span class = 'FieldInfo'>Existing Category: </span>
<?php echo $PostCategoryToBeDeleted ?>
<br>
<label for = 'CategoryTitle'>
<span class = 'FieldInfo'> Choose Category: </span>
</label>
<select class = 'form-control' name = 'CategoryTitle' id = 'CategoryTitle' disabled>
<?php
global $conn;
$sql = 'SELECT id, title FROM category';
$stmt = $conn->query( $sql );
while ( $DataRows = $stmt->fetch() ) {
    $CategoryId = $DataRows[ 'id' ];
    $CategoryName = $DataRows[ 'title' ];
    ?>
    <option><?php echo $CategoryName;
    ?></option>
    <?php }
    ?>
    </select>
    </div>
    <div class = 'form-group mb-1'>
    <span class = 'FieldInfo'>Existing Image: </span>
    <img class = 'mb-1' src = "uploads/<?php echo $PostImageToBeDeleted; ?>" width = '50px' ;
    height = '30px' ;
    alt = 'post-image' disabled>
    <br>
    <div class = 'custom-file'>
    <input type = 'File' class = 'custom-file-input' name = 'Image' id = 'imageSelect' value = '' disabled>
    <label for = 'imageSelect' class = 'custom-file-label'>Select Image</label>
    </div>
    </div>
    <div class = 'form-group'>
    <label for = 'PostDescription'>
    <span class = 'FieldInfo'> Post Description: </span>
    </label>
    <textarea class = 'form-control' name = 'PostDescription' id = 'PostDescription' rows = '12' cols = '90' disabled>
    <?php echo $PostDescriptionToBeDeleted;
    ?>
    </textarea>
    </div>
    <div class = 'row'>
    <div class = 'col-lg-6 mb-2'>
    <a href = 'admin-dashboard.php' class = 'btn btn-warning btn-block'><i class = 'fas fa-arrow-left'></i>
    Back To
    Dashboard</a>
    </div>
    <div class = 'col-lg-6 mb-2'>
    <button type = 'submit' name = 'deletePost' class = 'btn btn-danger btn-block'>
    <i class = 'fas fa-trash'></i> Delete
    </button>
    </div>
    </div>
    </div>
    </div>
    </form>
    </div>
    </div>
    </section>
    <!-- End of main post section -->

    <!-- Footer section -->
    <?php include ( './admin/inc/footer.php' );
    ?>
