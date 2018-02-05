<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 14/01/2018
 * Time: 14:26
 */
require_once 'includes/database.php';
require_once 'includes/userFunctions.php';
session_start();
$sessionId = session_id();
$dbConnection = dbConnect();
$query = "DELETE FROM sessions WHERE sessionId='$sessionId'";
$dbConnection->query($query);

session_unset();
session_destroy();
header('Location: index.php');

