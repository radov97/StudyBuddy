<?php
require_once 'includes/globalfunctions.php';
// Redirect safe to login if someone goes here without being logged
if (!isset($_SESSION['user_logged'])) {
    redirectTo(BASE_DOMAIN_URL . 'login.php');
}
$profile = getTemplate('mustacheTemplates/profile.mst');
// Change password
if (isset($_POST['change_password'])) {
    do {
        // Check if user already exists
        $isUserValid = checkUserAccount($_SESSION['user_logged']['email']);
        // Invalid user
        if (empty($isUserValid)) {
            $errorMessage = 'Something went wrong. Please try again later.';
            unset($successMessage);
            break;
        }
        // Old password doesn't match
        if ($isUserValid['password'] !== $_POST['old_password']) {
            $errorMessage = 'The old password does not match. Please try again.';
            unset($successMessage);
            break;
        }
        // Same password as the old one
        if ($isUserValid['password'] === $_POST['new_password']) {
            $errorMessage = 'Please enter a different new password.';
            unset($successMessage);
            break;
        }
        // Validate password
        if (!validateInput($_POST['new_password'], 'password')) {
            $errorMessage = 'Your new password does not match the requirements.';
            unset($successMessage);
            break;
        }
        // New password doesn't match
        if ($_POST['new_password'] !== $_POST['confirm_password']) {
            $errorMessage = 'New password does not match the confirmed password. Please try again.';
            unset($successMessage);
            break;
        }
        // Update password
        if (!updateUserPersonalData($_SESSION['user_logged']['email'], $_POST['new_password'], 'password')) {
            $errorMessage = 'Something went wrong. Please try again later.';
            unset($successMessage);
            break;
        }
        $successMessage = 'Your password has been successfully updated.';
        unset($errorMessage);
    } while(0);

}
// debug($_POST);

?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/profile.html'; ?>
<!-- Template -->
<?= $mustache->render($profile, []); ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>