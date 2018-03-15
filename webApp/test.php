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
$month = "2019-12-12 00:00:00";
$endDate = date('Y-m-t 00:00:00', strtotime($month));
echo $endDate;
echo "<br>";
echo calculateUsedHours(25, $month);