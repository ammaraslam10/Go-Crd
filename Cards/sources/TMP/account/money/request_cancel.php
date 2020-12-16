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
$update = $db->query("UPDATE pw_requests SET status='2' WHERE id='$row[id]'");

//send user notificcation
$to = idinfo($row['fromu'],"email");
$subject = "Oh no! Your funds request was rejected in ".$settings['name'];
$text = "Your funds request was rejected by ".idinfo($row['uid'],"first_name")." ".idinfo($row['uid'],"last_name");
$link = $settings['url'];
PW_EmailSys_Send_Generic($to,$subject,$text,$link);

$recipient_id = $row[fromu];
$amount = $row[amount];
$currency = $row[currency];
PW_InsertNotification($recipient_id,$_SESSION[pw_uid],idinfo($_SESSION[pw_uid],"first_name").' '.idinfo($_SESSION[pw_uid],"last_name").' has rejected your requested amount of '.$amount.' '.$currency,$amount,$currency,'12',time());
PW_InsertNotification($_SESSION[pw_uid],$recipient_id,'You have rejected '.$amount.' '.$currency.' to '.idinfo($recipient_id,"first_name").' '.idinfo($recipient_id,"last_name"),$amount,$currency,'13',time());

$_SESSION['msg'] = success($lang['success_4']);
$_SESSION['msg_type'] = $lang['head_requests'];
$redirect = $settings['url']."account/summary";
header("Location: $redirect");
//echo '<script>alert("hello");</script>';
?>
