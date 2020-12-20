<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

function success($text) {
	return '<div class="alert alert-success"><i class="fa fa-check"></i> '.$text.'</div>';
}

function error($text) {
	return '<div class="alert alert-danger"><i class="fa fa-times"></i> '.$text.'</div>';
}

function info($text) {
	return '<div class="alert alert-info"><i class="fa fa-info-circle"></i> '.$text.'</div>';
}
?>