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

        <title><?php echo $lang['title_send_money']; ?>- <?php echo $settings['name']; ?></title>

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
                    <h4>Send Money</h4>
                    <br>
                    <br>
                    <?php
                    $hide_form=0;
                    //echo $_POST['pw_send'];
                    $FormBTN = protect($_POST['pw_send']);
                    if($FormBTN == "send") {
                        $send_via = protect($_POST['send_via']);
                        //echo strtolower(gatewayinfo($send_via,"name"));
                        $amount = protect($_POST['amount']);
                        $currency = protect($_POST['currency']);
                        $email = protect($_POST['email']);
                        $description = protect($_POST['description']);
                        $wallet_passphrase = protect($_POST['wallet_passphrase']);
                        $code = protect($_POST['code']);
                        $checkResult = $ga->verifyCode($_SESSION['pw_secret'], $code, 2);    // 2 = 2*30sec clock tolerance
                        
                        $now = time();
                        $midnight = strtotime('today midnight');
                        $limit_reached = false;
                        //check for KYC limits:
                        if($send_via != 'wallet' && $settings['require_document_verify']=='1'){
                            $GetTodaySend = $db->query("SELECT * FROM pw_transactions WHERE (sender='$_SESSION[pw_uid]' and (status='3' or status='1') and sent_via<>'0' and created>='$midnight' and currency='$currency')");
                            //echo '<script>alert("'.$GetTodaySend->num_rows.'");</script>';
                            if(idinfo($_SESSION['pw_uid'],"document_verified") != "1") {
                                $qs = '<b>Would you like to verify your documents now?</b>';
                                $prompt = PW_GetDocumentPrompt();
                                $qs=$qs.$prompt;
                                if($settings['limit_maxtxs_sent']!='-1' && ($settings['limit_maxtxs_sent'] <= $GetTodaySend->num_rows)){
                                    $limit_reached = true;
                                    //echo '<script>alert("Limit reached number of transactions");</script>';
                                    $_SESSION['msg'] = error('Your daily sending number of transactions limit is reached.<br>Your allowed number of transactions is: '.$settings['limit_maxtxs_sent']).$qs;
                                }
                                else if($settings['limit_maxamount_sent']!='-1'){
                                    $today_sent_amount = 0;
                                    while($gts = $GetTodaySend->fetch_assoc()) {
                                        $today_sent_amount = $today_sent_amount + $gts[amount];
                                    }
                                    //echo '<script>alert("'.$today_sent_amount.'");</script>';
                                    if(($today_sent_amount+$amount)>$settings['limit_maxamount_sent']){
                                        //echo '<script>alert("Limit reached sending amount");</script>';
                                        $limit_reached = true;
                                        if($amount>$settings['limit_maxamount_sent']){
                                            $_SESSION['msg'] = error('You can not send this amount as it is more than allowed limits for unverified accounts.<br>Your daily sending allowed amount is: '.$settings['limit_maxamount_sent'].' '.$currency.'<br>You have already sent '.$today_sent_amount.' '.$currency.' today.').$qs;
                                        }
                                        else if($today_sent_amount >= $settings['limit_maxamount_sent']){
                                            $_SESSION['msg'] = error('You have already reached sending amount limit for unverified accounts.<br>Your daily sending allowed amount is: '.$settings['limit_maxamount_sent'].' '.$currency.'<br>You have already sent '.$today_sent_amount.' '.$currency.' today').$qs;
                                        }
                                        else{
                                            $_SESSION['msg'] = error('You can not send this amount as it will exceed the allowed sending amount limits for unverified accounts.<br>Your daily sending allowed amount is: '.$settings['limit_maxamount_sent'].' '.$currency.'<br>You have already sent '.$today_sent_amount.' '.$currency.' today').$qs;
                                        }
                                    }
                                }
                            } 
                            else {
                                if($settings['limit_maxtxs_sent_v']!='-1' && ($settings['limit_maxtxs_sent_v'] <= $GetTodaySend->num_rows)){
                                    $limit_reached = true;
                                    $_SESSION['msg'] = error('Your daily sending number of transactions limit is reached.<br>Please contact us to increase your sending limit.');
                                    
                                }
                                else if($settings['limit_maxamount_sent_v']!='-1'){
                                    $today_sent_amount = 0;
                                    while($gts = $GetTodaySend->fetch_assoc()) {
                                        $today_sent_amount = $today_sent_amount + $gts[amount];
                                    }
                                    //echo '<script>alert("'.$today_sent_amount.'");</script>';
                                    if(($today_sent_amount+$amount)>$settings['limit_maxamount_sent_v']){
                                        //echo '<script>alert("Limit reached sending amount");</script>';
                                        $limit_reached = true;
                                        if($amount>$settings['limit_maxamount_sent_v']){
                                            $_SESSION['msg'] = error('You can not send this amount as it is more than allowed limits for verified accounts.<br>Your daily sending allowed amount is: '.$settings['limit_maxamount_sent_v'].' '.$currency.'<br>You have already sent '.$today_sent_amount.' '.$currency.' today.<br>Please contact us to increase your sending limit.');
                                        }
                                        else if($today_sent_amount >= $settings['limit_maxamount_sent_v']){
                                            $_SESSION['msg'] = error('Your daily sending amount limit for verified accounts is reached.<br>Your daily sending allowed amount is: '.$settings['limit_maxamount_sent_v'].' '.$currency.'<br>You have already sent '.$today_sent_amount.' '.$currency.' today.<br>Please contact us to increase your sending limit.');
                                        }
                                        else{
                                            $_SESSION['msg'] = error('You can not send this amount as it will exceed the allowed sending amount limits for verified accounts.<br>Your daily sending allowed amount is: '.$settings['limit_maxamount_sent_v'].' '.$currency.'<br>You have already sent '.$today_sent_amount.' '.$currency.' today.<br>Please contact us to increase your sending limit.');
                                        }
                                    }
                                }
                            }
                        }
                        if(empty($amount)) {
                            echo error($lang['error_6']);
                        }  elseif(!is_numeric($amount)) {
                            echo error($lang['error_7']);
                        } elseif($amount<0) {
                            echo error($lang['error_7']);
                        } elseif($send_via == 'wallet' && get_wallet_balance($_SESSION['pw_uid'],$currency) < $amount) {
                            echo error($lang['error_8']);
                        } elseif(idinfo($_SESSION['pw_uid'],"email") == $email) {
                            echo error($lang['error_9']);
                        } elseif(PW_CheckUser($email)==false) {
                            echo error($lang['error_11']);
                        } elseif(idinfo($_SESSION['pw_uid'],"wallet_passphrase") && empty($wallet_passphrase)) {
                            echo error($lang['error_12']);
                        } elseif(idinfo($_SESSION['pw_uid'],"wallet_passphrase") && !password_verify($wallet_passphrase,idinfo($_SESSION['pw_uid'],"wallet_passphrase"))) {
                            echo error($lang['error_13']);
                        } elseif(idinfo($_SESSION['pw_uid'],"2fa_auth") == "1" && idinfo($_SESSION['pw_uid'],"2fa_auth_login") == "1" && !$checkResult) {
                            echo error($lang['error_51']);
                        } elseif($limit_reached) {
                            $_SESSION['msg_type'] = "Send Money";
                            $redirect = $settings['url']."account/summary";
                            if(idinfo($_SESSION['pw_uid'],"document_verified") != "1") {
                                $_SESSION['limit_reached']=true;
                            }
                            header("Location: $redirect");
                            //echo error('Your daily sending limit is reached.<br>Your allowed number of transactions is: '.$settings['limit_maxtxs_sent'].'<br>Your daily sending allowed amount is: '.$settings['limit_maxamount_sent'].' '.$currency.'<br>You can verify your account by clicking <a href="'.$settings[url].'account/settings/verification">here.</a>');
                        } else {
                            $amount = number_format($amount, 2, '.', '');
                            $recipient_id = PW_GetUserID($email);
                            $fee = ($amount * $settings['payfee_percentage']) / 100;
                            $amount_with_fee = $amount - $fee;
                            $status = 3;
                            if($send_via=='wallet'){
                                PW_UpdateUserWallet($recipient_id,$amount_with_fee,$currency,1);
                                PW_UpdateUserWallet($_SESSION['pw_uid'],$amount,$currency,2);
                                //echo '<script>alert("changed the wallet of current");</script>';
                                $status = 1;
                                $_SESSION['msg_type'] = "Send Money";
                            }
                            //echo "status is: ".$status;
                            $txid = strtoupper(randomHash(30));
                            $time = time();
                            if(strtolower(gatewayinfo($send_via,"name"))=='square' || strtolower(gatewayinfo($send_via,"name"))=='stripe'){
                                $status = 6;
                            }
                            $create_transaction = $db->query("INSERT pw_transactions (txid,type,sender,recipient,description,amount,currency,fee,status,created,sent_via) VALUES ('$txid','1','$_SESSION[pw_uid]','$recipient_id','$description','$amount','$currency','$fee','$status','$time','$send_via')");
                            $insert_activity = $db->query("INSERT pw_activity (txid,type,uid,u_field_1,amount,currency,status,created,deposit_via) VALUES ('$txid','2','$_SESSION[pw_uid]','$recipient_id','$amount','$currency','$status','$time','$send_via')");
                            $insert_activity = $db->query("INSERT pw_activity (txid,type,uid,u_field_1,amount,currency,status,created) VALUES ('$txid','1','$recipient_id','$_SESSION[pw_uid]','$amount_with_fee','$currency','$status','$time')");
                            PW_UpdateAdminWallet($fee,$currency);
                            $insert_admin_log = $db->query("INSERT pw_admin_logs (type,time,u_field_1,u_field_2,u_field_3) VALUES ('1','$time','$fee','$currency','$txid')");
                            //PW_EmailSys_PaymentNotification($email,$amount,$currency,$description,$txid);
                            $success_7 = str_ireplace("%amount%",$amount,$lang['success_7']);
                            $success_7 = str_ireplace("%currency%",$currency,$success_7);
                            $success_7 = str_ireplace("%email%",$email,$success_7);
                            $GetActivity = $db->query("SELECT * FROM pw_activity ORDER BY id DESC LIMIT 1");
                            $getd = $GetActivity->fetch_assoc();
                            $notif_detail = PW_DecodeUserActivity($getd['id']);
                            $GetActivity = $db->query("SELECT * FROM pw_activity WHERE uid='$_SESSION[pw_uid]' ORDER BY id DESC LIMIT 1");
                            $getd = $GetActivity->fetch_assoc();
                            if($send_via=='wallet'){
                                $time = time();
                                $update = $db->query("UPDATE pw_transactions SET updated='$time',status='1' WHERE txid='$getd[txid]'");
                                $update = $db->query("UPDATE pw_activity SET updated='$time',status='1' WHERE id='$getd[id]'");
                                
                                $GetRequest = $db->query("SELECT * FROM pw_requests WHERE (uid='$_SESSION[pw_uid]' and fromu='$recipient_id' and status='1' and cast(amount as FLOAT)<='$amount' and currency='$currency') ");
                                
                                if($GetRequest->num_rows>0){
                                    $getr = $GetRequest->fetch_assoc();
                                    //echo '<script>alert("'.$getr['id'].'");</script>';
                                    PW_InsertNotification($_SESSION[pw_uid],$recipient_id,'You have accepted and sent '.$amount.' '.$currency.' to '.idinfo($recipient_id,"first_name").' '.idinfo($recipient_id,"last_name"),$amount,$currency,'6',time());
                                    //notification for reciever
                                    PW_InsertNotification($recipient_id,$_SESSION[pw_uid],idinfo($_SESSION[pw_uid],"first_name").' '.idinfo($_SESSION[pw_uid],"last_name").' has sent your requested amount of '.$amount.' '.$currency,$amount,$currency,'7',time());
                                    PW_EmailSys_PaymentNotification($email,$amount,$currency,$description,$txid);
                                    $update_request = $db->query("UPDATE pw_requests SET status='3' WHERE id='$getr[id]' ");
                                    
                                }
                                else{
                                    PW_InsertNotification($_SESSION['pw_uid'],$recipient_id,'You have sent '.$amount.' '.$currency.' to '.idinfo($recipient_id,"first_name").' '.idinfo($recipient_id,"last_name").' and it will be reflected in their balance within next working day',$amount,$currency,'8',time());
                                    PW_InsertNotification($recipient_id,$_SESSION['pw_uid'],'You have recieved '.$amount.' '.$currency.' from '.idinfo($_SESSION['pw_uid'],"first_name").' '.idinfo($_SESSION['pw_uid'],"last_name").' and it will be reflected in your balance within next working day',$amount,$currency,'1',time());
                                    
                                    $GetTransaction = $db->query("SELECT * FROM pw_transactions WHERE txid='$getd[txid]'");
                                    $transaction = $GetTransaction->fetch_assoc();
                                    
                                    
                                    
                                    $amount = $transaction[amount];
                                    $currency = $transaction[currency];
                                    $recipient_id = $transaction[recipient];
                                    $sender_id = $_SESSION['pw_uid'];
                                    
                                    //send notification to recipient
                                    $to = idinfo($recipient_id,"email");
                                    $amount = $transaction[amount] - $transaction[fee];
                                    //echo '<script>alert("'.$amount.'");</script>';
                                    $subject = "Congratulations! You have received a payment in ".$settings['name'];
                                    $text = "You have received ".$amount.$currency." from ".idinfo($transaction['sender'],"first_name")." ".idinfo($transaction['sender'],"last_name");
                                    $link = $settings['url'].'account/transaction/'.$transaction[txid];
                                    PW_EmailSys_Send_Generic($to,$subject,$text,$link);
                                    
                                    //send notification to sender
                                    $to = idinfo($sender_id,"email");
                                    $amount = $transaction['amount'];
                                    $subject = "Transaction alert in ".$settings['name'];
                                    $text = "You have sent ".$amount.$currency." to ".idinfo($recipient_id,"first_name")." ".idinfo($recipient_id,"last_name");
                                    $link = $settings['url'].'account/transaction/'.$transaction['txid'];
                                    PW_EmailSys_Send_Generic($to,$subject,$text,$link);
                                }
                                //echo '<script>alert("'.$update.'");</script>';
                                $msg = success($success_7);
                                $_SESSION['msg'] = $msg;
                                
                                $redirect = $settings['url']."account/summary";
                                header("Location: $redirect");
                            }
                            elseif(strtolower(gatewayinfo($send_via,"name"))=='stripe'){
                                //echo '<script>alert("hello in send via wallet");</script>';
                                echo PF_Stripe_send($getd['id'],$send_via);
                                $hide_form=1;
                            }
                            elseif(strtolower(gatewayinfo($send_via,"name"))=='square'){
                                //echo '<script>alert("hello in send via wallet");</script>';
                                echo PF_Square_send($getd['id'],$send_via);
                                $hide_form=1;
                            }
                        }
                    }
                    
                    if($hide_form==0) {
                    ?>
                    <form class="user-connected-from user-login-form" action="" method="POST">
                        <div class="input-group input-pw-amount" style="border: none;">
                            <input type="number" autocomplete=off class="form-control form-control-lg text-center" style="border-radius: 40px;border: 1px solid rgba(0, 0, 0, 0.08);" value="<?php echo $amount;?>" name="amount" placeholder="Enter Amount" aria-label="Amount (to the nearest dollar)" style="border-radius: 40px;" required>
                            <div class="input-group-append">
                                <span class="input-group-text" style="padding: 0 0;border: none;">
                                    <select class="form-control form-control-lg text-center" name="currency">
                                        <?php
                                        $GetUWalles = $db->query("SELECT * FROM pw_users_wallets WHERE uid='$_SESSION[pw_uid]'");
                                        if($GetUWalles->num_rows>0) {
                                            while($guw = $GetUWalles->fetch_assoc()) {
                                                echo '<option value="'.$guw[currency].'">'.$guw[currency].'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </span>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="email" class="form-control form-control-lg text-center" id="exampleInputEmail1" value="<?php echo $email;?>" name="email" placeholder="<?php echo $lang['placeholder_5']; ?>" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control form-control-lg text-center"  name="description" rows="3" placeholder="<?php echo $lang['placeholder_4']; ?>" value="<?php echo $description;?>"></textarea>
                        </div>
                        <!--custom editing-->
                        <div class="form-group">
                                <label>Send From:</label>
                                <select class="form-control form-control-lg text-center" name="send_via">
                                    <option value="wallet">Wallet</option>
                                    <?php
                                    $GetGateways = $db->query("SELECT * FROM pw_gateways WHERE type='1' and status='1' and allow_send='1' ORDER BY id");
                                    if($GetGateways->num_rows>0) {
                                        while($get = $GetGateways->fetch_assoc()) {
                                            if(strtolower($get[name])!='stripe'){
                                                echo '<option value="'.$get[id].'">'.$get[name].'</option>';
                                            }
                                            else{
                                                echo '<option value="'.$get[id].'">Debit/Credit Card</option>';
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                        </div>
                        <?php if(idinfo($_SESSION['pw_uid'],"wallet_passphrase")) { ?>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-lg text-center" name="wallet_passphrase" placeholder="<?php echo $lang['placeholder_6']; ?>">
                        </div>
                        <?php } ?>
                        <?php if(idinfo($_SESSION['pw_uid'],"2fa_auth") == "1" && idinfo($_SESSION['pw_uid'],"2fa_auth_send") == "1") { ?>
                            <div class="form-group">
                            <input type="text" class="form-control form-control-lg text-center" name="code" placeholder="<?php echo $lang['placeholder_12']; ?>">
                        </div>
                        <?php } ?>
                        <button type="submit" name="pw_send" value="send" class="btn btn-default btn-lg btn-rounded shadow btn-block"><?php echo $lang['btn_12']; ?></button>
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

    </body>
    <!--Crypto Wallet -->
    </html>