<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino
 * Date: 16/01/2018
 * Time: 13:07
 */
setlocale(LC_TIME, 'it_IT');
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
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-10">
            <h1 class="display-4">Prenotazione sale</h1>
        </div>
    </div>
    <div class="row"><br></div>
    <?php require_once 'includes/menu.php'; ?>
    <div class="row">
        <div class="col-12 text-center">
            <br>
            <h3>Utente: <?php echo getUserCompleteName(getUserIdFromSession()); ?></h3> <br>
            Ore disponibili da contratto: <?php echo getUserAllowance(getUserIdFromSession()); ?><br>
            Costo orario: <?php echo getUserRate(getUserIdFromSession()) . "\xE2\x82\xAc"; ?><br>
            Tempo rimanente per il mese in
            corso: <?php echo getReadableRemainingTime(getUserIdFromSession(), date('Y-m-d', strtotime('now'))); ?>

        </div>
    </div>


</div>
</body>
</html>
