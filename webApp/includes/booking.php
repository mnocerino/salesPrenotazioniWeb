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

function newBooking($userId, $start, $end, $roomId, $price)
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
    if (!isUserAdmin(getUserIdFromSession())) {

        if (calculateRemainingSeconds(getUserIdFromSession(), date('Y-m-d', $requestedBooking)) < $requested) {
            header('Location: newReservation.php?error=notEnoughAllowance');
            die();
        }
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
        $nowQuery = date('Y-m-d H:i:s');
        $query = "INSERT INTO bookings  VALUES (NULL, '$roomId', '$userId', '1', '$start', '$end','$price', '$nowQuery')";
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

function changePrice($bookingId, $newPrice)
{
    $dbConnection = dbConnect();
    $query = "UPDATE bookings SET price='$newPrice' WHERE bookingId='$bookingId'";
    $rows = $dbConnection->query($query);
    return true;
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

function getUserBookings($userId)
{
    //$startDate= "2018-01-01 00:00:00";
    $startDate = date('Y-m-01 00:00:00');
    //$endDate = date('Y-m-t 23:59:59', strtotime($month));
    $dbConnection = dbConnect();
    $query = "SELECT * FROM bookings where userId='$userId' and start >= '$startDate' and status=1 ORDER BY start";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) return $rows;
    else return null;
}

function getAllUserBookings($userId)
{
    $startDate = "2018-01-01 00:00:00";
    $startDate = date('Y-01-01 00:00:00');
    //$startDate = date('Y-m-01 00:00:00');
    //$endDate = date('Y-m-t 23:59:59', strtotime($month));
    $dbConnection = dbConnect();
    $query = "SELECT * FROM bookings where userId='$userId' and start >= '$startDate' and status=1 ORDER BY start";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) return $rows;
    else return null;
}

function getUserBookingsOnMonth($userId, $month)
{
    $startDate = date('Y-m-01 00:00:00', strtotime($month));
    $endDate = date('Y-m-t 23:59:59', strtotime($month));
    $dbConnection = dbConnect();
    $query = "SELECT * FROM bookings where userId='$userId' and start >= '$startDate' and end<='$endDate' and status=1 ORDER BY start";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) return $rows;
    else return null;
}

function calculateBookingCost($userId, $start, $end)
{
    $totalCost = 0.0;
    $pmCost = floatval(0);
    $amCost = floatval(0);
    $today = date('Y-m-d', strtotime($start));
    $timeat14 = $today . ' 14:00:00';
    $userRateAM = getUserRate($userId);
    $userRatePM = getUserRatePM($userId);
    $startH = date('H', strtotime($start));
    $endH = date('H', strtotime($end));
    $addPM = false;
    $addAM = false;
    if ($endH >= 14 && $start < $timeat14) {
        $amMinutes = round(abs(strtotime($timeat14) - strtotime($start)) / 60 / 60, 2);
        $whole = floor($amMinutes);
        $decimals = $amMinutes - $whole;
        if ($decimals == 0.25 || $decimals == 0.75) {
            $addAM = true;
            //$amMinutes=$amMinutes+0.25;
        }
        $amCost = floatval($amMinutes) * floatval($userRateAM);
        $pmMinutes = round(abs(strtotime($end) - strtotime($timeat14)) / 60 / 60, 2);
        $whole = floor($pmMinutes);
        $decimals = $pmMinutes - $whole;
        if ($decimals == 0.25 || $decimals == 0.75) {
            $addPM = true;
            //$pmMinutes=$pmMinutes+0.25;
        }
        $pmCost = floatval($pmMinutes) * floatval($userRatePM);

        if ($addPM && !$addAM) {
            $pmCost = $pmCost + 0.25 * $userRatePM;
        } else if (!$addPM && $addAM) {
            $amCost = $amCost + 0.25 * $userRateAM;
        }
    } else if ($start < $timeat14 && $end < $timeat14) {
        $amMinutes = round(abs(strtotime($end) - strtotime($start)) / 60 / 60, 2);
        $whole = floor($amMinutes);
        $decimals = $amMinutes - $whole;
        echo 'Minuti: ' . $amMinutes . '<br>';
        echo 'Decimali: ' . $decimals . '<br>';
        if ($decimals == 0.25 || $decimals == 0.75) {
            $amMinutes = $amMinutes + 0.25;
            echo 'Minuti: ' . $amMinutes . '<br>';
        }
        $amCost = floatval($amMinutes) * floatval($userRateAM);
    } else if ($startH >= 14 && $endH >= 14) {
        $pmMinutes = round(abs(strtotime($end) - strtotime($start)) / 60 / 60, 2);
        $whole = floor($pmMinutes);
        $decimals = $pmMinutes - $whole;
        if ($decimals == 0.25 || $decimals == 0.75) {
            $pmMinutes = $pmMinutes + 0.25;
        }
        $pmCost = floatval($pmMinutes) * floatval($userRatePM);
    }
    $totalCost = $totalCost + $pmCost + $amCost;
    return $totalCost;
}

function getCSV()
{
    $dbConnection = dbConnect();
    $query = "SELECT bookingId,name,surname,start,end,price,roomName from bookings INNER JOIN users USING(userId) INNER JOIN rooms USING (roomId)";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        $fp = fopen('php://output', 'w');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="sales.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $csvHeader = array('id', 'nome', 'cognome', 'inizio', 'fine', 'prezzo', 'sala');
        fputcsv($fp, $csvHeader, ";", '"');
        while ($row = $rows->fetch(PDO::FETCH_NUM)) {
            fputcsv($fp, $row, ";", '"'); // push the rest
        }
    } else return null;

}