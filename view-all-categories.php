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
if ( isset( $_POST[ 'createCategory' ] ) ) {
    $categoryTitle = filter_var( $_POST[ 'categoryTitle' ], FILTER_UNSAFE_RAW );
    $AdminName = $_SESSION[ 'UserName' ];

    // PHP timezone
    date_default_timezone_set( 'Europe/Rome' );
    $CurrentTime = time();
    $DateTime = strftime( '%B-%d-%Y %H:%M:%S', $CurrentTime );
    // End of PHP timezone

    if ( empty( $categoryTitle ) ) {
        $_SESSION[ 'ErrorMessage' ] = 'Category title field must not be empty';
        Redirect_to( 'view-all-categories.php' );
    } elseif ( strlen( $categoryTitle ) < 3 ) {
        $_SESSION[ 'ErrorMessage' ] = 'Category title must be greater than 2 characters';
        Redirect_to( 'view-all-categories.php' );
    } elseif ( strlen( $categoryTitle ) > 21 ) {
        $_SESSION[ 'ErrorMessage' ] = 'Category title must be lesser than 20 characters';
        Redirect_to( 'view-all-categories.php' );
    } else {
        // Query to insert a new category in the DB when everything is OK
        global $conn;
        $sql = 'INSERT INTO category (title, author, datetime)';
        $sql .= 'VALUES(:categoryTitle, :adminName, :dateTime)';
        $stmt = $conn->prepare( $sql );
        $stmt->bindValue( ':categoryTitle', $categoryTitle );
        $stmt->bindValue( ':adminName', $AdminName );
        $stmt->bindValue( ':dateTime', $DateTime );
        $Execute = $stmt->execute();

        if ( $Execute ) {
            $_SESSION[ 'SuccessMessage' ] = 'Category with id: '.$conn->lastInsertId().' has been created successfully';
            // you can also redirect the user to other page as you want
            Redirect_to( 'view-all-categories.php' );
        } else {
            $_SESSION[ 'ErrorMessage' ] = 'Something went wrong. Please try again';
            Redirect_to( 'view-all-categories.php' );
        }
    }
}

?>
<!-- PHP CODE SECTION ABOVE -->

<!DOCTYPE html>
<html lang = 'en'>

<head>
<!-- Head section -->
<?php include ( './includes/head.php' );
?>

<title>Categories</title>
</head>

<body>

<!-- Admin Navbar section -->
<?php include ( './admin/inc/AdminNavbar.php' );
?>

<!-- Header section -->
<header class = 'bg-dark text-white py-3'>
<div class = 'container'>
<div class = 'row'>
<div class = 'text-info col-md-12'>
<h1 class = 'global_text_size_on_small_screen_dashboard_title'><i class = 'fas fa-edit'></i> Manage Categories
</h1>
</div>
</div>
</div>
</header>
<!-- End of header section -->

<!-- Main categories section -->
<section class = 'container py-2 mb-4'>
<div class = 'row'>
<div class = 'offset-lg-1 col-lg-10' style = 'min-height:400px;'>
<?php
echo ErrorMessage();
echo SuccessMessage();
?>
<form class = '' action = 'view-all-categories.php' method = 'post'>
<div class = 'card bg-secondary text-light mb-3'>
<div class = 'card-body bg-dark'>
<div class = 'form-group'>
<label for = 'title'> <span class = 'FieldInfo'> Category Title: </span></label>
<input class = 'form-control' type = 'text' name = 'categoryTitle' id = 'title' placeholder = 'Category title'
value = '' autocomplete = 'off'>
</div>
<div class = 'row'>
<div class = 'col-lg-6 mb-2'>
<a href = 'admin-dashboard.php' class = 'btn btn-warning btn-block'><i class = 'fas fa-arrow-left'></i>
Back To
Dashboard</a>
</div>
<div class = 'col-lg-6 mb-2'>
<button type = 'submit' name = 'createCategory' class = 'btn btn-success btn-block'>
<i class = 'fas fa-check'></i> Publish
</button>
</div>
</div>
</div>
</div>
</form>
<h2 class = 'category_text_size_on_small_screen_title'>Existing Categories</h2>
<div class = 'global_responsive_table_container'>
<table class = 'table table-striped table-hover'>
<thead class = 'thead-dark'>
<tr>
<th>No. </th>
<th>Date&Time</th>
<th>Category</th>
<th>Creator</th>
<th>Action</th>
</tr>
</thead>

<?php
global $conn;
$sql = 'SELECT * FROM category ORDER BY id DESC';
$Execute = $conn->query( $sql );
$SrNo = 0;
while ( $DataRows = $Execute->fetch() ) {
    $CategoryId = $DataRows[ 'id' ];
    $CategoryDate = $DataRows[ 'datetime' ];
    $CategoryTitle = $DataRows[ 'title' ];
    $CategoryAuthorName = $DataRows[ 'author' ];
    $SrNo++;
    ?>

    <tbody>
    <tr>
    <td><?php echo htmlentities( $SrNo );
    ?></td>
    <td>
    <?php if ( strlen( $CategoryDate ) > 10 ) {
        $CategoryDate = substr( $CategoryDate, 0, 12 ).'...';
    }
    echo htmlentities( $CategoryDate );
    ?>
    </td>
    <td><?php echo htmlentities( $CategoryTitle );
    ?></td>
    <td><?php echo htmlentities( $CategoryAuthorName );
    ?></td>
    <td> <a href = 'delete-category.php?id=<?php echo $CategoryId; ?>' class = 'btn btn-danger'>Delete</a></td>
    </tbody>
    <?php }
    ?>
    </table>
    </div>
    </div>
    </div>
    </section>
    <!-- End of main categories section -->

    <!-- Footer section -->
    <?php include ( './admin/inc/footer.php' );
    ?>
