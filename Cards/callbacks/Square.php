<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//echo '<script>alert("in square php");</script>';
//echo 'hello';
//echo '<script>window.location.href="https://www.google.com";</script>';
// Note this line needs to change if you don't use Composer:
//echo '<script>alert("hello1");</script>';
//echo getcwd().'<br>';
//if(file_exists('../square-php-sdk/autoload.php')){
 //   echo '<script>alert("milgyi");</script>';
//}
//else{
//    echo '<script>alert("ni mili");</script>';
//}
require('../square-php-sdk/autoload.php');
//require 'vendor/autoload.php';
//echo '<script>alert("hello2");</script>';
use Dotenv\Dotenv;
use Square\Models\CreateOrderRequest;
use Square\Models\CreateCheckoutRequest;
use Square\Models\Order;
use Square\Models\OrderLineItem;
use Square\Models\Money;
use Square\Exceptions\ApiException;
use Square\SquareClient;
// dotenv is used to read from the '.env' file created
//$dotenv = Dotenv::create(__DIR__);
//$dotenv->load();

// Pulled from the .env file and upper cased e.g. SANDBOX, PRODUCTION.
//$upper_case_environment = strtoupper(getenv('ENVIRONMENT'));

// Use the environment and the key name to get the appropriate values from the .env file.
//$access_token = getenv($upper_case_environment.'_ACCESS_TOKEN');    
//$location_id =  getenv($upper_case_environment.'_LOCATION_ID');

$access_token = 'EAAAELLb-dAoGwJqjM9mQPxj1xpH7vVBuqjTcbMMOS0ybBHgJYoiqBIgik2wkuRl';
$location_id =  'J55PGME0MBMD8';
// Initialize the authorization for Square
$client = new SquareClient([
  'accessToken' => $access_token,
  'environment' => sandbox
]);

// make sure we actually are on a POST with an amount
// This example assumes the order information is retrieved and hard coded
// You can find different ways to retrieve order information and fill in the following lineItems object.
try {
    global $settings;
    $base_price_money = new \Square\Models\Money();
    $base_price_money->setAmount($_SESSION['pw_square_squareAmount']);
    //echo '<script>alert("currency is: '.$_SESSION['pw_square_currency'].'");</script>';
    $base_price_money->setCurrency(strtoupper($_SESSION['pw_square_currency']));
    
    $order_line_item = new \Square\Models\OrderLineItem('1');
    $order_line_item->setName($_SESSION['pw_square_productName']);
    $order_line_item->setBasePriceMoney($base_price_money);
    
    $line_items = [$order_line_item];
    $order1 = new \Square\Models\Order($location_id);
    $order1->setReferenceId($_SESSION['pw_square_productNumber']);
    $order1->setLineItems($line_items);
    
    $order = new \Square\Models\CreateOrderRequest();
    $order->setOrder($order1);
    
    //echo '<script>alert("'.uniqid().'");</script>';
    $order->setIdempotencyKey(uniqid());
    
    $body = new \Square\Models\CreateCheckoutRequest(uniqid(), $order);
    $body->setAskForShippingAddress(false);
    $body->setMerchantSupportEmail($settings['infoemail']);
    $body->setPrePopulateBuyerEmail(idinfo($_SESSION['pw_uid'],"email"));
    if($_SESSION['pw_square_type']=='3'){
        $body->setRedirectUrl($settings['url'].'account/summary/success/deposit');
    }
    else{
        $body->setRedirectUrl($settings['url'].'account/summary/success/send');
    }
    $response = $client->getCheckoutApi()->createCheckout($location_id, $body);
    
    if ($response->isSuccess()) {
        $result = $response->getResult();
    } else {
        $errors = $response->getErrors();
    }
} catch (ApiException $e) {
  // If an error occurs, output the message
  //echo '<script>alert("inexception");</script>';
  echo 'Caught exception!<br/>';
  echo '<strong>Response body:</strong><br/>';
  echo '<pre>'; var_dump($e->getResponseBody()); echo '</pre>';
  echo '<br/><strong>Context:</strong><br/>';
  echo '<pre>'; var_dump($e->getContext()); echo '</pre>';
  exit();
}

// If there was an error with the request we will
// print them to the browser screen here
if ($response->isError()) {
  echo 'Api response has Errors';
  $errors = $response->getErrors();
  echo '<ul>';
  foreach ($errors as $error) {
      echo '<li>❌ ' . $error->getDetail() . '</li>';
  }
  echo '</ul>';
  exit();
}


// This redirects to the Square hosted checkout page
header('Location: '.$response->getResult()->getCheckout()->getCheckoutPageUrl());