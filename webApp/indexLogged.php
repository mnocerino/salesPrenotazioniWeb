<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino
 * Date: 16/01/2018
 * Time: 13:07
 */
require_once 'includes/database.php';
require_once 'includes/userMethods.php';
require_once 'includes/booking.php';
session_start();
if (!isUserLoggedIn()) {
    header('Location: index.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Prenotazione studi Sales</title>
    <?php
    require_once 'includes/includes.php';
    ?>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-2">
            <img src="images/salesGIF.gif" alt="Logo dello Studio Sales" width="100%">
        </div>
        <div class="col-10">
            <h1>Sales - Prenotazione Online Studi</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="myReservations.php">
                <button class="btn btn-primary">Le mie prenotazioni</button>
            </a>
            <a href="newReservation.php">
                <button class="btn btn-primary">Nuova prenotazione</button>
            </a>
            <a href="myStatus.php">
                <button class="btn btn-primary">Resoconto</button>
            </a>
            <a href="myAccount.php">
                <button class="btn btn-primary">Il mio account</button>
            </a>
            <a href="helpdesk.php">
                <button class="btn btn-info">Help-Desk</button>
            </a>
            <a href="administration/index.php">
                <button class="btn btn-warning">Amministrazione</button>
            </a>
            <a href="logout.php">
                <button class="btn btn-danger">Esci</button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p>

            </p>
        </div>
    </div>


</div>
</body>
</html>
