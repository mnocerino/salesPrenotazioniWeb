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

function newBooking($userId, $roomId, $start, $end)
{

}

function deleteBooking($bookingId)
{
    if (!checkIfUserCanDelete($bookingId)) {
        header('Location: error.php?error=cannotDelete');
        die;
    } else {
        $dbConnection = dbConnect();
        $query = "DELETE from bookings WHERE bookingId='$bookingId'";
        $rows = $dbConnection->query($query);
    }
}

//TODO: make checkIfUserCanDelete() actually work!
function checkIfUserCanDelete($bookingId)
{
    if (isUserAdmin(getUserIdFromSession())) {
        return true;
    }
    $dbConnection = dbConnect();
    $query = "SELECT * from bookings WHERE bookingId = '$bookingId' LIMIT 1;";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            if ($row['start'] >= date('Y-m-d H:i:s', time() - 24 * 60 * 60)) {
                return true;
            }
        }
    }
    return false;
}