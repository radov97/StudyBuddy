<?php
require_once 'includes/globalfunctions.php';
unset($_SESSION['user_logged']);
$register = getTemplate('mustacheTemplates/register.mst');
if (isset($_POST['register_user'])) {
    do {
        // Check if user already exists
        $isUserValid = checkUserAccount($_POST['email']);
        if (!empty($isUserValid)) {
            if ($isUserValid['verified'] === 'n') {
                $errorMessage = 'This account exists and must be verified. Check your email address.';
                unset($successMessage);
                break;
            }
            $errorMessage = 'There is already an account for ' . $_POST['email'];
            unset($successMessage);
            break;
        }
        $safeEmail = trimInputSides($_POST['email']);
        $safePassword = trimInputSides($_POST['password']);
        $confirmPassword = trimInputSides($_POST['confirm_password']);
        // Validate email
        if (!validateInput($safeEmail, 'email')) {
            $errorMessage = 'Please insert a valid email address.';
            unset($successMessage);
            break;
        }
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
        $passcode = generateRandomString();
        if (!registerUser($safeEmail, $safePassword, $passcode)) {
            $errorMessage = 'Something went wrong. Could not create your account.';
            unset($successMessage);
            break;
        }
        // Register new account and ask for validation
        $verifyUrl = BASE_DOMAIN_URL . 'login.php?success=verify&email=' . $safeEmail . '&passcode=' . $passcode;
        if (!mail($safeEmail, 'Verify Your Account', $verifyUrl, 'From: ' . BASE_DOMAIN_EMAIL)) {
            $errorMessage = 'Something went wrong. Could not send you a verify registration email. Please try again.';
            unset($successMessage);
            break;
        }
        redirectTo(BASE_DOMAIN_URL . 'login.php?success=new_user');
    } while (0);
}
// Set mustache data
$registerData = [
    'email' => isset($_POST['email']) ? $_POST['email'] : '',
    'login_url' => BASE_DOMAIN_URL . 'login.php',
];
?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/login.html'; ?>
<!-- Template -->
<?= $mustache->render($register, $registerData); ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>
<script>
$(document).ready(() => {
    // Autoselect password field
    $('#password-understood-btn').click(() => {
        // 500ms to wait the modal to fade and then autofocus the input
        setTimeout(() => { 
            $('#password-input').focus(); 
        }, 500);
    });
});
</script>