<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 14/01/2018
 * Time: 15:53
 */

require_once 'includes/booking.php';

echo date('Y-m-d h:m:s', strtotime('monday this week'));
echo "<br>";
echo date('Y-m-d', strtotime('sunday this week'));
echo "<br>";
echo "Lunedi di questa settimana: ";
echo getMondayOfWeek();
echo "<br>";
echo "Lunedì di settimana scorsa: ";
echo getPreviousWeek(getMondayOfWeek());
echo "<br>";
echo "Lunedì di una settimana qualsiasi: ";
$data = date("d-m-Y", strtotime('08-01-2018'));
echo getPreviousWeek($data);


$data = "12-05-2035";
echo "<br>";
echo "Lunedì del 12 5 2035: ";
echo date('d-m-Y', strtotime('previous Monday', strtotime($data)));