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

function getUserName($userId)
{
    $dbConnection = dbConnect();
    $sessionId = session_id();
    $query = "SELECT name from users WHERE userId = (SELECT userId from sessions WHERE userId = '$userId') LIMIT 1;";

    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            return $row['name'];
        }
    } else return "";

}

function getUserCompleteName($userId)
{
    $dbConnection = dbConnect();
    $sessionId = session_id();
    $query = "SELECT name,surname from users WHERE userId = (SELECT userId from sessions WHERE userId = '$userId') LIMIT 1;";

    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            return $row['name'] . " " . $row['surname'];
        }
    } else return "";

}


function getUserSurname($userId)
{
    $dbConnection = dbConnect();
    $sessionId = session_id();
    $query = "SELECT surname from users WHERE userId = (SELECT userId from sessions WHERE userId = '$userId') LIMIT 1;";

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

function getUserAllowance($userId)
{
    $dbConnection = dbConnect();
    $query = "SELECT allowance FROM users WHERE userId='$userId'";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            return $row['allowance'];
        }
    }
}

function getUserRate($userId)
{
    $dbConnection = dbConnect();
    $query = "SELECT rate FROM users WHERE userId='$userId'";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            return $row['rate'];
        }
    }
}

function calculateUsedHours($userId, $month)
{
    $startDate = date('Y-m-01 00:00:00');
    $endDate = date('Y-m-t 00:00:00', strtotime($month));

    $dbConnection = dbConnect();
    $query = "SELECT * FROM bookings where userId='$userId' and start BETWEEN '$startDate' AND '$endDate'";
    $rows = $dbConnection->query($query);
    $usedSeconds = 0;
    foreach ($rows as $row) {

        $date1 = new DateTime($row['start']);
        $date2 = new DateTime($row['end']);
        $diffInSeconds = $date2->getTimestamp() - $date1->getTimestamp();
        $usedSeconds = $usedSeconds + $diffInSeconds;
    }
    return $usedSeconds;
}

function calculateRemainingSeconds($userId, $monthDate)
{
    $startDate = date("Y-m-01 00:00:00", strtotime($monthDate));
    $used = calculateUsedHours($userId, $startDate);
    $allowance = getUserAllowance($userId) * 3600;
    $remaining = $allowance - $used;
    return $remaining;
}

function secToHR($seconds)
{
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds / 60) % 60);
    return $hours . " ore e " . $minutes . " minuti";
}

function getReadableRemainingTime($userId, $monthDate)
{
    return secToHR(calculateRemainingSeconds($userId, $monthDate));
    //eturn gmdate("H:i", calculateRemainingSeconds($userId,$monthDate));
}