<?php
include_once 'includes/dbh.inc.php';

function getClasses(): array
{
    global $conn;
    
    $sql = 'SELECT * FROM classes WHERE capacity > 0 ORDER BY module ASC, day_id ASC, minutes ASC';
    $result = mysqli_query($conn, $sql);

    $classes = [];
    if (!$result) {
        return $classes;
    }

    if (mysqli_num_rows($result) == 0) {
        mysqli_free_result($result);
        return $classes;
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $classes[] = $row;
    }
    mysqli_free_result($result);
    return $classes;
}
function confirmBooking(int $classId): bool
{
    global $conn;
    
    // Request the most recent update to avoid booking failure
    $capacity = 'SELECT capacity FROM classes WHERE class_id = ' . $classId;
    $result = mysqli_query($conn, $capacity);
    // if query fails
    if (!$result) {
        return false;
    }
    // if requested class does not exist anymore
    if (mysqli_num_rows($result) == 0) {
        mysqli_free_result($result);
        return false;
    }
    
    $capacity = mysqli_fetch_assoc($result);
    $capacity = (int)$capacity['capacity'];
    mysqli_free_result($result);
    
    if ($capacity == 0) {
        return false;
    } else {
        $update = 'UPDATE classes SET capacity = ' . ($capacity - 1) . ' WHERE class_id = ' . $classId;
        $result = mysqli_query($conn, $update);
            if (!$result) {
            return false;
        }
        return true;
    }
}   

function recordBooking(string $module, string $time, string $name, string $email): bool
{
    global $conn;
    
    $insert = 
        'INSERT INTO bookings (booking_id, module, time, user_name, email) 
            VALUES (
                NULL, "'
                .dbEscapeString($module).'", "'
                .dbEscapeString($time).'", "'
                .dbEscapeString($name).'", "'
                .dbEscapeString($email).'"
                )';
    $result = mysqli_query($conn, $insert);
    
    if (!$result) {
        return false;
    }
    return true;
}

function dbEscapeString(string $string): string
{
    global $conn;
    return mysqli_real_escape_string($conn, $string);
}

function checkFormInput(string $input, string $type): bool
{
    $validation = "";
    switch ($type) {
        case "name":
            $validation = "/^(?:[a-z]+[-' ]?)+[a-z]$/i";
            break;
        case "email":
            $validation = "/[a-zA-Z0-9._-]{3,}@[a-zA-Z0-9._-]{3,}[.]{1}[a-zA-Z0-9._-]{2,}/";
            break;
    default:
        return false;       
    }
    if (!preg_match($validation, $input)) {
        return false;
    }
    return true;
}

function clearInputSideSpaces(string $input): string
{
    $input = ltrim($input, " ");
    $input = rtrim($input, " ");
    return $input;
}