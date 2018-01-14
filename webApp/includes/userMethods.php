<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 14/01/2018
 * Time: 10:54
 */


function isUserLoggedIn()
{
    try {
        $dbConnection = new PDO('mysql:dbname=salesPrenotazioni;host=localhost', "root", "", array(PDO::ATTR_PERSISTENT => true));

    } catch (PDOException $e) {
        print "Errore!: " . $e->getMessage() . "<br/>";
        die();
    }
    $sessionId = session_id();
    $query = "SELECT * from sessions WHERE sessionId = '$sessionId' LIMIT 1;";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            return true;
        }
    } else return false;

}




//TODO: create other functions to use, let them return true or false values instead of printing something.
//TODO: complete the isUserLoggedIn() function to return if the user is currently logged in.
//TODO: create a function to return the userId from the session table and use it to manage permissions while booking rooms
