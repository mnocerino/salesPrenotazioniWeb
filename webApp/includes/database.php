<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 12/01/2018
 * Time: 18:58
 */
try {
    $dbConnection = new PDO('mysql:dbname=salesPrenotazioni;host=localhost', "root", "", array(PDO::ATTR_PERSISTENT => true));

} catch (PDOException $e) {
    print "Errore!: " . $e->getMessage() . "<br/>";
    die();
}


function dbConnect()
{
    try {
        $dbConnection = new PDO('mysql:dbname=salesPrenotazioni;host=localhost', "root", "", array(PDO::ATTR_PERSISTENT => true));

    } catch (PDOException $e) {
        print "Errore!: " . $e->getMessage() . "<br/>";
        die();
    }
    return $dbConnection;
}