<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 14/01/2018
 * Time: 10:54
 */

require_once 'database.php';

function isUserLoggedIn()
{
    $dbConnection = dbConnect();
    $sessionId = session_id();
    $query = "SELECT * from sessions WHERE sessionId = '$sessionId' LIMIT 1;";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            return true;
        }
    } else return false;

}

function getUserName()
{
    $dbConnection = dbConnect();
    $sessionId = session_id();
    $query = "SELECT name from users WHERE userId = (SELECT userId from sessions WHERE sessionId = '$sessionId') LIMIT 1;";

    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            return $row['name'];
        }
    } else return "";

}

function getUserCompleteName()
{
    $dbConnection = dbConnect();
    $sessionId = session_id();
    $query = "SELECT name,surname from users WHERE userId = (SELECT userId from sessions WHERE sessionId = '$sessionId') LIMIT 1;";

    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            return $row['name'] . " " . $row['surname'];
        }
    } else return "";

}

function getUserCompleteNameFromID($userId)
{
    $dbConnection = dbConnect();
    $sessionId = session_id();
    $query = "SELECT name,surname from users WHERE userId = '$userId' LIMIT 1;";

    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            return $row['name'] . " " . $row['surname'];
        }
    } else return "";

}

function getUserSurname()
{
    $dbConnection = dbConnect();
    $sessionId = session_id();
    $query = "SELECT surname from users WHERE userId = (SELECT userId from sessions WHERE sessionId = '$sessionId') LIMIT 1;";

    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            return $row['surname'];
        }
    } else return "";

}
function getUserIdFromSession()
{
    $dbConnection = dbConnect();
    $sessionId = session_id();
    $query = "SELECT userId from users WHERE userId = (SELECT userId from sessions WHERE sessionId = '$sessionId') LIMIT 1;";

    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            return $row['userId'];
        }
    } else return "";
}

function getUserIdFromMail($mail)
{
    $dbConnection = dbConnect();
    $query = "SELECT userId from users WHERE mail = '$mail' LIMIT 1;";

    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            return $row['userId'];
        }
    } else return "";
}


function checkPassword($mail, $password)
{
    $dbConnection = dbConnect();
    $query = "SELECT password FROM users WHERE mail = '$mail' LIMIT 1";
    $rows = $dbConnection->query($query);
    $passwordHashed = hash('sha1', $password);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            if ($passwordHashed == $row['password']) {
                return 1;
            }
        }
    }
    return false;
}

function checkIfUserExists($mail)
{
    $dbConnection = dbConnect();
    $query = "SELECT userId FROM users WHERE mail = '$mail' LIMIT 1";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        return true;
    } else return false;
}

function isUserActive($userId)
{
    $dbConnection = dbConnect();
    $query = "SELECT status FROM USERS WHERE userId= '$userId'";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            if (1 == $row['status']) {
                return true;
            }
        }
    }
    return false;
}

function isUserAdmin($userId)
{
    $dbConnection = dbConnect();
    $query = "SELECT * FROM administrators WHERE userId= '$userId'";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        return true;
    } else return false;
}

function getUserAllowance()
{
    $dbConnection = dbConnect();
    $userId = getUserIdFromSession();
    $query = "SELECT allowance FROM users WHERE userId='$userId'";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            return $row['allowance'];
        }
    }
}

function getUserRate()
{
    $dbConnection = dbConnect();
    $userId = getUserIdFromSession();
    $query = "SELECT rate FROM users WHERE userId='$userId'";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            return $row['rate'];
        }
    }
}