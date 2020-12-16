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
$ga 		= new GoogleAuthenticator();
$qrCodeUrl 	= $ga->getQRCodeGoogleUrl(idinfo($_SESSION['pw_uid'],"email"), $_SESSION['pw_secret'], $settings['name']);
?>
<!doctype html>
    <html lang="en" class="deeppurple-theme">
    <!--Crypto Wallet -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="icrypto">

        <title><?php echo $lang['title_request_money']; ?>- <?php echo $settings['name']; ?></title>

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
        <style>
        .form-group {
            margin-bottom: 0.5rem;
            margin-top: 2%;
            margin-bottom: 2%;
        }
        </style>
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

        <?php include('includes/sidebar.php');?>
        <div class="wrapper">
            
            <!-- header -->
            <?php include('includes/header.php');?>
            <!-- header ends -->

            <div class="row no-gutters login-row">
                <div class="col align-self-center px-3 text-center">
                    <h4>Request Money</h4>
                    <br><br>
                    <?php
                    $FormBTN = protect($_POST['pw_request']);
                    if($FormBTN == "request") {
                        $amount = protect($_POST['amount']);
                        $currency = protect($_POST['currency']);
                        $email = protect($_POST['email']);
                        $description = protect($_POST['description']);
                        if(empty($amount)) {
                            echo error($lang['error_6']);
                        } elseif(!is_numeric($amount)) {
                            echo error($lang['error_7']);
                        } elseif($amount<0) {
                            echo error($lang['error_7']);
                        } elseif(idinfo($_SESSION['pw_uid'],"email") == $email) {
                            echo error($lang['error_9']);
                        } elseif(PW_CheckUser($email)==false) {
                            echo error($lang['error_10']);
                        } else {
                            $amount = number_format($amount, 2, '.', '');
                            $uid = PW_GetUserID($email);
                            $time = time();
                            $insert = $db->query("INSERT pw_requests (uid,fromu,amount,currency,description,requested_on,status) VALUES ('$uid','$_SESSION[pw_uid]','$amount','$currency','$description','$time','1')");
                            if(idinfo($_SESSION['pw_uid'],"account_type") == "1") { $from = idinfo($_SESSION['pw_uid'],"first_name")." ".idinfo($_SESSION['pw_uid'],"last_name"); } else { $from = idinfo($_SESSION['pw_uid'],"business_name"); }
                            //insert notification
                            $GetRequest = $db->query("SELECT * FROM pw_requests WHERE uid='$_SESSION[pw_uid]' and status='1' ORDER BY id DESC LIMIT 1 ");
                            $getd = $GetRequest->fetch_assoc();
                            
                            if(idinfo($_SESSION['pw_uid'],"account_type") == "1") 
                            { $name = idinfo($_SESSION['pw_uid'],"first_name")." ".idinfo($_SESSION['pw_uid'],"last_name"); } 
                            else 
                            { $name = idinfo($_SESSION['pw_uid'],"business_name"); }
                            
                            //$insert_notification = $db->query("INSERT pw_notifications (uid,activity_id,detail,is_read,amount,type,time) VALUES ('$uid','$getd[id]','$notif_detail','0','$amount','2','$time')");
                            
                            PW_InsertNotification($uid,$_SESSION['pw_uid'],$name.' requests '.$amount.' '.$currency.' from you',$amount,$currency,'2',time());
                            PW_InsertNotification($_SESSION['pw_uid'],$uid,'You have requested '.$amount.' '.$currency.' from '.idinfo($uid,"first_name").' '.idinfo($uid,"last_name"),$amount,$currency,'5',time());
                            PW_EmailSys_PaymentRequestNotification($email,$amount,$currency,$description,$from);
                            $success_6 = str_ireplace("%amount%",$amount,$lang['success_6']);
                            $success_6 = str_ireplace("%currency%",$currency,$success_6);
                            $success_6 = str_ireplace("%email%",$email,$success_6);
                            $msg = success($success_6);
                            $_SESSION['msg'] = $msg;
                            $_SESSION['msg_type'] = "Request Money";
                            $redirect = $settings['url']."account/summary";
                            header("Location: $redirect");
                        }
                    }
                    ?>
                    <form class="user-connected-from user-login-form" action="" method="POST">
                        <div class="input-group input-pw-amount" style="border: none;">
                            <input type="number" autocomplete=off class="form-control form-control-lg text-center" name="amount" value="<?php echo $amount;?>" placeholder="Enter Amount" aria-label="Amount (to the nearest dollar)" style="border-radius: 40px;border: 1px solid rgba(0, 0, 0, 0.08);" required>
                            <div class="input-group-append">
                                <span class="input-group-text" style="padding: 0 0;border: none;">
                                    <select class="form-control form-control-lg text-center" name="currency">
                                        <?php
                                        $currencies = getFiatCurrencies();
                                        foreach($currencies as $code=>$name) {
                                            if($code == $settings['default_currency']) { $sel = 'selected'; } else { $sel = ''; }
                                            echo '<option value="'.$code.'" '.$sel.'>'.$code.'</option>';
                                        }
                                        ?>
                                    </select>
                                </span>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="email" class="form-control form-control-lg text-center" id="exampleInputEmail1" value="<?php echo $email;?>" name="email" placeholder="<?php echo $lang['placeholder_3']; ?>" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control form-control-lg text-center" name="description" value="<?php echo $description;?>" rows="3" placeholder="<?php echo $lang['placeholder_4']; ?>"></textarea>
                        </div>
                        <button type="submit" name="pw_request" value="request" class="btn btn-default btn-lg btn-rounded shadow btn-block"><?php echo $lang['btn_11']; ?></button>
                    </form>              
                </div>
            </div>
            <!-- login buttons -->
            
        <?php include('includes/footer.php');?>
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