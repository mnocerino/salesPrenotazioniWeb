<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 05/02/2018
 * Time: 13:21
 */
require_once '../../includes/database.php';
require_once '../../includes/userMethods.php';
require_once '../../includes/booking.php';
require_once '../../includes/room.php';
session_start();
if (!isUserLoggedIn()) {
    header('Location: ../../index.php');
    die();
}
if (!isUserAdmin(getUserIdFromSession())) {
    header('Location: ../../index.php');
}

if (isset($_POST['roomName']) && isset($_POST['roomDescription'])) {
    $roomName = filter_var(trim($_POST['roomName']), FILTER_SANITIZE_STRING);
    $roomDescription = filter_var(trim($_POST['roomDescription']), FILTER_SANITIZE_STRING);
    newRoom($roomName, $roomDescription);
    header('Location: ../manageRooms.php');
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Prenotazione studi Sales - Registrazione</title>
    <?php
    require_once '../../includes/includes.php';
    ?>
    <link rel="stylesheet" href="../../css/index.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Registrazione nuovo utente</h1><br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-auto text-center mx-auto">

            <p>Inserisci i dati della nuova stanza:<br>

            <form action="newRoom.php" method="post">
                <div class="form-group">

                    <label for="name">Nome</label>
                    <input type="text" class="form-control" id="name" name="roomName" aria-describedby="nameHelp"
                           placeholder="Nome" required>
                    <small id="nameHelp" class="form-text text-muted">Inserisci il nome della sala (corto).</small>


                    <label for="description">Descrizione</label>
                    <input type="text" class="form-control" id="roomDescription" name="roomDescription"
                           aria-describedby="roomDescriptionHelp" placeholder="Descrizione della stanza" required>
                    <small id="roomDescriptionHelp" class="form-text text-muted">Inserisci la descrizione della sala.
                    </small>

                </div>

                <button type="submit" class="btn btn-primary" id="submit">Crea la nuova stanza</button>
            </form>
        </div>
    </div>
</div>
</body>

</html>

