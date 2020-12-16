<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

if(!checkSession()) {
    $redirect = $settings['url']."login";
    header("Location: $redirect");
}

$redirect_summary = $settings['url']."account/summary";

$c = protect($_GET['c']);
switch($c) {
    case "converter": include("money/converter.php"); break;
    case "send": include("money/send.php"); break;
    case "request": include("money/request.php"); break;
    case "request_pay": include("money/request_pay.php"); break;
    case "request_cancel": include("money/request_cancel.php"); break;
    case "low_balance": include("money/low_balance.php"); break;
    case "deposit": include("money/deposit.php"); break;
    case "withdrawal": include("money/withdrawal.php"); break;
    default: header("Location: $redirect_summary");
}
?>