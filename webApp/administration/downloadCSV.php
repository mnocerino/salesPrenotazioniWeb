<?php
/**
 * Created by PhpStorm.
 * User: Mattia
 * Date: 14/03/2018
 * Time: 08:52
 */

setlocale(LC_TIME, 'it_IT');
require_once '../includes/database.php';
require_once '../includes/userFunctions.php';
require_once '../includes/booking.php';
require_once '../includes/rooms.php';

session_start();
if (!isUserLoggedIn()) {
    header('Location: ../index.php');
    die();
}
if (!isUserAdmin(getUserIdFromSession())) {
    header('Location: ../index.php');
    die();
}

getCSV();