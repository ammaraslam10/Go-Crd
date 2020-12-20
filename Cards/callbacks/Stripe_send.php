<?php
define('STRIPE_API_KEY', gatewayinfo($_SESSION['pw_stripe_gateway'],"a_field_2"));
define('STRIPE_PUBLISHABLE_KEY', gatewayinfo($_SESSION['pw_stripe_gateway'],"a_field_1")); 
  
$response = array();

// Check whether stripe token is not empty
if(!empty($_POST['stripeToken'])){
    //echo '<script>alert("hello froom stripe_send");</script>';
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

    $query = $db->query("SELECT * FROM pw_activity WHERE id='$productNumber'");
    if($query->num_rows==0) {
        die("Wrong ORDER id! in sending");
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
        //$update = $db->query("UPDATE pw_deposits SET status='1',gateway_txid='$txnID',processed_on='$time' WHERE id='$row[id]'");
        $update = $db->query("UPDATE pw_activity SET updated='$time',status='3' WHERE txid='$row[txid]'");
        $update = $db->query("UPDATE pw_transactions SET updated='$time',status='3' WHERE txid='$row[txid]'");
        
        $GetTransaction = $db->query("SELECT * FROM pw_transactions WHERE txid='$row[txid]'");
        $transaction = $GetTransaction->fetch_assoc();
        $amount = $transaction['amount'].$transaction['currency'];
        //send notification to admin
        $to = $settings['infoemail'];
        $subject = "New transaction in ".$settings['name'];
        $text = idinfo($transaction['sender'],"first_name")." ".idinfo($transaction['sender'],"last_name")." just transferred ".$amount." to ".idinfo($transaction['recipient'],"first_name")." ".idinfo($transaction['recipient'],"last_name")." using Stripe";
        $link = $settings['url'].'admin/?a=transactions&b=view&id='.$transaction['id'];
        PW_EmailSys_Send_Generic($to,$subject,$text,$link);
        
        //send notification to recipient
        $to = idinfo($transaction['recipient'],"email");
        $amount = $transaction['amount'] - $transaction['fee'];
        //echo $to.'<br>'.$amount;
        $subject = "Congratulations! You have received a payment in ".$settings['name'];
        $text = "You have received ".$amount.$transaction['currency']." from ".idinfo($transaction['sender'],"first_name")." ".idinfo($transaction['sender'],"last_name")." and should be reflected in your balance within 1-2 business days";
        //echo $text;
        $link = $settings['url'].'account/transaction/'.$transaction['txid'];
        PW_EmailSys_Send_Generic($to,$subject,$text,$link);
        
        //send notification to sender
        $to = idinfo($transaction['sender'],"email");
        $amount = $transaction['amount'];
        $subject = "Transaction alert in ".$settings['name'];
        $text = "You have sent ".$amount.$transaction['currency']." to ".idinfo($transaction['recipient'],"first_name")." ".idinfo($transaction['recipient'],"last_name")." and should be reflected in user's balance within 1-2 business days";
        $link = $settings['url'].'account/transaction/'.$transaction['txid'];
        PW_EmailSys_Send_Generic($to,$subject,$text,$link);
        
        $recipient_id = $transaction['recipient'];
        $currency = $transaction['currency'];
        //notification sender
        //PW_UpdateUserWallet($row['uid'],$row['amount'],$row['currency'],1);
        $last_insert_id = $productNumber;
        
        $GetRequest = $db->query("SELECT * FROM pw_requests WHERE (uid='$_SESSION[pw_uid]' and fromu='$recipient_id' and status='1' and cast(amount as FLOAT)<='$amount' and currency='$currency') ");
        if($GetRequest->num_rows>0){
            $getr = $GetRequest->fetch_assoc();
            PW_InsertNotification($_SESSION[pw_uid],$recipient_id,'You have accepted and sent '.$amount.' '.$currency.' to '.idinfo($recipient_id,"first_name").' '.idinfo($recipient_id,"last_name"),$amount,$currency,'6',time());
            //notification for reciever
            PW_InsertNotification($recipient_id,$_SESSION[pw_uid],idinfo($_SESSION[pw_uid],"first_name").' '.idinfo($_SESSION[pw_uid],"last_name").' has sent your requested amount of '.$amount.' '.$currency,$amount,$currency,'7',time());
            //PW_EmailSys_PaymentNotification($email,$amount,$currency,$description,$txid);
            $update_request = $db->query("UPDATE pw_requests SET status='3' WHERE id='$getr[id]' ");
            
        }
        else{
            PW_InsertNotification($_SESSION['pw_uid'],$recipient_id,'You have sent '.$amount.' '.$currency.' to '.idinfo($recipient_id,"first_name").' '.idinfo($recipient_id,"last_name").' and it will be reflected in their balance within next working day',$amount,$currency,'8',time());
            PW_InsertNotification($recipient_id,$_SESSION['pw_uid'],'You have recieved '.$amount.' '.$currency.' from '.idinfo($_SESSION['pw_uid'],"first_name").' '.idinfo($_SESSION['pw_uid'],"last_name").' and it will be reflected in your balance within next working day',$amount,$currency,'1',time());
        
        }
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