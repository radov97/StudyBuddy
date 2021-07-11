<?php
require_once 'includes/globalfunctions.php';
$register = getTemplate('mustacheTemplates/register.mst');

?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/login.html'; ?>
<!-- Template -->
<?= $mustache->render($register, []);  ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>