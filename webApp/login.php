<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 14/01/2018
 * Time: 10:53
 */
require_once 'includes/database.php';
require_once 'includes/userMethods.php';
session_start();
if (isUserLoggedIn()) {
    header('Location: index.php');
    die();
} else if (isset($_POST["mail"]) && isset($_POST["password"])) {
    //TODO: check if POST data is empty.

    $dbConnection = dbConnect();
    $sessionId = session_id();
    $mail = filter_var(trim($_POST['mail']), FILTER_SANITIZE_EMAIL);
    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
    if (!checkIfUserExists($mail)) {
        header('Location: index.php?error=userNotFound');
        die();
    }
    if (!checkPassword($mail, $password)) {
        header('Location: index.php?error=wrongPassword');
        die();
    }
    //DELETE OLD SESSION IF EXISTS
    $userId = getUserIdFromMail($mail);
    $query = "DELETE FROM sessions WHERE userId='$userId'";
    $end = date('Y-m-d H:i:s', time() + 60 * 60);
    $query = "INSERT INTO sessions (sessionId,userId,end) VALUES ('$sessionId','$userId','$end')";
    $rows = $dbConnection->query($query);
    header('Location: index.php');
} else echo 'something missing.';
