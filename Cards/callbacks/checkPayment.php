<?php
// Crypto Wallet
// Author: InterWebDev
// Website: https://iwebsoft.info
// Support: interwebbg@gmail.com
define('PWV1_INSTALLED',TRUE);
ob_start();
session_start();
error_reporting(0);
include("../configs/bootstrap.php");
include("../includes/bootstrap.php");
//include("../languages/".$settings[default_language].".php");
$a = protect($_GET['a']);
if($a == "PayPal") { include("PayPal.php"); }
elseif($a == "AdvCash") { include("AdvCash.php"); }
elseif($a == "Payeer") { include("Payeer.php"); }
elseif($a == "PerfectMoney") { include("PerfectMoney.php"); }
elseif($a == "Skrill") { include("Skrill.php"); }
elseif($a == "Paytm") { include("Paytm.php"); }
elseif($a == "Stripe") { include("Stripe.php"); }
elseif($a == "Stripe_send") { include("Stripe_send.php"); }
elseif($a == "Square") { include("Square.php"); }
else {
	echo 'Error! Unknown merchant.';
}
?>