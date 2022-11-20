<?php include( './admin/inc/db.php' );
?>
<?php include( './includes/globalFunctions.php' );
?>
<?php include( './includes/globalSessions.php' );
?>

<!DOCTYPE html>
<html lang='en'>

<head>
  <?php include( './includes/head.php' );
?>
  <title>Blog Page</title>
</head>

<body>

  <!-- Start of Navbar section -->
  <?php include( './includes/globalNavbar.php' );
?>
  <!-- End of Navbar section -->

  <!-- Main index post content section -->
  <div class='container'>
    <div class='blog_page_title'>
      <h2 style='color: #0f0f3e;' class='FieldInfo text-capitalize font-weight-bold'>Welcome to the Pool of Writers</h2>
      <p class='FieldInfo text-dark text-capitalize font-weight-bold font-italic'>'Write to Express, Not to
        Impress'</p>
    </div>

    <div class='row mt-4'>
      <div class='col-lg-8 col-md-12 col-sm-12 col-xs-12 py-4'>

        <?php
echo ErrorMessage();
echo SuccessMessage();
?>

        <?php

global $conn;
// SQL query when search button is active
if ( isset( $_GET[ 'SearchButton' ] ) ) {
    $Search = $_GET[ 'Search' ];
    $sql = "SELECT * FROM posts
        WHERE datetime LIKE :search
        OR title LIKE :search
        OR author LIKE :search
        OR category LIKE :search
        OR description LIKE :search";
    $stmt = $conn->prepare( $sql );
    $stmt->bindValue( ':search', '%'.$Search.'%' );
    $stmt->execute();
}

// If no post result found, ( post count return 0 ) than return a message
// Query when pagination is active ( example: index.php?page = 1 )
elseif ( isset( $_GET[ 'page' ] ) ) {
    $Page = $_GET[ 'page' ];
    if ( $Page == 0 || $Page<1 ) {
        $ShowPostFrom = 0;
    } else {
        $ShowPostFrom = ( $Page*5 )-5;
    }
    $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $ShowPostFrom,5";
    $stmt = $conn->query( $sql );
}

// Query when Category is active in the URL Tab
elseif ( isset( $_GET[ 'category' ] ) ) {
    $Category = $_GET[ 'category' ];
    $sql = "SELECT * FROM posts WHERE category='$Category' ORDER BY id DESC";
    $stmt = $conn->query( $sql );
}

// Else if not any of those actions are active, then the default query will be used instead.
else {
    $sql = 'SELECT * FROM posts ORDER BY id DESC LIMIT 0,3';
    $stmt = $conn->query( $sql );
}
while ( $DataRows = $stmt->fetch() ) {
    $PostId = $DataRows[ 'id' ];
    $DateTime = $DataRows[ 'datetime' ];
    $PostTitle = $DataRows[ 'title' ];
    $CategoryTitle = $DataRows[ 'category' ];
    $AdminName = $DataRows[ 'author' ];
    $PostImage = $DataRows[ 'image' ];
    $PostDescription = $DataRows[ 'description' ];
    ?>

        <div class='card'>
          <img src=" uploads/<?php echo htmlentities($PostImage); ?>" style='max-height:450px;
' class='img-fluid card-img-top' />
          <div class='card-body'>
            <h4 class='card-title global_text_size_on_small_screen_title'><?php echo htmlentities( $PostTitle );
    ?></h4>
            <small class='text-muted global_text_size_on_small_screen_category'>Category: <span
                class='text-dark'></span>
              <a href="index.php?category=<?php echo htmlentities($CategoryTitle); ?>"
                class='text-capitalize font-weight-bold' style='color: #0f0f3e;'><?php echo htmlentities( $CategoryTitle );
    ?></a>
              </span> & Written by <span class='text-dark'> <a
                  href="admin-profile.php?username=<?php echo htmlentities($AdminName); ?>" style='color: #0f0f3e;'
                  class='text-capitalize font-weight-bold'><?php echo htmlentities( $AdminName );
    ?></a></span>
              On <span class='text-dark'><?php echo htmlentities( $DateTime );
    ?></span>
            </small>
            <span style='float:right;  font-size: 11px;
' class='badge badge-dark text-light'>
              Comments:
              <?php echo ApproveCommentsAccordingtoPost( $PostId );
    ?>

            </span>
            <hr>
            <p class='card-text global_text_size_on_small_screen_paragraph'>
              <?php if ( strlen( $PostDescription ) > 250 ) {
        $PostDescription = substr( $PostDescription, 0, 250 ).'...';
    }
    echo htmlentities( $PostDescription );
    ?>
            </p>
            <a href="blog-post-detail.php?id=<?php echo $PostId; ?>" style='float:right;
'>
              <span class='btn text-white global_text_size_on_small_screen_btn' style="background: #0f0f3e;">
                Read More &rang;
                &rang;
              </span>
            </a>
          </div>
        </div>
        <br>
        <?php }
    ?>

        <!-- Pagination section -->
        <nav>
          <ul class='pagination pagination-sm'>
            <!-- Backward pagination btn -->
            <?php if ( isset( $Page ) ) {
        if ( $Page>1 ) {
            ?>
            <li class='page-item'>
              <a href="index.php?page=<?php echo $Page-1; ?>" class='page-link'>&laquo;
              </a>
            </li>
            <?php }
        }
        ?>
            <?php
        global $conn;
        $sql = 'SELECT COUNT(*) FROM posts';
        $stmt = $conn->query( $sql );
        $RowPagination = $stmt->fetch();
        $TotalPosts = array_shift( $RowPagination );
        $PostPagination = $TotalPosts/5;
        $PostPagination = ceil( $PostPagination );
        for ( $i = 1; $i <= $PostPagination; $i++ ) {
            if ( isset( $Page ) ) {
                if ( $i == $Page ) {
                    ?>
            <li class='page-item active'>
              <a href="index.php?page=<?php echo $i; ?>" class='page-link'><?php echo $i;
                    ?></a>
            </li>
            <?php
                } else {
                    ?>
            <li class='page-item'>
              <a href="index.php?page=<?php echo $i; ?>" class='page-link'><?php echo $i;
                    ?></a>
            </li>
            <?php
                }
            }
        }
        ?>

            <!-- Create the forward pagination btn -->
            <?php
        if ( isset( $Page ) && !empty( $Page ) ) {
            if ( $Page+1 <= $PostPagination ) {
                ?>
            <li class='page-item'>
              <a href="index.php?page=<?php echo $Page+1; ?>" class='page-link'>&raquo;
              </a>
            </li>
            <?php }
            }
            ?>

          </ul>
        </nav>
      </div>

      <!-- Sidebar section -->
      <?php include( './includes/sidebar.php' );
            ?>

    </div>
  </div>

  <!-- footer section -->
  <?php include( './includes/footer.php' );
            ?>