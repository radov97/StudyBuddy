<?php
require_once 'includes/globalfunctions.php';
// Redirect safe to login if someone goes here without being logged
if (!isset($_SESSION['user_logged'])) {
    redirectTo(BASE_DOMAIN_URL . 'login.php');
}
// Determine alerts
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case "login":
            $successMessage = "Welcome back. Let's find a buddy today.";
            unset($errorMessage);
            break;
    default:
        break;
    }
}

?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->

<!-- Template -->

<h1 class="bg-warning">Search Post</h1>

<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>