<?php include( './admin/inc/db.php' );
?>
<?php include( './includes/globalFunctions.php' );
?>
<?php include( './includes/globalSessions.php' );
?>
<?php $SearchQueryParams = $_GET[ 'id' ];
?>
<?php

$pageUrl = urlencode( 'http://' . $_SERVER[ 'SERVER_NAME' ] . $_SERVER[ 'REQUEST_URI' ] );

if ( isset( $_POST[ 'SubmitComment' ] ) ) {
    $CommenterName = filter_var( $_POST[ 'CommenterName' ], FILTER_UNSAFE_RAW );
    $CommenterEmail = filter_var( $_POST[ 'CommenterEmail' ], FILTER_UNSAFE_RAW );
    $CommenterMessage = filter_var( $_POST[ 'CommenterMessage' ], FILTER_UNSAFE_RAW );

    // PHP timezone
    date_default_timezone_set( 'Europe/Rome' );
    $CurrentTime = time();
    $DateTime = strftime( '%B-%d-%Y %H:%M:%S', $CurrentTime );
    // End of PHP timezone

    if ( empty( $CommenterName ) || empty( $CommenterEmail ) || empty( $CommenterMessage ) ) {
        $_SESSION[ 'ErrorMessage' ] = 'All fields must be filled out';
        Redirect_to( "blog-post-detail.php?id={$SearchQueryParams}" );
    } elseif ( strlen( $CommenterMessage ) > 500 ) {
        $_SESSION[ 'ErrorMessage' ] = 'Comment length must be lesser than 500 characters';
        Redirect_to( "blog-post-detail.php?id={$SearchQueryParams}" );
    } else {
        // Query to insert a new category in the DB when everything is OK
        global $conn;
        $sql = 'INSERT INTO comments (datetime, name, email, comment, approvedby, status, post_id)';
        $sql .= "VALUES(:datetime,:name,:email,:comment,'Pending','OFF', :postIdFromURL)";
        $stmt = $conn->prepare( $sql );
        $stmt->bindValue( ':datetime', $DateTime );
        $stmt->bindValue( ':name', $CommenterName );
        $stmt->bindValue( ':email', $CommenterEmail );
        $stmt->bindValue( ':comment', $CommenterMessage );
        $stmt->bindValue( ':postIdFromURL', $SearchQueryParams );
        $Execute = $stmt->execute();
        if ( $Execute ) {
            $_SESSION[ 'SuccessMessage' ] = 'Thanks for your comment toward this article';
            Redirect_to( "blog-post-detail.php?id={$SearchQueryParams}" );
        } else {
            $_SESSION[ 'ErrorMessage' ] = 'Something went wrong. Please try again';
            Redirect_to( "blog-post-detail.php?id={$SearchQueryParams}" );
        }
    }
}
?>

<!DOCTYPE html>
<html lang='en'>

<head>
  <?php include( './includes/head.php' );
?>
  <!-- <title>Post Detail Page</title> -->
</head>

<body>
  <!-- Start of Navbar section -->
  <?php include( './includes/globalNavbar.php' );
?>

  <!-- End of Navbar section -->

  <!-- Main index post content section -->
  <div class='container'>
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
} else {
    // Query to display the default blog post
    $PostIdFromURL = $_GET[ 'id' ];
    if ( !isset( $PostIdFromURL ) ) {
        $_SESSION[ 'ErrorMessage' ] = 'We are sorry, Bad Request failed!';
        Redirect_to( 'index.php?page=1' );
    }
    $sql = "SELECT * FROM posts WHERE id = '$PostIdFromURL'";
    $stmt = $conn->query( $sql );
    $Result = $stmt->rowCount();
    if ( $Result != 1 ) {
        $_SESSION[ 'ErrorMessage' ] = 'We are sorry, Bad Request failed!';
        Redirect_to( 'index.php?page=1' );
    }
}

while ( $DataRows = $stmt->fetch() ) {
    $PostId = $DataRows[ 'id' ];
    $DateTime = $DataRows[ 'datetime' ];
    $PostTitle = $DataRows[ 'title' ];
    $CategoryTitle = $DataRows[ 'category' ];
    $AdminName = $DataRows[ 'author' ];
    $PostImage = $DataRows[ 'image' ];
    $PostDescription = $DataRows[ 'description' ];
}
?>

        <div class='card'>
          <img src="uploads/<?php echo htmlentities($PostImage); ?>" style='max-height:450px;
