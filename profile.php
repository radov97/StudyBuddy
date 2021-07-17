<?php
require_once 'includes/globalfunctions.php';
// Redirect safe to login if someone goes here without being logged
if (!isset($_SESSION['user_logged'])) {
    redirectTo(BASE_DOMAIN_URL . 'login.php');
}
$profile = getTemplate('mustacheTemplates/profile.mst');
?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/profile.html'; ?>
<!-- Template -->
<?= $mustache->render($profile, []); ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>