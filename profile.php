<?php
require_once 'includes/globalfunctions.php';
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

<h1 class="bg-warning">Work in progress</h1>

<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>