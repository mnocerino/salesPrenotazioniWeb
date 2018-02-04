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
            <h3 class="display-4">Nuova prenotazione</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
            <p class="lead text-center">Regole</p>
            <ul>
                <li>E' possibile prenotare le sale fino a 10 giorni</li>
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
                        <input type="date" class="form-control" name="startDate" aria-describedby="startDate"
                               value="<?php if (isset($_GET['date'])) echo $_GET['date']; ?>">
                        <small id="startDate" class="form-text text-muted">Inserisci la data della prenotazione.</small>
                    </div>
                    <div class="col-auto">
                        <label for="startOre">Ore:</label>
                        <select class="form-control" name="startOre" aria-describedby="startOre">
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
                        <small id="startOre" class="form-text text-muted">Inserisci l'ora di inizio della
                            prenotazione.
                        </small>
                    </div>
                    <div class="col-auto">
                        <label for="startMin">Minuti:</label>
                        <select class="form-control" name="startMin" aria-describedby="startMin">
                            <option value="00">00</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="45">45</option>
                        </select>
                        <small id="startMin" class="form-text text-muted">Inserisci il minuto di inizio della
                            prenotazione.
                        </small>
                    </div>
                </div>
                    <div class="form-row">
                        <div class="col-auto">
                            <label for="endOre">Ore:</label>
                            <select class="form-control" name="endOre" aria-describedby="endOre">
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
                            <small id="endOre" class="form-text text-muted">Inserisci l'ora di fine della
                                prenotazione.
                            </small>
                        </div>
                        <div class="col-auto">
                            <label for="endMin">Minuti:</label>
                            <select class="form-control" name="endMin" aria-describedby="endMin">
                                <option value="00">00</option>
                                <option value="15">15</option>
                                <option value="30">30</option>
                                <option value="45">45</option>
                            </select>
                            <small id="endMin" class="form-text text-muted">Inserisci il minuto di fine della
                                prenotazione.
                            </small>
                        </div>
                        <div class="col-auto">
                            <label for="room">Stanza:</label>
                            <select class="form-control" name="room" aria-describedby="room">
                                <?php
                                $query = "SELECT roomId,roomName FROM rooms";
                                $rows = $dbConnection->query($query);
                                foreach ($rows as $row) {
                                    echo "<option value=\"" . $row['roomId'] . "\">" . $row['roomName'] . "</option>";
                                }
                                ?>
                            </select>
                            <small id="room" class="form-text text-muted">Scegli la sala da prenotare</small>
                        </div>
                    </div>


                <button type="submit" class="btn btn-primary">Prenota</button>
            </form>
        </div>

    </div>


</div>
</body>
</html>
