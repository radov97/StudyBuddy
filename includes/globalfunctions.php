<?php
require_once 'includes/dbh.inc.php';
// Global variables
define("BASE_DOMAIN_URL", "http://localhost/StudyBuddy/");
define("BASE_DOMAIN_EMAIL", "andreirdv97@gmail.com");
define("USER_MAX_ALLOWED_POSTS", 4);
// Database interaction functions

// Used to insert strings securely into DB
function dbEscapeString(string $string): string
{
    global $conn;
    return mysqli_real_escape_string($conn, $string);
}

// Used to register new user
function registerUser(string $email, string $password, string $passcode): bool
{
    global $conn;
    $insert = 
        "INSERT INTO user_accounts (
                email, 
                password, 
                verified, 
                url_passcode,
                description,
                course_type,
                course_name,
                course_tag,
                academic_year,
                total_posts
            ) 
            VALUES (
               '".dbEscapeString($email)."',
               '".dbEscapeString($password)."',
               'n', 
               '".dbEscapeString($passcode)."', '', '', '', '', '', '0'
            )";
    $result = mysqli_query($conn, $insert);
    if (!$result) {

        return false;
    }

    return true;
}
// Used to validate a new account
function verifyUserAccount(string $email, string $passcode): bool
{
    global $conn;
    $update = 
        "UPDATE user_accounts SET verified = 'y' 
            WHERE email = '" . dbEscapeString($email) . "' 
            AND url_passcode = '" . dbEscapeString($passcode) . "'";
    $result = mysqli_query($conn, $update);
    if (!$result) {

        return false;
    }

    return true;
}
// Used to update user data 
function updateUserPersonalData(string $email, string $newParameter, string $parameter): bool
{
    global $conn;
    $update = 
        "UPDATE user_accounts SET " . dbEscapeString($parameter) . " = '" . dbEscapeString($newParameter) . "' 
            WHERE email = '" . dbEscapeString($email) . "'"; 
    $result = mysqli_query($conn, $update);
    if (!$result) {

        return false;
    }

    return true;
}
// Used to return user account details
function checkUserAccount(string $email, ?bool $profile = false): array
{
    global $conn;
    $userData = [];
    $query = "SELECT * FROM user_accounts WHERE email = '" . dbEscapeString($email) . "'";
    $result = mysqli_query($conn, $query);
    if (!$result) {

        return $userData;
    }
    if (mysqli_num_rows($result) == 0) {
        mysqli_free_result($result);

        return $userData;
    }
    $row = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    if (true === $profile) {
        return [
            'email' => $row['email'],
            'description' => $row['description'],
            'course_type' => $row['course_type'],
            'course_name' => $row['course_name'],
            'course_tag' => $row['course_tag'],
            'academic_year' => $row['academic_year'],
        ];
    }

    return [
        'email' => $row['email'],
        'password' => $row['password'],
        'verified' => $row['verified'],
        'url_passcode' => $row['url_passcode'],
        'description' => $row['description'],
        'course_type' => $row['course_type'],
        'course_name' => $row['course_name'],
        'course_tag' => $row['course_tag'],
        'academic_year' => $row['academic_year'],
        'total_posts' => $row['total_posts'],
    ];
}
// Used to add posts
function addPost(string $title, string $module, string $description, string $email): bool 
{
    global $conn;
    $insert = "INSERT INTO posts (id, title, module, description, email, date) 
        VALUES (
            NULL, 
            '".dbEscapeString($title)."', 
            '".dbEscapeString($module)."', 
            '".dbEscapeString($description)."', 
            '".dbEscapeString($email)."', 
            current_timestamp()
        )";
    $result = mysqli_query($conn, $insert);
    if (!$result) {

        return false;
    }

    return true;
}
// Used to get posts for a user
function getUserPosts(string $email): array 
{
    global $conn;
    $posts = [];
    $query = "SELECT * FROM posts WHERE email = '" . dbEscapeString($email) . "' ORDER BY date DESC";
    $result = mysqli_query($conn, $query);
    if (!$result) {

        return $posts;
    }
    if (mysqli_num_rows($result) == 0) {
        mysqli_free_result($result);

        return $posts;
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
    mysqli_free_result($result);
    return $posts;
}
// Used to get a post having id
function getPostById(int $id): array
{
    global $conn;
    $post = [];
    $query = "SELECT * FROM posts WHERE id = " . (int) $id;
    $result = mysqli_query($conn, $query);
    if (!$result) {

        return $post;
    }
    if (mysqli_num_rows($result) == 0) {
        mysqli_free_result($result);

        return $post;
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $post[] = $row;
    }
    mysqli_free_result($result);
    return $post[0]; 
}
// Used to delete a post
function deletePost(int $id): bool 
{
    global $conn;
    $delete = "DELETE FROM posts WHERE id = " . (int) $id;
    $result = mysqli_query($conn, $delete);
    if (!$result) {

        return false;
    }

    return true;
}
// Used to update a post
function updatePost(int $id, string $title, string $module, string $description): bool 
{
    global $conn;
    $update = 
        "UPDATE posts SET 
            title = '" . dbEscapeString($title) . "',
            module = '" . dbEscapeString($module) . "',
            description = '" . dbEscapeString($description) . "'
            WHERE id =" . (int) $id;
    $result = mysqli_query($conn, $update);
    if (!$result) {

        return false;
    }

    return true;
}
function getFilteredPosts(?array $filters = []): array
{
    global $conn;
    $posts = [];
    if (!empty($filters)) {
        $uTable = ['course_type', 'course_name', 'course_tag', 'academic_year'];
        $pTable = ['title', 'module'];
        $sqlOperator = '';
        $iterator = 1;
        foreach ($filters as $key => $filterinfo) {
            if (in_array($key, $uTable)) {
                $sqlOperator .= 'u.'.$key;
            } else if (in_array($key, $pTable)) {
                $sqlOperator .= 'p.'.$key;
            }
            $safeFilter = dbEscapeString($filterinfo);
            $sqlOperator .= " LIKE '%{$safeFilter}%' ";
            if ($iterator === count($filters)) {
                break;
            }
            $sqlOperator .= " AND ";
            $iterator++;
        }
        $query = "SELECT 
                    p.id, p.title, p.module, p.description,
                    u.course_type, u.course_name, u.course_tag, u.academic_year, p.email, p.date
                FROM posts AS p INNER JOIN user_accounts AS u ON p.email = u.email 
                    WHERE {$sqlOperator}
                ORDER BY p.date DESC;";
    } else {
        $query = "SELECT * FROM posts ORDER BY date DESC";
    }
    
    $result = mysqli_query($conn, $query);
    if (!$result) {

        return $posts;
    }
    if (mysqli_num_rows($result) == 0) {
        mysqli_free_result($result);

        return $posts;
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
    mysqli_free_result($result);

    return $posts; 
}

// Codebase functions

// Used to insert mustache templates
function getTemplate(string $path): string 
{
    ob_start();
    require_once $path;
    return ob_get_clean();
}
// Used to redirect to other page
function redirectTo(string $url): void 
{
    header('Location: ' . $url);
    exit();
}
// Used to debug code
function debug($variable): string 
{
    return highlight_string("<?php\n\$data =\n" . var_export($variable, true) . ";\n?>");
}
// Used to validate each input inserted
function validateInput(string $input, string $type): bool
{
    $validation = "";
    switch ($type) {
        case "email":
            $validation = "/[a-zA-Z0-9._-]{3,}@[a-zA-Z0-9._-]{3,}[.]{1}[a-zA-Z0-9._-]{2,}/";
            break;
        case 'password':
            $validation = "/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,20}$/";
            break;
    default:
        return false;       
    }
    if (!preg_match($validation, $input)) {
        return false;
    }
    return true;
}
// Used to remove sides whitespaces from an input
function trimInputSides(string $input): string
{
    $input = ltrim($input, " ");
    $input = rtrim($input, " ");
    return $input;
}
// Used to generate a random string
function generateRandomString(int $length = 10): string 
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return (string) $randomString;
}

?>