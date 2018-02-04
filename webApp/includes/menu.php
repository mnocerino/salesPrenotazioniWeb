<div class="row">
    <div class="col-12 text-center">
        <a href="indexLogged.php">
            <button class="btn btn-primary">Home</button>
        </a>
        <a href="myReservations.php">
            <button class="btn btn-primary">Le mie prenotazioni</button>
        </a>
        <a href="newReservation.php">
            <button class="btn btn-primary">Nuova prenotazione</button>
        </a>

        <a href="myAccount.php">
            <button class="btn btn-primary">Il mio account</button>
        </a>
        <?php
        if (isUserAdmin(getUserIdFromSession())):
            ?>
        <a href="administration/index.php">
            <button class="btn btn-warning">Amministrazione</button>
        </a>
        <?php
        endif;
        ?>
        <a href="logout.php">
            <button class="btn btn-danger">Esci</button>
        </a>
    </div>
</div>