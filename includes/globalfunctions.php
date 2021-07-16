<?php
require_once 'includes/dbh.inc.php';
// Global variables
define("BASE_DOMAIN_URL", "http://localhost/StudyBuddy/");
define("BASE_DOMAIN_EMAIL", "andreirdv97@gmail.com");
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
        "INSERT INTO user_accounts (email, password, verified, url_passcode) 
            VALUES (
               '".dbEscapeString($email)."',
               '".dbEscapeString($password)."',
               'n', 
               '".dbEscapeString($passcode)."'
            )";
    $result = mysqli_query($conn, $insert);
    if (!$result) {

        return false;
    }

    return true;
}

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
// Used to return user account details
function checkUserAccount(string $email): array
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

    return [
        'email' => $row['email'],
        'password' => $row['password'],
        'verified' => $row['verified'],
        'url_passcode' => $row['url_passcode']
    ];
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