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
require_once '../../includes/booking.php';
$rooms = showRooms();
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

if (isset($_POST['userId'])) {
    $userId = filter_var(trim($_POST['userId']), FILTER_SANITIZE_NUMBER_INT);
    $newPassword = generateNewPassword();
    adminChangeUserPassword($userId, $newPassword);
    $stage2 = true;
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
                <form action="generateNewPassword.php" method="post">
                    <div class="form-group">
                        <input type="number" id="userId" name="userId" value="<?php echo $_GET['userId'] ?>" hidden>

                        <button type="submit" class="btn btn-primary" id="submit">Premi qui per cambiare la password.
                        </button>
                </form>
            <?php
            elseif ($stage2):
                ?>
                <div class="col-md-auto text-center mx-auto">
                    <h3>Password modificata correttamente.</h3>
                    <p>Nome utente: <?php echo getUserMailFromId($userId) ?><br>
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
