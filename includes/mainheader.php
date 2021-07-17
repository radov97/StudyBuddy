<?php
// Mustache PHP version 2.13.0
require_once 'mustache.php-2.13.0/src/Mustache/Autoloader.php';
Mustache_Autoloader::register();
$mustache = new Mustache_Engine(['entity_flags' => ENT_QUOTES]);
// Determine navbar
if (isset($_SESSION['user_logged'])) {
    $navbar = getTemplate('mustacheTemplates/navbarlogged.mst');
    $navbarData = [
        'profile_url' => BASE_DOMAIN_URL . 'profile.php',
        'createpost_url' => BASE_DOMAIN_URL . 'createpost.php',
        'searchpost_url' => BASE_DOMAIN_URL . 'searchpost.php',
        'logout_url' => BASE_DOMAIN_URL . 'login.php?success=logout',
    ];
} else {
    $navbar = getTemplate('mustacheTemplates/navbarsignout.mst');
    $navbarData = [
        'login_url' => BASE_DOMAIN_URL . 'login.php',
        'register_url' => BASE_DOMAIN_URL . 'register.php'
    ];
}
// Determine alert message
if (isset($successMessage)) {
    $alertMessage = getTemplate('mustacheTemplates/alertmessage.mst');
    $alertMessageData = ['type' => 'alert-success', 'message' => $successMessage];
    $soundSrc = 'resources/sounds/success.ogg';
}
if (isset($errorMessage)) {
    $alertMessage = getTemplate('mustacheTemplates/alertmessage.mst');
    $alertMessageData = ['type' => 'alert-danger', 'message' => $errorMessage];
    $soundSrc = 'resources/sounds/error.ogg';
}
?>
<!-- Style -->
<?php require_once 'styles/styles.html'; ?>
<?php require_once 'styles/navbar.html'; ?>

<!DOCTYPE html>
<html lang="en">
<!--COMP702, Andrei Radovici, Summer 2021-->
<!-- The integrity and crossorigin attributes are used for Subresource Integrity (SRI) checking. This allows browsers to ensure that resources hosted on third-party servers have not been tampered with. Use of SRI is recommended as a best-practice, whenever libraries are loaded from a third-party source -->
    <head>
        <meta name="mobile-web-app-capable" content="yes">
        <meta charset="UTF-8">
        <meta name="author" content="Andrei Radovici">
        <meta name="description" content="Web-Based Platform Project for COMP702">
        <meta name="keywords" content="COMP702,StudyBuddy">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>StudBud Pairing</title>
        <!-- Website Favicon -->
        <link rel="icon" type="image/png" href="resources/logo/logo_small_icon_only.png">
        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" integrity="sha384-tKLJeE1ALTUwtXlaGjJYM3sejfssWdAaWR2s97axw4xkiAdMzQjtOjgcyw0Y50KU" crossorigin="anonymous">
        <!-- jQuery 3.6.0 minified version -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </head>
    <body>
        <main class="site-content">
    <!-- Render navbar -->
    <?= $mustache->render($navbar, $navbarData); ?>
    <!-- Render alert message -->
    <?php
        if (isset($alertMessage)) {
            echo $mustache->render($alertMessage, $alertMessageData);
        }
    ?>
