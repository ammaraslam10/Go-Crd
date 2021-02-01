<?php
if(file_exists("./install.php")) {
	header("Location: ./install.php");
} 
define('PWV1_INSTALLED',TRUE);
ob_start();
session_start();
//error_reporting(E_ALL);
include("configs/bootstrap.php");
include("includes/bootstrap.php");
//include(getLanguage($settings['url'],null,null));

$a = protect($_GET['a']);
error_reporting(0);
//echo '<script>alert("'.$a.'");</script>';
switch($a) {
	case "admin": include("sources/"); break;

	//case "notifications": include("sources/account/summary.php"); break;
	case "login": include("sources/login.php"); break;
	case "register": include("sources/register.php"); break;
	case "password": include("sources/password.php"); break;
	case "email_verify": include("sources/email_verify.php"); break;
	case "phone_verify": include("sources/phone_verify.php"); break;
	case "page": include("sources/page.php"); break;
	case "contacts": include("sources/contacts.php"); break;
	case "merchant": include("sources/merchant.php"); break;
	case "knowledge": include("sources/knowledge.php"); break;
	case "payment": include("sources/payment.php"); break;
	case "deposit": include("sources/deposit.php"); break;
	case "": include("sources/home.php"); break;
	case "create-card": include("sources/card_create.php"); break;
	case "edit-card": include("sources/card_edit.php"); break;
	case "view-card-messages": include("sources/card_messages.php"); break;
	case "image-upload": include("sources/image_upload.php"); break;
	case "logout": 
		unset($_SESSION['pw_uid']);
		unset($_COOKIE['prowall_uid']);
		setcookie("prowall_uid", "", time() - (86400 * 30), '/'); // 86400 = 1 day
		session_unset();
		session_destroy();
		header("Location: $settings[url]");
	break;
	default: include("sources/card_view.php"); break;
	
}
mysqli_close($db);
?>