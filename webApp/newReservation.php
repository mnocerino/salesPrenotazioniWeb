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
    <div class="row">
        <div class="col-12 text-center">
            <br>
            <h3 class="display-4">Nuova prenotazione</h3>
            <?php if (isset($_GET['date'])) echo $_GET['date']; ?>
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
            <form>
                <div class="form-row">
                    <div class="col-auto">
                        <label for="startDate">Data</label>
                        <input type="date" class="form-control" id="startDate" aria-describedby="startDate"
                               value="<?php if (isset($_GET['date'])) echo $_GET['date']; ?>">
                        <small id="startDate" class="form-text text-muted">Inserisci la data della prenotazione.</small>
                    </div>
                    <div class="col-auto">
                        <label for="startOre">Ore:</label>
                        <select class="form-control" id="startOre" aria-describedby="startOre">
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                        </select>
                        <small id="startOre" class="form-text text-muted">Inserisci l'ora di inizio della
                            prenotazione.
                        </small>
                    </div>
                    <div class="col-auto">
                        <label for="startMin">Minuti:</label>
                        <select class="form-control" id="startMin" aria-describedby="startMin">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                        <small id="startMin" class="form-text text-muted">Inserisci il minuto di inizio della
                            prenotazione.
                        </small>
                    </div>
                    <div class="form-row">

                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Prenota</button>
            </form>
        </div>

    </div>


</div>
</body>
</html>
