<?php
require_once 'includes/globalfunctions.php';
unset($_SESSION['user_logged']);
$activation = getTemplate('mustacheTemplates/activation.mst');
if (isset($_POST['resend_link'])) {
    $safeEmail = trimInputSides($_POST['email']);
    $isUserValid = checkUserAccount($safeEmail);
    do {
        // Invalid user
        if (empty($isUserValid)) {
            $errorMessage = 'Invalid email address.';
            unset($successMessage);
            break;
        }
        // Already verified
        if ($isUserValid['verified'] === 'y') {
            $errorMessage = 'This account is already verified.';
            unset($successMessage);
            break;
        }
        // Register new account and ask for validation
        $verifyUrl = BASE_DOMAIN_URL . 'login.php?success=verify&email=' . $safeEmail . '&passcode=' . $isUserValid['url_passcode'];
        if (!mail($safeEmail, 'Verify Your Account', $verifyUrl, 'From: ' . BASE_DOMAIN_EMAIL)) {
            $errorMessage = 'Something went wrong. Could not send you a verify registration email. Please try again.';
            unset($successMessage);
            break;
        }
        $successMessage = 'A link to activate your account has been successfully sent to your email.';
        unset($errorMessage);
    } while(0);
}
// Set mustache data
$activationData = ['login_url' => BASE_DOMAIN_URL . 'login.php'];
?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/login.html'; ?>
<!-- Template -->
<?= $mustache->render($activation, $activationData);  ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>
