<?php
require_once 'includes/globalfunctions.php';
$template = getTemplate('mustacheTemplates/index.mst');
debug($_SERVER);
?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->

<!-- Template -->
<h1>This page is just a test</h1>
<h1>I love you Dasha</h1>
<?= $mustache->render($template, ['planet' => 'World!']);  ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>
