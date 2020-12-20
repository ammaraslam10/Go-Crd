<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

if(checkSession()) {
    $redirect = $settings['url']."account/summary";
    header("Location: $redirect");
}

$hash = protect($_GET['hash']);
$query = $db->query("SELECT * FROM pw_users WHERE email_hash='$hash'");
if($query->num_rows==0) { header("Location: $settings[url]"); }
$row = $query->fetch_assoc();
$update = $db->query("UPDATE pw_users SET email_hash='',email_verified='1',status='1' WHERE id='$row[id]'");

//send email for KYC
if($settings['require_document_verify']=='1'){
    $to = $row['email'];
    $subject = "We need more information in ".$settings['name'];
    $text = "Thank you for verifying your email. Please move a step ahead and provide us with your required documents so you can send funds without any limits.";
    $link = $settings['url'].'account/settings/verification';
    PW_EmailSys_Send_Generic($to,$subject,$text,$link);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="icrypto">

        <title>Email Verify <?php echo $lang['title_account']; ?></title>

        <!-- Material design icons CSS -->
        <link rel="stylesheet" href="<?php echo $settings['url']; ?>icrypto_assets/vendor/materializeicon/material-icons.css">

        <!-- Roboto fonts CSS -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">

        <!-- Bootstrap core CSS -->
        <link href="<?php echo $settings['url']; ?>icrypto_assets/vendor/bootstrap-4.4.1/css/bootstrap.min.css" rel="stylesheet">

        <!-- Swiper CSS -->
        <link href="<?php echo $settings['url']; ?>icrypto_assets/vendor/swiper/css/swiper.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?php echo $settings['url']; ?>icrypto_assets/css/style.css" rel="stylesheet">
    </head>
<body>
    <div class="user-login-signup-section modal-container">
        <div class="container">
            <div class="user-login-signup-form-wrap">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="user-connected-form-block">
                        <h3><?php echo $lang['title_email_verification']; ?></h3>
                        <hr/>
                            <div class="alert alert-success">
                                <i class="fa fa-check"></i> <?php echo $lang['success_18']; ?>
                            </div>
                            <h6>You can now <a href="<?php echo $settings['url'].'login'?>">login</a> to your account</h6>
                        </div><!-- create-account-block -->
                    </div>
                </div>
            </div><!-- user-login-signup-form-wrap -->
        </div>
        <div class="container">
                <div class="col-md-12 prowallet-footer-text-white">
                    <center>Copyright &copy; 2020 <?php echo $settings['name']; ?>.</center>
                </div>  
        </div>
    </div><!-- user-login-signup-section -->
    
    <!-- jquery, popper and bootstrap js -->
    <script src="<?php echo $settings['url']; ?>icrypto_assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo $settings['url']; ?>icrypto_assets/js/popper.min.js"></script>
    <script src="<?php echo $settings['url']; ?>icrypto_assets/vendor/bootstrap-4.4.1/js/bootstrap.min.js"></script>

    <!-- swiper js -->
    <script src="<?php echo $settings['url']; ?>icrypto_assets/vendor/swiper/js/swiper.min.js"></script>

    <!-- cookie js -->
    <script src="<?php echo $settings['url']; ?>icrypto_assets/vendor/cookie/jquery.cookie.js"></script>

    <!-- template custom js -->
    <script src="<?php echo $settings['url']; ?>icrypto_assets/js/main.js"></script>
</body>
</html>
