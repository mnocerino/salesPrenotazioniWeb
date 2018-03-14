<?php
/**
 * Created by PhpStorm.
 * User: Mattia
 * Date: 12/03/2018
 * Time: 09:42
 */

require_once 'includes/database.php';
require_once 'includes/userFunctions.php';
require_once 'includes/booking.php';

$bookings = getUserBookingsOnMonth(13, "2018-03-23");
foreach ($bookings as $booking) {
    echo "ciao<br>";
}
echo '<br>Fine dello script';