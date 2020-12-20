<?php
define('STRIPE_API_KEY', gatewayinfo($_SESSION['pw_stripe_gateway'],"a_field_2")); 
define('STRIPE_PUBLISHABLE_KEY', gatewayinfo($_SESSION['pw_stripe_gateway'],"a_field_1")); 
  
$response = array();

// Check whether stripe token is not empty
if(!empty($_POST['stripeToken'])){
    
    $productName = $_SESSION['pw_stripe_productName']; 
    $productNumber = $_SESSION['pw_stripe_productNumber']; 
    $productPrice = $_SESSION['pw_stripe_productPrice']; 
    $currency = $_SESSION['pw_stripe_currency']; 

    // Convert product price to cent
    $stripeAmount = round($productPrice*100, 2);
    // Get token and buyer info
    $token  = $_POST['stripeToken'];
    $email  = $_POST['stripeEmail'];
    
    // Include Stripe PHP library 
    require_once '../includes/payment_src/stripe-php/init.php'; 
    
    // Set API key
    \Stripe\Stripe::setApiKey(STRIPE_API_KEY);
	
	// Add customer to stripe 
    $customer = \Stripe\Customer::create(array( 
        'email' => $email, 
        'source'  => $token 
    )); 
    
    // Charge a credit or a debit card
    $charge = \Stripe\Charge::create(array(
        'customer' => $customer->id,
        'amount'   => $stripeAmount,
        'currency' => $currency,
        'description' => $productName,
    ));

    $query = $db->query("SELECT * FROM pw_deposits WHERE id='$productNumber'");
    if($query->num_rows==0) {
        die("Wrong ORDER id!");
    }
    $row = $query->fetch_assoc();
    
    // Retrieve charge details
    $chargeJson = $charge->jsonSerialize();

    // Check whether the charge is successful
    if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){
        
        // Order details
		$txnID = $chargeJson['balance_transaction']; 
        $paidAmount = ($chargeJson['amount']/100);
        $paidCurrency = $chargeJson['currency']; 
        $status = $chargeJson['status'];
        $orderID = $chargeJson['id'];
        $payerName = $chargeJson['source']['name'];
		
		// Include database connection file  
        $time = time();
        $update = $db->query("UPDATE pw_deposits SET gateway_txid='$txnID',processed_on='$time',status='3' WHERE id='$row[id]'");
        $update = $db->query("UPDATE pw_transactions SET updated='$time',status='3' WHERE txid='$row[txid]'");
        //$update = $db->query("UPDATE pw_deposits SET status='1',gateway_txid='$txnID',processed_on='$time' WHERE id='$row[id]'");
        $update = $db->query("UPDATE pw_activity SET updated='$time',status='3' WHERE type='3' and u_field_1='$row[id]'");
        //PW_UpdateUserWallet($row['uid'],$row['amount'],$row['currency'],1);
        $last_insert_id = $productNumber;
        
        //send admin notificcation
        $to = $settings['infoemail'];
        $subject = "New deposit in ".$settings['name'];
        $text = "A user just made a new deposit into their wallet";
        $link = $settings['url'].'admin/?a=deposits&b=view&id='.$row['id'];
        PW_EmailSys_Send_Generic($to,$subject,$text,$link);
        
        $amount=$row['amount'];
        $currency = $row['currency'];
        PW_InsertNotification($_SESSION['pw_uid'],$row['id'],'You have made a deposit of '.$amount.' '.$currency.' and it will be reflected in your balance within next working day',$amount,$currency,'14',time());
        
        // If order inserted successfully
		if($last_insert_id && $status == 'succeeded'){
            $response = array(
                'status' => 1,
                'msg' => 'Your Payment has been Successful!',
                'txnData' => $chargeJson
            );
        }else{
            $response = array(
                'status' => 0,
                'msg' => 'Transaction has been failed.'
            );
        }
    }else{
        $response = array(
            'status' => 0,
            'msg' => 'Transaction has been failed.'
        );
    }
}else{
    $response = array(
        'status' => 0,
        'msg' => 'Form submission error...'
    );
}

// Return response
echo json_encode($response);
?>