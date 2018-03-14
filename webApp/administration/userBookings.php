<?php
/**
 * Created by PhpStorm.
 * User: Mattia
 * Date: 14/03/2018
 * Time: 08:52
 */

setlocale(LC_TIME, 'it_IT');
require_once '../includes/database.php';
require_once '../includes/userFunctions.php';
require_once '../includes/booking.php';
require_once '../includes/rooms.php';

session_start();
if (!isUserLoggedIn()) {
    header('Location: ../index.php');
    die();
}
if (!isUserAdmin(getUserIdFromSession())) {
    header('Location: ../index.php');
    die();
}
$userIsSet = false;
$activeUsers = getActiveUsers();
$deactivatedUsers = getDeactivatedUsers();
if (isset($_POST['userID']) && $_POST['userID'] != '') {
    $userIsSet = true;
    $userID = $_POST['userID'];
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
            <h1 class="display-4">Amministrazione utenti</h1>
        </div>
    </div>
    <div class="row"><br></div>
    <?php require_once '../includes/adminMenu.php'; ?>
    <br>
    <?php
    if ($userIsSet) : ?>
        <div class="row">
            <div class="col-lg-auto text-center mx-auto">
                <table class="table table-striped table-bordered text-center">
                    <h3>Prenotazioni di: <?php echo getUserCompleteName($userID) ?></h3>
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Data</td>
                        <td>Inizio</td>
                        <td>Fine</td>
                        <td>Sala</td>
                        <td>Costo</td>
                        <td>Azioni</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    //TODO: make a search year-based
                    $userBookings = getAllUserBookings($userID);
                    if ($userBookings != null) {
                        foreach ($userBookings as $booking) {
                            $start = strtotime($booking['start']);
                            $startDay = date('Y-m-d', $start);
                            $startTime = date('H:i', $start);
                            $end = strtotime($booking['end']);
                            $endTime = date('H:i', $end);
                            $roomName = getRoomName($booking['roomId']);
                            echo "<tr>";
                            echo "<td>" . $booking['bookingId'] . "</td>";
                            echo "<td>" . $startDay . "</td>";
                            echo "<td>" . $startTime . "</td>";
                            echo "<td>" . $endTime . "</td>";
                            echo "<td>" . $roomName . "</td>";
                            echo "<td>" . $booking['price'] . "</td>";
                            echo "<td>";
                            echo "<form action='changePrice.php' method='post'><input type='number' hidden value='" . $booking['bookingId'] . "'name='booking'><button action='submit'>Cambia prezzo</button></form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-auto text-center mx-auto">
                <a href="downloadCSV.php">
                    <button class="btn btn-info">Scarica tutte le prenotazioni</button>
                </a><br><br><br>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-auto text-center mx-auto">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Cognome</td>
                        <td>Nome</td>
                        <td>Azione</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    //TODO: download a csv file with all bookings
                    foreach ($activeUsers as $user) {
                        echo "<tr>";
                        echo "<td>" . $user['userId'] . "</td>";
                        echo "<td>" . $user['surname'] . "</td>";
                        echo "<td>" . $user['name'] . "</td>";
                        echo "<td>";
                        echo "<form action='userBookings.php' method='post'><input type='number' hidden value='" . $user['userId'] . "' name='userID'><button action='submit'>Visualizza</button></form>";
                        echo "<form action='userBilling.php' method='post'><input type='number' hidden value='" . $user['userId'] . "' name='userID'><button action='submit'>Resoconto</button></form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>