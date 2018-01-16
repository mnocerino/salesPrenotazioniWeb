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
    $dbConnection = dbConnect();
    $query = "SELECT * from bookings where bookingId='$bookingId' LIMIT 1";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            //TODO: Check if start date is less than 48 hours before now() in order to check if the user has rights to delete the booking or not.
        }
    }
}

function deleteBookingAsAdmin($bookingId)
{
    $dbConnection = dbConnect();
    if (checkifUserIsAdmin(getUserIdFromSession())) {
        $query = "DELETE from bookings where bookingId='$bookingId'";
        $rows = $dbConnection->query($query);
    }

}
function checkIfUserCanDelete($bookingId)
{
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

function getMondayOfWeek()
{
    return date('d-m-Y', strtotime('monday this week'));
}

function getSundayOfWeek()
{
    date('d-m-Y', strtotime('sunday this week'));
}

function getPreviousWeek($selectedMonday)
{
    return date('d-m-Y', strtotime("-7 days", strtotime("monday week", strtotime($selectedMonday))));
    //TODO: THIS IS NOT WORKING.

}