<?php
// Crypto Wallet
// Author: Crypto Wallet
define('PWV1_INSTALLED',TRUE);
ob_start();
session_start();
error_reporting(0);
include("../configs/bootstrap.php");
include("../includes/bootstrap.php");
//include("../languages/".$settings[default_language].".php");

if(checkSession()) {
    $id = protect($_GET['id']);
    
    $query = $db->query("SELECT * FROM pw_users_wallets WHERE id='$id' and uid='$_SESSION[pw_uid]'");
    if($query->num_rows>0) {
        $row = $query->fetch_assoc();
        echo $row['currency'];
    } 
}
?>