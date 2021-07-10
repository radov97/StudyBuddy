<?php

$m = new Mustache_Engine(array('entity_flags' => ENT_QUOTES));
echo $m->render('Hello {{planet}}', array('planet' => 'World!'));
?>

<!-- Header -->
<?php include_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php include_once 'styles/index.html'; ?>
<!-- Template -->
    <h1 class="bg-warning">Test Page</h1>
<!-- Footer -->
<?php include_once 'includes/mainfooter.php'; ?>
