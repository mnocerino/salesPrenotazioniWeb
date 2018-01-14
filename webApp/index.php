<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino
 * Date: 12/01/2018
 * Time: 18:48
 */
require_once 'includes/database.php';
require_once 'includes/userMethods.php';
session_start();

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
        <div class="col-12">
            <h1>Sales - Prenotazione Online Studi</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p>Area riservata ai professionisti collaboratori dello studio</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php
            if (!isUserLoggedIn()) :?>
                <a href="login.php">
                    <button class="btn btn-info">Login richiesto</button>
                </a>
            <?php
            endif;
            ?>
        </div>
    </div>
</div>
</body>
</html>
