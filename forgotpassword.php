<?php
require_once 'includes/globalfunctions.php';
unset($_SESSION['user_logged']);
$forgotPassword = getTemplate('mustacheTemplates/forgotpassword.mst');
if (isset($_POST['resend_password'])) {
    $safeEmail = trimInputSides($_POST['email']);
    $isUserValid = checkUserAccount($safeEmail);
    do {
        // Invalid user
        if (empty($isUserValid)) {
            $errorMessage = 'Invalid email address.';
            unset($successMessage);
            break;
        }
        $resetPassUrl = BASE_DOMAIN_URL . 'resetpassword.php?email=' . $safeEmail . '&passcode=' . $isUserValid['url_passcode'];
        if (!mail($safeEmail, 'Reset Password', $resetPassUrl, 'From: ' . BASE_DOMAIN_EMAIL)) {
            $errorMessage = 'Something went wrong. Could not send your password. Please try again later.';
            unset($successMessage);
            break;
        }
        $successMessage = 'An email containing a reset link has been successfully sent.';
        unset($errorMessage);
    } while(0);
}
// Set mustache data
$forgotPasswordData = ['login_url' => BASE_DOMAIN_URL . 'login.php'];
?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/login.html'; ?>
<!-- Template -->
<?= $mustache->render($forgotPassword, $forgotPasswordData);  ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>