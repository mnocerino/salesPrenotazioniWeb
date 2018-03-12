<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 14/01/2018
 * Time: 19:56
 */
require_once 'database.php';
require_once 'userFunctions.php';
require_once 'booking.php';

function newBooking($userId, $start, $end, $roomId)
{
    $requestedBooking = strtotime($start);
    $endBooking = strtotime($end);
    $requested = $endBooking - $requestedBooking;
    $now = strtotime('now');
    if ($endBooking <= $requestedBooking) {
        header('Location: newReservation.php?error=endBeforeStart');
        die();
    }

    //Check if user has allowance hours
    if (calculateRemainingSeconds(getUserIdFromSession(), date('Y-m-d', $requestedBooking)) < $requested) {
        header('Location: newReservation.php?error=notEnoughAllowance');
        die();
    }
    //Check if start date is in the future
    if ($requestedBooking < $now) {
        header('Location: newReservation.php?error=startIsInThePast');
        die();
    }
    //Check if end time is over the 9PM
    if (date('H', $endBooking) == '21') {
        if (date('i', $endBooking) != 0) {
            header('Location: newReservation.php?error=endOver');
            die();
        }
    }
    //Check if room is booked in those hours
    $query = "SELECT bookingId from (SELECT * from bookings WHERE roomId= $roomId AND status=1 AND start BETWEEN '$start' and '$end') as alias WHERE start != '$end'";
    $dbConnection = dbConnect();
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        header('Location: newReservation.php?error=alreadyBooked');
        die();
    }
    $query = "SELECT bookingId from (SELECT * from bookings WHERE roomId= $roomId AND status=1 AND end BETWEEN '$start' and '$end') as alias WHERE end != '$start'";
    //echo $query; die();
    $dbConnection = dbConnect();
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        header('Location: newReservation.php?error=alreadyBooked');
        die();
    } else {
        $query = "INSERT INTO bookings  VALUES (NULL, '$roomId', '$userId', '1', '$start', '$end')";
        $rows = $dbConnection->query($query);
        $query = "SELECT bookingId from bookings WHERE userid='$userId' AND roomId = '$roomId' AND start = '$start' AND end = '$end' LIMIT 1";
        echo $query;
        $rows2 = $dbConnection->query($query);
        foreach ($rows2 as $row) {
            return $row['bookingId'];
        }
    }
}


function deleteBooking($bookingId)
{
    if (!checkIfUserCanDelete($bookingId)) {
        return false;
    } else {
        $dbConnection = dbConnect();
        $query = "UPDATE bookings SET status='2' WHERE bookingId='$bookingId'";
        $rows = $dbConnection->query($query);
        return true;
    }
}

function checkIfUserCanDelete($bookingId)
{
    if (isUserAdmin(getUserIdFromSession())) {
        return true;
    }
    $startTime = null;
    $dbConnection = dbConnect();
    $query = "SELECT * from bookings where bookingId='$bookingId' LIMIT 1;";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            $startTime = $row['start'];
        }
    }
    $startTime = strtotime($startTime);
    $minimumDate = strtotime('-2 days', $startTime);
    if ($minimumDate > strtotime('now')) {
        return true;
    }
    return false;
}

function getBookingInfo($bookingId)
{
    $dbConnection = dbConnect();
    $query = "SELECT * FROM bookings WHERE bookingId='$bookingId'";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) return $rows;
    else return null;
}

function getUserBookings($userId, $month)
{
    $startDate = date('Y-m-01 00:00:00');
    //$endDate = date('Y-m-t 23:59:59', strtotime($month));
    $dbConnection = dbConnect();
    $query = "SELECT * FROM bookings where userId='$userId' and start >= '$startDate' and status=1 ORDER BY start";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) return $rows;
    else return null;
}

function calculateBookingCost($userId, $start, $end)
{


    $totalCost = 0.0;
    $pmCost = 0.0;
    $amCost = 0.0;
    $userRateAM = getUserRate($userId);
    $userRatePM = getUserRate($userId);
    $startH = date('H', strtotime($start));
    $startI = date('i', strtotime($start));
    $endH = date('H', strtotime($end));
    $endI = date('i', strtotime($end));
    $minutes = round(abs(strtotime($end) - strtotime($start)) / 60, 2); //THIS RETURNS NUM. OF MINUTES
    //TODO: Generate all cases and calculate prices accordingly. Rates changes at 2PM. Round everything at 30 minutes. (15->30 min, 45-> 1h.)


    $totalCost = $totalCost + $pmCost + $amCost;
    return $totalCost;
}