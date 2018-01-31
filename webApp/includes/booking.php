<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 14/01/2018
 * Time: 19:56
 */
require_once 'database.php';
require_once 'userMethods.php';
require_once 'configuration.php';

function newBooking($userId, $start, $end, $roomId)
{
    $maximumBookingDate = strtotime('now +10 days');
    $requestedBooking = strtotime($start);
    $endBooking = strtotime($end);
    if ($endBooking <= $requestedBooking) {
        header('Location: newBooking.php?error=endBeforeStart');
        die();
    }
    if ($requestedBooking > $requestedBooking) {
        header('Location: newBooking.php?error=moreThan10Days');
        die();
    }
    //Check if room is booked in those hours
    $query = "SELECT * from bookings WHERE roomId= $roomId AND start BETWEEN '$start' and '$end' AND end BETWEEN '$start' and '$end'";
    $dbConnection = dbConnect();
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        header('Location: newBooking.php?error=alreadyBooked');
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
        //header('Location: error.php?error=cannotDelete');
        echo "non puoi cancellare";
        die;
    } else {
        $dbConnection = dbConnect();
        $query = "UPDATE bookings SET status='2' WHERE bookingId='$bookingId'";
        $rows = $dbConnection->query($query);
    }
}

//TODO: make this function actually work, dumbass.
function checkIfUserCanDelete($bookingId)
{
    if (isUserAdmin(getUserIdFromSession())) {
        return true;
    }
    $startTime = null;
    $dbConnection = dbConnect();
    $query = "SELECT start from bookings where bookindId='$bookingId' LIMIT 1;";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            $startTime = $row['start'];
        }
    }
    $query = "SELECT * from bookings WHERE bookingId = '$bookingId' LIMIT 1;";
    $rows2 = $dbConnection->query($query);
    if ($rows2->rowCount() > 0) {
        echo "sono entrato nel ciclo";
        foreach ($rows as $row) {
            echo "Data massima per cancellazione: " . (strtotime($startTime)) . " - maggiore di ora: " . strtotime($startTime);
            echo "Data massima per cancellazione: " . date('Y-m-d H:i:s', (strtotime($minimumDate))) . " - maggiore di ora: " . date('Y-m-d H:i:s', (strtotime($startTime)));
            if (strtotime($minimumDate) > strtotime('now')) {
                return true;
            }
        }
    }
    return false;
}


