<div class='col-lg-4 col-md-12 col-sm-12 col-xs-12'>
  <div class='card mt-4 hide_custom_side_bar_container_blog_info'>
    <div class='card-body'>
      <img src="./images/blog_logo.jpg" class='d-block img-fluid mb-3' alt=''>
      <div class='text-left'>
        <p> The Pool of Writers (POW) is an informative platform that features the writings of emerging and scholarly
          writers, with focused on various prevailing issues in Liberia and around the world. </p>
        <div>
          <a href="about-us.php" style="background: #0f0f3e;" class="btn text-white" style="font-size: 12px;">Read more
            ...</a>
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class='card show_login_sidebar_section_on_large_screen hide_login_sidebar_section_on_large_screen'>
    <div style="background: #0f0f3e;" class='card-header text-light'>
      <h2 class='lead'>Join the Forum !</h2>
    </div>
    <div class='card-body'>
      <?php if ( isset( $_SESSION[ 'UserId' ] ) ) : ?>
      <a href='logout.php' class='btn btn-danger btn-block text-center text-white mb-4'>
        Logout
      </a>
      <?php else : ?>
      <a href='login.php' style="background: #0f0f3e;" class='btn btn-block text-center text-white mb-4'>
        Login
      </a>
      <?php endif ?>
    </div>
  </div>
  <br>
  <div class='card'>
    <div style="background: #0f0f3e;" class='card-header text-white'>
      <h2 class='lead'>Categories</h2>
    </div>
    <div class='card-body'>
      <!-- Show all categories from DB on the main page -->
      <?php
global $conn;
$sql = 'SELECT * FROM category ORDER BY id DESC';
$stmt = $conn->query( $sql );
while ( $DataRows = $stmt->fetch() ) {
    $CategoryId = $DataRows[ 'id' ];
    $CategoryTitle = $DataRows[ 'title' ];
    ?>
      <a href="index.php?category=<?php echo $CategoryTitle; ?>"
        class="global_text_size_on_small_screen_category_title">
        <span class='heading FieldInfo text-dark text-capitalize font-weight-bold'><?php echo $CategoryTitle;
    ?></span>
      </a>
      <br>
      <?php }
    ?>
    </div>
  </div>
  <br>
  <div class='card custom_margin_sidebar_margin_bottom'>
    <div style="background: #0f0f3e;" class='card-header text-white'>
      <!-- Show all Recent posts from DB on the main page -->
      <h2 class='lead'> Recent Posts</h2>
    </div>
    <div class='card-body'>
      <?php
    global $conn;
    $sql = 'SELECT * FROM posts ORDER BY id DESC LIMIT 0, 5';
    $stmt = $conn->query( $sql );
    while ( $DataRows = $stmt->fetch() ) {
        $PostId = $DataRows[ 'id' ];
        $PostTitle = $DataRows[ 'title' ];
        $PostDateTime = $DataRows[ 'datetime' ];
        $PostImage = $DataRows[ 'image' ];
        ?>

      <div class='media'>
        <a href="blog-post-detail.php?id=<?php echo htmlentities($PostId); ?>" target='_blank'>
          <img src="uploads/<?php echo htmlentities($PostImage); ?>" class='d-block img-fluid align-self-start'
            width='90' height='94' alt='recent-post-img'>
        </a>
        <div class='media-body ml-2'>
          <a style='text-decoration: none;
' href="blog-post-detail.php?id=<?php echo htmlentities($PostId); ?>" target='_blank'>
            <h6 style="color: #0f0f3e;"
              class='lead FieldInfo font-weight-bold global_text_size_on_small_screen_recent_post_title'>
              <?php if ( strlen( $PostTitle ) > 5 ) {
            $PostTitle = substr( $PostTitle, 0, 10 ).'...';
            echo htmlentities( $PostTitle );
        }
        ?>
            </h6>
          </a>
          <p class='small global_text_size_on_small_screen_recent_post_date'>
            <?php echo htmlentities( $PostDateTime ) ?>
          </p>
        </div>
      </div>
      <hr>
      <?php }
        ?>
    </div>
  </div>
</div>