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

$now = date('Y-m-d H:i:00', strtotime('now'));
echo $now;