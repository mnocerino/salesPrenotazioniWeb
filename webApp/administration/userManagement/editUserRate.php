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
session_start();


if (!isUserLoggedIn()) {
    header('Location: ../../index.php');
    die();
}
if (!isUserAdmin(getUserIdFromSession())) {
    header('Location: ../../index.php');
    die();
}

if (isset($_POST['userId']) && isset($_POST['userRate']) && isset($_POST['userRatePM'])) {
    $userId = filter_var(trim($_POST['userId']), FILTER_SANITIZE_NUMBER_INT);
    $userRate = floatval($_POST['userRate']);
    $userRatePM = floatval($_POST['userRatePM']);
    changeUserRate($userId, $userRate, $userRatePM);
    header('Location: ../manageUsers.php');
    die();
}

if (isset($_GET['userId'])):
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
    </head>
    <body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <h1>Modifica utente</h1><br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-auto text-center mx-auto">
                <p>Modifica il costo orario per l'utente: <?php echo getUserCompleteName($_GET['userId']) ?><br>
                <form action="editUserRate.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="userId" aria-describedby="nameHelp"
                               value="<?php echo $_GET['userId'] ?>" required hidden>
                        <label for="userRate">Costo orario AM</label>
                        <input type="number" class="form-control" id="userRate" name="userRate"
                               aria-describedby="userAllowanceHelp" value="<?php echo getUserRate($_GET['userId']) ?>"
                               required step="0.01" min="0">
                        <small id="userRateHelp" class="form-text text-muted">Inserisci il costo orario AM per l'utente.
                        </small>
                    </div>
                    <div class="form-group">

                        <label for="userRate">Costo orario PM</label>
                        <input type="number" class="form-control" id="userRatePM" name="userRatePM"
                               aria-describedby="userAllowanceHelp" value="<?php echo getUserRatePM($_GET['userId']) ?>"
                               required step="0.01" min="0">
                        <small id="userRatePMHelp" class="form-text text-muted">Inserisci il costo orario PM per
                            l'utente.
                        </small>
                    </div>
                    <button type="submit" class="btn btn-primary" id="submit">Modifica il costo orario</button>
                </form>
            </div>
        </div>
    </div>
    </body>

    </html>

<?php
else: header('Location: ../manageUsers.php');
endif;
?>