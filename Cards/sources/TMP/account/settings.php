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
$c = protect($_GET['c']);
$redirect_profile = $settings['url']."account/settings/profile";
switch($c) {
    case "profile": include("settings/profile.php"); break;
    case "change_password": include("settings/change_password.php"); break;
    case "wallet_passphrase": include("settings/wallet_passphrase.php"); break;
    case "2fa": include("settings/2fa.php"); break;
    case "verification": include("settings/verification.php"); break;
    case "api_key": include("settings/api_key.php"); break;
    case "logs": include("settings/logs.php"); break;
    default: $default = "1";
}
if($default=="1"){
?>

<!doctype html>
<html lang="en" class="deeppurple-theme">


<!--Crypto Wallet -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="icrypto">

    <title>Settings</title>

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
                <div class="col-12 px-0">
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-dark mb-1">Email Notification</h6>
                                    <p class="text-secondary mb-0 small">Default all notification will be sent</p>
                                </div>
                                <div class="col-2 pl-0 align-self-center text-right">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1" checked>
                                        <label class="custom-control-label" for="customSwitch1"></label>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-dark mb-1">SMS Notification</h6>
                                    <p class="text-secondary mb-0 small">Receive SMS notification</p>
                                </div>
                                <div class="col-2 pl-0 align-self-center text-right">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch4" checked>
                                        <label class="custom-control-label" for="customSwitch4"></label>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-dark mb-1">Profile Availability</h6>
                                    <p class="text-secondary mb-0 small">Everyone can see my profile in search</p>
                                </div>
                                <div class="col-2 pl-0 align-self-center text-right">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch2">
                                        <label class="custom-control-label" for="customSwitch2"></label>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-dark mb-1">Sent Request</h6>
                                    <p class="text-secondary mb-0 small">Everyone can sent me a request</p>
                                </div>
                                <div class="col-2 pl-0 align-self-center text-right">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch3">
                                        <label class="custom-control-label" for="customSwitch3"></label>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <a href="<?php echo $settings['url']; ?>account/settings/change_password" class="row">
                                <div class="col">
                                    <h6 class="text-dark mb-1">Change password</h6>
                                    <p class="text-secondary mb-0 small">Remember to change your password</p>
                                </div>                                
                                <div class="col-2 pl-0 align-self-center text-right">
                                     <i class="material-icons text-secondary">chevron_right</i>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="<?php echo $settings['url']; ?>account/settings/profile" class="row">
                                <div class="col">
                                    <h6 class="text-dark mb-1">Edit Profile</h6>
                                    <p class="text-secondary mb-0 small">Change the details of your profile</p>
                                </div>                                
                                <div class="col-2 pl-0 align-self-center text-right">
                                     <i class="material-icons text-secondary">chevron_right</i>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="<?php echo $settings['url']; ?>account/settings/wallet_passphrase" class="row">
                                <div class="col">
                                    <h6 class="text-dark mb-1"><?php echo $lang['settings_wallet_passphrase']; ?></h6>
                                    <p class="text-secondary mb-0 small">Check or change wallet passphrase</p>
                                </div>                                
                                <div class="col-2 pl-0 align-self-center text-right">
                                     <i class="material-icons text-secondary">chevron_right</i>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="<?php echo $settings['url']; ?>account/settings/2fa" class="row">
                                <div class="col">
                                    <h6 class="text-dark mb-1"><?php echo $lang['settings_2fa']; ?></h6>
                                    <p class="text-secondary mb-0 small">Check 2FA</p>
                                </div>                                
                                <div class="col-2 pl-0 align-self-center text-right">
                                     <i class="material-icons text-secondary">chevron_right</i>
                                </div>
                            </a>
                        </li>
                        
                        <li class="list-group-item">
                            <a href="<?php echo $settings['url']; ?>account/settings/verification" class="row">
                                <div class="col">
                                    <h6 class="text-dark mb-1"><?php echo $lang['settings_verification']; ?></h6>
                                    <p class="text-secondary mb-0 small">Check 2FA</p>
                                </div>                                
                                <div class="col-2 pl-0 align-self-center text-right">
                                     <i class="material-icons text-secondary">chevron_right</i>
                                </div>
                            </a>
                        </li>
                        <?php if(idinfo($_SESSION['pw_uid'],"account_type") == "2") { ?>
                        <li class="list-group-item">
                            <a href="<?php echo $settings['url']; ?>account/settings/api_key" class="row">
                                <div class="col">
                                    <h6 class="text-dark mb-1"><?php echo $lang['settings_merchant_api_key']; ?></h6>
                                    <p class="text-secondary mb-0 small">Check 2FA</p>
                                </div>                                
                                <div class="col-2 pl-0 align-self-center text-right">
                                     <i class="material-icons text-secondary">chevron_right</i>
                                </div>
                            </a>
                        </li>
                        <?php }?>
                        <li class="list-group-item">
                            <a href="<?php echo $settings['url']; ?>account/settings/logs" class="row">
                                <div class="col">
                                    <h6 class="text-dark mb-1"><?php echo $lang['settings_account_logs']; ?></h6>
                                    <p class="text-secondary mb-0 small">Check 2FA</p>
                                </div>                                
                                <div class="col-2 pl-0 align-self-center text-right">
                                     <i class="material-icons text-secondary">chevron_right</i>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="<?php echo $settings['url']; ?>logout" class="row">
                                <div class="col">
                                    <h6 class="text-dark mb-1">Logout</h6>
                                    <p class="text-secondary mb-0 small">Logout from the account.</p>
                                </div>                                
                                <div class="col-2 pl-0 align-self-center text-right">
                                     <i class="material-icons text-secondary">chevron_right</i>
                                </div>
                            </a>
                        </li>
                    </ul>
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
    <?php } ?>
