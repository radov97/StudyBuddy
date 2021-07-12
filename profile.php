<?php
require_once 'includes/globalfunctions.php';

if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case "new_user":
            $successMessage = 'Your account has been successfully created.';
            break;
    default:
        break;
    }
}

// debug($_SESSION);
?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->

<!-- Template -->
<h1>This page is just a test</h1>
<h1>I love you Dasha</h1>

<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>