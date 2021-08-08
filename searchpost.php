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
        'disabled' => ($postinfo['email'] === $_SESSION['user_logged']['email']) ? 'disabled' : '',
        'searchpost_url' => BASE_DOMAIN_URL . 'searchpost.php',
        'email' => $postinfo['email'],
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
<script>
    $(document).ready(() => {
        $("#filters-container-id").slideToggle("fast");
        $('#filters-btn').click(() => {
            $("#filters-container-id").slideToggle("slow");
            setTimeout(() => { 
                $('#arrow-icon').toggleClass("bi-sort-down-alt bi-sort-up-alt");
            }, 450);
        });
        $('#scroll-to-top-btn').click(() => {
            $(window).scrollTop(0);
        });

        $('.user-profile-modal-btn').click(function () {
            $.ajax({
                url: 'ajaxcalls.php',
                type: 'POST',
                data: {
                    view_user_profile: true,
                    email: $(this).data('email'),
                },
                success: (response) => {
                    // Hide Send Email Button for same user
                    if (true === response.isSameUser) {
                        $('#user-profile-send-email-btn').attr("disabled", true);
                    } else {
                        $('#user-profile-send-email-btn').removeAttr("disabled");
                    }
                    // Autofill user profile modal
                    $('#profile-course-type').html(response.data.course_type);
                    $('#profile-course-name').html(response.data.course_name);
                    $('#profile-course-tag').html(response.data.course_tag);
                    $('#profile-year').html(response.data.academic_year);
                    $('#profile-description').html(response.data.description);
                    $('#user-profile-modal').modal('show');
                },
                error: (response) => {
                    alert(response.responseJSON.error);
                },
            });

        });
    });
</script>