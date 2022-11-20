<?php include( './admin/inc/db.php' );
?>
<?php include( './includes/globalFunctions.php' );
?>
<?php include( './includes/globalSessions.php' );
?>

<?php
// Start of fetching existing Admin data when they login
$SearchQueryParams = $_GET[ 'username' ];
global $conn;
$sql = 'SELECT aname, aheadline, abio, aimage FROM admin WHERE username=:userName';
$stmt = $conn->prepare( $sql );
$stmt -> bindValue( ':userName', $SearchQueryParams );
$stmt -> execute();
$Result = $stmt->rowCount();
if ( $Result == 1 ) {
    while ( $DataRows = $stmt->fetch() ) {
        $ExistingName = $DataRows[ 'aname' ];
        $ExistingBio = $DataRows[ 'abio' ];
        $ExistingImage = $DataRows[ 'aimage' ];
        $ExistingHeadline = $DataRows[ 'aheadline' ];
    }
} else {
    $_SESSION[ 'ErrorMessage' ] = 'Bad Request !';
    Redirect_to( 'index.php?page=1' );
}
?>

<!-- PHP CODE SECTION ABOVE -->
<!DOCTYPE html>
<html lang = 'en'>

<head>
<!-- Head section -->
<?php include ( './includes/head.php' );
?>

<title>Admin profile</title>
</head>

<body>

<!-- Admin Navbar section -->
<?php include ( './includes/globalNavbar.php' );
?>

<!-- Start of Header -->
<header class = 'text-white py-3' style="background: #0f0f3e;">
<div class = 'container'>
<div class = 'row'>
<div class = 'col-md-6'>
<h1 class = 'global_text_size_on_small_screen_dashboard_title' style="color: #fff;">
<i class = 'fas fa-user mr-2' style="color: #fff;">
<?php echo $ExistingName;
?>
</i>
</h1>
<h3 class = 'global_text_size_on_small_screen_profile_headline'><?php echo $ExistingHeadline;
?></h3>
</div>
</div>
</div>
</header>
<!-- End of Header -->

<!-- Main my profile section -->
<section class = 'container py-2 mb-4 custom_profile_container'>
<div class = 'row'>

<div class = 'col-md-3'>
<img src = "./images/<?php echo $ExistingImage; ?>" style = 'width: 100%;'

class = 'img-fluid mb-3 rounded-circle global_image_size_on_small_screen_profile_image'
alt = 'admin-profile-image'>
</div>

<div class = 'col-md-9 custom_profile_paragraph_container' style = 'min-height: 400px;'>
<div class = 'card'>
<div class = 'card-body'>
<p class = 'lead global_text_size_on_small_screen_paragraph'><?php echo $ExistingBio ?></p>
</div>
</div>
</div>

</div>
</section>
<!-- End of main my profile section -->

<!-- Footer section -->
<?php include ( './admin/inc/footer.php' );
?>
