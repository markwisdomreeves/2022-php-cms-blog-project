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

  <title>View all comments</title>
</head>

<body>

  <!-- Admin Navbar section -->
  <?php include ( './admin/inc/AdminNavbar.php' );
?>

  <!-- Header section -->
  <header class='bg-dark text-white py-3'>
    <div class='container'>
      <div class='row'>
        <div class='col-md-12 text-info'>
          <h1 class='global_text_size_on_small_screen_dashboard_title'><i class='fas fa-comments text-info'></i> Manage
            Comments</h1>
        </div>
      </div>
    </div>
  </header>
  <!-- End of header section -->

  <section class='container py-2 mb-4'>
    <div class='row' style='min-height: 30px;'>
      <div class='col-lg-12' style='min-height: 400px;'>
        <?php
echo ErrorMessage();
echo SuccessMessage();
?>
        <div class='global_responsive_table_container'>
          <table class='table table-striped table-bordered table-hover'>
            <thead class='thead-dark'>
              <tr>
                <th>No.</th>
                <th>Date&Time</th>
                <th>Name</th>
                <th>Comment</th>
                <th>Action</th>
                <th>Details</th>
              </tr>
            </thead>

            <?php
global $conn;
$sql = 'SELECT * FROM comments ORDER BY id DESC';
$Execute = $conn->query( $sql );
$SrNo = 0;
while ( $DataRows = $Execute->fetch() ) {
    $CommentId = $DataRows[ 'id' ];
    $DateTime = $DataRows[ 'datetime' ];
    $CommenterName = $DataRows[ 'name' ];
    $CommentContent = $DataRows[ 'comment' ];
    $CommentPostId = $DataRows[ 'post_id' ];
    $SrNo++;
    ?>

            <tbody>
              <tr>
                <td><?php echo htmlentities( $SrNo );
    ?></td>
                <td>
                  <?php if ( strlen( $DateTime ) > 10 ) {
        $DateTime = substr( $DateTime, 0, 12 ).'...';
    }
    echo htmlentities( $DateTime );
    ?>
                </td>
                <td><?php echo htmlentities( $CommenterName );
    ?></td>
                <td>
                  <?php if ( strlen( $CommentContent ) > 15 ) {
        $CommentContent = substr( $CommentContent, 0, 17 ).'...';
    }
    echo htmlentities( $CommentContent );
    ?>
                </td>
                <td>
                  <a href="delete-comment.php?id=<?php echo $CommentId; ?>" class='btn btn-danger'>Delete</a>
                </td>
                <td style='min-width: 140px;'>
                  <a class='btn btn-primary' href="blog-post-detail.php?id=<?php echo $CommentPostId; ?>"
                    target='_blank'>Preview</a>
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

  <!-- Footer section -->
  <?php include ( './admin/inc/footer.php' );
    ?>