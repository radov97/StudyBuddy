<?php
require_once 'includes/globalfunctions.php';
// Redirect safe to login if someone goes here without being logged
if (!isset($_SESSION['user_logged'])) {
    redirectTo(BASE_DOMAIN_URL . 'login.php');
} 
$userPosts = getUserPosts('tetst');
// $userPosts = getUserPosts($_SESSION['user_logged']['email']);
do {
    // No posts
    if (empty($userPosts)) {
        $myposts = getTemplate('mustacheTemplates/mypostsnone.mst');
        $mypostsData = [
            'addpost_url' => BASE_DOMAIN_URL . 'addpost.php'
        ];
        break;
    }
    // Show posts
} while (0);

?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<style>
    .no-posts {
        border: 5px #ffc107 solid !important;
        background-color: #fff8c5 !important;
    }
</style>
<!-- Template -->
<?= $mustache->render($myposts, $mypostsData); ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>