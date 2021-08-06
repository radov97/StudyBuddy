<?php
require_once 'includes/globalfunctions.php';
$template = getTemplate('mustacheTemplates/index.mst');
debug($_SERVER);
?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->

<!-- Template -->
<?= $mustache->render($template, ['planet' => 'World!']);  ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>
