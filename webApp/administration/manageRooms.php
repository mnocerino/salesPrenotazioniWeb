<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino
 * Date: 16/01/2018
 * Time: 13:07
 */
setlocale(LC_TIME, 'it_IT');
require_once '../includes/database.php';
require_once '../includes/userFunctions.php';
require_once '../includes/booking.php';
require_once '../includes/rooms.php';
$rooms = showRooms();
$deactivatedRooms = showDeactivatedRooms();
session_start();
if (!isUserLoggedIn()) {
    header('Location: ../index.php');
    die();
}
if (!isUserAdmin(getUserIdFromSession())) {
    header('Location: ../index.php');
    die();
}

?>

<!DOCTYPE html>
<html lang="it">
<meta charset="UTF-8">
<head>
    <title>Prenotazione studi Sales</title>
    <?php
    require_once '../includes/includes.php';
    ?>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="display-4">Amministrazione stanze</h1>
        </div>
    </div>
    <div class="row"><br></div>
    <?php require_once '../includes/adminMenu.php'; ?>
    <div class="row">
        <div class="col-lg-auto text-center mx-auto">
            <br>
            <a href="roomManagement/newRoom.php" class="btn btn-primary" role="button">Crea nuova stanza</a>
            <p>Nota bene: la disattivazione della sala comporta anche la cancellazione di tutte le prenotazioni
                effettuate con inizio successivo al momento della disattivazione.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-auto text-center mx-auto">
            <br>
            <h3>Stanze attive</h3>

            <table class="table table-striped table-bordered text-center">
                <thead>
                <tr>
                    <td>Codice stanza</td>
                    <td>Nome stanza</td>
                    <td>Descrizione stanza</td>
                    <td>Operazioni</td>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($rooms as $room) {
                    echo "<tr>";
                    echo "<td>" . $room['roomId'] . "</td><td>" . $room['roomName'] . "</td><td>" . $room['roomDescription'] . "</td>";
                    echo "<td><a href=\"roomManagement/deactivateRoom.php?roomId=" . $room['roomId'] . "\" class=\"btn btn-danger\" role=\"button\">Disattiva</a> ";
                    echo "<a href=\"roomManagement/editRoom.php?roomId=" . $room['roomId'] . "\" class=\"btn btn-warning\" role=\"button\">Modifica</a></td> ";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-auto text-center mx-auto">
            <h3>Stanze non attive</h3>
            <table class="table table-striped table-bordered text-center">
                <thead>
                <tr>
                    <td>Codice stanza</td>
                    <td>Nome stanza</td>
                    <td>Descrizione stanza</td>
                    <td>Operazioni</td>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($deactivatedRooms as $room) {
                    echo "<tr>";
                    echo "<td>" . $room['roomId'] . "</td><td>" . $room['roomName'] . "</td><td>" . $room['roomDescription'] . "</td>";
                    echo "<td><a href=\"roomManagement/activateRoom.php?roomId=" . $room['roomId'] . "\" class=\"btn btn-danger\" role=\"button\">Attiva</a> ";
                    echo "<a href=\"roomManagement/editRoom.php?roomId=" . $room['roomId'] . "\" class=\"btn btn-warning\" role=\"button\">Modifica</a> </td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
