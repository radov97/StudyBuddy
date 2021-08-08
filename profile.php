<?php
require_once 'includes/globalfunctions.php';
// Redirect safe to login if someone goes here without being logged
if (!isset($_SESSION['user_logged'])) {
    redirectTo(BASE_DOMAIN_URL . 'login.php');
}
$profile = getTemplate('mustacheTemplates/profile.mst');
// Change password
if (isset($_POST['change_password'])) {
    do {
        // Check if user already exists
        $isUserValid = checkUserAccount($_SESSION['user_logged']['email']);
        // Invalid user
        if (empty($isUserValid)) {
            $errorMessage = 'Something went wrong. Please try again later.';
            unset($successMessage);
            break;
        }
        // Old password doesn't match
        if ($isUserValid['password'] !== $_POST['old_password']) {
            $errorMessage = 'The old password does not match. Please try again.';
            unset($successMessage);
            break;
        }
        // Same password as the old one
        if ($isUserValid['password'] === $_POST['new_password']) {
            $errorMessage = 'Please enter a different new password.';
            unset($successMessage);
            break;
        }
        // Validate password
        if (!validateInput($_POST['new_password'], 'password')) {
            $errorMessage = 'Your new password does not match the requirements.';
            unset($successMessage);
            break;
        }
        // New password doesn't match
        if ($_POST['new_password'] !== $_POST['confirm_password']) {
            $errorMessage = 'New password does not match the confirmed password. Please try again.';
            unset($successMessage);
            break;
        }
        // Update password
        if (!updateUserPersonalData($_SESSION['user_logged']['email'], $_POST['new_password'], 'password')) {
            $errorMessage = 'Something went wrong. Please try again later.';
            unset($successMessage);
            break;
        }
        $successMessage = 'Your password has been successfully updated.';
        unset($errorMessage);
    } while(0);

}
// Update description
if (isset($_POST['save_description'])) {
    $safeDescription = trimInputSides($_POST['description']);
    if (!updateUserPersonalData($_SESSION['user_logged']['email'], $safeDescription, 'description')) {
        $errorMessage = 'Something went wrong. Could not update the description. Please try again later.';
        unset($successMessage);
    } else {
        $successMessage = 'Your profile description has been successfully updated.';
        unset($errorMessage);
    }
}
// Update course type
if (isset($_POST['save_course_type'])) {
    $safeCourseType = trimInputSides($_POST['course_type']);
    if (!updateUserPersonalData($_SESSION['user_logged']['email'], $safeCourseType, 'course_type')) {
        $errorMessage = 'Something went wrong. Could not update the course type. Please try again later.';
        unset($successMessage);
    } else {
        $successMessage = 'Your profile course type has been successfully updated.';
        unset($errorMessage);
    }
}
// Update course name
if (isset($_POST['save_course_name'])) {
    $safeCourseName = trimInputSides($_POST['course_name']);
    if (!updateUserPersonalData($_SESSION['user_logged']['email'], $safeCourseName, 'course_name')) {
        $errorMessage = 'Something went wrong. Could not update the course name. Please try again later.';
        unset($successMessage);
    } else {
        $successMessage = 'Your profile course name has been successfully updated.';
        unset($errorMessage);
    }
}
// Update course tag
if (isset($_POST['save_course_tag'])) {
    $safeCourseTag = trimInputSides($_POST['course_tag']);
    if (!updateUserPersonalData($_SESSION['user_logged']['email'], $safeCourseTag, 'course_tag')) {
        $errorMessage = 'Something went wrong. Could not update the course tag. Please try again later.';
        unset($successMessage);
    } else {
        $successMessage = 'Your profile course tag has been successfully updated.';
        unset($errorMessage);
    }
}
// Update academic year
if (isset($_POST['save_academic_year'])) {
    $safeAcademicYear = trimInputSides($_POST['academic_year']);
    if (!updateUserPersonalData($_SESSION['user_logged']['email'], $safeAcademicYear, 'academic_year')) {
        $errorMessage = 'Something went wrong. Could not update the academic year. Please try again later.';
        unset($successMessage);
        
    } else {
        $successMessage = 'Your profile academic year has been successfully updated.';
        unset($errorMessage);
    }
}

// Set mustache data
$userData = checkUserAccount($_SESSION['user_logged']['email'], true);
$profileData = [
    'description' => $userData['description'],
    'course_name' => $userData['course_name'],
    'course_tag' => $userData['course_tag'],
    'academic_year' => $userData['academic_year'],
];

?>

<!-- Header -->
<?php require_once 'includes/mainheader.php'; ?>
<!-- Style -->
<?php require_once 'styles/profile.html'; ?>
<!-- Template -->
<?= $mustache->render($profile, $profileData); ?>
<!-- Footer -->
<?php require_once 'includes/mainfooter.php'; ?>
<script>
$(document).ready(() => {
    // Autoselect the course type if any
    let courseType = '<?= !empty($userData['course_type']) ? $userData['course_type'] : '' ?>';
    $("#course-type option[value='" + courseType + "']").attr("selected","selected");
});
</script>