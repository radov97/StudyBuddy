<?php
require_once 'includes/globalfunctions.php';
$resetPassword = getTemplate('mustacheTemplates/resetpassword.mst');
// Set mustache data
$resetPasswordData = ['login_url' => BASE_DOMAIN_URL . 'login.php'];

if (isset($_POST['reset_password'])) {
    $safePassword = trimInputSides($_POST['password']);
    $confirmPassword = trimInputSides($_POST['confirm_password']);
    do {
        // Validate password
        if (!validateInput($safePassword, 'password')) {
            $errorMessage = 'Your password does not match the requirements.';
            unset($successMessage);
            break;
        }
        if ($safePassword !== $confirmPassword) {
            $errorMessage = 'Password does not match the confirmed password.';
            unset($successMessage);
            break;
        }
        $isUserValid = checkUserAccount($_GET['email']);
        // Invalid user
        if (empty($isUserValid)) {
            $errorMessage = 'This user account does not exist.';
            unset($successMessage);
            break;
        }
        if ($isUserValid['url_passcode'] !== $_GET['passcode']) {
            $errorMessage = 'You do not have access to change reset this password. Please request another reset password link.';
            unset($successMessage);
            break;
        }
        // Store this into DB as a password substitute
        $hashAndSalt = password_hash($safePassword, PASSWORD_DEFAULT);
        // Update password
        if (!updateUserPersonalData($_GET['email'], $hashAndSalt, 'password')) {
            $errorMessage = 'Something went wrong. Please try again later.';
            unset($successMessage);
            break;
        }
        $successMessage = 'Password reset successfully.';
        unset($errorMessage);
    } while (0);
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
