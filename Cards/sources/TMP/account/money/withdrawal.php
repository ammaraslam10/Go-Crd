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
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="icrypto">

        <title>Withdraw Money - <?php echo $settings['name']; ?></title>

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
        <?php include('includes/sidebar.php');?>
        <div class="wrapper">
            <?php include('includes/header.php');?>
            <div class="row no-gutters login-row">
                <div class="col align-self-center px-3 text-center">
                    <h4>Withdraw Money</h4>
                    <br></br>
                    <?php
                    $hide_form=0;
                    $FormBTN = protect($_POST['pw_withdrawal']);
                    if($FormBTN == "withdrawal") {
                        //echo 'hello withdrawal';
                        $withdrawal_to = protect($_POST['withdrawal_to']);
                        $wallet = protect($_POST['wallet_id']);
                        $amount = protect($_POST['amount']);
                        $wallet_passphrase = protect($_POST['wallet_passphrase']);
                        $code = protect($_POST['code']);
                        //echo 'hello code';
                        //$checkResult = $ga->verifyCode($_SESSION['pw_secret'], $code, 2);    // 2 = 2*30sec clock tolerance
                        //echo 'hello verify code';
                        //echo "wallet id is: ".$wallet." and login user is:".$_SESSION[pw_uid];
                        $CheckWallet = $db->query("SELECT * FROM pw_users_wallets WHERE id='$wallet' and uid='$_SESSION[pw_uid]'");
                        //echo 'hello checkwallet';
                        if($CheckWallet->num_rows>0) {
                            $wb = $CheckWallet->fetch_assoc();
                        }
                        $currency = $wb['currency'];
                        $midnight = strtotime('today midnight');
                        $limit_reached = false;
                        //check for KYC limits:
                        if($settings['require_document_verify']=='1'){
                            $GetTodayWithdrawal = $db->query("SELECT * FROM pw_withdrawals WHERE (uid='$_SESSION[pw_uid]' and (status='1' or status='3') and requested_on>='$midnight' and currency='$currency')");
                            //echo '<script>alert("'.$GetTodayWithdrawal->num_rows.'");</script>';
                            if(idinfo($_SESSION['pw_uid'],"document_verified") != "1") {
                                $qs = '<b>Would you like to verify your documents now?</b>';
                                $prompt = PW_GetDocumentPrompt();
                                $qs=$qs.$prompt;
                                if($settings['limit_maxtxs_sent']!='-1' && ($settings['limit_maxtxs_sent'] <= $GetTodayWithdrawal->num_rows)){
                                    $limit_reached = true;
                                    //echo '<script>alert("Limit reached number of transactions");</script>';
                                    $_SESSION['msg'] = error('Your daily number of withdrawal transactions limit is reached.<br>Your allowed number of withdrawal transactions is: '.$settings['limit_maxtxs_sent'].'<br>You can verify your account by clicking <a href="'.$settings[url].'account/settings/verification">here.</a>').$qs;
                               
                                }
                                else if($settings['limit_maxamount_sent']!='-1'){
                                    $today_sent_amount = 0;
                                    while($gts = $GetTodayWithdrawal->fetch_assoc()) {
                                        $today_sent_amount = $today_sent_amount + $gts[amount];
                                    }
                                    //echo '<script>alert("'.$today_sent_amount.'");</script>';
                                    if(($today_sent_amount+$amount)>$settings['limit_maxamount_sent']){
                                        //echo '<script>alert("Limit reached sending amount");</script>';
                                        $limit_reached = true;
                                        if($amount>$settings['limit_maxamount_sent']){
                                            $_SESSION['msg'] = error('You can not withdraw this amount as it is more than allowed limits for unverified accounts.<br>Your daily withdraw allowed amount is: '.$settings['limit_maxamount_sent'].' '.$currency.'<br>You can verify your account by clicking <a href="'.$settings[url].'account/settings/verification">here.</a>').$qs;
                                        }
                                        else if($today_sent_amount >= $settings['limit_maxamount_sent']){
                                            $_SESSION['msg'] = error('You have already reached withdraw amount limit for unverified accounts.<br>Your daily withdraw allowed amount is: '.$settings['limit_maxamount_sent'].' '.$currency.'<br>You have already withdrawn '.$today_sent_amount.' '.$currency.' today.<br>You can verify your account by clicking <a href="'.$settings[url].'account/settings/verification">here.</a>').$qs;
                                        }
                                        else{
                                            $_SESSION['msg'] = error('You can not withdraw this amount as it will exceed the allowed withdraw amount limits for unverified accounts.<br>Your daily withdraw allowed amount is: '.$settings['limit_maxamount_sent'].' '.$currency.'<br>You have already withdrawn '.$today_sent_amount.' '.$currency.' today.<br>You can verify your account by clicking <a href="'.$settings[url].'account/settings/verification">here.</a>').$qs;
                                        }
                                    }
                                }
                            } 
                            else {
                                if($settings['limit_maxtxs_sent_v']!='-1' && ($settings['limit_maxtxs_sent_v'] <= $GetTodayWithdrawal->num_rows)){
                                    $limit_reached = true;
                                    $_SESSION['msg'] = error('Your daily number of withdrawal transactions limit is reached.<br>Please contact us to increase your withdrawal transactions limit.');
                                }
                                else if($settings['limit_maxamount_sent_v']!='-1'){
                                    $today_sent_amount = 0;
                                    while($gts = $GetTodayWithdrawal->fetch_assoc()) {
                                        $today_sent_amount = $today_sent_amount + $gts[amount];
                                    }
                                    //echo '<script>alert("'.$today_sent_amount.'");</script>';
                                    if(($today_sent_amount+$amount)>$settings['limit_maxamount_sent_v']){
                                        //echo '<script>alert("Limit reached sending amount");</script>';
                                        $limit_reached = true;
                                        if($amount>$settings['limit_maxamount_sent_v']){
                                            $_SESSION['msg'] = error('You can not withdraw this amount as it is more than allowed limits for verified accounts.<br>You have already withdrawn '.$today_sent_amount.' '.$currency.' today.<br>Please contact us to increase your daily withdrawal limit.');
                                        }
                                        else if($today_sent_amount >= $settings['limit_maxamount_sent_v']){
                                            $_SESSION['msg'] = error('Your daily withdraw amount limit for verified accounts is reached.<br>Your daily withdrawal allowed amount is: '.$settings['limit_maxamount_sent_v'].' '.$currency.'<br>You have already withdrawn '.$today_sent_amount.' '.$currency.' today.<br>Please contact us to increase your withdrawal limit.');
                                        }
                                        else{
                                            $_SESSION['msg'] = error('You can not withdraw this amount as it will exceed the allowed withdrawal amount limits for verified accounts.<br>Your daily withdrawal allowed amount is: '.$settings['limit_maxamount_sent_v'].' '.$currency.'<br>You have already withdrawn '.$today_sent_amount.' '.$currency.' today.<br>Please contact us to increase your withdrawal limit.');
                                        }
                                    }
                                }
                            }
                        }
                        
                        
                        if(empty($withdrawal_to)) {
                            echo error($lang['error_14']);
                        }  elseif(empty($wallet)) {
                            echo error($lang['error_15']);
                        } elseif(!is_numeric($amount)) {
                            echo error($lang['error_7']);
                        } elseif($amount<0) {
                            echo error($lang['error_7']);
                        } elseif($CheckWallet->num_rows==0) {
                            echo error($lang['error_16']);
                        } elseif($amount > $wb['amount']) {
                            echo error($lang['error_8']);
                        }  elseif(idinfo($_SESSION['pw_uid'],"wallet_passphrase") && empty($wallet_passphrase)) {
                            echo error($lang['error_12']);
                        } elseif(idinfo($_SESSION['pw_uid'],"wallet_passphrase") && !password_verify($wallet_passphrase,idinfo($_SESSION['pw_uid'],"wallet_passphrase"))) {
                            echo error($lang['error_13']);
                        } elseif(idinfo($_SESSION['pw_uid'],"2fa_auth") == "1" && idinfo($_SESSION['pw_uid'],"2fa_auth_login") == "1" && !$checkResult) {
                            echo error($lang['error_51']);
                        } elseif($limit_reached) {
                            $_SESSION['msg_type'] = "Withdraw Money";
                            $redirect = $settings['url']."account/summary";
                            if(idinfo($_SESSION['pw_uid'],"document_verified") != "1") {
                                $_SESSION['limit_reached']=true;
                            }
                            header("Location: $redirect");
                            //echo error('Your daily sending limit is reached.<br>Your allowed number of transactions is: '.$settings['limit_maxtxs_sent'].'<br>Your daily sending allowed amount is: '.$settings['limit_maxamount_sent'].' '.$currency.'<br>You can verify your account by clicking <a href="'.$settings[url].'account/settings/verification">here.</a>');
                        } else {
                            $error=0;
                            foreach($_POST['fieldvalues'] as $k=>$v) {
                                if(empty($v)) {
                                    $error=1;
                                    $fname = PW_GetFieldName($k);
                                    $msg = error('Field: "'.$fname.'" is empty.');
                                }
                            }

                            if($error==1) {
                                echo $msg;
                            } else {
                                $time = time();
                                $txid = strtoupper(randomHash(30));
                                $amount = number_format($amount, 2, '.', '');
                                $fee = gatewayinfo($withdrawal_to,"fee");
                                $include_fee = gatewayinfo($withdrawal_to,"include_fee");
                                $extra_fee = gatewayinfo($withdrawal_to,"extra_fee");
                                if($wb['currency'] !== $settings['default_currency']) {
                                    $fee = currencyConvertor($fee,$settings['default_currency'],$wb['currency']);
                                    $amount_with_fee = $amount - $fee;
                                } else {
                                    $amount_with_fee = $amount - $fee;
                                }
                                if($include_fee == "1") {
                                    $calculate = $amount_with_fee * $extra_fee;
                                    $calculate = $calculate / 100;
                                    $amount_with_fee = $amount_with_fee - $calculate;
                                }
                                $amount_with_fee = number_format($amount_with_fee, 2, '.', '');
                                $cfee = $amount - $amount_with_fee;
                                $create_withdrawal = $db->query("INSERT pw_withdrawals (uid,txid,method,amount,currency,fee,requested_on,processed_on,status) VALUES ('$_SESSION[pw_uid]','$txid','$withdrawal_to','$amount','$wb[currency]','$cfee','$time','0','1')");
                                $WithdrawalQuery = $db->query("SELECT * FROM pw_withdrawals WHERE uid='$_SESSION[pw_uid]' ORDER BY id DESC LIMIT 1");
                                $w = $WithdrawalQuery->fetch_assoc();
                                foreach($_POST['fieldvalues'] as $k=>$v) {
                                    if(!empty($v)) {
                                        $insert = $db->query("INSERT pw_withdrawals_values (uid,withdrawal_id,gateway_id,field_id,value) VALUES ('$_SESSION[pw_uid]','$w[id]','$withdrawal_to','$k','$v')");
                                    }
                                }
                                //echo 'hello in error';
                                PW_UpdateUserWallet($_SESSION['pw_uid'],$amount,$wb['currency'],2);
                                $create_transaction = $db->query("INSERT pw_transactions (txid,type,sender,withdrawal_via,description,amount,currency,fee,status,created,item_id) VALUES ('$txid','4','$_SESSION[pw_uid]','$withdrawal_to','$description','$amount','$wb[currency]','$cfee','3','$time','$w[id]')");
                                $insert_activity = $db->query("INSERT pw_activity (txid,type,uid,u_field_1,amount,currency,status,withdrawal_via,created,deposit_via) VALUES ('$txid','4','$_SESSION[pw_uid]','$w[id]','$amount','$wb[currency]','3','$withdrawal_to','$time','$withdrawal_to')");
                                //echo success($lang['success_8']);
                                
                                //send admin notificcation
                                $to = $settings['infoemail'];
                                $subject = "New withdrawal in ".$settings['name'];
                                $text = "A user just made a new withdrawal from their wallet";
                                $link = $settings['url'].'admin/?a=withdrawals&b=view&id='.$w['id'];
                                PW_EmailSys_Send_Generic($to,$subject,$text,$link);
                                
                                //insert notification
                                $GetActivity = $db->query("SELECT * FROM pw_activity ORDER BY id DESC LIMIT 1");
                                $getd = $GetActivity->fetch_assoc();
                                $notif_detail = 'Your withdrawal of '.$amount." ".$currency." is being processed and will be in your bank account within 1-2 days";
                                $insert_notification = $db->query("INSERT pw_notifications (uid,activity_id,detail,is_read,amount,type,time) VALUES ('$_SESSION[pw_uid]','$getd[id]','$notif_detail','0','$amount','3','$getd[created]')");
                            
                                $msg = success($lang['success_8']);
                                $_SESSION['msg'] = $msg;
                                $_SESSION['msg_type'] = "Withdraw Money";
                                $redirect = $settings['url']."account/summary";
                                header("Location: $redirect");
                                //echo success("Your funds will reach the bank within specified time.");
                            }
                        }
                    }

                    if($hide_form==0) {
                    ?>
                    <form class="user-connected-from user-login-form" action="" method="POST">
                    <div class="row form-group">
                        <div class="col">
                            <label>From Wallet</label>
                            <select class="form-control form-control-lg text-center" name="wallet_id" id="wallet_id" onchange="PW_GetWalletCurrency(this.value);">
                                <?php
                                $GetUserWallets = $db->query("SELECT * FROM pw_users_wallets WHERE uid='$_SESSION[pw_uid]'");
                                if($GetUserWallets->num_rows>0) {
                                    while($getu = $GetUserWallets->fetch_assoc()) {
                                        echo '<option value="'.$getu[id].'">'.get_wallet_balance($_SESSION[pw_uid],$getu[currency]).' '.$getu[currency].'</option>';
                                    }
                                } 
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <label>To</label>
                            <select class="form-control form-control-lg text-center" name="withdrawal_to" id="withdrawal_to" onchange="PW_Load_Gateway_Fields(this.value);">
                                <?php
                                $GetGateways = $db->query("SELECT * FROM pw_gateways WHERE type='2' and status='1' ORDER BY id");
                                if($GetGateways->num_rows>0) {
                                    while($get = $GetGateways->fetch_assoc()) {
                                        if($get[id] == $withdrawal_to){
                                            $sel = 'selected';
                                        }
                                        else{$sel='';}
                                        if(strtolower($get[name])!="bank transfer"){
                                            echo '<option value="'.$get[id].'" '.$sel.'>'.$get[name].'</option>';
                                        }
                                        else{
                                            echo '<option value="'.$get[id].'" '.$sel.'>Bank</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:2%;margin-bottom:2%;">
                        <input type="number" autocomplete=off placeholder="Enter Amount" class="form-control form-control-lg text-center" value="<?php echo $amount;?>" name="amount" id="send_amount" onkeyup="PW_Calculate(this.value);" onkeydown="PW_Calculate(this.value);" required>
                    </div>
                    <input type="hidden" id="c_currency">
                    <input type="hidden" id="d_currency" value="<?php echo $settings['default_currency']; ?>">
                    <span id="pw_gateway_fields"></span>
                    <?php if(idinfo($_SESSION['pw_uid'],"wallet_passphrase")) { ?>
                    <div class="form-group">
                        <label><?php echo $lang['field_7']; ?></label>
                        <input type="password" class="form-control form-control-lg text-center" name="wallet_passphrase">
                    </div>
                    <?php } ?>
                    
                    <?php if(idinfo($_SESSION['pw_uid'],"2fa_auth") == "1" && idinfo($_SESSION['pw_uid'],"2fa_auth_send") == "1") { ?>
                        <div class="form-group">
                        <label><?php echo $lang['placeholder_12']; ?></label>
                        <input type="text" class="form-control form-control-lg text-center" name="code" placeholder="">
                    </div>
                    <?php } ?>
                    <button type="submit" name="pw_withdrawal" value="withdrawal" class="btn btn-default btn-lg btn-rounded shadow btn-block">Withdraw</button>
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
        <script src="<?php echo $settings['url']; ?>assets/js/wallet.js"></script>
        <input type="hidden" id="url" value="<?php echo $settings['url']; ?>">
        <script>
            $(document).ready(function() {
                PW_Load_Gateway_Fields($("#withdrawal_to").val());
                $('input[name="fieldvalues[7]"]').val(<?php echo $_POST['fieldvalues[7]'];?>);
                $('input[name="fieldvalues[8]"]').val(<?php echo $_POST['fieldvalues[8]'];?>);
                $('input[name="fieldvalues[9]"]').val(<?php echo $_POST['fieldvalues[9]'];?>);
            });
        </script>
    </body>
    <!--Crypto Wallet -->
    </html>