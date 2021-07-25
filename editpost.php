<?php
require_once 'includes/globalfunctions.php';
// Redirect safe to login if someone goes here without being logged
if (!isset($_SESSION['user_logged'])) {
    redirectTo(BASE_DOMAIN_URL . 'login.php');
}
if (!isset($_GET['post_id'])) {
    redirectTo(BASE_DOMAIN_URL . 'myposts.php');
}
if (isset($_POST['delete_post'])) {
    $isUserValid = checkUserAccount($_SESSION['user_logged']['email']);
    if (
        deletePost((int) $_GET['post_id']) &&
        updateUserPersonalData(
            $_SESSION['user_logged']['email'], 
            (string)((int) $isUserValid['total_posts'] - 1), 
            'total_posts'
        )
    ) {
        redirectTo(BASE_DOMAIN_URL . 'myposts.php?success=delete');
    }
    $errorMessage = 'Your post cannot be deleted. Please try again.';
    unset($successMessage);
}
if (isset($_POST['update_post'])) {
    $safeTitle = trimInputSides($_POST['title']);
    $safeModule = trimInputSides($_POST['module']);
    if (updatePost((int) $_GET['post_id'], $safeTitle, $safeModule, $_POST['description'])) {
        redirectTo(BASE_DOMAIN_URL . 'myposts.php?success=update');
    }
    $errorMessage = 'Your post cannot be updated. Please try again.';
    unset($successMessage);
}
$editpost = getTemplate('mustacheTemplates/editpost.mst');
$postinfo = getPostById((int) $_GET['post_id']);
$editpostData = [
    'myprofile_url' => BASE_DOMAIN_URL . 'myposts.php',
    'title' => $postinfo['title'],
    'module' => $postinfo['module'],
    'description' => $postinfo['description'],
];

?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/editpost.html'; ?>
<!-- Template -->
<?= $mustache->render($editpost, $editpostData); ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>
