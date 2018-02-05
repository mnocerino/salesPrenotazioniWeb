<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 05/02/2018
 * Time: 13:21
 */
require_once 'includes/database.php';
require_once 'includes/userFunctions.php';
require_once 'includes/booking.php';
require_once 'includes/rooms.php';
session_start();
if (!isUserLoggedIn()) {
    header('Location: index.php');
    die();
}


if (isset($_POST['oldPassword']) && isset($_POST['newPassword'])) {

    $oldPassword = filter_var(trim($_POST['oldPassword']), FILTER_SANITIZE_STRING);
    $newPassword = filter_var(trim($_POST['newPassword']), FILTER_SANITIZE_STRING);
    changePassword(getUserIdFromSession(), $oldPassword, $newPassword);
    header('Location: logout.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Prenotazione studi Sales - Cambio password</title>
    <?php
    require_once 'includes/includes.php';
    ?>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Cambio password</h1><br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-auto text-center mx-auto">

            <p>Modifica la tua password:<br>

            <form action="changePassword.php" method="post">
                <div class="form-group">

                    <label for="oldPassword">Vecchia password</label>
                    <input type="password" class="form-control" id="oldPassword" name="oldPassword"
                           aria-describedby="oldPasswordHelp" required>
                    <small id="oldPasswordHelp" class="form-text text-muted">Inserisci la tua password attuale.</small>


                    <label for="newPassword">Nuova password</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword"
                           aria-describedby="newPasswordHelp" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                    <small id="newPasswordHelp" class="form-text text-muted">Inserisci la nuova password.</small>

                </div>

                <button type="submit" class="btn btn-primary" id="submit">Cambia la password</button>
            </form>
        </div>
    </div>
</div>
</body>

</html>
