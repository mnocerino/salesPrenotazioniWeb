<?php
/**
 * Created by PhpStorm.
 * User: Mattia Nocerino - mnocerino@gmail.com
 * Date: 24/01/2018
 * Time: 12:53
 */

class calendar
{
    private $dayNames = array("Lun", "Mar", "Mer", "Gio", "Ven", "Sab", "Dom");
    private $yearCurrent = null;
    private $monthCurrent = null;
    private $dayCurrent = null;
    private $dateCurrent = null;
    private $monthLenght = null;
    private $naviHref = null;

    public function __construct()
    {
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    }


}