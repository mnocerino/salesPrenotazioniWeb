<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 02/02/2018
 * Time: 16:48
 */
require_once 'includes/database.php';
require_once 'includes/userFunctions.php';
require_once 'includes/booking.php';
require_once 'includes/rooms.php';
session_start();
if (!isUserLoggedIn()) {
    header('Location: index.php');
    die();
} else if (isset($_POST["startDate"]) && isset($_POST["startOre"]) && isset($_POST["startMin"]) && isset($_POST["endOre"]) && isset($_POST["endMin"]) && isset($_POST["room"])) {

    $dbConnection = dbConnect();
    $startDate = filter_var(trim($_POST['startDate']), FILTER_SANITIZE_STRING);
    $startOre = filter_var(trim($_POST['startOre']), FILTER_SANITIZE_NUMBER_INT);
    $startMin = filter_var(trim($_POST['startMin']), FILTER_SANITIZE_NUMBER_INT);
    $endOre = filter_var(trim($_POST['endOre']), FILTER_SANITIZE_NUMBER_INT);
    $endMin = filter_var(trim($_POST['endMin']), FILTER_SANITIZE_NUMBER_INT);
    $room = filter_var(trim($_POST['room']), FILTER_SANITIZE_NUMBER_INT);
    $queryStart = $startDate . " " . $startOre . ":" . $startMin . ":00";
    $queryEnd = $startDate . " " . $endOre . ":" . $endMin . ":00";
    $price = calculateBookingCost(getUserIdFromSession(), $queryStart, $queryEnd);
    $booked = newBooking((getUserIdFromSession()), $queryStart, $queryEnd, $room, $price);
    $header = "Location: myReservations.php?bookingId=" . $booked;
    header($header);
} else header('Location newReservation.php?error=missingData');
