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
<!doctype html>
<html lang="en" class="deeppurple-theme">


<!--Crypto Wallet -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="icrypto">

    <title>Settings - Wallet Passphrase</title>

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
                <h3><?php echo $lang['head_wallet_passphrase']; ?></h3>
                <p><?php echo $lang['head_wallet_passphrase_info']; ?></p>
                <hr/>
                <?php
                $FormBTN = protect($_POST['pw_passphrase']);
                if($FormBTN == "setup") {
                    $passphrase = protect($_POST['passphrase']);
                    if(empty($passphrase)) {
                        echo error($lang['error_28']);
                    } elseif(strlen($passphrase)<6) {
                        echo error($lang['error_29']);  
                    } else {
                        $passphrase = password_hash($passphrase, PASSWORD_DEFAULT);
                        $update = $db->query("UPDATE pw_users SET wallet_passphrase='$passphrase' WHERE id='$_SESSION[pw_uid]'");
                        echo success($lang['success_13']);
                    }
                }
                if($FormBTN == "change") {
                    $cpassphrase = protect($_POST['cpassphrase']);
                    $npassphrase = protect($_POST['npassphrase']);
                    $cnpassphrase = protect($_POST['cnpassphrase']);
                    if(!password_verify($cpassphrase, idinfo($_SESSION['pw_uid'],"wallet_passphrase"))) {
                        echo error($lang['error_30']);
                    } elseif(empty($npassphrase)) {
                        echo error($lang['error_28']);
                    } elseif($npassphrase !== $cnpassphrase) {
                        echo error($lang['error_31']);
                    } else {
                        $passphrase = password_hash($npassphrase, PASSWORD_DEFAULT);
                        $update = $db->query("UPDATE pw_users SET wallet_passphrase='$passphrase' WHERE id='$_SESSION[pw_uid]'");
                        echo success($lang['success_14']);
                    }
                } 
                if($FormBTN == "remove") {
                    $cpassphrase = protect($_POST['cpassphrase']);
                    if(!password_verify($cpassphrase, idinfo($_SESSION['pw_uid'],"wallet_passphrase"))) {
                        echo error($lang['error_32']);
                    } else {
                        $update = $db->query("UPDATE pw_users SET wallet_passphrase='' WHERE id='$_SESSION[pw_uid]'");
                        echo success($lang['success_15']);
                    }
                }
                ?>
                
                <?php
                if(empty(idinfo($_SESSION['pw_uid'],"wallet_passphrase"))) {
                ?>
                <form class="user-connected-from user-signup-form" action="" method="POST">
                <div class="form-group">
                        <label><?php echo $lang['field_21']; ?></label>
                        <input type="password" class="form-control" name="passphrase">
                    </div>
                    <button type="submit" name="pw_passphrase" value="setup" class="btn btn-default btn-rounded btn-block col" style="padding:12px;"><?php echo $lang['btn_20']; ?></button>
                </form>
                <?php 
                } else {
                ?>
                <form class="user-connected-from user-signup-form" action="" method="POST">
                <div class="form-group">
                        <label><?php echo $lang['field_22']; ?></label>
                        <input type="password" class="form-control" name="cpassphrase">
                    </div>
                    <div class="form-group">
                        <label><?php echo $lang['field_21']; ?></label>
                        <input type="password" class="form-control" name="npassphrase">
                    </div>
                    <div class="form-group">
                        <label><?php echo $lang['field_23']; ?></label>
                        <input type="password" class="form-control" name="cnpassphrase">
                    </div>
                    <button type="submit" name="pw_passphrase" value="change" class="btn btn-default btn-rounded btn-block col" style="padding:12px;"><?php echo $lang['btn_17']; ?></button> 
                    <button type="submit" name="pw_passphrase" value="remove" class="btn btn-default btn-rounded btn-block col" style="padding:12px;"><?php echo $lang['btn_21']; ?></button>
                </form>
                <?php
                }
                ?>
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