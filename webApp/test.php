<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 14/01/2018
 * Time: 15:53
 */
require_once 'includes/database.php';
require_once 'includes/userMethods.php';
require_once 'includes/booking.php';
session_start();
if (!isUserLoggedIn()) {
    header('Location: index.php');
    die();
}


echo date('Y-m-d H:i:s', strtotime('now +10 days'));
$date = '2018-02-25 12:00:00';
echo "<br>";
$checkDate = strtotime($date);
echo "<br>";
$tenDaysFromNow = strtotime('now +10 days');
echo($checkDate > $tenDaysFromNow);
echo "<br>";
newBooking('1', '2018-02-01 08:00:00', '2018-02-01 09:15:00', '2');
?>
