<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 05/02/2018
 * Time: 13:21
 */
require_once '../../includes/database.php';
require_once '../../includes/userFunctions.php';
require_once '../../includes/booking.php';
require_once '../../includes/rooms.php';
session_start();
if (!isUserLoggedIn()) {
    header('Location: ../../index.php');
    die();
}
if (!isUserAdmin(getUserIdFromSession())) {
    header('Location: ../../index.php');
}

if (isset($_POST['roomName']) && isset($_POST['roomDescription']) && isset($_POST['roomId'])) {
    $roomId = filter_var(trim($_POST['roomId']), FILTER_SANITIZE_NUMBER_INT);
    $roomName = filter_var(trim($_POST['roomName']), FILTER_SANITIZE_STRING);
    $roomDescription = filter_var(trim($_POST['roomDescription']), FILTER_SANITIZE_STRING);
    editRoom($roomId, $roomName, $roomDescription);
    header('Location: ../manageRooms.php');
    die();
}

if (isset($_GET['roomId'])):
    $roomName = getRoomName($_GET['roomId']);
    $roomDescription = getRoomDescription($_GET['roomId']);
    ?>

    <!DOCTYPE html>
    <html lang="it">
    <meta charset="UTF-8">
    <head>
        <!--
        Mattia Nocerino - 818089
        Progetto: realizzazione di un sistema web per la gestione della prenotazioni di sale e uffici in uno studio associato di psicologia.
        Pagina per la modifica di una stanza gia' presente a sistema.
        -->

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
                <h1>Modifica stanza</h1><br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-auto text-center mx-auto">

                <p>Modifica i dati della stanza:<br>

                <form action="editRoom.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="roomId" aria-describedby="nameHelp"
                               value="<?php echo $_GET['roomId'] ?>" required hidden>
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" id="name" name="roomName" aria-describedby="nameHelp"
                               value="<?php echo $roomName ?>" required>
                        <small id="nameHelp" class="form-text text-muted">Inserisci il nome della sala (corto).</small>


                        <label for="roomDescription">Descrizione</label>
                        <input type="text" class="form-control" id="roomDescription" name="roomDescription"
                               aria-describedby="roomDescriptionHelp" value="<?php echo $roomDescription ?>" required>
                        <small id="roomDescriptionHelp" class="form-text text-muted">Inserisci la descrizione della
                            sala.
                        </small>

                    </div>

                    <button type="submit" class="btn btn-primary" id="submit">Modifica la stanza</button>
                </form>
            </div>
        </div>
    </div>
    </body>

    </html>

<?php
endif;
?>