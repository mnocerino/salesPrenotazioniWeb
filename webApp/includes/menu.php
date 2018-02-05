<div class="row">
    <div class="col-12 text-center">
        <a href="indexLogged.php" class="btn btn-primary" role="button">Home</a>
        <a href="myReservations.php" class="btn btn-primary" role="button">Le mie prenotazioni</a>
        <a href="newReservation.php" class="btn btn-primary" role="button">Nuova prenotazione</a>
        <a href="myAccount.php" class="btn btn-primary" role="button">Il mio account</a>
        <?php
        if (isUserAdmin(getUserIdFromSession())):
            ?>
            <a href="administration/index.php" class="btn btn-warning" role="button">Amministrazione</a>

        <?php
        endif;
        ?>
        <a href="logout.php" class="btn btn-danger" role="button">Esci</a>
    </div>
</div>