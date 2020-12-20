<?php
// Crypto Wallet
// Author: Crypto Wallet
define('PWV1_INSTALLED',TRUE);
ob_start();
session_start();
error_reporting(0);
include("../configs/bootstrap.php");
include("../includes/bootstrap.php");
//include("../languages/".$settings[default_language].".php");

if(checkSession()) {
    $amount = protect($_GET['amount']);
    $from = protect($_GET['from']);
    $to = protect($_GET['to']);
    echo currencyConvertor($amount,$from,$to);
}
?>