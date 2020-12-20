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

$b = protect($_GET['b']);

if($b == "reset") {
?>
<!doctype html>

    <html lang="en" class="deeppurple-theme">

    <!--Crypto Wallet -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
        <meta name="author" content="icrypto">
        <title><?php echo $lang['title_reset_account_password']; ?> - <?php echo $settings['name']; ?></title>
        <meta name="description" content="<?php echo $settings['description']; ?>">   

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
                        $FormBTN = protect($_POST['pw_reset']);
                        if($FormBTN == "reset") {
                            $email = protect($_POST['email']);
                            $recaptcha_response = protect($_POST['g-recaptcha-response']);
                            if(empty($email)) {
                                echo error($lang['error_40']);
                            } elseif(PW_CheckUser($email)==false) {
                                echo error($lang['error_41']);
                            } elseif($settings['enable_recaptcha'] == "1" && !VerifyGoogleRecaptcha($recaptcha_response)) {
                                echo error($lang['error_52']);  
                            } else {
                                $hash = randomHash(25);
                                $update = $db->query("UPDATE pw_users SET password_recovery='$hash' WHERE email='$email'");
                                PW_EmailSys_Send_Password_Reset($email);
                                echo success($lang['success_20']);
                            }
                        }
                    ?>
                    <form class="form-signin mt-3 " action="" method="POST">
                        <div class="form-group">
                            <input type="email" class="form-control form-control-lg text-center" name="email" placeholder="<?php echo $lang['placeholder_3']; ?>">
                        
                        </div>

                        <!--<div class="form-group my-4 text-left">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="rememberme">
                                <label class="custom-control-label" for="rememberme">Remember Me</label>
                            </div>
                        </div>-->
                        
                        <p class="text-secondary mt-4 d-block">If you already have password,<br>please <a href="<?php echo $settings['url']; ?>login" class="">Sign in</a> here</p>
                        <?php if($settings['enable_recaptcha'] == "1") { ?>
                            <center><script src="https://www.google.com/recaptcha/api.js" async defer></script>
                            <div class="g-recaptcha" data-sitekey="<?php echo $settings['recaptcha_publickey']; ?>"></div></center>
                            <br>
                        <?php } ?>
                        <button type="submit" name="pw_reset" value="reset" class="btn btn-default btn-lg btn-rounded shadow btn-block"><?php echo $lang['btn_16']; ?></button>
                    </form>
                    <p style="margin-top:2%;"><?php echo $lang['do_not_have_an_account']; ?>  <a href="<?php echo $settings['url']; ?>register"> <?php echo $lang['register']; ?></a></p>
                </div>
            </div>

            <!-- login buttons -->
            <!--
            <div class="row mx-0 bottom-button-container">
                <div class="col">
                    <a href="change-password.html" class="btn btn-default btn-lg btn-rounded shadow btn-block">Reset Password</a>
                </div>
            </div>-->
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
elseif($b == "change") {
    $hash = protect($_GET['hash']);
    if(empty($hash)) { header("Location: $settings[url]"); }
    $CheckUser = $db->query("SELECT * FROM pw_users WHERE password_recovery='$hash'");
    if($CheckUser->num_rows==0) { header("Location: $settings[url]"); }
    $u = $CheckUser->fetch_assoc();
    $old_password = $u['password'];
?>
<!doctype html>

    <html lang="en" class="deeppurple-theme">

    <!--Crypto Wallet -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
        <meta name="author" content="icrypto">
        <title><?php echo $lang['title_reset_account_password']; ?> - <?php echo $settings['name']; ?></title>
        <meta name="description" content="<?php echo $settings['description']; ?>">   

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
                        $HideChangeForm = 0;
                        $FormBTN = protect($_POST['pw_change']);
                        if($FormBTN == "change") {
                            $password = protect($_POST['password']);
                            $cpassword = protect($_POST['cpassword']);
                            $new_password = password_hash($password, PASSWORD_DEFAULT);
                            //echo '<script>alert("new is: '.$new_password.'");</script>';
                            //echo '<script>alert("old is: '.$old_password.'");</script>';
                            ///echo '<script>alert("new is: '.idinfo($u[id],"password").'");</script>';
                            if(empty($password)) { 
                                echo error($lang['error_42']);
                            } elseif(strlen($password)<8) { 
                                echo error($lang['error_43']);
                            } elseif($password !== $cpassword) {
                                echo error($lang['error_44']);
                            } elseif(password_verify($cpassword, idinfo($u['id'],"password"))) {
                                echo error('New password should be different from old password');
                            } elseif(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/',$password)) {
									echo error("Your new password must contain following:<br>1 Uppercase Letter<br>1 Lowercase Letter<br>1 Number");	
							} else {
                                $password = password_hash($password, PASSWORD_DEFAULT);
                                $update = $db->query("UPDATE pw_users SET password='$password',password_recovery='' WHERE id='$u[id]'");
                                echo success($lang['success_21']);
                                $newURL=$settings['url'].'login?msg=change_password';
                                header('Location: '.$newURL);
                                $HideChangeForm=1;
                            }
                        }
                        if($HideChangeForm==0) {
                    ?>
                    <form class="form-signin mt-3 " action="" method="POST">
                        <div class="form-group">
                            <input type="email" class="form-control form-control-lg text-center" name="email" disabled value="<?php echo $u['email']; ?>" placeholder="Email address">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-lg text-center" name="password" placeholder="<?php echo $lang['placeholder_13']; ?>">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-lg text-center" name="cpassword" placeholder="<?php echo $lang['placeholder_14']; ?>">
                        </div>
                        <button type="submit" name="pw_change" value="change" class="btn btn-default btn-lg btn-rounded shadow btn-block"><?php echo $lang['btn_17']; ?></button>
                        <!--<div class="form-group my-4 text-left">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="rememberme">
                                <label class="custom-control-label" for="rememberme">Remember Me</label>
                            </div>
                        </div>-->
                    </form>
                    <p style="margin-top:2%;"><?php echo $lang['do_not_have_an_account']; ?>  <a href="<?php echo $settings['url']; ?>register"> <?php echo $lang['register']; ?></a></p>
                    <?php } ?>         
                </div>
            </div>

            <!-- login buttons -->
            <!--
            <div class="row mx-0 bottom-button-container">
                <div class="col">
                    <a href="change-password.html" class="btn btn-default btn-lg btn-rounded shadow btn-block">Reset Password</a>
                </div>
            </div>-->
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
    header("Location: $settings[url]");
}
?>
