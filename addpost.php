<?php
require_once 'includes/globalfunctions.php';
// Redirect safe to login if someone goes here without being logged
if (!isset($_SESSION['user_logged'])) {
    redirectTo(BASE_DOMAIN_URL . 'login.php');
}
$addPost = getTemplate('mustacheTemplates/addpost.mst');

if (isset($_POST['add_post'])) {
    do {
        // Limit the user to max 4 posts
        $isUserValid = checkUserAccount($_SESSION['user_logged']['email']);
        if ((int) $isUserValid['total_posts'] >= USER_MAX_ALLOWED_POSTS) {
            $errorMessage = 'You cannot add more than '. USER_MAX_ALLOWED_POSTS . ' posts. Try to delete some or update existing ones.';
            unset($successMessage);
            break;
        }
        $safeTitle = trimInputSides($_POST['title']);
        $safeModule = trimInputSides($_POST['module']);
        if (
            addPost($safeTitle, $safeModule, $_POST['description'], $_SESSION['user_logged']['email']) &&
            updateUserPersonalData(
                $_SESSION['user_logged']['email'], 
                (string)((int) $isUserValid['total_posts'] + 1), 
                'total_posts'
            )
        ) {
            $successMessage = 'Your post has been added successfully.';
            unset($errorMessage);
        } else {
            $errorMessage = 'Something went wrong. Could not add this post. Please try again later.';
            unset($successMessage);
        }
    } while (0);
}

?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/addpost.html'; ?>
<!-- Template -->
<?= $mustache->render($addPost, []); ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>
<script>
$(document).ready(() => {
    // Autoselect module field
    $('#module-understood-btn').click(() => {
        // 500ms to wait the modal to fade and then autofocus the input
        setTimeout(() => { 
            $('#module-input').focus(); 
        }, 500);
    });
});
</script>