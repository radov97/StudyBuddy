<?php
require_once 'includes/globalfunctions.php';
// Redirect safe to login if someone goes here without being logged
if (!isset($_SESSION['user_logged'])) {
    redirectTo(BASE_DOMAIN_URL . 'login.php');
}
if (!isset($_GET['post_id'])) {
    redirectTo(BASE_DOMAIN_URL . 'myposts.php');
}
$editpost = getTemplate('mustacheTemplates/editpost.mst');
$editpostData = [
    'myprofile_url' => BASE_DOMAIN_URL . 'myposts.php',
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
