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
            <h3 class="display-4">Nuova prenotazione</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">
            <?php
            if (isset($_GET['error']) && $_GET['error'] == "endBeforeStart"):
                ?>
                <div class="alert alert-danger" role="alert">
                    Hai selezionato un orario di fine precedente a quello di inizio.
                </div>
            <?php
            elseif (isset($_GET['error']) && $_GET['error'] == "notEnoughAllowance"):
                ?>
                <div class="alert alert-danger" role="alert">
                    Non hai abbastanza ore disponibili per coprire tutta la prenotazione. Avvisa l'amministrazione.
                </div>
            <?php
            elseif (isset($_GET['error']) && $_GET['error'] == "startIsInThePast"):
                ?>
                <div class="alert alert-danger" role="alert">
                    Non puoi prenotare una data e ora nel passato.
                </div>
            <?php
            elseif (isset($_GET['error']) && $_GET['error'] == "alreadyBooked"):
                ?>
                <div class="alert alert-danger" role="alert">
                    La sala è già prenotata in questo orario. Scegli un'altra sala o un diverso orario.
                </div>
            <?php
            elseif (isset($_GET['error']) && $_GET['error'] == "endOver"):
                ?>
                <div class="alert alert-danger" role="alert">
                    Lo studio chiude alle 21. Non è possibile prenotare oltre questo orario.
                </div>
            <?php
            elseif (isset($_GET['error']) && $_GET['error'] == "missingData"):
                ?>
                <div class="alert alert-danger" role="alert">
                    Non hai compilato tutti i campi.
                </div>
            <?php
            endif;
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
            <p class="lead text-center">Regole</p>
            <ul>
                <li>Le prenotazioni possono essere cancellate fino a 48 prima della prenotazione stessa</li>
            </ul>
        </div>
        <div class="col-6"></div>
    </div>
    <div class="row">

        <div class="col-12 justify-content-md-center">
            <br>
            <form action="registerReservation.php" method="post">
                <div class="form-row">
                    <div class="col-auto">
                        <label for="startDate">Data</label>
                        <input type="date" class="form-control" name="startDate" id="startDate"
                               aria-describedby="startDate"
                               value="<?php if (isset($_GET['date'])) echo $_GET['date']; else echo date('Y-m-d', strtotime('now')); ?>">
                        <small id="startDateTip" class="form-text text-muted">Inserisci la data della prenotazione.
                        </small>
                    </div>
                    <div class="col-auto">
                        <label for="startOre">Ore:</label>
                        <select class="form-control" name="startOre" id="startOre" aria-describedby="startOre">
                            <option value="08">8</option>
                            <option value="09">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                        </select>
                        <small id="startOreTip" class="form-text text-muted">Inserisci l'ora di inizio della
                            prenotazione.
                        </small>
                    </div>
                    <div class="col-auto">
                        <label for="startMin">Minuti:</label>
                        <select class="form-control" name="startMin" id="startMin" aria-describedby="startMin">
                            <option value="00">00</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="45">45</option>
                        </select>
                        <small id="startMinTip" class="form-text text-muted">Inserisci il minuto di inizio della
                            prenotazione.
                        </small>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-auto">
                        <label for="endOre">Ore:</label>
                        <select class="form-control" name="endOre" id="endOre" aria-describedby="endOre">
                            <option value="08">8</option>
                            <option value="09">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                        </select>
                        <small id="endOreTip" class="form-text text-muted">Inserisci l'ora di fine della
                            prenotazione.
                        </small>
                    </div>
                    <div class="col-auto">
                        <label for="endMin">Minuti:</label>
                        <select class="form-control" name="endMin" id="endMin" aria-describedby="endMin">
                            <option value="00">00</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="45">45</option>
                        </select>
                        <small id="endMinTip" class="form-text text-muted">Inserisci il minuto di fine della
                            prenotazione.
                        </small>
                    </div>
                    <div class="col-auto">
                        <label for="room">Stanza:</label>
                        <select class="form-control" name="room" id="room" aria-describedby="room">
                            <?php
                            $query = "SELECT roomId,roomName FROM rooms where isActive = 1";
                            $rows = $dbConnection->query($query);
                            foreach ($rows as $row) {
                                echo "<option value=\"" . $row['roomId'] . "\">" . $row['roomName'] . "</option>";
                            }
                            ?>
                        </select>
                        <small id="roomTip" class="form-text text-muted">Scegli la sala da prenotare</small>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary">Prenota</button>
            </form>
        </div>

    </div>


</div>
</body>
</html>
