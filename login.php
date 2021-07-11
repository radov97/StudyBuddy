<?php
require_once 'includes/globalfunctions.php';
$login = getTemplate('mustacheTemplates/login.mst');

?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/login.html'; ?>
<!-- Template -->
<?= $mustache->render($login, []);  ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>