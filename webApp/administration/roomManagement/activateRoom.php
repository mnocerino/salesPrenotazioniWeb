<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 05/02/2018
 * Time: 12:58
 */

require_once '../../includes/database.php';
require_once '../../includes/userFunctions.php';
require_once '../../includes/booking.php';
require_once '../../includes/rooms.php';

session_start();
if (!isUserLoggedIn()) {
    header('Location: ../../../index.php');
    die();
}
if (!isUserAdmin(getUserIdFromSession())) {
    header('Location: ../../index.php');
}

if (isset($_GET['roomId'])) {
    $roomId = filter_var(trim($_GET['roomId']), FILTER_SANITIZE_NUMBER_INT);
    activateRoom($roomId);
}
header('Location: ../manageRooms.php');