<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

function PW_EmailSys_Send_Generic($to,$subject,$text,$link) {
	global $db, $settings, $smtpconf;
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Host = $smtpconf["host"];
		$mail->Port = $smtpconf["port"];
		$mail->SMTPAuth = $smtpconf['SMTPAuth'];
		$mail->Username = $smtpconf["user"];
		$mail->Password = $smtpconf["pass"];
		$mail->setFrom($settings['infoemail'], $settings['name']);
		$mail->addAddress($to, $to);
		//Set the subject line
		$lang = array();
		$mail->Subject = $subject;
		$path =$_SERVER['DOCUMENT_ROOT'].'/prowallet_new/';
		$tpl = new Template($path."templates/Email_Templates/generic.tpl",$lang);
		$tpl->set("link",$link);
		$tpl->set("msg",$text);
		$tpl->set("url",$settings['url']);
		$tpl->set("name",$settings['name']);
		$email_template = $tpl->output();
		$mail->msgHTML($email_template);
		//Replace the plain text body with one created manually
		$mail->AltBody = $msg;
		//Attach an image file
		//send the message, check for errors
		$send = $mail->send();
		if($send) { 
			return true;
		} else {
			return false;
		}
	
}

function PW_EmailSys_Send_Invite($invite_to,$invite_by) {
	global $db, $settings, $smtpconf;
	$eQuery = $db->query("SELECT * FROM pw_users WHERE email='$invite_to'");
	if($eQuery->num_rows==0) {
		$row = $eQuery->fetch_assoc();
		$to = $invite_to;
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Host = $smtpconf["host"];
		$mail->Port = $smtpconf["port"];
		$mail->SMTPAuth = $smtpconf['SMTPAuth'];
		$mail->Username = $smtpconf["user"];
		$mail->Password = $smtpconf["pass"];
		$mail->setFrom($settings['infoemail'], $settings['name']);
		$mail->addAddress($to, $to);
		//Set the subject line
		$lang = array();
		$mail->Subject = 'Invitation to join '.$settings[name];
		$tpl = new Template("templates/Email_Templates/invite.tpl",$lang);
		$tpl->set("url",$settings['url']);
		$tpl->set("name",$settings['name']);
		$tpl->set("email",$invite_to);
		$email_template = $tpl->output();
		$mail->msgHTML($email_template);
		//Replace the plain text body with one created manually
		$mail->AltBody = 'You are invited to join '.$settings[name].' by your friend.';
		//Attach an image file
		//send the message, check for errors
		$send = $mail->send();
		if($send) { 
			return true;
		} else {
			return false;
		}
	}
	else{
	    //echo '<script>alert("hello");</script>';
	    return false;
	}
	
}



function PW_EmailSys_Send_Email_Verification($email) {
	global $db, $settings, $smtpconf;
	$eQuery = $db->query("SELECT * FROM pw_users WHERE email='$email'");
	if($eQuery->num_rows>0) {
		$row = $eQuery->fetch_assoc();
		$to = $row['email'];
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Host = $smtpconf["host"];
		$mail->Port = $smtpconf["port"];
		$mail->SMTPAuth = $smtpconf['SMTPAuth'];
		$mail->Username = $smtpconf["user"];
		$mail->Password = $smtpconf["pass"];
		$mail->setFrom($settings['infoemail'], $settings['name']);
		$mail->addAddress($to, $to);
		//Set the subject line
		$lang = array();
		$mail->Subject = 'Activate your '.$settings[name].' account';
		$tpl = new Template("templates/Email_Templates/Email_Verification.tpl",$lang);
		$tpl->set("url",$settings['url']);
		$tpl->set("name",$settings['name']);
		$tpl->set("email",$row['email']);
		$tpl->set("hash",$row['email_hash']);
		$email_template = $tpl->output();
		$mail->msgHTML($email_template);
		//Replace the plain text body with one created manually
		$mail->AltBody = '['.$settings[name].'] Account verification';
		//Attach an image file
		//send the message, check for errors
		$send = $mail->send();
		if($send) { 
			return true;
		} else {
			return false;
		}
	}
}

