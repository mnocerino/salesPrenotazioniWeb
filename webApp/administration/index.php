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
<head>
    <!--
    Mattia Nocerino - 818089
    Progetto: realizzazione di un sistema web per la gestione della prenotazioni di sale e uffici in uno studio associato di psicologia.
    Pagina principale di amministrazione. Permette di visionare tutte le prenotazioni e di crearne delle nuove.
    -->

    <title>Prenotazione studi Sales</title>
    <?php
    require_once '../includes/includes.php';
    ?>

    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-10">
            <h1 class="display-4">Amministrazione prenotazioni</h1>
        </div>
    </div>
    <div class="row"><br></div>
    <?php require_once '../includes/adminMenu.php'; ?>
    <div class="row"><br></div>
    <div class="row ">
        <div class="col-3">

        </div>
        <div class="col-6 text-center">
            <?php
            $dt = new DateTime;
            if (isset($_GET['year']) && isset($_GET['week'])) {
                $dt->setISODate($_GET['year'], $_GET['week']);
            } else {
                $dt->setISODate($dt->format('o'), $dt->format('W'));
            }
            $year = $dt->format('o');
            $week = $dt->format('W');
            ?>
            <a href="<?php echo $_SERVER['PHP_SELF'] . '?week=' . ($week - 1) . '&year=' . $year; ?>"
               class="btn btn-info" role="button">Settimana precedente</a>
            <a href="<?php echo $_SERVER['PHP_SELF'] . '?week=' . ($week + 1) . '&year=' . $year; ?>"
               class="btn btn-info" role="button">Settimana successiva</a>
        </div>
        <div class="col-3">

        </div>
    </div>
    <div class="row"><br></div>
    <div class="row">
        <div class="col-12">
            <?php
            $dt = new DateTime;
            if (isset($_GET['year']) && isset($_GET['week'])) {
                $dt->setISODate($_GET['year'], $_GET['week']);
            } else {
                $dt->setISODate($dt->format('o'), $dt->format('W'));
            }
            $year = $dt->format('o');
            $week = $dt->format('W');
            ?>

            <table class="table table-striped table-bordered text-center">
                <thead>
                <tr>
                    <td>
                        Giorno
                    </td>
                    <td>
                        Prenotazioni
                    </td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <a href="./newReservation.php?date=<?php echo $dt->format('Y-m-d') ?>">Lunedì<br> <?php echo $dt->format('d-m-Y') ?>
                        </a>
                    </td>
                    <?php
                    foreach ($rooms as $room) {
                        $roomId = $room['roomId'];
                        $roomName = $room['roomName'];
                        echo "<tr><td class='text-right'>$roomName</td>";
                        $startTime = $dt->format('Y-m-d' . " 00:00:00");
                        $endTime = $dt->format('Y-m-d') . " 23:59:59";
                        $query = "SELECT * from bookings where start BETWEEN '$startTime' AND '$endTime' and roomId='$roomId' AND status=1 ORDER BY start";
                        $rows = $dbConnection->query($query);
                        foreach ($rows as $row) {
                            echo "<td>";
                            $inizio = date('H:i', (strtotime($row['start'])));
                            $fine = date('H:i', (strtotime($row['end'])));
                            echo getUserCompleteName($row['userId']) . "  dalle " . $inizio . " alle " . $fine;
                            $deleteAddress = "deleteReservation.php?bookingId=" . $row['bookingId'];
                            echo "<br><a href=\"" . $deleteAddress . "\" class='btn btn-danger' role='button'>Elimina</a>";
                            echo "</td>";
                        }
                    } ?>
                </tr>
                <tr>
                    <td>
                        <a href="./newReservation.php?date=<?php $dt->modify('+1 day');
                        echo $dt->format('Y-m-d') ?>">Martedì<br> <?php echo $dt->format('d-m-Y') ?></a>
                    </td>
                    <?php
                    $rooms = showRooms();
                    foreach ($rooms as $room) {
                        $roomId = $room['roomId'];
                        $roomName = $room['roomName'];
                        echo "<tr><td class='text-right'>$roomName</td>";
                        $startTime = $dt->format('Y-m-d' . " 00:00:00");
                        $endTime = $dt->format('Y-m-d') . " 23:59:59";
                        $query = "SELECT * from bookings where start BETWEEN '$startTime' AND '$endTime' and roomId='$roomId' AND status=1 ORDER BY start";
                        $rows = $dbConnection->query($query);
                        foreach ($rows as $row) {
                            echo "<td>";
                            $inizio = date('H:i', (strtotime($row['start'])));
                            $fine = date('H:i', (strtotime($row['end'])));
                            echo getUserCompleteName($row['userId']) . "  dalle " . $inizio . " alle " . $fine;
                            $deleteAddress = "deleteReservation.php?bookingId=" . $row['bookingId'];
                            echo "<br><a href=\"" . $deleteAddress . "\" class='btn btn-danger' role='button'>Elimina</a>";
                            echo "</td>";
                        }
                    } ?>

                </tr>
                <tr>
                    <td>
                        <a href="./newReservation.php?date=<?php $dt->modify('+1 day');
                        echo $dt->format('Y-m-d') ?>">Mercoledì<br> <?php echo $dt->format('d-m-Y') ?></a>
                    </td>
                    <?php
                    $rooms = showRooms();
                    foreach ($rooms as $room) {
                        $roomId = $room['roomId'];
                        $roomName = $room['roomName'];
                        echo "<tr><td class='text-right'>$roomName</td>";
                        $startTime = $dt->format('Y-m-d' . " 00:00:00");
                        $endTime = $dt->format('Y-m-d') . " 23:59:59";
                        $query = "SELECT * from bookings where start BETWEEN '$startTime' AND '$endTime' and roomId='$roomId' AND status=1 ORDER BY start";
                        $rows = $dbConnection->query($query);
                        foreach ($rows as $row) {
                            echo "<td>";
                            $inizio = date('H:i', (strtotime($row['start'])));
                            $fine = date('H:i', (strtotime($row['end'])));
                            echo getUserCompleteName($row['userId']) . "  dalle " . $inizio . " alle " . $fine;
                            $deleteAddress = "deleteReservation.php?bookingId=" . $row['bookingId'];
                            echo "<br><a href=\"" . $deleteAddress . "\" class='btn btn-danger' role='button'>Elimina</a>";
                            echo "</td>";
                        }

                    } ?>
                </tr>
                <tr>
                    <td>
                        <a href="./newReservation.php?date=<?php $dt->modify('+1 day');
                        echo $dt->format('Y-m-d') ?>">Giovedì<br> <?php echo $dt->format('d-m-Y') ?></a>
                    </td>
                    <?php
                    $rooms = showRooms();
                    foreach ($rooms as $room) {
                        $roomId = $room['roomId'];
                        $roomName = $room['roomName'];
                        echo "<tr><td class='text-right'>$roomName</td>";
                        $startTime = $dt->format('Y-m-d' . " 00:00:00");
                        $endTime = $dt->format('Y-m-d') . " 23:59:59";
                        $query = "SELECT * from bookings where start BETWEEN '$startTime' AND '$endTime' and roomId='$roomId' AND status=1 ORDER BY start";
                        $rows = $dbConnection->query($query);
                        foreach ($rows as $row) {
                            echo "<td>";
                            $inizio = date('H:i', (strtotime($row['start'])));
                            $fine = date('H:i', (strtotime($row['end'])));
                            echo getUserCompleteName($row['userId']) . "  dalle " . $inizio . " alle " . $fine;
                            $deleteAddress = "deleteReservation.php?bookingId=" . $row['bookingId'];
                            echo "<br><a href=\"" . $deleteAddress . "\" class='btn btn-danger' role='button'>Elimina</a>";
                            echo "</td>";
                        }
                    } ?>
                </tr>
                <tr>
                    <td>
                        <a href="./newReservation.php?date=<?php $dt->modify('+1 day');
                        echo $dt->format('Y-m-d') ?>">Venerdì <br><?php echo $dt->format('d-m-Y') ?></a>
                    </td>
                    <?php
                    $rooms = showRooms();
                    foreach ($rooms as $room) {
                        $roomId = $room['roomId'];
                        $roomName = $room['roomName'];
                        echo "<tr><td class='text-right'>$roomName</td>";
                        $startTime = $dt->format('Y-m-d' . " 00:00:00");
                        $endTime = $dt->format('Y-m-d') . " 23:59:59";
                        $query = "SELECT * from bookings where start BETWEEN '$startTime' AND '$endTime' and roomId='$roomId' AND status=1  ORDER BY start";
                        $rows = $dbConnection->query($query);
                        foreach ($rows as $row) {
                            echo "<td>";
                            $inizio = date('H:i', (strtotime($row['start'])));
                            $fine = date('H:i', (strtotime($row['end'])));
                            echo getUserCompleteName($row['userId']) . "  dalle " . $inizio . " alle " . $fine;
                            $deleteAddress = "deleteReservation.php?bookingId=" . $row['bookingId'];
                            echo "<br><a href=\"" . $deleteAddress . "\" class='btn btn-danger' role='button'>Elimina</a>";
                            echo "</td>";
                        }
                    } ?>
                </tr>
                <tr>
                    <td>
                        <a href="./newReservation.php?date=<?php $dt->modify('+1 day');
                        echo $dt->format('Y-m-d') ?>">Sabato <br><?php echo $dt->format('d-m-Y') ?></a>
                    </td>
                    <?php
                    $rooms = showRooms();
                    foreach ($rooms as $room) {
                        $roomId = $room['roomId'];
                        $roomName = $room['roomName'];
                        echo "<tr><td class='text-right'>$roomName</td>";
                        $startTime = $dt->format('Y-m-d' . " 00:00:00");
                        $endTime = $dt->format('Y-m-d') . " 23:59:59";
                        $query = "SELECT * from bookings where start BETWEEN '$startTime' AND '$endTime' and roomId='$roomId' AND status=1 ORDER BY start";
                        $rows = $dbConnection->query($query);
                        foreach ($rows as $row) {
                            echo "<td>";
                            $inizio = date('H:i', (strtotime($row['start'])));
                            $fine = date('H:i', (strtotime($row['end'])));
                            echo getUserCompleteName($row['userId']) . "  dalle " . $inizio . " alle " . $fine;
                            $deleteAddress = "deleteReservation.php?bookingId=" . $row['bookingId'];
                            echo "<br><a href=\"" . $deleteAddress . "\" class='btn btn-danger' role='button'>Elimina</a>";
                            echo "</td>";
                        }

                    } ?>
                </tr>
                <tr>
                    <td>
                        <a href="./newReservation.php?date=<?php $dt->modify('+1 day');
                        echo $dt->format('Y-m-d') ?>">Domenica <br><?php echo $dt->format('d-m-Y') ?></a>
                    </td>
                    <?php
                    $rooms = showRooms();
                    foreach ($rooms as $room) {
                        $roomId = $room['roomId'];
                        $roomName = $room['roomName'];
                        echo "<tr><td class='text-right'>$roomName</td>";
                        $startTime = $dt->format('Y-m-d' . " 00:00:00");
                        $endTime = $dt->format('Y-m-d') . " 23:59:59";
                        $query = "SELECT * from bookings where start BETWEEN '$startTime' AND '$endTime' and roomId='$roomId' AND status=1  ORDER BY start";
                        $rows = $dbConnection->query($query);
                        foreach ($rows as $row) {
                            echo "<td>";
                            $inizio = date('H:i', (strtotime($row['start'])));
                            $fine = date('H:i', (strtotime($row['end'])));
                            echo getUserCompleteName($row['userId']) . "  dalle " . $inizio . " alle " . $fine;
                            $deleteAddress = "deleteReservation.php?bookingId=" . $row['bookingId'];
                            echo "<br><a href=\"" . $deleteAddress . "\" class='btn btn-danger' role='button'>Elimina</a>";
                            echo "</td>";
                        }
                    } ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
