<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('STRIPE_API_KEY', gatewayinfo($_SESSION['pw_stripe_gateway'],"a_field_2"));
define('STRIPE_PUBLISHABLE_KEY', gatewayinfo($_SESSION['pw_stripe_gateway'],"a_field_1")); 
  
$response = array();

// Check whether stripe token is not empty

    //echo '<script>alert("hello froom stripe_send");</script>';
    $productName = $_SESSION['pw_stripe_productName']; 
    $productNumber = $_SESSION['pw_stripe_productNumber']; 
    $productPrice = $_SESSION['pw_stripe_productPrice']; 
    $currency = $_SESSION['pw_stripe_currency']; 

    // Convert product price to cent
    $stripeAmount = round($productPrice*100, 2);
    // Get token and buyer info
    //$token  = $_POST['stripeToken'];
    //$email  = $_POST['stripeEmail'];
    
    // Include Stripe PHP library 
    require_once '../includes/payment_src/stripe-php/init.php'; 
    
    // Set API key
    \Stripe\Stripe::setApiKey(STRIPE_API_KEY);
    
    // Add customer to stripe 
    /*$customer = \Stripe\Customer::create(array( 
        'email' => $email, 
        'source'  => $token 
    )); 
    
    // Charge a credit or a debit card
    $charge = \Stripe\Charge::create(array(
        'customer' => $customer->id,
        'amount'   => $stripeAmount,
        'currency' => $currency,
        'description' => $productName,
    ));*/
	
	$session = \Stripe\Checkout\Session::create([
      'payment_method_types' => ['card'],
      'line_items' => [[
        'price_data' => [
          'product' => 'prod_Hb5li1HMHfRxP7',
          'unit_amount' => 1500,
          'currency' => 'usd',
        ],
        'quantity' => 1,
      ]],
      'mode' => 'payment',
      'success_url' => 'https://example.com/success',
      'cancel_url' => 'https://example.com/cancel',
    ]);
    print_r($session);
    echo '<script src="https://js.stripe.com/v3/"></script>
    <script>var stripe = Stripe("pk_test_xAqjPZZNRX2kyRYGP2i6t4TE00D6uc4Mlf");
    
    var checkoutButton = document.getElementById("checkout-button");
    //checkoutButton.addEventListener("click", function() {
      alert("hello");
      stripe.redirectToCheckout({
        // Make the id field from the Checkout Session creation API response
        // available to this file, so you can provide it as argument here
        // instead of the {{CHECKOUT_SESSION_ID}} placeholder.
        sessionId: \'{{CHECKOUT_SESSION_ID}}\'
      }).then(function (result) {
        // If `redirectToCheckout` fails due to a browser or network
        // error, display the localized error message to your customer
        // using `result.error.message`.
      });
    //});
    </script>';
    echo '<script>document.getElementById("checkout-button").click()</script>';
?>