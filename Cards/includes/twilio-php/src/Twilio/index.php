<?php
// Include the bundled autoload from the Twilio PHP Helper Library
if(file_exists('autoload.php')){
    echo 'file milgyi';
}
else{
    echo 'ni mili';
}
require 'autoload.php';
use Twilio\Rest\Client;
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
    '+923114114466',
    array(
        'from' => $twilio_number,
        'body' => 'I sent this message in under 10 minutes!'
    )
);
if ($message->sid) {
        echo "Message sent!";
    }