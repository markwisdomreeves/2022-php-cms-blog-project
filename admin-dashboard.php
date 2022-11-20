<?php include( './admin/inc/db.php' );
?>
<?php include( './includes/globalFunctions.php' );
?>
<?php include( './includes/globalSessions.php' );
?>

<?php ConfirmIfUserIsLoginOrNot();
?>

<!DOCTYPE html>
<html lang='en'>

<head>
  <!-- Head section -->
  <?php include ( './includes/head.php' );
?>

  <title>Dashboard</title>
</head>

<body>

  <!-- Admin Navbar section -->
  <?php include ( './admin/inc/AdminNavbar.php' );
?>

  <!-- Header section -->
  <header class='text-white py-2' style='background: #0f0f3e;'>
    <div class='container'>
      <div class='row'>
        <div class='col-md-12 text-danger mb-2 mt-2'>
          <h1 class='global_text_size_on_small_screen_dashboard_title'><i class='fas fa-cog text-danger'></i> Dashboard
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

  <!-- Main area section -->
  <section class='container py-2 mb-4'>
    <div class='row'>
      <!-- Left side area starts -->
      <div class='col-lg-2 d-none d-md-block'>
        <div class='card text-center bg-dark text-white mb-3 global_admin_card_box'>
          <div class='card-body'>
            <h1 class='lead'>Posts</h1>
            <h4 class='display-5'>
              <i class='fab fa-readme' style='color: #dc3545;'></i>
              <?php TotalPosts();
?>
            </h4>
          </div>
        </div>

        <div class='card text-center bg-dark text-white mb-3 global_admin_card_box'>
          <div class='card-body'>
            <h1 class='lead'>Categories</h1>
            <h4 class='display-5'>
              <i class='fas fa-folder' style='color: #dc3545;'></i>
              <?php TotalCategories();
?>
            </h4>
          </div>
        </div>

        <div class='card text-center bg-dark text-white mb-3 global_admin_card_box'>
          <div class='card-body'>
            <h1 class='lead'>Admins</h1>
            <h4 class='display-5'>
              <i class='fas fa-users' style='color: #dc3545;'></i>
              <?php TotalAdmins();
?>
            </h4>
          </div>
        </div>

        <div class='card text-center bg-dark text-white mb-3 global_admin_card_box'>
          <div class='card-body'>
            <h1 class='lead'>Comments</h1>
            <h4 class='display-5'>
              <i class='fas fa-comments' style='color: #dc3545;'></i>
              <?php TotalComments();
?>
            </h4>
          </div>
        </div>
      </div>
      <!-- Left side area ends -->

      <div class='col-lg-10'>
        <?php
echo ErrorMessage();
echo SuccessMessage();
?>
        <h1 class='global_text_size_on_small_screen_dashboard_title'>Top Posts</h1>
        <div class='global_responsive_table_container'>
          <table class='table table-striped table-hover'>
            <thead class='thead-dark'>
              <tr>
                <th>No. </th>
                <th>Date&Time</th>
                <th>Title</th>
                <th>Author</th>
                <th>Comments</th>
                <th>Details</th>
              </tr>
            </thead>
            <?php
$SrNo = 0;
global $conn;
$sql = 'SELECT * FROM posts ORDER BY id DESC LIMIT 0,6';
$stmt = $conn->query( $sql );
while ( $DataRows = $stmt->fetch() ) {
    $PostId = $DataRows[ 'id' ];
    $PostDateAndTime = $DataRows[ 'datetime' ];
    $PostAuthor = $DataRows[ 'author' ];
    $PostTitle = $DataRows[ 'title' ];
    $SrNo++;
    ?>
            <tbody>
              <tr>
                <td><?php echo $SrNo;
    ?></td>
                <td>
                  <?php
    if ( strlen( $PostDateAndTime ) > 10 ) {
        $PostDateAndTime = substr( $PostDateAndTime, 0, 12 ). '..';
        echo $PostDateAndTime;
    }
    ?>
                </td>
                <td>
                  <?php
    if ( strlen( $PostTitle ) > 10 ) {
        $PostTitle = substr( $PostTitle, 0, 12 ). '..';
        echo $PostTitle;
    }
    ?>

                </td>
                <td><?php echo $PostAuthor;
    ?></td>
                <td class='col-sm-1'>
                  <?php $Total = ApproveCommentsAccordingtoPost( $PostId );
    ?>
                  <span class='badge badge-success'>
                    <?php echo $Total;
    ?>
                  </span>
                </td>
                <td>
                  <a href="blog-post-detail.php?id=<?php echo $PostId; ?>" class='btn btn-info' target='_blank'>
                    Preview
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

  <!-- End of main section -->

  <!-- Footer section -->
  <?php include ( './admin/inc/footer.php' );
    ?>