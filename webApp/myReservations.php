<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 14/01/2018
 * Time: 10:53
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
if (isset($_GET['bookingId'])) {
    $booking = filter_var(trim($_GET['bookingId']), FILTER_SANITIZE_NUMBER_INT);
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


    <?php if (isset($_GET['bookingId']) && getBookingInfo($booking) != null) : ?>
        <div class="row">
            <div class="col-12 text-center">
                <br><br><h4>Prenotazione effettuata</h4>
                <p>
                    La prenotazione con identificativo <?php echo $booking ?> è stata effettuata correttamente.<br>
                    <?php
                    $rows = getBookingInfo($booking);
                    foreach ($rows as $row) {
                        echo "Prenotazione per il giorno: " . date('d-m-Y', strtotime($row['start'])) . "<br>";
                        echo "Dalle ore: " . date('H:i', strtotime($row['start'])) . " alle ore: " . date('H:i', strtotime($row['end'])) . "<br>";
                        echo "Sala: " . getRoomName($row['roomId']);
                    };
                    ?>
                </p>
            </div>
        </div>

    <?php else: ?>
        <div class="row">
            <div class="col-12 text-center">
                <br>
                <h4>Prenotazioni effettuate</h4>
                <?php
                $rows = getUserBookings(getUserIdFromSession(), date('Y-m-d', strtotime('now')));
                if ($rows != null) {
                    echo "<table class=\"table table-striped table-bordered  text-center\">";
                    echo "<thead><tr><td>Prenotazione</td><td>Giorno</td><td>Inizio</td><td>Fine</td><td>Sala</td></tr></thead>";
                    foreach ($rows as $row) {
                        echo "<tr><td>" . $row['bookingId'];
                        if (checkIfUserCanDelete($row['bookingId'])) {
                            $deleteAddress = "deleteReservation.php?bookingId=" . $row['bookingId'];
                            echo "<br><a href=\"" . $deleteAddress . "\" class='btn btn-danger' role='button'>Elimina</a>";

                        }
                        echo "</td>";
                        echo "<td>" . date('d-m-Y', strtotime($row['start'])) . "</td>";
                        echo "<td>" . date('H:i', strtotime($row['start'])) . "</td>";
                        echo "<td>" . date('H:i', strtotime($row['end'])) . "</td>";
                        echo "<td>" . getRoomName($row['roomId']) . "</td></tr>";
                    }
                    echo "</table>";
                }
                ?>
            </div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>