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
if(!isset($_SESSION['try'])){
    $_SESSION['try'] = 0;
}
$type = protect($_GET['type']);
if($type == "auth") {
    $auth_id = $_SESSION['pw_auth_uid'];
    $query = $db->query("SELECT * FROM pw_users WHERE id='$auth_id'");
    if($query->num_rows==0) { 
        $redirect = $settings['url']."login";
        header("Location: $redirect");
    }
    $u = $query->fetch_assoc();
    $ga 		= new GoogleAuthenticator();
    $qrCodeUrl 	= $ga->getQRCodeGoogleUrl(idinfo($_SESSION['pw_auth_uid'],"email"), $_SESSION['pw_secret'], $settings['name']);
    ?>
    <!doctype html>
    <html lang="en" class="deeppurple-theme">
    <!--Crypto Wallet -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="icrypto">

        <title><?php echo $lang['title_2fa']; ?> - <?php echo $settings['name']; ?></title>

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
                    <img src="<?php echo $settings['url']; ?>icrypto_assets/img/logo-login.png" alt="logo" class="logo-small">
                    <?php
                    $FormBTN = protect($_POST['pw_auth']);
                    if($FormBTN == "auth") {
                        $code = protect($_POST['code']);
                        $checkResult = $ga->verifyCode($_SESSION['pw_secret'], $code, 2);    // 2 = 2*30sec clock tolerance
                        if($checkResult) {
                                    $_SESSION['pw_auth_code'] = false;
                                    $_SESSION['pw_auth_id'] = false;
                                    $_SESSION['pw_uid'] = $u['id'];
                                    $last_login = $login['last_login']+5000;
                                    if(time() > $last_login) {
                                        $time = time();
                                        $update = $db->query("UPDATE pw_users SET last_login='$time' WHERE id='$u[id]'");
                                    }
                                    $time = time();
                                    $login_ip = $_SERVER['REMOTE_ADDR'];
                                    $insert = $db->query("INSERT pw_users_logs (uid,type,time,u_field_1) VALUES ('$u[id]','1','$time','$login_ip')");
                                    if($_SESSION['pw_payorder_url']) {
                                        $redirect = $_SESSION['pw_payorder_url'];
                                        header("Location: $redirect");
                                    } else {
                                        $redirect = $settings['url']."account/summary";
                                        header("Location: $redirect");
                                    }
                        } else {
                            echo error($lang['error_51']);
                        }
                    } 
                    ?>
                    <form class="form-signin mt-3 " action="" method="POST">
                    <div class="form-group">
                        <input type="email" class="form-control form-control-lg text-center" id="exampleInputEmail1" disabled value="<?php echo $u['email']; ?>" name="email" placeholder="<?php echo $lang['placeholder_3']; ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg text-center" id="exampleInputAuth" name="code" placeholder="<?php echo $lang['placeholder_12']; ?>">
                    </div>
                        <!--<div class="form-group my-4 text-left">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="rememberme">
                                <label class="custom-control-label" for="rememberme">Remember Me</label>
                            </div>
                        </div>-->
                        
                        <a href="<?php echo $settings['url']; ?>password/reset" class="mt-4 d-block"><?php echo $lang['forgot_password']; ?></a>
                    <!-- login buttons --><div class="form-group">
                            <button type="submit" name="pw_auth" value="auth" class="btn btn-default btn-lg btn-rounded shadow btn-block" style="margin-top:5%;margin-bottom:5%;"><?php echo $lang['btn_29']; ?></button>
                            </div>
                    </form>
                    <p><?php echo $lang['do_not_have_an_account']; ?>  <a href="<?php echo $settings['url']; ?>register"> <?php echo $lang['register']; ?></a></p>
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
    <!--Crypto Wallet -->
    </html>
    <?php
} 
else {
?>
<!doctype html>
    <html lang="en" class="deeppurple-theme">
    <!--Crypto Wallet -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="icrypto">

        <title><?php echo $lang['title_2fa']; ?> - <?php echo $settings['name']; ?></title>

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
                    <img src="<?php echo $settings['url']; ?>icrypto_assets/img/logo-login.png" alt="logo" class="logo-small">
                    <br>
                    <?php
                    if(isset($_GET['msg'])){
                        if($_GET['msg']=='change_password'){
                            echo success('Your password has been changed successfully, <br>You must login with the new password again.');
                        }
                        if($_GET['msg']=='email_verify'){
                            echo success('Thank you for registering. We\'ve sent a verification link to the email address '.idinfo($_SESSION[uid],"email").'. Please click the in the email to confirm then come back here to login.');
                            //session_destroy();
                        }
                    }
                    $FormBTN = protect($_POST['pw_login']);
                    if($FormBTN == "login") {
                        $email = protect($_POST['email']);
                        $password = protect($_POST['password']);
                        $recaptcha_response = protect($_POST['g-recaptcha-response']);
                            
                        $CheckLogin = $db->query("SELECT * FROM pw_users WHERE email='$email'");
                        if(empty($email) or empty($password)) { 
                            echo error($lang['error_36']);
                        } elseif($CheckLogin->num_rows==0) {
                            echo error($lang['error_37']);
                        } elseif($settings['enable_recaptcha'] == "1" && $_SESSION['try']>=3 && !VerifyGoogleRecaptcha($recaptcha_response)) {
                            echo error($lang['error_52']);  
                        }
                        else {
                            $login = $CheckLogin->fetch_assoc();
                            if(password_verify($password, $login['password'])) {
                                //password correct
                                if($login['status'] == "11") {
                                    echo error($lang['error_38']);
                                }
                                else if($settings['require_phone_verify']=="1" && $login['phone_verified']=="0"){
                                    $newURL=$settings['url'].'phone-verify/?id='.$login['id'];
                                    header('Location: '.$newURL);
                                }
                                else if($settings['require_email_verify']=="1" && $login['email_verified']=="0"){
                                    echo error("You need to verify your email address before you can login.");
                                }
                                else {
                                    if($login['2fa_auth'] == "1" && $login['2fa_auth_login'] == "1") {
                                        $_SESSION['pw_auth_uid'] = $login['id'];
                                        $_SESSION['pw_secret'] = $login['googlecode'];
                                        $_SESSION['pw_auth_code'] = strtoupper(randomHash(7));
                                        //PW_EmailSys_Send_2FA_Code($login['email'],$_SESSION['pw_auth_code']);
                                        $redirect = $settings['url']."login/auth";
                                        header("Location: $redirect");
                                    } else {
                                        $_SESSION['pw_uid'] = $login['id'];
                                        $_SESSION['start'] = time();
                                        $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);

                                        if(protect($_POST['remember_me']) == "yes") {
                                            setcookie("prowall_uid", $login['id'], time() + (86400 * 30), '/'); // 86400 = 1 day
                                        }
                                        $last_login = $login['last_login']+5000;
                                        if(time() > $last_login) {
                                            $time = time();
                                            $update = $db->query("UPDATE pw_users SET last_login='$time' WHERE id='$login[id]'");
                                        }
                                        $time = time();
                                        $login_ip = $_SERVER['REMOTE_ADDR'];
                                        $insert = $db->query("INSERT pw_users_logs (uid,type,time,u_field_1) VALUES ('$login[id]','1','$time','$login_ip')");
                                        if($_SESSION['pw_payorder_url']) {
                                            $redirect = $_SESSION['pw_payorder_url'];
                                            header("Location: $redirect");   
                                        } else {
                                            $redirect = $settings['url']."account/summary";
                                            header("Location: $redirect");
                                        }
                                    }
                                }
                            } else {
                                $_SESSION['try'] = $_SESSION['try'] + 1;
                                echo error($lang['error_37']);
                            }
                        }
                    }
                    ?>
                    <form class="form-signin mt-3 " action="" method="POST">
                    <div class="form-group">
                        <input type="email" class="form-control form-control-lg text-center" id="exampleInputEmail1" value="<?php echo $email;?>" name="email" placeholder="<?php echo $lang['placeholder_3']; ?>">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-lg text-center" id="exampleInputPassword1" value="<?php echo $password;?>" name="password" placeholder="<?php echo $lang['placeholder_11']; ?>">
                    </div>
                    <?php if($settings['enable_recaptcha'] == "1" && $_SESSION['try']>=3) { ?>
                        <center><script src="https://www.google.com/recaptcha/api.js" async defer></script>
                        <div class="g-recaptcha" data-sitekey="<?php echo $settings['recaptcha_publickey']; ?>"></div></center>
                        <br>
                    <?php } ?>
                        <!--<div class="form-group my-4 text-left">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="rememberme">
                                <label class="custom-control-label" for="rememberme">Remember Me</label>
                            </div>
                        </div>-->
                        <a href="<?php echo $settings['url']; ?>password/reset" class="mt-4 d-block"><?php echo $lang['forgot_password']; ?></a>
                    <!-- login buttons -->
                    <div class="form-group">
                            <button type="submit" name="pw_login" value="login" class="btn btn-default btn-lg btn-rounded shadow btn-block" style="margin-top:5%;margin-bottom:5%;"><?php echo $lang['btn_27']; ?></button>
                    </div>
                    </form>
                    <p><?php echo $lang['do_not_have_an_account']; ?>  <a href="<?php echo $settings['url']; ?>register"> <?php echo $lang['register']; ?></a></p>
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
<?php
}
?>