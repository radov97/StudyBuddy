<?php
require_once 'includes/globalfunctions.php';
unset($_SESSION['user_logged']);
$login = getTemplate('mustacheTemplates/login.mst');
// Determine alerts
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case "new_user":
            $successMessage = 'Your account has been successfully created. Please confirm your email address.';
            unset($errorMessage);
            break;
        case "verify":
            $isUserValid = checkUserAccount($_GET['email']);
            do {
                if (empty($isUserValid) || $isUserValid['url_passcode'] !== $_GET['passcode']) {
                    $errorMessage = 'This verification link is not valid. Please request a new one.';
                    unset($successMessage);
                    break;
                }
                if ($isUserValid['verified'] === 'y') {
                    $successMessage = 'This account is already verified. You can login.';
                    unset($errorMessage);
                    break;
                }
                // Verify account
                if (!verifyUserAccount($_GET['email'], $_GET['passcode'])) {
                    $errorMessage = 'Could not verify your account. Please request a new verification link and try again.';
                    unset($successMessage);
                    break;
                }
                $successMessage = 'Your account has successfully been verified. You can login.';
                unset($errorMessage);
            } while(0);
            break;
        case "logout":
            $successMessage = 'Successfully logout. See you next time.';
            unset($errorMessage);
            unset($_SESSION['user_logged']);
            break;
    default:
        break;
    }
}
// Determine login
if (isset($_POST['login_user'])) {
    $safeEmail = trimInputSides($_POST['email']);
    $safePassword = trimInputSides($_POST['password']);
    // Check if user already exists
    $isUserValid = checkUserAccount($safeEmail);
    do {
        // Invalid user
        if (empty($isUserValid)) {
            $errorMessage = 'Invalid email address.';
            unset($successMessage);
            break;
        }
        // Account not verified yet
        if ($isUserValid['verified'] === 'n') {
            $errorMessage = 'This account must be verified. Please check your email.';
            unset($successMessage);
            break;
        }
        //  Wrong password
        if (!password_verify($safePassword, $isUserValid['password'])) {
            $errorMessage = 'Wrong password.';
            unset($successMessage);
            break;
        }
        $_SESSION['user_logged']['email'] = $safeEmail;
        redirectTo(BASE_DOMAIN_URL . 'searchpost.php?success=login');
    } while(0);
}
// Autofill saved email
$fillEmail = '';
if (isset($_POST['email'])) {
    $fillEmail = $_POST['email'];
} else if (empty($fillEmail) && isset($_GET['email'])) {
    $fillEmail = $_GET['email'];
}
// Set mustache data
$loginData = [
    'login_url' => $fillEmail,
];
?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/login.html'; ?>
<!-- Template -->
<?= $mustache->render($login, $loginData); ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>