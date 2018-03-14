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

if (!isset($_POST['userID'])) {
    header('Location: index.php');
    die();
}
$userID = $_POST['userID'];
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
    <br><br><br>
    <div class="row">
        <div class="col-lg-auto text-center mx-auto">
            <h3>Utente: <?php echo getUserCompleteName($userID) ?></h3>
            <table class="table table-striped table-bordered text-center">
                <thead>
                <tr>
                    <td>Mese</td>
                    <td>Numero prenotazioni</td>
                    <td>Ore prenotate</td>
                    <td>Costo totale</td>
                </tr>
                </thead>
                <tbody>
                <?php
                $grandTotal = 0.0;
                $months = array("null", "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");
                for ($month = 1; $month <= 12; $month++) {
                    $monthQuery = date('Y-' . $month . '-01');
                    $userBookings = getUserBookingsOnMonth($userID, $monthQuery);
                    $totalCost = 0.0;
                    $totalBookings = 0;
                    if ($userBookings != null) {
                        foreach ($userBookings as $booking) {
                            $totalCost = (float)$totalCost + (float)$booking['price'];
                            $totalBookings++;
                            $grandTotal = $grandTotal + $totalCost;
                        }
                    }
                    echo "<tr>";
                    echo "<td>" . $months[$month] . "</td>";
                    echo "<td>" . $totalBookings . "</td>";
                    echo "<td>" . getUsedTimes($userID, $monthQuery) . "</td>";
                    echo "<td>" . $totalCost . "</td>";
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