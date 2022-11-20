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

<!DOCTYPE html>
<html lang='en'>

<head>
  <!-- Head section -->
  <?php include ( './includes/head.php' );
?>
  <title>Posts</title>
</head>

<body>

  <!-- Admin Navbar section -->
  <?php include ( './admin/inc/AdminNavbar.php' );
?>

  <!-- Header section -->
  <header class='bg-dark text-white py-2'>
    <div class='container'>
      <div class='row'>
        <div class='col-md-12 text-info mb-2 mt-2'>
          <h1 class='global_text_size_on_small_screen_dashboard_title'><i class='fas fa-blog text-info'></i> Blog Posts
          </h1>
        </div>
        <div class='col-lg-3 mb-2'>
          <a href='add-new-blog-post.php' class='btn btn-primary btn-block'>
            <i class='fas fa-edit'></i> Add New Post
          </a>
        </div>
        <div class='col-lg-3 mb-2'>
          <a href='view-all-categories.php' class='btn btn-info btn-block'>
            <i class='fas fa-folder-plus'></i> Add New Category
          </a>
        </div>
        <div class='col-lg-3 mb-2'>
          <a href='manage-admins.php' class='btn btn-warning btn-block'>
            <i class='fas fa-user-plus'></i> Add New Admin
          </a>
        </div>
        <div class='col-lg-3 mb-2'>
          <a href='view-all-comments.php' class='btn btn-success btn-block'>
            <i class='fas fa-check'></i> Approve Comments
          </a>
        </div>

      </div>
    </div>
  </header>
  <!-- End of header section -->

  <!-- Main Post section -->
  <section class='container py-2 mb-4' id='custom_margin_bottom'>
    <div class='row'>
      <div class='col-lg-12'>
        <?php
echo ErrorMessage();
echo SuccessMessage();

?>

        <div class='global_responsive_table_container'>
          <table class='table table-striped table-sm'>
            <thead class='table-dark'>
              <tr>
                <th>#</th>
                <th>Title</th>
                <th>Category</th>
                <th>Date&Time</th>
                <th>Author</th>
                <th>Image</th>
                <th>Comments</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Preview</th>
              </tr>
            </thead>
            <?php
global $conn;
$sql = 'SELECT * FROM posts ORDER BY id desc';
$stmt = $conn->query( $sql );
$Sr = 0;
while ( $DataRows = $stmt->fetch() ) {
    $PostId = $DataRows[ 'id' ];
    $DateTime = $DataRows[ 'datetime' ];
    $PostTitle = $DataRows[ 'title' ];
    $CategoryTitle = $DataRows[ 'category' ];
    $AdminName = $DataRows[ 'author' ];
    $PostImage = $DataRows[ 'image' ];
    $PostDescription = $DataRows[ 'description' ];
    $Sr++;
    ?>
            <tbody>
              <tr scope='row'>
                <td>
                  <?php echo $Sr;
    ?>
                </td>
                <td>
                  <?php
    if ( strlen( $PostTitle ) > 5 ) {
        $PostTitle = substr( $PostTitle, 0, 8 ). '..';
        echo $PostTitle;
    }
    ?>
                </td>
                <td>
                  <?php
    if ( strlen( $CategoryTitle ) > 2 ) {
        $CategoryTitle = substr( $CategoryTitle, 0, 10 ). '..';
        echo $CategoryTitle;
    }
    ?>
                </td>
                <td>
                  <?php
    if ( strlen( $DateTime ) > 10 ) {
        $DateTime = substr( $DateTime, 0, 12 ). '..';
        echo $DateTime;
    }
    ?>
                </td>
                <td>
                  <?php
    if ( strlen( $AdminName ) > 2 ) {
        $AdminName = substr( $AdminName, 0, 4 ). '..';
        echo $AdminName;
    }
    ?>
                </td>
                <td class='col-sm-1'>
                  <img src="uploads/<?php echo $PostImage; ?>" class='img-fluid img-thumbnail' alt='blog-image'>
                </td>
                <td class='col-sm-1'>
                  <?php $Total = ApproveCommentsAccordingtoPost( $PostId );

    ?>
                  <span class='badge badge-success'>
                    <?php echo $Total;
    ?>
                  </span>
                </td>
                <td>
                  <a href="edit-blog-post.php?id=<?php echo $PostId; ?>">
                    <span class='btn btn-warning'>
                      <i class='fas fa-edit' aria-hidden='true'></i>
                    </span>
                  </a>
                </td>
                <td>
                  <a href="delete-blog-post.php?id=<?php echo $PostId; ?>">
                    <span class='btn btn-danger'>
                      <i class='fa fa-trash' aria-hidden='true'></i></a>
                  </span>
                  </a>
                </td>
                <td>
                  <a href="blog-post-detail.php?id=<?php echo $PostId; ?>" target='_blank'>
                    <span class='btn btn-info'>
                      <i class='fa fa-eye' aria-hidden='true'></i>
                    </span>
                  </a>
                </td>
              </tr>
            </tbody>
            <?php }
    ?>
          </table>
        </div>
      </div>
    </div>
  </section>
  <!-- End of main post section -->

  <!-- Footer section -->
  <?php include ( './admin/inc/footer.php' );
    ?>