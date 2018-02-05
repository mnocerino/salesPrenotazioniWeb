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
}

if (isset($_POST['userId']) && isset($_POST['userAllowance'])) {
    $userId = filter_var(trim($_POST['userId']), FILTER_SANITIZE_NUMBER_INT);
    $userAllowance = filter_var(trim($_POST['userAllowance']), FILTER_SANITIZE_NUMBER_FLOAT);

    changeUserAllowance($userId, $userAllowance);
    header('Location: ../manageUsers.php');
    die();
}

if (isset($_GET['userId'])):
    ?>

    <!DOCTYPE html>
    <html lang="it">
    <head>
        <!--
        Mattia Nocerino - 818089
        Progetto: realizzazione di un sistema web per la gestione della prenotazioni di sale e uffici in uno studio associato di psicologia.
        Pagina per la modifica del monte ore di un professionista.
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

                <p>Modifica il monte ore disponibile per l'utente: <?php echo getUserCompleteName($_GET['userId']) ?>
                    <br>

                <form action="editUserAllowance.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="userId" aria-describedby="nameHelp"
                               value="<?php echo $_GET['userId'] ?>" required hidden>
                        <label for="userAllowance">Monte ore</label>
                        <input type="number" class="form-control" id="userAllowance" name="userAllowance"
                               aria-describedby="userAllowanceHelp"
                               value="<?php echo getUserAllowance($_GET['userId']) ?>" required>
                        <small id="userAllowanceHelp" class="form-text text-muted">Inserisci il monte ore disponibile
                            per l'utente.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary" id="submit">Modifica il monte ore</button>
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