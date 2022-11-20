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
if ( isset( $_POST[ 'editPost' ] ) ) {
    $PostTitle = filter_var( $_POST[ 'PostTitle' ], FILTER_UNSAFE_RAW );
    $CategoryTitle = filter_var( $_POST[ 'CategoryTitle' ], FILTER_UNSAFE_RAW );
    $PostDescription = filter_var( $_POST[ 'PostDescription' ], FILTER_UNSAFE_RAW );
    $Image = $_FILES[ 'Image' ][ 'name' ];
    $Target = 'uploads/'.basename( $_FILES[ 'Image' ][ 'name' ] );
    $AdminName = $_SESSION[ 'UserName' ];

    // PHP timezone
    date_default_timezone_set( 'Europe/Rome' );
    $CurrentTime = time();
    $DateTime = strftime( '%B-%d-%Y %H:%M:%S', $CurrentTime );
    // End of PHP timezone

    if ( empty( $PostTitle ) ) {
        $_SESSION[ 'ErrorMessage' ] = 'Post title field must not be empty';
        Redirect_to( 'view-blog-posts.php' );
    }
    if ( strlen( $PostTitle ) < 10 ) {
        $_SESSION[ 'ErrorMessage' ] = 'Post title must be greater than 10 characters';
        Redirect_to( 'view-blog-posts.php' );
    } elseif ( empty( $PostDescription ) ) {
        $_SESSION[ 'ErrorMessage' ] = 'Post description field must not be empty';
        Redirect_to( 'view-blog-posts.php' );
    } elseif ( strlen( $PostDescription ) > 4999 ) {
        $_SESSION[ 'ErrorMessage' ] = 'Post description must be lesser than 5000 characters';
        Redirect_to( 'view-blog-posts.php' );
    } elseif ( strlen( $PostDescription ) < 10 ) {
        $_SESSION[ 'ErrorMessage' ] = 'Post description must be greater than 10 characters';
        Redirect_to( 'view-blog-posts.php' );
    } 
    
    else {
        // Query to insert a new category in the DB when everything is OK
        global $conn;
        if ( !empty( $_FILES[ 'Image' ][ 'name' ] ) ) {
            $sql = "UPDATE posts
          SET title='$PostTitle', category='$CategoryTitle', image='$Image', description='$PostDescription' WHERE id='$SearchQueryParams'";
        } else {
            $sql = "UPDATE posts
          SET title='$PostTitle', category='$CategoryTitle', description='$PostDescription' WHERE id='$SearchQueryParams'";
        }
        $Execute = $conn->query( $sql );
        move_uploaded_file( $_FILES[ 'Image' ][ 'tmp_name' ], $Target );

        if ( $Execute ) {
            $_SESSION[ 'SuccessMessage' ] = 'Post has been updated successfully';
            Redirect_to( 'view-blog-posts.php' );
        } else {
            $_SESSION[ 'ErrorMessage' ] = 'Something went wrong. Please try again';
            Redirect_to( 'view-blog-posts.php' );
        }
    }
}

?>

<!DOCTYPE html>
<html lang = 'en'>

<head>
<!-- Head section -->
<?php include ( './includes/head.php' );
?>
<title>Edit Post</title>
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
<h1 class = 'global_text_size_on_small_screen_dashboard_title'></h1><i class = 'fas fa-edit text-info'></i> Edit
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

// Fetching existing posts according to id on.
global $conn;
$sql = "SELECT * FROM posts WHERE id='$SearchQueryParams'";
$stmt = $conn->query( $sql );
while ( $DataRows = $stmt->fetch() ) {
    $PostTitleToBeUpdated = $DataRows[ 'title' ];
    $PostCategoryToBeUpdated = $DataRows[ 'category' ];
    $PostImageToBeUpdated = $DataRows[ 'image' ];
    $PostDescriptionToBeUpdated = $DataRows[ 'description' ];
}
?>

<form action = "edit-blog-post.php?id=<?php echo $SearchQueryParams; ?>" method = 'POST'
enctype = 'multipart/form-data'>
<div class = 'card bg-secondary text-light mb-3'>
<div class = 'card-body bg-dark'>
<div class = 'form-group'>
<label for = 'PostTitle'>
<span class = 'FieldInfo'> Post Title: </span>
</label>
<input type = 'text' class = 'form-control' name = 'PostTitle' id = 'PostTitle' placeholder = 'Type post title'
value = "<?php echo $PostTitleToBeUpdated; ?>" autocomplete = 'off'>
</div>
<div class = 'form-group'>
<span class = 'FieldInfo'>Existing Category: </span>
<?php echo $PostCategoryToBeUpdated ?>
<br>
<label for = 'CategoryTitle'>
<span class = 'FieldInfo'> Choose Category: </span>
</label>
<select class = 'form-control' name = 'CategoryTitle' id = 'CategoryTitle'>
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
    <img class = 'mb-1' src = "uploads/<?php echo $PostImageToBeUpdated; ?>" width = '50px' ;
    height = '30px' ;
    alt = 'post-image'>
    <br>
    <div class = 'custom-file'>
    <input type = 'File' class = 'custom-file-input' name = 'Image' id = 'imageSelect' value = ''>
    <label for = 'imageSelect' class = 'custom-file-label'>Select Image</label>
    </div>
    </div>
    <div class = 'form-group'>
    <label for = 'PostDescription'>
    <span class = 'FieldInfo'> Post Description: </span>
    </label>
    <textarea class = 'form-control' name = 'PostDescription' id = 'PostDescription' rows = '12' cols = '90'
    autocomplete = 'off'>
    <?php echo $PostDescriptionToBeUpdated;
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
    <button type = 'submit' name = 'editPost' class = 'btn btn-success btn-block'>
    <i class = 'fas fa-edit'></i> Update Post
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
