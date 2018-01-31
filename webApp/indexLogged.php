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
        <div class="col-2">
            <img src="images/salesGIF.gif" alt="Logo dello Studio Sales" width="100%">
        </div>
        <div class="col-10">
            <h1 class="display-4">Sales - Prenotazione Online Studi</h1>
        </div>
    </div>
    <div class="row"><br></div>
    <?php require_once 'includes/menu.php'; ?>
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
            <a href="<?php echo $_SERVER['PHP_SELF'] . '?week=' . ($week - 1) . '&year=' . $year; ?>">
                <button class="btn btn-info">Settimana precedente</button>
            </a>
            <a href="<?php echo $_SERVER['PHP_SELF'] . '?week=' . ($week + 1) . '&year=' . $year; ?>">
                <button class="btn btn-info">Settimana successiva</button>
            </a>
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

            <table class="table table-striped table-bordered  text-center">
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
                        <a href="./newReservation.php?date=<?php echo $dt->format('Y-m-d') ?>">Lunedì <?php echo $dt->format('d-m-Y') ?></a>
                    </td>

                    <?php
                    $startTime = $dt->format('Y-m-d' . " 00:00:00");
                    $endTime = $dt->format('Y-m-d') . " 23:59:59";
                    $query = "SELECT * from bookings where start BETWEEN '$startTime' AND '$endTime' ORDER BY start";
                    $rows = $dbConnection->query($query);
                    foreach ($rows as $row) {
                        echo "<td>";
                        $inizio = date('H:i', (strtotime($row['start'])));
                        $fine = date('H:i', (strtotime($row['end'])));
                        echo getUserCompleteNameFromID($row['userId']) . "  dalle " . $inizio . " alle " . $fine;
                        echo "</td>";
                    }
                    ?>

                </tr>
                <tr>
                    <td>
                        <a href="./newReservation.php?date=<?php $dt->modify('+1 day');
                        echo $dt->format('Y-m-d') ?>">Martedì <?php echo $dt->format('d-m-Y') ?></a>
                    </td>
                    <?php
                    $startTime = $dt->format('Y-m-d' . " 00:00:00");
                    $endTime = $dt->format('Y-m-d') . " 23:59:59";
                    $query = "SELECT * from bookings where start BETWEEN '$startTime' AND '$endTime' ORDER BY start";
                    $rows = $dbConnection->query($query);
                    foreach ($rows as $row) {
                        echo "<td>";
                        $inizio = date('H:i', (strtotime($row['start'])));
                        $fine = date('H:i', (strtotime($row['end'])));
                        echo getUserCompleteNameFromID($row['userId']) . "  dalle " . $inizio . " alle " . $fine;
                        echo "</td>";
                    }
                    ?>
                </tr>
                <tr>
                    <td>
                        <a href="./newReservation.php?date=<?php $dt->modify('+1 day');
                        echo $dt->format('Y-m-d') ?>">Mercoledì <?php echo $dt->format('d-m-Y') ?></a>
                    </td>
                    <?php
                    $startTime = $dt->format('Y-m-d' . " 00:00:00");
                    $endTime = $dt->format('Y-m-d') . " 23:59:59";
                    $query = "SELECT * from bookings where start BETWEEN '$startTime' AND '$endTime' ORDER BY start";
                    $rows = $dbConnection->query($query);
                    foreach ($rows as $row) {
                        echo "<td>";
                        $inizio = date('H:i', (strtotime($row['start'])));
                        $fine = date('H:i', (strtotime($row['end'])));
                        echo getUserCompleteNameFromID($row['userId']) . "  dalle " . $inizio . " alle " . $fine;
                        echo "</td>";
                    }
                    ?>
                </tr>
                <tr>
                    <td>
                        <a href="./newReservation.php?date=<?php $dt->modify('+1 day');
                        echo $dt->format('Y-m-d') ?>">Giovedì <?php echo $dt->format('d-m-Y') ?></a>
                    </td>
                    <?php
                    $startTime = $dt->format('Y-m-d' . " 00:00:00");
                    $endTime = $dt->format('Y-m-d') . " 23:59:59";
                    $query = "SELECT * from bookings where start BETWEEN '$startTime' AND '$endTime' ORDER BY start";
                    $rows = $dbConnection->query($query);
                    foreach ($rows as $row) {
                        echo "<td>";
                        $inizio = date('H:i', (strtotime($row['start'])));
                        $fine = date('H:i', (strtotime($row['end'])));
                        echo getUserCompleteNameFromID($row['userId']) . "  dalle " . $inizio . " alle " . $fine;
                        echo "</td>";
                    }
                    ?>
                </tr>
                <tr>
                    <td>
                        <a href="./newReservation.php?date=<?php $dt->modify('+1 day');
                        echo $dt->format('Y-m-d') ?>">Venerdì <?php echo $dt->format('d-m-Y') ?></a>
                    </td>
                    <?php
                    $startTime = $dt->format('Y-m-d' . " 00:00:00");
                    $endTime = $dt->format('Y-m-d') . " 23:59:59";
                    $query = "SELECT * from bookings where start BETWEEN '$startTime' AND '$endTime' ORDER BY start";
                    $rows = $dbConnection->query($query);
                    foreach ($rows as $row) {
                        echo "<td>";
                        $inizio = date('H:i', (strtotime($row['start'])));
                        $fine = date('H:i', (strtotime($row['end'])));
                        echo getUserCompleteNameFromID($row['userId']) . "  dalle " . $inizio . " alle " . $fine;
                        echo "</td>";
                    }
                    ?>
                </tr>
                <tr>
                    <td>
                        <a href="./newReservation.php?date=<?php $dt->modify('+1 day');
                        echo $dt->format('Y-m-d') ?>">Sabato <?php echo $dt->format('d-m-Y') ?></a>
                    </td>
                    <?php
                    $startTime = $dt->format('Y-m-d' . " 00:00:00");
                    $endTime = $dt->format('Y-m-d') . " 23:59:59";
                    $query = "SELECT * from bookings where start BETWEEN '$startTime' AND '$endTime' ORDER BY start";
                    $rows = $dbConnection->query($query);
                    foreach ($rows as $row) {
                        echo "<td>";
                        $inizio = date('H:i', (strtotime($row['start'])));
                        $fine = date('H:i', (strtotime($row['end'])));
                        echo getUserCompleteNameFromID($row['userId']) . "  dalle " . $inizio . " alle " . $fine;
                        echo "</td>";
                    }
                    ?>
                </tr>
                <tr>
                    <td>
                        <a href="./newReservation.php?date=<?php $dt->modify('+1 day');
                        echo $dt->format('Y-m-d') ?>">Domenica <?php echo $dt->format('d-m-Y') ?></a>
                    </td>
                    <?php
                    $startTime = $dt->format('Y-m-d' . " 00:00:00");
                    $endTime = $dt->format('Y-m-d') . " 23:59:59";
                    $query = "SELECT * from bookings where start BETWEEN '$startTime' AND '$endTime' ORDER BY start";
                    $rows = $dbConnection->query($query);
                    foreach ($rows as $row) {
                        echo "<td>";
                        $inizio = date('H:i', (strtotime($row['start'])));
                        $fine = date('H:i', (strtotime($row['end'])));
                        echo getUserCompleteNameFromID($row['userId']) . "  dalle " . $inizio . " alle " . $fine;
                        echo "</td>";
                    }
                    ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>


</div>
</body>
</html>
