<?php
require_once 'includes/globalfunctions.php';
$template = getTemplate('mustacheTemplates/index.mst');

?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/index.html'; ?>
<!-- Template -->
<?= $mustache->render($template, ['planet' => 'World!']);  ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>
