<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 05/02/2018
 * Time: 10:54
 */
setlocale(LC_TIME, 'it_IT');
require_once '../../includes/database.php';
require_once '../../includes/userFunctions.php';

session_start();
$stage2 = false;
if (!isUserLoggedIn()) {
    header('Location: ../../index.php');
    die();
}
if (!isUserAdmin(getUserIdFromSession())) {
    header('Location: ../../index.php');
    die();
}

if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email'])) {
    $newPassword = generateNewPassword();
    $passwordForDb = hash('sha1', $newPassword);
    $registered = registerNewUser($_POST['name'], $_POST['surname'], $_POST['email'], $passwordForDb);
    $stage2 = true;
}
?>
<!DOCTYPE html>
<html lang="it">
<meta charset="UTF-8">
<head>
    <title>Prenotazione studi Sales - Registrazione</title>
    <?php
    require_once '../../includes/includes.php';
    ?>
    <link rel="stylesheet" href="../../css/index.css">
    <link rel="stylesheet" href="../../css/registration.css">
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
                </p>
                <form action="newUser.php" method="post">
                    <div class="form-group">

                        <label for="name">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp"
                               placeholder="Nome" required>
                        <small id="nameHelp" class="form-text text-muted">Inserisci il nome.</small>


                        <label for="surname">Cognome</label>
                        <input type="text" class="form-control" id="surname" name="surname"
                               aria-describedby="cognomeHelp" placeholder="Cognome" required>
                        <small id="cognomeHelp" class="form-text text-muted">Inserisci il cognome.</small>

                    </div>
                    <div class="form-group">
                        <label for="email">Indirizzo email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                               placeholder="nome@dominio.com" required>
                        <small id="emailHelp" class="form-text text-muted">Inserisci l'indirizzo mail.</small>
                    </div>
                    <button type="submit" class="btn btn-primary" id="submit">Registrati</button>
                </form>
            <?php
            elseif ($stage2 && !$registered):
                ?>

                <div class="col-md-auto text-center mx-auto">
                    <h3>Questa mail risulta già registrata. Torna alla <a href="../index.php">amministrazione</a>.</h3>

                </div>
            <?php
            elseif ($stage2 && $registered):
                ?>
                <div class="col-md-auto text-center mx-auto">
                    <h3>Utente registrato correttamente.</h3>
                    <p>Nome utente: <?php echo $_POST['email'] ?><br>
                        Password: <?php echo $newPassword ?><br>
                        Stampare e consegnare questa pagina all'utente.<br>
                        Sarà possibile cambiare la password una volta effettuato l'accesso.<br>
                        <a href="../manageUsers.php">Torna all'amministrazione.</a>

                    </p>
                </div>

            <?php
            endif;
            ?>

        </div>
    </div>
</div>
</body>
</html>