function PW_EmailSys_Send_Password_Reset($email) {
	global $db, $settings, $smtpconf;
	$eQuery = $db->query("SELECT * FROM pw_users WHERE email='$email'");
	if($eQuery->num_rows>0) {
		$row = $eQuery->fetch_assoc();
		$to = $row['email'];
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Host = $smtpconf["host"];
		$mail->Port = $smtpconf["port"];
		$mail->SMTPAuth = $smtpconf['SMTPAuth'];
		$mail->Username = $smtpconf["user"];
		$mail->Password = $smtpconf["pass"];
		$mail->setFrom($settings['infoemail'], $settings['name']);
		$mail->addAddress($to, $to);
		//Set the subject line
		$lang = array();
		$mail->Subject = 'Recover your '.$settings[name].' account password';
		$tpl = new Template("templates/Email_Templates/Password_Reset.tpl",$lang);
		$tpl->set("url",$settings['url']);
		$tpl->set("name",$settings['name']);
		$tpl->set("email",$row['email']);
		$tpl->set("hash",$row['password_recovery']);
		$email_template = $tpl->output();
		$mail->msgHTML($email_template);
		//Replace the plain text body with one created manually
		$mail->AltBody = 'Recover your '.$settings[name].' account password';
		//Attach an image file
		//send the message, check for errors
		$send = $mail->send();
		if($send) { 
			return true;
		} else {
			return false;
		}
	}
}

function PW_EmailSys_Send_2FA_Code($email,$code) {
	global $db, $settings, $smtpconf;
	$eQuery = $db->query("SELECT * FROM pw_users WHERE email='$email'");
	if($eQuery->num_rows>0) {
		$row = $eQuery->fetch_assoc();
		$to = $row['email'];
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Host = $smtpconf["host"];
		$mail->Port = $smtpconf["port"];
		$mail->SMTPAuth = $smtpconf['SMTPAuth'];
		$mail->Username = $smtpconf["user"];
		$mail->Password = $smtpconf["pass"];
		$mail->setFrom($settings['infoemail'], $settings['name']);
		$mail->addAddress($to, $to);
		//Set the subject line
		$lang = array();
		$mail->Subject = $settings[name].' 2FA';
		$tpl = new Template("templates/Email_Templates/2FA_Auth.tpl",$lang);
		$tpl->set("url",$settings['url']);
		$tpl->set("name",$settings['name']);
		$tpl->set("email",$row['email']);
		$tpl->set("code",$code);
		$email_template = $tpl->output();
		$mail->msgHTML($email_template);
		//Replace the plain text body with one created manually
		$mail->AltBody = $settings[name].' 2FA';
		//Attach an image file
		//send the message, check for errors
		$send = $mail->send();
		if($send) { 
			return true;
		} else {
			return false;
		}
	}
}

function PW_EmailSys_PaymentNotification($email,$amount,$currency,$description,$txid) {
	global $db, $settings, $smtpconf;
	$eQuery = $db->query("SELECT * FROM pw_users WHERE email='$email'");
	if($eQuery->num_rows>0) {
		$row = $eQuery->fetch_assoc();
		$to = $row['email'];
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Host = $smtpconf["host"];
		$mail->Port = $smtpconf["port"];
		$mail->SMTPAuth = $smtpconf['SMTPAuth'];
		$mail->Username = $smtpconf["user"];
		$mail->Password = $smtpconf["pass"];
		$mail->setFrom($settings['infoemail'], $settings['name']);
		$mail->addAddress($to, $to);
		//Set the subject line
		$lang = array();
		$mail->Subject = 'Payment Received';
		$tpl = new Template("templates/Email_Templates/Payment_Notification.tpl",$lang);
		$tpl->set("url",$settings['url']);
		$tpl->set("name",$settings['name']);
		$tpl->set("email",$row['email']);
		$tpl->set("amount",$amount);
		$tpl->set("currency",$currency);
		$tpl->set("description",$description);
		$tpl->set("txid",$txid);
		$email_template = $tpl->output();
		$mail->msgHTML($email_template);
		//Replace the plain text body with one created manually
		$mail->AltBody = $settings[name].' Payment Received';
		//Attach an image file
		//send the message, check for errors
		$send = $mail->send();
		if($send) { 
			return true;
		} else {
			return false;
		}
	}
}

