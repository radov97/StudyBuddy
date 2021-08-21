<?php
require_once 'includes/globalfunctions.php';
$resetPassword = getTemplate('mustacheTemplates/resetpassword.mst');
// Set mustache data
$resetPasswordData = ['login_url' => BASE_DOMAIN_URL . 'login.php'];

debug($_POST);
if (isset($_POST['reset_password'])) {
    $safePassword = trimInputSides($_POST['password']);
    $confirmPassword = trimInputSides($_POST['confirm_password']);
    // Password doesn't match requirement criteria
    // Password is not the same
    // Something went wrong
    // Update new password
}
?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/login.html'; ?>
<!-- Template -->
<?= $mustache->render($resetPassword, $resetPasswordData);  ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>
