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
    input {
        background-color: #fff8c5 !important;
        transition: border .5s;
    }
    input:focus {
        border: 5px #ffc107 solid !important;
    }
    input:disabled {
        background-color: #e9ecef !important;
    }

</style>
<!-- Template -->

<div class="container">
    <div class="row justify-content-center">
    <div class="input-group w-75 mb-3">
        <span class="input-group-text w-25 text-center test">Email Address</span>
        <input type="text" class="form-control shadow-none" value="<?= $_SESSION['user_logged']['email'] ?>" disabled>
        <button class="input-group-text btn btn-dark shadow-none">Change Password</button>
    </div>
    <div class="input-group w-75">
        <span class="input-group-text w-25 text-center">Description</span>
        <input type="text" class="form-control shadow-none" value="<?= $_SESSION['user_logged']['email'] ?>">
        <button class="input-group-text btn btn-warning shadow-none">Save</button>
    </div>
    </div>

</div>

<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>