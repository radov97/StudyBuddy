<?php
require_once 'includes/globalfunctions.php';
$forgotPassword = getTemplate('mustacheTemplates/forgotpassword.mst');

?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/login.html'; ?>
<!-- Template -->
<?= $mustache->render($forgotPassword, []);  ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>