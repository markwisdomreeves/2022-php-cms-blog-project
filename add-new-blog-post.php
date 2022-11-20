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
if ( isset( $_POST[ 'createNewPost' ] ) ) {
    $PostTitle = filter_var( $_POST[ 'PostTitle' ], FILTER_UNSAFE_RAW );
    $CategoryTitle = filter_var( $_POST[ 'CategoryTitle' ], FILTER_UNSAFE_RAW );
    $PostDescription = $_POST[ 'PostDescription' ];
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
    } elseif ( strlen( $PostDescription ) < 20 ) {
        $_SESSION[ 'ErrorMessage' ] = 'Post description must be greater than 20 characters';
        Redirect_to( 'view-blog-posts.php' );
    } elseif ( strlen( $PostDescription ) > 7999 ) {
        $_SESSION[ 'ErrorMessage' ] = 'Post description must be lesser than 5000 characters';
        Redirect_to( 'view-blog-posts.php' );
    } else {
        // Query to insert a new category in the DB when everything is OK
        global $conn;
        $sql = 'INSERT INTO posts (datetime,title,category,author,image,description)';
        $sql .= 'VALUES(:dateTime,:postTitle,:categoryTitle,:adminName,:imageName,:postDescription)';
        $stmt = $conn->prepare( $sql );
        $stmt->bindValue( ':dateTime', $DateTime );
        $stmt->bindValue( ':postTitle', $PostTitle );
        $stmt->bindValue( ':categoryTitle', $CategoryTitle );
        $stmt->bindValue( ':adminName', $AdminName );
        $stmt->bindValue( ':imageName', $Image );
        $stmt->bindValue( ':postDescription', $PostDescription );
        $Execute = $stmt->execute();
        move_uploaded_file( $_FILES[ 'Image' ][ 'tmp_name' ], $Target );

        if ( $Execute ) {
            $_SESSION[ 'SuccessMessage' ] = 'Post with id: '.$conn->lastInsertId().' has been created successfully';
            // you can also redirect the user to other page as you want
            Redirect_to( 'view-blog-posts.php' );
        } else {
            $_SESSION[ 'ErrorMessage' ] = 'Something went wrong. Please try again';
            Redirect_to( 'view-blog-posts.php' );
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

  <title>Add New Post</title>
</head>

<body>

  <!-- Admin Navbar section -->
  <?php include ( './admin/inc/AdminNavbar.php' );
?>

  <!-- Header section -->
  <header class='bg-dark text-white py-3'>
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h1 class='global_text_size_on_small_screen_dashboard_title'><i class='fas fa-edit text-info'></i> Add New
            Post</h1>
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
        <form class='' action='add-new-blog-post.php' method='POST' enctype='multipart/form-data'>
          <div class='card bg-secondary text-light mb-3'>
            <div class='card-body bg-dark'>
              <div class='form-group'>
                <label for='PostTitle'> <span class='FieldInfo'> Post Title: </span></label>
                <input class='form-control' type='text' name='PostTitle' id='PostTitle' autocomplete='off'
                  placeholder='Add post title'>
              </div>
              <div class='form-group'>
                <label for='categoryTitle'> <span class='FieldInfo'> Choose category</span></label>
                <select class='form-control' id='categoryTitle' name='CategoryTitle'>
                  <?php
global $conn;
$sql = 'SELECT id, title FROM category';
$stmt = $conn->query( $sql );
while ( $DataRows = $stmt->fetch() ) {
    $id = $DataRows[ 'id' ];
    $categoryName = $DataRows[ 'title' ];
    ?>

                  <option> <?php echo $categoryName;
    ?> </option>

                  <?php }
    ?>
                </select>
              </div>
              <div class='form-group'>
                <div class='custom-file'>
                  <input class='custom-file-input' type='File' name='Image' id='imageSelect'>
                  <label for='imageSelect' class='custom-file-label'>Selected Image</label>
                </div>
              </div>
              <div class='form-group'>
                <label for='Post'> <span class='FieldInfo'> Post Description: </span></label>
                <textarea class='form-control' name='PostDescription' id='PostDescription' rows='12' cols='90' autocomplete='off'
                  placeholder='Add blog description'></textarea>
              </div>

              <div class='row'>
                <div class='col-lg-6 mb-2'>
                  <a href='admin-dashboard.php' class='btn btn-warning btn-block'><i class='fas fa-arrow-left'></i>
                    Back To
                    Dashboard</a>
                </div>
                <div class='col-lg-6 mb-2'>
                  <button type='submit' name='createNewPost' class='btn btn-success btn-block'>
                    <i class='fas fa-check'></i> Publish
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
  <!-- End of post section -->

  <!-- Footer section -->
  <?php include ( './admin/inc/footer.php' );
    ?>