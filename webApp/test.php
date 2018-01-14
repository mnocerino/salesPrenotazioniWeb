<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 14/01/2018
 * Time: 15:53
 */
$userId = 1;
$now = date('Y-m-d H:i:s', time());
$query = "UPDATE users SET lastLogin = '$now' WHERE userId='$userId'";
echo $query;