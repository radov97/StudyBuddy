<?php
require_once 'includes/globalfunctions.php';
// Redirect safe to login if someone goes here without being logged
if (!isset($_SESSION['user_logged'])) {
    redirectTo(BASE_DOMAIN_URL . 'login.php');
} 


?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<style>
    .no-posts {
        border: 5px #ffc107 solid !important;
        background-color: #fff8c5 !important;
    }
</style>
<!-- Template -->

<div class="container text-center">
    <div class="row bg-warning rounded mt-5 p-1 no-posts">
        <h2>You have no posts yet</h2>
    </div>
    <a 
        class="btn btn-warning btn-lg shadow-none w-25 m-5"
        href="addpost.php"
    >
        <i class="bi bi-file-plus"></i>
        Add Post
    </a>

</div>

<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>