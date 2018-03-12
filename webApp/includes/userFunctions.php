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
    $query = "SELECT name from users WHERE userId = (SELECT userId from users WHERE userId = '$userId') LIMIT 1;";

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
    $query = "SELECT name,surname from users WHERE userId = (SELECT userId from users WHERE userId = '$userId') LIMIT 1;";

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
    $query = "SELECT surname from users WHERE userId = (SELECT userId from users WHERE userId = '$userId') LIMIT 1;";

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
    $query = "SELECT status FROM users WHERE userId = '$userId'";
    $rows = $dbConnection->query($query);
    //echo $query;
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

function getUserRatePM($userId)
{
    $dbConnection = dbConnect();
    $query = "SELECT ratePM FROM users WHERE userId='$userId'";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            return $row['ratePM'];
        }
    }
}

function calculateUsedHours($userId, $month)
{
    $startDate = date('Y-m-01 00:00:00');
    $endDate = date('Y-m-t 00:00:00', strtotime($month));

    $dbConnection = dbConnect();
    $query = "SELECT * FROM bookings where userId='$userId' and start BETWEEN '$startDate' AND '$endDate' and status=1";
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
}

function registerNewUser($name, $surname, $mail, $password)
{
    $dbConnection = dbConnect();
    $name = filter_var(trim($name), FILTER_SANITIZE_STRING);
    $surname = filter_var(trim($surname), FILTER_SANITIZE_STRING);
    $mail = filter_var(trim($mail), FILTER_SANITIZE_EMAIL);
    if (!checkIfUserExists($mail)) {
        $query = "INSERT INTO users (name, surname, mail, password) VALUES ('$name' , '$surname', '$mail', '$password')";
        $dbConnection->query($query);
        return getUserIdFromMail($mail);
    } else return false;

}

function checkPasswordFromid($userId, $password)
{
    $dbConnection = dbConnect();
    $query = "SELECT password FROM users WHERE userId = '$userId' LIMIT 1";
    $rows = $dbConnection->query($query);
    $passwordHashed = hash('sha1', $password);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            if ($passwordHashed == $row['password']) {
                return true;
            }
        }
    }
    return false;
}

function changePassword($userId, $oldPassword, $newPassword)
{
    if (checkPasswordFromid($userId, $oldPassword)) {
        $dbConnection = dbConnect();
        $passwordHashed = hash('sha1', $newPassword);
        $query = "UPDATE users SET password = '$passwordHashed' WHERE userId=$userId";
        $dbConnection->query($query);
    }
}

function generateNewPassword()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 10; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getActiveUsers()
{
    $dbConnection = dbConnect();
    $query = "SELECT * from users WHERE status=1";
    return $dbConnection->query($query);
}

function getDeactivatedUsers()
{
    $dbConnection = dbConnect();
    $query = "SELECT * from users WHERE status=0";
    return $dbConnection->query($query);
}

function makeAdmin($userId)
{
    $dbConnection = dbConnect();
    $query = "INSERT INTO administrators (userId) VALUES ('$userId')";
    echo $query;
    $dbConnection->query($query);
}

function makeUser($userId)
{
    $dbConnection = dbConnect();
    $query = "DELETE FROM administrators WHERE userId=$userId";
    $dbConnection->query($query);
}

function adminChangeUserPassword($userId, $password)
{
    $dbConnection = dbConnect();
    $passwordHashed = hash('sha1', $password);
    $query = "UPDATE users SET password = '$passwordHashed' WHERE userId=$userId";
    $dbConnection->query($query);
}

function activateUser($userId)
{
    $dbConnection = dbConnect();
    $query = "UPDATE users SET status='1' WHERE userId='$userId'";
    $dbConnection->query($query);
}

function deactivateUser($userId)
{
    $dbConnection = dbConnect();
    $query = "UPDATE users SET status='0' WHERE userId='$userId'";
    $dbConnection->query($query);
}

function getActiveUsersAdmins()
{
    $dbConnection = dbConnect();
    $query = "SELECT administrators.userId,name,surname,mail from administrators JOIN  users  ON administrators.userId=users.userId and status=1";
    return $dbConnection->query($query);
}

function changeUserRate($userId, $rate, $ratePM)
{
    $dbConnection = dbConnect();
    $query = "UPDATE users SET rate='$rate', ratePM='$ratePM' WHERE userId='$userId'";
    // $query = "UPDATE users SET (rate,ratePM) VALUES ('$rate', '$ratePM') WHERE userId='$userId'";
    $dbConnection->query($query);
}

function changeUserAllowance($userId, $allowance)
{
    $dbConnection = dbConnect();
    $query = "UPDATE users SET allowance='$allowance' WHERE userId='$userId'";
    $dbConnection->query($query);
}

function getUserMailFromId($userId)
{
    $dbConnection = dbConnect();
    $query = "SELECT mail FROM users WHERE userId='$userId'";
    $rows = $dbConnection->query($query);
    if ($rows->rowCount() > 0) {
        foreach ($rows as $row) {
            return $row['mail'];
        }
    }
}