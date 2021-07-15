<?php
require_once 'includes/globalfunctions.php';
$register = getTemplate('mustacheTemplates/register.mst');

// $mail_sent = mail('anasdasdci@eden.co.uk', 'Test Subject 2', 'Hello There!', 'From: andreirdv97@gmail.com');
// echo 'mail_sent = ' . $mail_sent;

if (isset($_POST['register_user'])) {
    do {
        // Check if user already exists
        $isUserValid = checkUserAccount($_POST['email']);
        if (!empty($isUserValid)) {
            $errorMessage = 'There is already an account for ' . $_POST['email'];
            break;
        }
        $safeEmail = trimInputSides($_POST['email']);
        $safePassword = trimInputSides($_POST['password']);
        $confirmPassword = trimInputSides($_POST['confirm_password']);
        // Validate email
        if (!validateInput($safeEmail, 'email')) {
            $errorMessage = 'Please insert a valid email address.';
            break;
        }
        // Validate password
        if (!validateInput($safePassword, 'password')) {
            $errorMessage = 'Your password does not match the requirements.';
            break;
        }
        if ($safePassword !== $confirmPassword) {
            $errorMessage = 'Password does not match the confirmed password.';
            break;
        }
        if (!registerUser($safeEmail, $safePassword)) {
            $errorMessage = 'Something went wrong. Could not create your account.';
            break;
        }
        $_SESSION['user_logged']['email'] = $safeEmail;
        redirectTo('login.php?success=new_user');
    } while (0);
}

?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/login.html'; ?>
<!-- Template -->
<?= $mustache->render($register, ['email'=> isset($_POST['email']) ? $_POST['email'] : '']); ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>