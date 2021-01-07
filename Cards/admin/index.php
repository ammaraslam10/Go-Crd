<?php
// Crypto Wallet
// Author: Crypto Wallet
if(file_exists("./install.php")) {
	header("Location: ./install.php");
} 
define('PWV1_INSTALLED',TRUE);
ob_start();
session_start();
error_reporting(0);
//error_reporting(E_ALL);
include("../configs/bootstrap.php");
include("../includes/bootstrap.php");
$file_url = '../uploads/su';
$to_search = '../uploads/su';
$img_url = get_image($file_url,$to_search);

//if(checkAdminSession()) {
//	include("sources/header.php");
	$a = protect($_GET['a']);
	//echo $a;
	switch($a) {
		case "su": include("super_admin.php"); break;

		case "user_information": include("user_info.php"); break;
		case "admin_information": include("admin_info.php"); break;
		case "direct_user_card_information": include("usercard_info.php"); break;
		case "admin_user_card_information": include("admincard_info.php"); break;
		case "edit_profile": include("edit-profile.php"); break;
		case "sending_methods": include("sources/sending_methods.php"); break;
		case "withdrawals": include("sources/withdrawals.php"); break;
		case "transactions": include("sources/transactions.php"); break;
		case "merchant_payments": include("sources/merchant_payments.php"); break;
		case "knowledge": include("sources/knowledge.php"); break;
		case "verification_settings": include("sources/verification_settings.php"); break;
		case "languages": include("sources/languages.php"); break;
		case "update_logo": include("sources/update_logo.php"); break;
		case "pages": include("sources/pages.php"); break;
		case "smtp_settings": include("sources/smtp_settings.php"); break;
		case "logs": include("sources/logs.php"); break;
		case "settings": include("sources/settings.php"); break;
		case "currencyconverter_settings": include("sources/currencyconverter_settings.php"); break;
		case "recaptcha_settings": include("sources/recaptcha_settings.php"); break;
		case "admin_profits": include("sources/admin_profits.php"); break;
		case "logout": 
			unset($_SESSION['pw_admin_uid']);
			unset($_COOKIE['pw_admin_uid']);
			setcookie("pw_admin_uid", "", time() - (86400 * 30), '/'); // 86400 = 1 day
			session_unset();
			session_destroy();
			header("Location: $settings[url]");
		break;
		default: include("sources/dashboard.php");
	}
//	include("sources/footer.php");
//} else {
//	include("sources/login.php");
//}
mysqli_close($db);
?>