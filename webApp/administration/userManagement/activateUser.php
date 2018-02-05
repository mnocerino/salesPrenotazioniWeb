<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 05/02/2018
 * Time: 14:24
 */

require_once '../../includes/database.php';
require_once '../../includes/userFunctions.php';


session_start();
if (!isUserLoggedIn()) {
    header('Location: ../../../index.php');
    die();
}
if (!isUserAdmin(getUserIdFromSession())) {
    header('Location: ../../index.php');
}

if (isset($_GET['userId'])) {
    $userId = filter_var(trim($_GET['userId']), FILTER_SANITIZE_NUMBER_INT);
    activateUser($userId);
}
header('Location: ../manageUsers.php');