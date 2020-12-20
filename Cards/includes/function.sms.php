<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}
require __DIR__.'/twilio-php/src/Twilio/autoload.php';

use Twilio\Rest\Client;

function PW_Send_SMS($to_number,$msg) {
    // Your Account SID and Auth Token from twilio.com/console
    $account_sid = 'AC5c15005fe4716075050cca902ebcbb38';
    $auth_token = 'ec57ab596d2dc360c2af0f81fa8d17df';
    // In production, these should be environment variables. E.g.:
    // $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]
    // A Twilio number you own with SMS capabilities
    $twilio_number = "+12029371094";
    $client = new Client($account_sid, $auth_token);
    $client->messages->create(
    // Where to send a text message (your cell phone?)
    $to_number,
        array(
            'from' => $twilio_number,
            'body' => $msg
        )
    );
}

?>