<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino
 * Date: 12/01/2018
 * Time: 18:48
 */
require_once 'includes/database.php';
require_once 'includes/userMethods.php';
session_start();

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Prenotazione studi Sales</title>
    <?php
    require_once 'includes/includes.php';
    ?>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-2">
            <img src="images/salesGIF.gif" alt="Logo dello Studio Sales" width="100%">
        </div>
        <div class="col-10">
            <h1 class="display-4">Sales - Prenotazione Online Studi</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p>Area riservata ai professionisti collaboratori dello studio</p>
        </div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <?php
            if (!isUserLoggedIn()) :?>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Login richiesto
                </button>

                <!-- Modal -->
                <form action="login.php" method="post">
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <?php
            else :
                ?>
                <h3>Benvenuto/a, <?php print getUserName(); ?>!</h3>
                <p>Effettua il <a href="logout.php">logout.</a></p>
            <?php
            endif;
            ?>
        </div>
        <div class="col-3"></div>
    </div>
</div>
</body>
</html>
