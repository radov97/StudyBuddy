<?php
require_once 'includes/globalfunctions.php';
$resetPassword = getTemplate('mustacheTemplates/resetpassword.mst');

// Set mustache data
$resetPasswordData = [
    'login_url' => BASE_DOMAIN_URL . 'login.php',
];
?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/login.html'; ?>
<!-- Template -->
<?= $mustache->render($resetPassword, $resetPasswordData);  ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>
