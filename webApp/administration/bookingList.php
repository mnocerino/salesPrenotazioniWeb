<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 05/02/2018
 * Time: 13:21
 */
require_once '../includes/database.php';
require_once '../includes/userFunctions.php';
require_once '../includes/booking.php';

session_start();
if (!isUserLoggedIn()) {
    header('Location: ../index.php');
    die();
}
if (!isUserAdmin(getUserIdFromSession())) {
    header('Location: ../index.php');
    die();
}


if (isset($_POST['booking'])):
    ?>

    <!DOCTYPE html>
    <html lang="it">
    <meta charset="UTF-8">
    <head>
        <title>Prenotazione studi Sales - Cambia prezzo</title>
        <?php
        require_once '../includes/includes.php';
        ?>
        <link rel="stylesheet" href="../css/index.css">
    </head>
    <body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <h1>Modifica costo prenotazione</h1><br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-auto text-center mx-auto">

                <p>Modifica il costo della prenotazione: <?php ?>
                    <br>

                <form action="changePrice.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="bookingId" aria-describedby="nameHelp"
                               value="<?php echo $_POST['booking'] ?>" required hidden>
                        <label for="newPrice">Costo</label>
                        <input type="number" class="form-control" id="newPrice" name="newPrice"
                               aria-describedby="newPriceHelp"
                               value="<?php ?>" required>
                        <small id="newPriceHelp" class="form-text text-muted">Inserisci il nuovo costo.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary" id="submit">Modifica il costo</button>
                </form>
            </div>
        </div>
    </div>
    </body>

    </html>

<?php
else: header('Location: userBookings.php');
endif;
?>