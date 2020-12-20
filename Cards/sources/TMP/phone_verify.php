<?php
//echo 'hello';
//echo '<script>alert("'.$_GET['id'].'");</script>';
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
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
global $db,$settings;
$GetU = $db->query("SELECT * FROM pw_users WHERE id='$_GET[id]' and phone_verified='0'");
if($GetU->num_rows==0){
    $redirect = $settings['url']."account/summary";
    header("Location: $redirect");
}
$gu = $GetU->fetch_assoc();
if(isset($_GET['id'])){
    $_SESSION['id'] = $_GET['id'];
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

        <title>Verify Phone - <?php echo $settings['name']; ?></title>

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
        <!--<div class="row no-gutters vh-100 loader-screen">
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
        </div>-->
        <!-- Loader ends -->

        <div class="wrapper">
            <!-- header -->
            <div class="header">
                <div class="row no-gutters">
                    <div class="col-auto">
                        <a href="<?php echo $settings['url']; ?>" class="btn  btn-link text-dark"><i class="material-icons">chevron_left</i></a>
                    </div>
                    <div class="col text-center"></div>
                    <div class="col-auto">
                    </div>
                </div>
            </div>
            <!-- header ends -->

            <div class="row no-gutters login-row">
                <div class="col align-self-center px-3 text-center">
                    <br>
                    <?php
                    $status = "send";
                    $FormBTN = protect($_POST['pw_verify']);
                    //echo $FormBTN;
                    if($FormBTN == "send_code") {
                        $phone = protect($_POST['phone']);
                        //echo '<script>alert("'.$phone.'");</script>';
                        if(empty($phone)) { 
                            echo error($lang['error_36']);
                        } elseif(!preg_match('/^\+(?:[0-9] ?){6,14}[0-9]$/',$phone)) {
							echo error("Invalid phone number.<br>Please enter in the following format: +11234567890");	
						} else{
                            $code = rand(100000,999999);
                            //echo '<script>alert("'.$code.'");</script>';
                            $update = $db->query("UPDATE pw_users SET phone_hash='$code' WHERE id='$_GET[id]'");
                            $msg = 'Your '.$settings['name'].' verification code is: '.$code;
                            //echo 'before sending';
                            PW_Send_SMS($phone,$msg);
                            //echo 'after sending';
                            //$CheckLogin = $db->query("SELECT * FROM pw_users WHERE email='$email'");
                            echo success("Your verification code has been sent");
                            $status = "verify";
						} 
                    }
                    elseif($FormBTN == "verify_code") {
                        $code = protect($_POST['code']);
                        if(strlen($code)!=6){
                            echo error("Invalid code");
                            $status = "verify";
                        }else{
                            $GetU = $db->query("SELECT * FROM pw_users WHERE id='$_SESSION[id]' and phone_hash='$code'");
                            if($GetU->num_rows==0){
                                echo error("Invalid code");
                                $status = "verify";
                            }
                            else{
                                $gu = $GetU->fetch_assoc();
                                $update = $db->query("UPDATE pw_users SET phone_verified='1' WHERE id='$_SESSION[id]'");
                                $msg = "Thank you for verification.";
                                echo success($msg);
                                $status = "verified";
                            }
                            
                        }
                        
                    }
                    if($status=="send"){?>
                        <h4>You need to verify your phone number before you can login and access the features.</h4>
                        <form class="form-signin mt-3 " action="" method="POST">
                        <div class="form-group">
                            <input id="phone_num" type="text" class="form-control form-control-lg text-center" value="<?php echo $gu['phone'];?>" name="phone" placeholder="Phone Number" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="pw_verify" value="send_code" class="btn btn-default btn-lg btn-rounded shadow btn-block" style="margin-top:5%;margin-bottom:5%;">Send code</button>
                        </div>
                        </form>
                    <?php }
                    elseif($status=="verify"){?>
                    <form class="form-signin mt-3 " action="" method="POST">
                        <div class="form-group">
                            <input type="number" class="form-control form-control-lg text-center" id="exampleInputEmail1" name="code" placeholder="Enter code here">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="pw_verify" value="verify_code" class="btn btn-default btn-lg btn-rounded shadow btn-block" style="margin-top:5%;margin-bottom:5%;">Verify code</button>
                        </div>
                        </form>
                    <?php } 
                    if($status=="verified"){
                        if($settings['require_email_verify'] == "1"){
                            $newUrl = $settings['url'].'login?msg=email_verify';
                        }
                        else{
                            $newUrl = $settings['url'].'login';
                        }
                    ?>
                    <p>You can login by clicking <a href="<?php echo $newUrl;?>">here.</a></p>
                    <?php }?>
                </div>
            </div>

            
            <!-- login buttons -->
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
        
    </body>