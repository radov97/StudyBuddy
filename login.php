<?php
require_once 'includes/globalfunctions.php';
$login = getTemplate('mustacheTemplates/login.mst');
// Determine alerts
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case "logout":
            $successMessage = 'Successfully logout. See you next time.';
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
            break;
        }
        //  Wrong password
        if ($isUserValid['password'] !== $safePassword) {
            $errorMessage = 'Wrong password.';
            break;
        }
        $_SESSION['user_logged']['email'] = $safeEmail;
        redirectTo('profile.php?success=login');
    } while(0);
}

?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/login.html'; ?>
<!-- Template -->
<?= $mustache->render($login, ['email'=> isset($_POST['email']) ? $_POST['email'] : '']); ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>