function PW_EmailSys_PaymentRequestNotification($email,$amount,$currency,$description,$from) {
	global $db, $settings, $smtpconf;
	$eQuery = $db->query("SELECT * FROM pw_users WHERE email='$email'");
	if($eQuery->num_rows>0) {
		$row = $eQuery->fetch_assoc();
		$to = $row['email'];
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Host = $smtpconf["host"];
		$mail->Port = $smtpconf["port"];
		$mail->SMTPAuth = $smtpconf['SMTPAuth'];
		$mail->Username = $smtpconf["user"];
		$mail->Password = $smtpconf["pass"];
		$mail->setFrom($settings['infoemail'], $settings['name']);
		$mail->addAddress($to, $to);
		//Set the subject line
		$lang = array();
		$mail->Subject = $from.' request payment from you';
		$tpl = new Template("templates/Email_Templates/Payment_Request.tpl",$lang);
		$tpl->set("url",$settings['url']);
		$tpl->set("name",$settings['name']);
		$tpl->set("email",$row['email']);
		$tpl->set("amount",$amount);
		$tpl->set("currency",$currency);
		$tpl->set("description",$description);
		$tpl->set("from",$from);
		$email_template = $tpl->output();
		$mail->msgHTML($email_template);
		//Replace the plain text body with one created manually
		$mail->AltBody = $settings[name].' Payment Request';
		//Attach an image file
		//send the message, check for errors
		$send = $mail->send();
		if($send) { 
			return true;
		} else {
			return false;
		}
	}
}

function PW_EmailSys_NewDisputeMessage($email,$hash) {
	global $db, $settings, $smtpconf;
	$eQuery = $db->query("SELECT * FROM pw_users WHERE email='$email'");
	if($eQuery->num_rows>0) {
		$row = $eQuery->fetch_assoc();
		$to = $row['email'];
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Host = $smtpconf["host"];
		$mail->Port = $smtpconf["port"];
		$mail->SMTPAuth = $smtpconf['SMTPAuth'];
		$mail->Username = $smtpconf["user"];
		$mail->Password = $smtpconf["pass"];
		$mail->setFrom($settings['infoemail'], $settings['name']);
		$mail->addAddress($to, $to);
		//Set the subject line
		$lang = array();
		$mail->Subject = 'New message - Dispute: '.$hash;
		$tpl = new Template("templates/Email_Templates/New_Dispute_Message.tpl",$lang);
		$tpl->set("url",$settings['url']);
		$tpl->set("name",$settings['name']);
		$tpl->set("email",$row['email']);
		$tpl->set("hash",$hash);
		$email_template = $tpl->output();
		$mail->msgHTML($email_template);
		//Replace the plain text body with one created manually
		$mail->AltBody = $settings[name].' New Dispute Message';
		//Attach an image file
		//send the message, check for errors
		$send = $mail->send();
		if($send) { 
			return true;
		} else {
			return false;
		}
	}
}

function PW_EmailSys_DisputeClosed($email,$hash,$message,$custom_path="") {
	global $db, $settings, $smtpconf;
	$eQuery = $db->query("SELECT * FROM pw_users WHERE email='$email'");
	if($eQuery->num_rows>0) {
		$row = $eQuery->fetch_assoc();
		$to = $row['email'];
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Host = $smtpconf["host"];
		$mail->Port = $smtpconf["port"];
		$mail->SMTPAuth = $smtpconf['SMTPAuth'];
		$mail->Username = $smtpconf["user"];
		$mail->Password = $smtpconf["pass"];
		$mail->setFrom($settings['infoemail'], $settings['name']);
		$mail->addAddress($to, $to);
		//Set the subject line
		$lang = array();
		$mail->Subject = 'Dispute '.$hash.' was closed';
		$tpl = new Template($custom_path."templates/Email_Templates/Dispute_Closed.tpl",$lang);
		$tpl->set("url",$settings['url']);
		$tpl->set("name",$settings['name']);
		$tpl->set("email",$row['email']);
		$tpl->set("hash",$hash);
		$tpl->set("message",$message);
		$email_template = $tpl->output();
		$mail->msgHTML($email_template);
		//Replace the plain text body with one created manually
		$mail->AltBody = $settings[name].' Dispute was closed';
		//Attach an image file
		//send the message, check for errors
		$send = $mail->send();
		if($send) { 
			return true;
		} else {
			return false;
		}
	}
}
?>