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