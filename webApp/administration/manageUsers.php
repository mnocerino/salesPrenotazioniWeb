<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino
 * Date: 16/01/2018
 * Time: 13:07
 */
setlocale(LC_TIME, 'it_IT');
require_once '../includes/database.php';
require_once '../includes/userFunctions.php';
require_once '../includes/booking.php';
require_once '../includes/rooms.php';

session_start();
if (!isUserLoggedIn()) {
    header('Location: ../index.php');
    die();
}
if (!isUserAdmin(getUserIdFromSession())) {
    header('Location: ../index.php');
    die();
}

$activeUsers = getActiveUsers();
$getActiveUsersAdmins = getActiveUsersAdmins();
$deactivatedUsers = getDeactivatedUsers();

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Prenotazione studi Sales</title>
    <?php
    require_once '../includes/includes.php';
    ?>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="display-4">Amministrazione utenti</h1>
        </div>
    </div>
    <div class="row"><br></div>
    <?php require_once '../includes/adminMenu.php'; ?>
    <div class="row">
        <div class="col-lg-auto text-center mx-auto">
            <br>
            <a href="userManagement/newUser.php" class="btn btn-primary" role="button">Crea nuovo utente</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-auto text-center mx-auto">
            <br>
            <h3>Utenti amministratori</h3>

            <table class="table table-striped table-bordered text-center">
                <thead>
                <tr>
                    <td>Codice utente</td>
                    <td>Cognome</td>
                    <td>Nome</td>
                    <td>Email</td>
                    <td>Operazioni</td>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($getActiveUsersAdmins as $activeUserAdmin) {
                    echo "<tr>";
                    echo "<td>" . $activeUserAdmin['userId'] . "</td>";
                    echo "<td>" . $activeUserAdmin['surname'] . "</td>";
                    echo "<td>" . $activeUserAdmin['name'] . "</td>";
                    echo "<td>" . $activeUserAdmin['mail'] . "</td>";
                    echo "<td>";
                    if ($activeUserAdmin['userId'] != getUserIdFromSession()) echo "<a href=\"userManagement/makeUser.php?userId=" . $activeUserAdmin['userId'] . "\" class=\"btn btn-danger\" role=\"button\">Rendi utente normale</a> ";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-auto text-center mx-auto">
            <br>
            <h3>Utenti attivi</h3>

            <table class="table table-striped table-bordered text-center">
                <thead>
                <tr>
                    <td>Codice utente</td>
                    <td>Cognome</td>
                    <td>Nome</td>
                    <td>Email</td>
                    <td>Costo orario</td>
                    <td>Ore mensili</td>
                    <td>Ultimo accesso</td>
                    <td>Operazioni</td>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($activeUsers as $activeUser) {
                    echo "<tr>";
                    echo "<td>" . $activeUser['userId'] . "</td>";
                    echo "<td>" . $activeUser['surname'] . "</td>";
                    echo "<td>" . $activeUser['name'] . "</td>";
                    echo "<td>" . $activeUser['mail'] . "</td>";
                    echo "<td>" . $activeUser['rate'] . "</td>";
                    echo "<td>" . $activeUser['allowance'] . "</td>";
                    echo "<td>" . $activeUser['lastLogin'] . "</td>";
                    echo "<td>";
                    if (getUserIdFromSession() != $activeUser['userId']) echo "<a href=\"userManagement/deactivateUser.php?userId=" . $activeUser['userId'] . "\" class=\"btn btn-danger\" role=\"button\">Disattiva</a> ";
                    echo "<a href=\"userManagement/editUserRate.php?userId=" . $activeUser['userId'] . "\" class=\"btn btn-info\" role=\"button\">Modifica costo orario</a> ";
                    echo "<a href=\"userManagement/editUserAllowance.php?userId=" . $activeUser['userId'] . "\" class=\"btn btn-info\" role=\"button\">Modifica ore mensili</a> ";
                    if ($activeUser['userId'] != getUserIdFromSession()) echo "<a href=\"userManagement/generateNewPassword.php?userId=" . $activeUser['userId'] . "\" class=\"btn btn-danger\" role=\"button\">Genera nuova password</a> ";
                    if (!isUserAdmin($activeUser['userId'])) echo "<a href=\"userManagement/makeAdmin.php?userId=" . $activeUser['userId'] . "\" class=\"btn btn-danger\" role=\"button\">Rendi amministratore</a> ";
                    if (isUserAdmin($activeUser['userId']) && getUserIdFromSession() != $activeUser['userId']) echo "<a href=\"userManagement/makeUser.php?userId=" . $activeUser['userId'] . "\" class=\"btn btn-danger\" role=\"button\">Rendi utente normale</a> ";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-auto text-center mx-auto">
            <h3>Utenti non attivi</h3>
            <table class="table table-striped table-bordered text-center">
                <thead>
                <tr>
                    <td>Codice utente</td>
                    <td>Cognome</td>
                    <td>Nome</td>
                    <td>Email</td>
                    <td>Costo orario</td>
                    <td>Ore mensili</td>
                    <td>Ultimo accesso</td>
                    <td>Operazioni</td>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($deactivatedUsers as $deactivatedUser) {
                    echo "<tr>";
                    echo "<td>" . $deactivatedUser['userId'] . "</td>";
                    echo "<td>" . $deactivatedUser['surname'] . "</td>";
                    echo "<td>" . $deactivatedUser['name'] . "</td>";
                    echo "<td>" . $deactivatedUser['mail'] . "</td>";
                    echo "<td>" . $deactivatedUser['rate'] . "</td>";
                    echo "<td>" . $deactivatedUser['allowance'] . "</td>";
                    echo "<td>" . $deactivatedUser['lastLogin'] . "</td>";
                    echo "<td>";
                    echo "<a href=\"userManagement/activateUser.php?userId=" . $deactivatedUser['userId'] . "\" class=\"btn btn-danger\" role=\"button\">Attiva</a> ";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
