<?php
require_once 'includes/globalfunctions.php';
// Redirect safe to login if someone goes here without being logged
if (!isset($_SESSION['user_logged'])) {
    redirectTo(BASE_DOMAIN_URL . 'login.php');
} 


?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->

<!-- Template -->

<h1 class="bg-warning">My Posts</h1>

<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>