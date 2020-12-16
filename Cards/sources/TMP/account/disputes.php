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

$c = protect($_GET['c']);
switch($c) {
    case "open": include("disputes/open.php"); break;
    case "dispute": include("disputes/dispute.php"); break;
    case "escalate": include("disputes/escalate.php"); break;
    case "close": include("disputes/close.php"); break;
    default: include("disputes/disputes.php");
}
?>