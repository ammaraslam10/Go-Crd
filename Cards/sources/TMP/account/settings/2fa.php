<?php
// Crypto Wallet
// Author: Crypto Wallet 
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

if(!checkSession()) {
    $redirect = $settings['url']."login";
    header("Location: $redirect");
}   
?>

<?php
$ga = new GoogleAuthenticator();
$FormBTN = protect($_POST['pw_2fa']);
if($FormBTN == "enable") {
    if(idinfo($_SESSION['ew_uid'],"googlecode")) {
        $secret = idinfo($_SESSION['pw_uid'],"googlecode");
        $_SESSION['pw_secret'] = $secret;
    } else {
        $secret = $ga->createSecret();
        $_SESSION['pw_secret'] = $secret;
    }
    $update = $db->query("UPDATE pw_users SET 2fa_auth='1',2fa_auth_login='1',2fa_auth_send='1',2fa_auth_withdrawal='1',googlecode='$secret' WHERE id='$_SESSION[pw_uid]'");    
}
if($FormBTN == "disable") {
    $update = $db->query("UPDATE pw_users SET 2fa_auth='0' WHERE id='$_SESSION[pw_uid]'");
}
?>
<!doctype html>
<html lang="en" class="deeppurple-theme">


<!--Crypto Wallet -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="icrypto">

    <title>Settings - 2FA</title>

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
    <!-- Loader -->
    <div class="row no-gutters vh-100 loader-screen">
        <div class="col align-self-center text-white text-center">
            <img src="<?php echo $settings['url']; ?>icrypto_assets/img/logo.png" alt="logo">
            <h1 class="mt-3"><span class="font-weight-light ">Crypto</span>Wallet</h1>
            <p class="text-mute text-uppercase small">Mobile Template</p>
            <div class="laoderhorizontal">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <!-- Loader ends -->
    
    <!-- sidebar -->
    <?php include('includes/sidebar.php'); ?>
    <!-- sidebar ends -->
    
    <div class="wrapper">
        <!-- header -->
        <?php include('includes/header.php'); ?>
        <!-- header ends -->
        
        <div class="container">            
            <div class="row mt-3">
                <div class="col text-center">
                    <h3><?php echo $lang['head_2fa']; ?></h3>
                    <p><?php echo $lang['head_2fa_info']; ?></p>
                    <hr/>
                    <?php if(idinfo($_SESSION['pw_uid'],"2fa_auth") == "1") { ?>
                    <form class="user-connected-from user-signup-form" action="" method="POST">
                        <?php echo $lang['currency_status']; ?>: <span class="badge badge-success"><?php echo $lang['enabled']; ?></span>
                        <button type="submit" name="pw_2fa" value="disable" class="btn btn-danger float-right"><?php echo $lang['btn_14']; ?></button>
                    </form>
                    <br>
                    <form action="" method="POST">
                    <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <div class="custom-checkbox-wrap">
                                    <input type="checkbox" class="custom-control-input" id="2fa_auth_login" name="2fa_auth_login" <?php if(idinfo($_SESSION['pw_uid'],"2fa_auth_login") == "1") { echo 'checked'; } ?> value="yes">
                                    <label class="custom-control-label" for="2fa_auth_login">Require Google Authenticator code when login</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <div class="custom-checkbox-wrap">
                                    <input type="checkbox" class="custom-control-input" id="2fa_auth_send" name="2fa_auth_send" <?php if(idinfo($_SESSION['pw_uid'],"2fa_auth_send") == "1") { echo 'checked'; } ?> value="yes">
                                    <label class="custom-control-label" for="2fa_auth_send">Require Google Authenticator code when send funds from your wallet</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <div class="custom-checkbox-wrap">
                                    <input type="checkbox" class="custom-control-input" id="2fa_auth_withdrawal" name="2fa_auth_withdrawal" <?php if(idinfo($_SESSION['pw_uid'],"2fa_auth_withdrawal") == "1") { echo 'checked'; } ?> value="yes">
                                    <label class="custom-control-label" for="2fa_auth_withdrawal">Require Google Authenticator code when withdrawal funds from your wallet</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="pw_2fa" value="save"  class="btn btn-default btn-rounded btn-block col" style="padding:12px;">Save Changes</button>
                    </form>
                    <br>
                    <h3>Configurate your device</h3>
                    <p>Download Google Authenticator and Scan QR Code below or enter your token manually.</p>
                    <hr/>
                    <?php
                    $qrCodeUrl 	= $ga->getQRCodeGoogleUrl(idinfo($_SESSION['pw_uid'],"email"), $_SESSION['pw_secret'], $settings['name']); 
                    ?>
                        Token: <span class="float-right"><?php echo idinfo($_SESSION['pw_uid'],"googlecode"); ?></span><br><br>
                        <center><img src='<?php echo $qrCodeUrl; ?>'><br>
                                <a class="" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">
                                        <img src="<?php echo $settings['url']; ?>assets/images/android.png" width="150px">
                                </a> 
                                <a class="" href="https://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8" target="_blank">
                                    <img src="<?php echo $settings['url']; ?>assets/images/iphone.png" width="150px">
                                </a>
                                </center>
                    <?php } else { ?>
                        <form class="user-connected-from user-signup-form" action="" method="POST">
                        <?php echo $lang['currency_status']; ?>: <span class="badge badge-danger"><?php echo $lang['disabled']; ?></span>
                        <br>
                        <br>
                        <button type="submit" name="pw_2fa" value="enable" class="btn btn-default btn-rounded"><?php echo $lang['btn_15']; ?></button>
                        </form>
                    <?php } ?>
                    </div>
            </div>
        </div>
        <!-- footer-->
        <?php include('includes/footer.php'); ?>
        <!-- footer ends-->
    </div>

    
    
    <!-- color chooser menu start -->
    <div class="modal fade " id="colorscheme" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content ">
                <div class="modal-header theme-header border-0">
                    <h6 class="">Color Picker</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="text-center theme-color">
                        <button class="m-1 btn red-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="red-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn blue-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="blue-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn yellow-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="yellow-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn green-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="green-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn pink-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="pink-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn orange-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="orange-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn purple-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="purple-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn deeppurple-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="deeppurple-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn lightblue-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="lightblue-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn teal-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="teal-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn lime-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="lime-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn deeporange-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="deeporange-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn gray-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="gray-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn black-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="black-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-6 text-left">
                        <div class="row">
                            <div class="col-auto text-right align-self-center"><i class="material-icons text-warning vm">wb_sunny</i></div>
                            <div class="col-auto text-center align-self-center px-0">
                                <div class="custom-control custom-switch float-right">
                                    <input type="checkbox" name="themelayout" class="custom-control-input" id="theme-dark">
                                    <label class="custom-control-label" for="theme-dark"></label>
                                </div>
                            </div>
                            <div class="col-auto text-left align-self-center"><i class="material-icons text-dark vm">brightness_2</i></div>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <div class="row">
                            <div class="col-auto text-right align-self-center">LTR</div>
                            <div class="col-auto text-center align-self-center px-0">
                                <div class="custom-control custom-switch float-right">
                                    <input type="checkbox" name="rtllayout" class="custom-control-input" id="theme-rtl">
                                    <label class="custom-control-label" for="theme-rtl"></label>
                                </div>
                            </div>
                            <div class="col-auto text-left align-self-center">RTL</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- color chooser menu ends -->


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

    <!-- page level script -->
    <script>
        $(window).on('load', function() {

        });

    </script>
</body>


<!--Crypto Wallet -->
</html>