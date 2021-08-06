<?php
require_once 'includes/globalfunctions.php';
// Redirect safe to login if someone goes here without being logged
if (!isset($_SESSION['user_logged'])) {
    redirectTo(BASE_DOMAIN_URL . 'login.php');
}
$searchpost = getTemplate('mustacheTemplates/searchpost.mst');
// Determine alerts
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case "login":
            $successMessage = "Welcome back. Let's find a buddy today.";
            unset($errorMessage);
            break;
    default:
        break;
    }
}

$allPosts = getAllPosts();

foreach ($allPosts as $index => $postinfo) {
    $postsData['posts'][] = [
        'date' => date_format(date_create($postinfo['date']), "jS F Y, H:i a"),
        'module' => !empty($postinfo['module']) ? $postinfo['module'] : 'NO MODULE',
        'title' => $postinfo['title'],
        'description' => $postinfo['description'],
    ];        
}

?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/searchpost.html'; ?>
<!-- Template -->
<?= $mustache->render($searchpost, $postsData); ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>