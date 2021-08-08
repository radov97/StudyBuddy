<?php  
require_once 'includes/globalfunctions.php';
// Redirect safe to login if someone goes here without being logged
if (!isset($_SESSION['user_logged'])) {
    redirectTo(BASE_DOMAIN_URL . 'login.php');
}
// Call to get user profile data
if (isset($_POST['view_user_profile'])) {
    $userData = checkUserAccount($_POST['email'], true);
    if (empty($userData)) {
        header('Content-type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Something went wrong. This user profile cannot be viewed.']);
        exit;
    }
    switch ($userData['course_type']) {
        case "bachelor":
            $userData['course_type'] = 'Bachelor Degree Student';
            break;
        case "msc":
            $userData['course_type'] = 'Master Course Student';
            break;
        case "phd":
            $userData['course_type'] = 'Phd Student';
            break;
        default:
            $userData['course_type'] = '&nbsp;';
            break;
    }
    $userData['course_name'] = empty($userData['course_name']) ? '&nbsp;' : $userData['course_name'];
    $userData['course_tag'] = empty($userData['course_tag']) ? '&nbsp;' : $userData['course_tag'];
    $userData['academic_year'] = empty($userData['academic_year']) ? '&nbsp;' : 'Year ' . $userData['academic_year'];
    $userData['description'] = empty($userData['description']) ? '&nbsp;' : '&#8220;' . $userData['description'] . '&#8221';
    header('Content-type: application/json');
    http_response_code(200);
    echo json_encode(['data' => $userData]);
    exit;
}

?>