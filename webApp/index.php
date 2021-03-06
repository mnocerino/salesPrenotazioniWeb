<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino
 * Date: 12/01/2018
 * Time: 18:48
 */
require_once 'includes/database.php';
require_once 'includes/userFunctions.php';
session_start();
if (isUserLoggedIn()) {
    header('Location: indexLogged.php');
    die();
}
?>


<!DOCTYPE html>
<html lang="it">
<meta charset="UTF-8">
<head>
    <title>Prenotazione studi Sales</title>
    <?php
    require_once 'includes/includes.php';
    ?>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-auto text-center mx-auto">
            <h1 class="display-3">Studio Associato di Psicologia Rebaudengo</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-auto text-center mx-auto">
            <p>Area riservata ai professionisti collaboratori dello studio</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 text-center mx-auto">
            <?php
            if (isset($_GET['error']) && $_GET['error'] == "wrongPassword"):
                ?>
                <div class="alert alert-danger" role="alert">
                    Hai inserito la password errata.
                </div>
            <?php
            elseif (isset($_GET['error']) && $_GET['error'] == "userNotFound"):
                ?>
                <div class="alert alert-danger" role="alert">
                    Questo utente non esiste.
                </div>
            <?php
            elseif (isset($_GET['error']) && $_GET['error'] == "userDeactivated"):
                ?>
                <div class="alert alert-danger" role="alert">
                    Questo utente è stato disabilitato. Contatta gli uffici.
                </div>
            <?php
            endif;
            ?>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#moduloLogin">
                Login richiesto
            </button>


            <!-- Modal -->
            <form action="login.php" method="post">
                <div class="modal fade" id="moduloLogin" tabindex="-1" role="dialog"
                     aria-labelledby="moduloLogin" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modulo di login</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Inserisci i tuoi dati per continuare
                                <div class="form-group">
                                    <label for="mail">Indirizzo mail </label>
                                    <input type="email" class="form-control" name="mail"
                                           placeholder="Inserisci la mail">

                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password"
                                           placeholder="Password">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                                <button class="btn btn-primary" type="submit">Login</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
</div>
</body>
</html>
