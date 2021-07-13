<?php
require_once 'includes/globalfunctions.php';
$register = getTemplate('mustacheTemplates/register.mst');

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
            // May contain letter and numbers <br/>
            // Must contain at least 1 number and 1 letter <br/>
            // May contain any of these characters: !@#$% <br/>
            // Must be 8-12 characters <br/>
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
        redirectTo('profile.php?success=new_user');
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