' class='img-fluid card-img-top' />
          <div class='card-body'>
            <h4 class='card-title global_text_size_on_small_screen_title'><?php echo htmlentities( $PostTitle );
?></h4>
            <small class='text-muted global_text_size_on_small_screen_category'>Category: <span
                class='text-dark'></span>
              <a href="index.php?category=<?php echo htmlentities($CategoryTitle); ?>" style="color: #0f0f3e;"
                class='FieldInfo text-capitalize font-weight-bold'><?php echo htmlentities( $CategoryTitle );
?></a>
              </span> & Written by <span class='text-dark'> <a
                  href="admin-profile.php?username=<?php echo htmlentities($AdminName); ?>" style="color: #0f0f3e;"
                  class='FieldInfo text-capitalize font-weight-bold'><?php echo htmlentities( $AdminName );
?></a></span>
              On <span class='text-dark'><?php echo htmlentities( $DateTime );
?></span>
            </small>
            <!-- Start of Share btn -->
            <hr>
            <!-- End of Share btn -->
            <p class='card-text global_text_size_on_small_screen_paragraph'>
              <?php echo nl2br( htmlentities( $PostDescription ) );
?>
            </p>
          </div>
        </div>
        <br>
        <?php ?>

        <!-- Starts of comment post ( fetching existing Comments ) -->
        <span class='FieldInfo text-uppercase font-weight-bold' style="color: #0f0f3e;">Comments</span>
        <br><br>
        <?php
global $conn;
// $sql = "SELECT * FROM comments WHERE post_id='$SearchQueryParams' AND status='ON'";
$sql = "SELECT * FROM comments WHERE post_id='$SearchQueryParams'";
$stmt = $conn->query( $sql );
while ( $DataRows = $stmt->fetch() ) {
    $CommentDate = $DataRows[ 'datetime' ];
    $CommenterName = $DataRows[ 'name' ];
    $CommenterContent = $DataRows[ 'comment' ];
    ?>

        <div>
          <div class='media CommentBlock'>
            <img class='d-block img-responsive img-fluid align-self-start custom_comment_user_img_on_small_screen'
              src='./images/comment.png' alt='comment-img'>
            <div class='media-body ml-2'>
              <h6 class='lead custom_comment_title_on_small_screen'><?php echo $CommenterName;
    ?></h6>
              <p class='custom_comment_paragraph_on_small_screen'><?php echo $CommenterContent;
    ?></p>
              <p class='custom_comment_date_on_small_screen'><?php echo $CommentDate;
    ?></p>
            </div>
          </div>
        </div>
        <hr>
        <?php }
    ?>
        <!-- End of comment post ( fetching existing Comments ) -->

        <!-- Start of comment container section -->
        <div>
          <form class='' action="blog-post-detail.php?id=<?php echo $SearchQueryParams ?>" method='POST'>
            <div class='card mb-3'>
              <div class='card-header'>
                <h5 style="color: #0f0f3e;"
                  class='FieldInfo text-capitalize font-weight-bold global_text_size_on_small_screen_comment_title'>
                  Share
                  your thoughts about this post
                </h5>
              </div>
              <div class='card-body'>
                <div class='form-group'>
                  <div class='input-group'>
                    <div class='input-group-prepend'>
                      <span class='input-group-text'><i class='fas fa-user'></i></span>
                    </div>
                    <input class='form-control' type='text' name='CommenterName' placeholder='Enter your name' value=''>
                  </div>
                </div>
                <div class='form-group'>
                  <div class='input-group'>
                    <div class='input-group-prepend'>
                      <span class='input-group-text'><i class='fas fa-envelope'></i></span>
                    </div>
                    <input class='form-control' type='text' name='CommenterEmail' placeholder='Add your email' value=''>
                  </div>
                </div>
                <div class='form-group'>
                  <textarea name='CommenterMessage' class='form-control' rows='6' cols='80'
                    placeholder='Add your comment'></textarea>
                </div>
                <div class=''>
                  <button type='submit' name='SubmitComment' style="background: #0f0f3e;"
                    class='btn text-white'>Submit</button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <!-- End of comment container section -->
      </div>

      <!-- Sidebar section -->
      <?php include( './includes/sidebar.php' );
    ?>

    </div>
  </div>

  <!-- Go to www.addthis.com/dashboard to customize your tools -->
  <script type='text/javascript' src='//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-6334a37b01f6f5f3'></script>

  <!-- Sidebar section -->
  <?php include( './includes/footer.php' );
    ?>