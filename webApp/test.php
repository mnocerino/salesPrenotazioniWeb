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

echo getUserRate(13) . '<br>';
echo getUserRatePM(13);

echo '<br>';
$start = '2018-03-02 13:15:00';
$end = '2018-03-02 14:15:00';
echo $start . '<br>' . $end . '<br>';
echo calculateBookingCost(13, $start, $end);
echo '<br>Fine dello script';