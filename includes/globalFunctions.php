<?php include( './admin/inc/db.php' );
?>

<?php

function Redirect_to( $New_Location ) {
    header( 'Location: '.$New_Location );
    exit();
}

function CheckIfUserNameExistsOrNot( $UserName ) {
    global $conn;
    $sql = 'SELECT username FROM admin WHERE username=:userName';
    $stmt = $conn->prepare( $sql );
    $stmt->bindValue( ':userName', $UserName );
    $stmt->execute();
    $Result = $stmt->rowCount();
    if ( $Result == 1 ) {
        return true;
    } else {
        return false;
    }
}

function LoginAttempt( $UserName, $Password ) {
    global $conn;
    $sql = 'SELECT * FROM admin WHERE username=:userName AND password=:passWord LIMIT 1';
    $stmt = $conn->prepare( $sql );
    $stmt->bindValue( ':userName', $UserName );
    $stmt->bindValue( ':passWord', $Password );
    $stmt->execute();
    $Result = $stmt->rowCount();
    if ( $Result == 1 ) {
        return $FoundAccount = $stmt->fetch();
    } else {
        return null;
    }
}

function ConfirmIfUserIsLoginOrNot() {
    if ( isset( $_SESSION[ 'UserId' ] ) ) {
        return true;
    } else {
        $_SESSION[ 'ErrorMessage' ] = 'Login is required!';
        Redirect_to( 'login.php' );
    }
}

function TotalPosts() {
    global $conn;
    $sql = 'SELECT COUNT(*) FROM posts';
    $stmt = $conn->query( $sql );
    $TotalRows = $stmt->fetch();
    $TotalPostsFromDB = array_shift( $TotalRows );
    echo $TotalPostsFromDB;
}

function TotalCategories() {
    global $conn;
    $sql = 'SELECT COUNT(*) FROM category';
    $stmt = $conn->query( $sql );
    $TotalRows = $stmt->fetch();
    $TotalCategoriesFromDB = array_shift( $TotalRows );
    echo $TotalCategoriesFromDB;
}

function TotalAdmins() {
    global $conn;
    $sql = 'SELECT COUNT(*) FROM admin';
    $stmt = $conn->query( $sql );
    $TotalRows = $stmt->fetch();
    $TotalAdminsFromDB = array_shift( $TotalRows );
    echo $TotalAdminsFromDB;
}

function TotalComments() {
    global $conn;
    $sql = 'SELECT COUNT(*) FROM comments';
    $stmt = $conn->query( $sql );
    $TotalRows = $stmt->fetch();
    $TotalCommentsFromDB = array_shift( $TotalRows );
    echo $TotalCommentsFromDB;
}

function ApproveCommentsAccordingtoPost( $PostId ) {
    global $conn;
    $sqlApprovedComments = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId'";
    $stmtApprovedComments = $conn->query( $sqlApprovedComments );
    $TotalCommentRows = $stmtApprovedComments->fetch();
    $TotalApprovedCommentLists = array_shift( $TotalCommentRows );
    return $TotalApprovedCommentLists;
}

function DisApproveCommentsAccordingtoPost( $PostId ) {
    global $conn;
    $sqlDisApprovedComments = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId'";
    $stmtDisApprovedComments = $conn->query( $sqlDisApprovedComments );
    $TotalDisCommentRows = $stmtDisApprovedComments->fetch();
    $TotalDisApprovedCommentLists = array_shift( $TotalDisCommentRows );
    return $TotalDisApprovedCommentLists;
}

?>