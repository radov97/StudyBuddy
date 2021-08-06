<?php
require_once 'includes/globalfunctions.php';
// Redirect safe to login if someone goes here without being logged
if (!isset($_SESSION['user_logged'])) {
    redirectTo(BASE_DOMAIN_URL . 'login.php');
}
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
?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<style>
    .posts-container {
        display: flex;
        flex-direction: column;
        flex-wrap: nowrap;
        background-color: #fff8c5;
        justify-content: center;
        align-items: center;
        border: 5px #ffc107 solid !important;
        border-radius: .5rem !important;
        margin-bottom: 3rem !important;
        margin-top: 3rem !important;
    }
    .card {
        width: 95%;
    }
    .card-header-custom {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        align-items: center;
    }
</style>
<!-- Template -->
<div class="container">
    <div class="posts-container">
        <div class="card text-white bg-dark mt-2 mb-2">
            <div class="card-header w-100">
                <div class="card-header-custom">
                    <button class="btn btn-lg btn-light shadow-none rounded-top p-1">
                        <i class="bi bi-person-square h1"></i>
                    </button>
                    <h2 class="m-2">Help me with biologyk jakdj kasjd kasjd kasjd kasjd kasjd kasjd kasjd kasjd aks jdkasjd as</h2>
                </div>

            </div>
            <div class="card-body">
                <div class="card-title h5">
                    Help me with biology
                </div>
                <p class="card-text">Help me with biology</p>
                <a 
                    class="btn btn-warning w-25 float-end shadow-none"
                    href={{edit_url}}
                >
                    <i class="bi bi-pencil"></i> 
                    Edit
                </a>
            </div>
        </div>
    </div>
</div>


<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>