<?php
require_once 'includes/globalfunctions.php';
// Redirect safe to login if someone goes here without being logged
if (!isset($_SESSION['user_logged'])) {
    redirectTo(BASE_DOMAIN_URL . 'login.php');
}
// Determine alerts
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case "update":
            $successMessage = 'Your post have successfully been updated.';
            unset($errorMessage);
            break;
        case 'delete':
            $successMessage = 'Your post have successfully been deleted.';
            unset($errorMessage);
            break;
    default:
        break;
    }
}
// Get posts
$userPosts = getUserPosts($_SESSION['user_logged']['email']);
do {
    // No posts
    if (empty($userPosts)) {
        $myposts = getTemplate('mustacheTemplates/mypostsnone.mst');
        $mypostsData = [
            'addpost_url' => BASE_DOMAIN_URL . 'addpost.php'
        ];
        break;
    }
    // Show posts
    if (!empty($userPosts)) {
        $myposts = getTemplate('mustacheTemplates/myposts.mst');
        foreach ($userPosts as $index => $postinfo) {
            $mypostsData['posts'][] = [
                'date' => date_format(date_create($postinfo['date']), "jS F Y, H:i a"),
                'module' => !empty($postinfo['module']) ? $postinfo['module'] : 'NO MODULE',
                'title' => $postinfo['title'],
                'edit_url' => BASE_DOMAIN_URL . 'editpost.php?post_id=' .  urlencode($postinfo['id']),
            ];        
        }
        break;
    };
} while (0);

?>

<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/myposts.html'; ?>
<!-- Template -->
<?= $mustache->render($myposts, $mypostsData); ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>