<?php
require_once 'includes/globalfunctions.php';
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
        $message = 'Your password is: ' . $isUserValid['password'];
        if (!mail($safeEmail, 'Forgotten Password', $message, 'From: ' . BASE_DOMAIN_EMAIL)) {
            $errorMessage = 'Something went wrong. Could not send your password. Please try again later.';
            unset($successMessage);
            break;
        }
        $successMessage = 'An email containing your password has been successfully sent.';
        unset($errorMessage);
    } while(0);
}

?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/login.html'; ?>
<!-- Template -->
<?= $mustache->render($forgotPassword, []);  ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>