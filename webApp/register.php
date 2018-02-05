<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 05/02/2018
 * Time: 10:54
 */
setlocale(LC_TIME, 'it_IT');
require_once 'includes/database.php';
require_once 'includes/userMethods.php';
require_once 'includes/booking.php';
$rooms = showRooms();
session_start();
$stage2 = false;
if (isUserLoggedIn()) {
    header('Location: index.php');
    die();
}
if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['password'])) {
    $registered = registerNewUser($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['password']);
    $stage2 = true;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <title>Prenotazione studi Sales - Registrazione</title>
    <?php
    require_once 'includes/includes.php';
    ?>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/registration.css">
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
            <?php
            if (!$stage2):
                ?>
                <p>Inserisci i dati per effettuare la registrazione<br>
                <h4>La password richiede:</h4>
                <p id="letter" class="invalid">Almeno un carattere in <b>minuscolo</b></p>
                <p id="capital" class="invalid">Almeno un carattere in <b>maiuscolo</b></p>
                <p id="number" class="invalid">Un <b>numero</b></p>
                <p id="length" class="invalid">Deve essere di almeno <b>8 caratteri</b></p>
                <p id="samePasswordCheck" class="invalid">Le password devono essere <b>uguali</b></p>
                </p>
                <form action="register.php" method="post">
                    <div class="form-group">

                        <label for="name">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp"
                               placeholder="Nome" required>
                        <small id="nameHelp" class="form-text text-muted">Inserisci il tuo nome.</small>


                        <label for="surname">Cognome</label>
                        <input type="text" class="form-control" id="surname" name="surname"
                               aria-describedby="cognomeHelp" placeholder="Cognome" required>
                        <small id="cognomeHelp" class="form-text text-muted">Inserisci il tuo cognome.</small>

                    </div>
                    <div class="form-group">
                        <label for="email">Indirizzo email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                               placeholder="nome@dominio.com" required>
                        <small id="emailHelp" class="form-text text-muted">Inserisci il tuo indirizzo mail.</small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                               aria-describedby="passwordHelp" placeholder="Password" required
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onkeyup='check_pass();'>
                        <small id="passwordHelp" class="form-text text-muted">Inserisci una password sicura.</small>
                        <label for="passwordCheck">Conferma password</label>
                        <input type="password" class="form-control" id="passwordCheck" name="passwordCheck"
                               aria-describedby="passwordHelpCheck" placeholder="Reinserisci la tua password" required
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onkeyup='check_pass();'>
                        <small id="passwordHelp" class="form-text text-muted">Reinserisci la password.</small>
                    </div>
                    <button type="submit" class="btn btn-primary" id="submit" disabled>Registrati</button>
                </form>
            <?php
            elseif ($stage2 && !$registered):
                ?>

                <div class="col-md-auto text-center mx-auto">
                    <h3>Questa mail risulta già registrata. Torna alla <a href="index.php">home</a> per effettuare il
                        login.</h3>

                </div>
            <?php
            elseif ($stage2 && $registered):
                ?>
                <div class="col-md-auto text-center mx-auto">
                    <h3>Utente registrato correttamente. Torna alla <a href="index.php">home</a> per effettuare il
                        login.</h3>
                </div>

            <?php
            endif;
            ?>

        </div>
    </div>
</div>
</body>
<script src="js/registrationValidation.js"></script>
</html>
