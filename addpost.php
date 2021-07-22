<?php
require_once 'includes/globalfunctions.php';
// Redirect safe to login if someone goes here without being logged
if (!isset($_SESSION['user_logged'])) {
    redirectTo(BASE_DOMAIN_URL . 'login.php');
} 
$addPost = getTemplate('mustacheTemplates/addpost.mst');
$addPostData = [];
?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/addpost.html'; ?>
<!-- Template -->
<?= $mustache->render($addPost, $addPostData); ?>
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