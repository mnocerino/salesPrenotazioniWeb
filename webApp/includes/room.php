<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 05/02/2018
 * Time: 12:58
 */
require_once 'database.php';
require_once 'userMethods.php';
require_once 'configuration.php';

function deactivateRoom($roomId)
{
    $dbConnection = dbConnect();
    $now = date('Y-m-d H:i:00', strtotime('now'));
    $query = "UPDATE bookings SET status='2' WHERE roomId='$roomId' and start >= '$now'";
    $dbConnection->query($query);
    $query = "UPDATE rooms SET isActive='0' WHERE roomId='$roomId'";
    $dbConnection->query($query);
}

function activateRoom($roomId)
{

    $dbConnection = dbConnect();
    $query = "UPDATE rooms SET isActive='1' WHERE roomId='$roomId'";
    $dbConnection->query($query);

}

function editRoom($roomId, $roomName, $roomDescription)
{
    $dbConnection = dbConnect();
    $roomName = filter_var(trim($roomName), FILTER_SANITIZE_STRING);
    $roomDescription = filter_var(trim($roomDescription), FILTER_SANITIZE_STRING);
    $query = "UPDATE rooms SET roomName='$roomName', roomDescription='$roomDescription' WHERE roomId='$roomId'";
    $dbConnection->query($query);

}

function newRoom($roomName, $roomDescription)
{
    $dbConnection = dbConnect();
    $roomName = filter_var(trim($roomName), FILTER_SANITIZE_STRING);
    $roomDescription = filter_var(trim($roomDescription), FILTER_SANITIZE_STRING);
    $query = "INSERT INTO rooms (roomName, roomDescription)VALUES ('$roomName', '$roomDescription')";
    $dbConnection->query($query);
}
