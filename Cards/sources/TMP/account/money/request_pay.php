<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$id = protect($_GET['id']);
$query = $db->query("SELECT * FROM pw_requests WHERE id='$id' and uid='$_SESSION[pw_uid]' and status='1'");
if($query->num_rows==0) { 
    $redirect = $settings['url']."account/summary";
    header("Location: $redirect");
}
$row = $query->fetch_assoc();
echo '<script>alert("okoko")</script>';
$amount = $row['amount'];
$currency = $row['currency'];
$description = $row['description'];
$recipient_id = $row['fromu'];
$email = idinfo($recipient_id,"email");
if(get_wallet_balance($_SESSION['pw_uid'],$currency) < $amount){
    $redirect = $settings['url']."account/money/request/low-balance/";
    header("Location: $redirect");
} 
else {
    $update = $db->query("UPDATE pw_requests SET status='3' WHERE id='$row[id]'");
    $fee = ($amount * $settings['payfee_percentage']) / 100;
    $amount_with_fee = $amount - $fee;
    PW_UpdateUserWallet($_SESSION['pw_uid'],$amount,$currency,2);
    PW_UpdateUserWallet($recipient_id,$amount_with_fee,$currency,1);
    $txid = strtoupper(randomHash(30));
    //echo '<script>alert("'.$txid.'");</script>';
    $time = time();
    $create_transaction = $db->query("INSERT pw_transactions (txid,type,sender,recipient,description,amount,currency,fee,status,created,sent_via) VALUES ('$txid','1','$_SESSION[pw_uid]','$recipient_id','$description','$amount','$currency','$fee','1','$time','wallet')");
    //notification for sender
    $insert_activity = $db->query("INSERT pw_activity (txid,type,uid,u_field_1,amount,currency,status,created,deposit_via) VALUES ('$txid','2','$_SESSION[pw_uid]','$recipient_id','$amount','$currency','1','$time','0')");
    PW_InsertNotification($_SESSION[pw_uid],$recipient_id,'You have accepted and sent '.$amount.' '.$currency.' to '.idinfo($recipient_id,"first_name").' '.idinfo($recipient_id,"last_name"),$amount,$currency,'6',$time);
    //notification for reciever
    $insert_activity = $db->query("INSERT pw_activity (txid,type,uid,u_field_1,amount,currency,status,created) VALUES ('$txid','1','$recipient_id','$_SESSION[pw_uid]','$amount_with_fee','$currency','1','$time')");
    PW_InsertNotification($recipient_id,$_SESSION[pw_uid],idinfo($_SESSION[pw_uid],"first_name").' '.idinfo($_SESSION[pw_uid],"last_name").' has sent your requested amount of '.$amount.' '.$currency,$amount,$currency,'7',$time);
    
    PW_UpdateAdminWallet($fee,$currency);
    $insert_admin_log = $db->query("INSERT pw_admin_logs (type,time,u_field_1,u_field_2,u_field_3) VALUES ('1','$time','$fee','$currency','$txid')");
    PW_EmailSys_PaymentNotification($email,$amount,$currency,$description,$txid);
    $success_5 = str_ireplace("%amount%",$amount,$lang['success_5']);
    $success_5 = str_ireplace("%currency%",$currency,$success_5);
    $success_5 = str_ireplace("%email%",$email,$success_5);
    $msg = success($success_5);
    $_SESSION['msg'] = $msg;
    $_SESSION['msg_type'] = "Accept Request";
    $redirect = $settings['url']."account/summary";
    header("Location: $redirect");
}
?>
