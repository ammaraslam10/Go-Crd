<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

if(!checkSession()) {
    $redirect = $settings['url']."login";
    header("Location: $redirect");
}?>
<!doctype html>
    <html lang="en" class="deeppurple-theme">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="icrypto">

        <title><?php echo $lang['title_deposit_money']; ?>- <?php echo $settings['name']; ?></title>

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
            margin-top: 5%;
            margin-bottom: 5%;
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
        <?php include('includes/header.php');?>

            <div class="row no-gutters login-row">
                <div class="col align-self-center px-3 text-center">
                    <h4>Deposit Money</h4>
                    <br><br>
                    <?php
                    $hide_form=0;
                    $FormBTN = protect($_POST['pw_deposit']);
                    if($FormBTN == "deposit") {
                        $amount = protect($_POST['amount']);
                        $currency = protect($_POST['currency']);
                        $gateway = protect($_POST['deposit_via']);
                        
                        $midnight = strtotime('today midnight');
                        $limit_reached = false;
                        //check for KYC limits:
                        if($settings['require_document_verify']=='1'){
                            $GetTodayDeposit = $db->query("SELECT * FROM pw_deposits WHERE (uid='$_SESSION[pw_uid]' and (status='3' or status='1') and requested_on>='$midnight' and currency='$currency')");
                            //echo '<script>alert("'.$GetTodayDeposit->num_rows.'");</script>';
                            if(idinfo($_SESSION['pw_uid'],"document_verified") != "1") {
                                $qs = '<b>Would you like to verify your documents now?</b>';
                                $prompt = PW_GetDocumentPrompt();
                                $qs=$qs.$prompt;
                                if($settings['limit_maxtxs_sent']!='-1' && ($settings['limit_maxtxs_sent'] <= $GetTodayDeposit->num_rows)){
                                    $limit_reached = true;
                                    //echo '<script>alert("Limit reached number of transactions");</script>';
                                    $_SESSION['msg'] = error('Your daily sending number of deposit transactions limit is reached.<br>Your allowed number of deposit transactions is: '.$settings['limit_maxtxs_sent'].'<br>You can verify your account by clicking <a href="'.$settings[url].'account/settings/verification">here.</a>').$qs;
                               
                                }
                                else if($settings['limit_maxamount_sent']!='-1'){
                                    $today_sent_amount = 0;
                                    while($gts = $GetTodayDeposit->fetch_assoc()) {
                                        $today_sent_amount = $today_sent_amount + $gts[amount];
                                    }
                                    //echo '<script>alert("'.$today_sent_amount.'");</script>';
                                    if(($today_sent_amount+$amount)>$settings['limit_maxamount_sent']){
                                        //echo '<script>alert("Limit reached sending amount");</script>';
                                        $limit_reached = true;
                                        if($amount>$settings['limit_maxamount_sent']){
                                            $_SESSION['msg'] = error('You can not deposit this amount as it is more than allowed limits for unverified accounts.<br>Your daily deposit allowed amount is: '.$settings['limit_maxamount_sent'].' '.$currency.'<br>You can verify your account by clicking <a href="'.$settings[url].'account/settings/verification">here.</a>').$qs;
                                        }
                                        else if($today_sent_amount >= $settings['limit_maxamount_sent']){
                                            $_SESSION['msg'] = error('You have already reached deposit amount limit for unverified accounts.<br>Your daily deposit allowed amount is: '.$settings['limit_maxamount_sent'].' '.$currency.'<br>You have already deposited '.$today_sent_amount.' '.$currency.' today.<br>You can verify your account by clicking <a href="'.$settings[url].'account/settings/verification">here.</a>').$qs;
                                        }
                                        else{
                                            $_SESSION['msg'] = error('You can not deposit this amount as it will exceed the allowed deposit amount limits for unverified accounts.<br>Your daily deposit allowed amount is: '.$settings['limit_maxamount_sent'].' '.$currency.'<br>You have already deposited '.$today_sent_amount.' '.$currency.' today.<br>You can verify your account by clicking <a href="'.$settings[url].'account/settings/verification">here.</a>').$qs;
                                        }
                                    }
                                }
                            } 
                            else {
                                if($settings['limit_maxtxs_sent_v']!='-1' && ($settings['limit_maxtxs_sent_v'] <= $GetTodayDeposit->num_rows)){
                                    $limit_reached = true;
                                    $_SESSION['msg'] = error('Your daily number of deposit transactions limit is reached.<br>Please contact us to increase your deposit transactions limit.');
                                }
                                else if($settings['limit_maxamount_sent_v']!='-1'){
                                    $today_sent_amount = 0;
                                    while($gts = $GetTodayDeposit->fetch_assoc()) {
                                        $today_sent_amount = $today_sent_amount + $gts[amount];
                                    }
                                    //echo '<script>alert("'.$today_sent_amount.'");</script>';
                                    if(($today_sent_amount+$amount)>$settings['limit_maxamount_sent_v']){
                                        //echo '<script>alert("Limit reached sending amount");</script>';
                                        $limit_reached = true;
                                        if($amount>$settings['limit_maxamount_sent_v']){
                                            $_SESSION['msg'] = error('You can not deposit this amount as it is more than allowed limits for verified accounts.<br>You have already deposited '.$today_sent_amount.' '.$currency.' today.<br>Please contact us to increase your daily deposit limit.');
                                        }
                                        else if($today_sent_amount >= $settings['limit_maxamount_sent_v']){
                                            $_SESSION['msg'] = error('Your daily deposit amount limit for verified accounts is reached.<br>Your daily deposit allowed amount is: '.$settings['limit_maxamount_sent_v'].' '.$currency.'<br>You have already deposited '.$today_sent_amount.' '.$currency.' today.<br>Please contact us to increase your deposit limit.');
                                        }
                                        else{
                                            $_SESSION['msg'] = error('You can not deposit this amount as it will exceed the allowed deposit amount limits for verified accounts.<br>Your daily deposit allowed amount is: '.$settings['limit_maxamount_sent_v'].' '.$currency.'<br>You have already deposited '.$today_sent_amount.' '.$currency.' today.<br>Please contact us to increase your deposit limit.');
                                        }
                                    }
                                }
                            }
                        }
                        if(empty($amount)) {
                            echo error($lang['error_6']);
                        } elseif(!is_numeric($amount)) {
                            echo error($lang['error_7']);
                        } elseif($amount<0) {
                            echo error($lang['error_7']);
                        } elseif($limit_reached) {
                            $_SESSION['msg_type'] = "Deposit Money";
                            $redirect = $settings['url']."account/summary";
                            if(idinfo($_SESSION['pw_uid'],"document_verified") != "1") {
                                $_SESSION['limit_reached']=true;
                            }
                            header("Location: $redirect");
                            //echo error('Your daily sending limit is reached.<br>Your allowed number of transactions is: '.$settings['limit_maxtxs_sent'].'<br>Your daily sending allowed amount is: '.$settings['limit_maxamount_sent'].' '.$currency.'<br>You can verify your account by clicking <a href="'.$settings[url].'account/settings/verification">here.</a>');
                        } else {
                            $amount = number_format($amount, 2, '.', '');
                            $txid = strtoupper(randomHash(30));
                            $time = time();
                            $status = '3';
                            if(strtolower(gatewayinfo($gateway,"name"))=='square' || strtolower(gatewayinfo($gateway,"name"))=='stripe'){
                                $status = '6';
                            }
                            $reference_number = $currency.strtoupper(randomHash(10)); 
                            $description = 'Deposit '.$amount.' '.$currency.' to '.idinfo($_SESSION[pw_uid],"email");
                            $create_deposit = $db->query("INSERT pw_deposits (uid,txid,method,amount,currency,requested_on,processed_on,reference_number,status) VALUES ('$_SESSION[pw_uid]','$txid','$gateway','$amount','$currency','$time','0','$reference_number','$status')");
                            $GetDeposit = $db->query("SELECT * FROM pw_deposits WHERE uid='$_SESSION[pw_uid]' ORDER BY id DESC LIMIT 1");
                            $getd = $GetDeposit->fetch_assoc();
                            $create_transaction = $db->query("INSERT pw_transactions (txid,type,sender,recipient,description,deposit_via,amount,currency,fee,status,created) VALUES ('$txid','3','$_SESSION[pw_uid]','$getd[id]','$description','$gateway','$amount','$currency','','$stauts','$time')");
                            $insert_activity = $db->query("INSERT pw_activity (txid,type,uid,deposit_via,u_field_1,amount,currency,status,created) VALUES ('$txid','3','$_SESSION[pw_uid]','$gateway','$getd[id]','$amount','$currency','$status','$time')");
                            //insert notification
                            if(strtolower(gatewayinfo($gateway,"name"))=='square'){
                                $GetDeposit = $db->query("SELECT * FROM pw_activity WHERE uid='$_SESSION[pw_uid]' ORDER BY id DESC LIMIT 1");
                            }
                            else{
                                $GetDeposit = $db->query("SELECT * FROM pw_deposits WHERE uid='$_SESSION[pw_uid]' ORDER BY id DESC LIMIT 1");
                            }
                            $getd = $GetDeposit->fetch_assoc();
                            //echo '<script>alert("'.$getd['id'].'");</script>';
                            if(strtolower(gatewayinfo($gateway,"name"))!='square' && strtolower(gatewayinfo($gateway,"name"))!='stripe'){
                                $to = $settings['infoemail'];
                                $subject = "New deposit in ".$settings['name'];
                                $text = "A user just made a new deposit into their wallet";
                                $link = $settings['url'].'admin/?a=deposits&b=view&id='.$getd['id'];
                                PW_EmailSys_Send_Generic($to,$subject,$text,$link);
                                PW_InsertNotification($_SESSION['pw_uid'],$getd['id'],'You have made a deposit of '.$amount.' '.$currency.' and it will be reflected in your balance within next working day',$amount,$currency,'14',time());
       
                            }
                            
                            echo getPaymentForm($getd['id'],$gateway);
                            $hide_form=1;
                        }
                    }
                    if($hide_form==0) {
                        //btn btn-default btn-lg btn-rounded shadow btn-block
                        //form-control form-control-lg text-center

                    ?>
                    <form class="form-signin mt-3 " action="" method="POST">
                        <div class="input-group input-pw-amount" style="border: none;">
                            <input type="number" class="form-control form-control-lg text-center" value="<?php echo $amount;?>" name="amount" placeholder="Enter Amount" aria-label="Amount (to the nearest dollar)" style="border-radius: 40px;border: 1px solid rgba(0, 0, 0, 0.08);" required autocomplete=off>
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
                            <label>Deposit From:</label>
                            <select class="form-control form-control-lg text-center" name="deposit_via">
                                <?php
                                $GetGateways = $db->query("SELECT * FROM pw_gateways WHERE type='1' and status='1' ORDER BY id");
                                if($GetGateways->num_rows>0) {
                                    while($get = $GetGateways->fetch_assoc()) {
                                        if(strtolower($get[name]) != "stripe"){
                                                echo '<option value="'.$get[id].'">'.$get[name].'</option>';
                                        }
                                        else{
                                                echo '<option value="'.$get[id].'">Visa/MasterCard</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="pw_deposit" value="deposit" class="btn btn-default btn-lg btn-rounded shadow btn-block"><?php echo $lang['btn_10']; ?></button>
                        </div>
                    </form>
                    <?php } ?>               
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
        <script>
            $(document).ready(function() {
                $("body").off("dblclick");
            });
        </script>
    </body>
    <!--Crypto Wallet -->
    </html>