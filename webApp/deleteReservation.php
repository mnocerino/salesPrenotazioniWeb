<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 01/02/2018
 * Time: 12:26
 */

require_once 'includes/database.php';
require_once 'includes/userFunctions.php';
require_once 'includes/booking.php';
require_once 'includes/rooms.php';
session_start();
if (!isUserLoggedIn()) {
    header('Location: index.php');
    die();
}

if (isset($_GET['bookingId'])) {
    $booking = filter_var(trim($_GET['bookingId']), FILTER_SANITIZE_NUMBER_INT);
    if (deleteBooking($booking)) header('Location: myReservations.php');
    die();


}
header('Location: error.php?error=cannotDelete');
