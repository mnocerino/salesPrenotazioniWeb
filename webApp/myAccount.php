<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino
 * Date: 16/01/2018
 * Time: 13:07
 */
setlocale(LC_TIME, 'it_IT');
require_once 'includes/database.php';
require_once 'includes/userFunctions.php';
require_once 'includes/booking.php';
require_once 'includes/rooms.php';
session_start();
if (!isUserLoggedIn()) {
    header('Location: index.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="it">
<meta charset="UTF-8">
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
            <?php
            $userRateAM = getUserRate(getUserIdFromSession());
            $userRatePM = getUserRatePM(getUserIdFromSession());
            if ($userRateAM == $userRatePM) : ?>
                Costo orario: <?php echo $userRateAM . "\xE2\x82\xAc"; ?><br>
            <?php else: ?>
                Costo orario dalle 8 alle 14: <?php echo $userRateAM . " \xE2\x82\xAc" ?>. <br>
                Costo orario dalle 14 alle 21: <?php echo $userRatePM . " \xE2\x82\xAc"; endif; ?><br>
            <?php
            $remainingSeconds = calculateRemainingSeconds(getUserIdFromSession(), date('Y-m-d', strtotime('now')));
            if ($remainingSeconds < 0): ?>
                <?php
                echo "Hai utilizzato: " . secToHR(abs($remainingSeconds)) . " in più rispetto al tuo monte ore.";
                ?>
            <?
            else:
                ?>
                Tempo rimanente per il mese in
                corso: <?php echo getReadableRemainingTime(getUserIdFromSession(), date('Y-m-d', strtotime('now')));

            endif;
            ?>
            <br>
            <a href="changePassword.php" class="btn btn-primary" role="button">Cambia la tua password</a>
        </div>
    </div>


</div>
</body>
</html>
