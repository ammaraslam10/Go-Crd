<?php
// Crypto Wallet
// Author: Crypto Wallet
clearstatcache();
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}
if(!checkSession()) {
    $redirect = $settings['url']."login";
    header("Location: $redirect");
}
if(isset($_GET['referenceId'])){
    //global $db;
    //echo '<script>alert("'.$_GET['referenceId'].'");</script>';
    if($_GET['msg']=="deposit"){
        $GetActivity = $db->query("SELECT * FROM pw_activity WHERE id='$_GET[referenceId]'");
        $activity = $GetActivity->fetch_assoc();
        $deposit_id = $activity['u_field_1'];
        $time = time();
        $txnID = $_GET['transactionId'];
        
        if($activity['updated'] == ''){
            $to = $settings['infoemail'];
            $subject = "New deposit in ".$settings['name'];
            $text = "A user just made a new deposit into their wallet";
            $link = $settings['url'].'admin/?a=deposits&b=view&id='.$deposit_id;
            PW_EmailSys_Send_Generic($to,$subject,$text,$link);
            $update = $db->query("UPDATE pw_activity SET updated='$time',status='3' WHERE id='$_GET[referenceId]'");
            $update = $db->query("UPDATE pw_deposits SET gateway_txid='$txnID',processed_on='$time',status='3' WHERE id='$deposit_id'");
            
            $amount = $activity['amount'];
            $currency = $activity['currency'];
            PW_InsertNotification($_SESSION['pw_uid'],$activity['u_field_1'],'You have made a deposit of '.$amount.' '.$currency.' and it will be reflected in your balance within next working day',$amount,$currency,'14',time());
        }
        
        
        
    }
    elseif($_GET['msg']=="send"){
        $GetActivity = $db->query("SELECT * FROM pw_activity WHERE id='$_GET[referenceId]'");
        $activity = $GetActivity->fetch_assoc();
        $time = time();
        
        $txnID = $_GET['transactionId'];
        $GetTransaction = $db->query("SELECT * FROM pw_transactions WHERE txid='$activity[txid]'");
        $transaction = $GetTransaction->fetch_assoc();
        
        
        
        $amount = $activity[amount];
        $currency = $activity[currency];
        $recipient_id = $transaction[recipient];
        $sender_id = $activity[uid];
        
        //echo '<script>alert("'.$transaction[id].'");</script>';
        
        if($transaction['updated']==''){
            //echo "transaction is<br>";
            //print_r($transaction);
            //notification sender
            
            //send notification to admin
            $to = $settings['infoemail'];
            $subject = "New transaction in ".$settings['name'];
            $text = idinfo($sender_id,"first_name")." ".idinfo($sender_id,"last_name")." just transferred ".$amount." to ".idinfo($recipient_id,"first_name")." ".idinfo($recipient_id,"last_name")." using Square";
            $link = $settings['url'].'admin/?a=transactions&b=view&id='.$transaction['id'];
            PW_EmailSys_Send_Generic($to,$subject,$text,$link);
            
            //send notification to recipient
            $to = idinfo($recipient_id,"email");
            $amount = $transaction[amount] - $transaction[fee];
            //echo '<script>alert("'.$amount.'");</script>';
            $subject = "Congratulations! You have received a payment in ".$settings['name'];
            $text = "You have received ".$amount.$transaction[currency]." from ".idinfo($transaction['sender'],"first_name")." ".idinfo($transaction['sender'],"last_name")." and should be reflected in your balance within 1-2 business days";
            $link = $settings['url'].'account/transaction/'.$transaction[txid];
            PW_EmailSys_Send_Generic($to,$subject,$text,$link);
            
            //send notification to sender
            $to = idinfo($sender_id,"email");
            $amount = $transaction['amount'];
            $subject = "Transaction alert in ".$settings['name'];
            $text = "You have sent ".$amount.$transaction['currency']." to ".idinfo($transaction['recipient'],"first_name")." ".idinfo($transaction['recipient'],"last_name")." and should be reflected in user's balance within 1-2 business days";
            $link = $settings['url'].'account/transaction/'.$transaction['txid'];
            PW_EmailSys_Send_Generic($to,$subject,$text,$link);
            
            
            $update = $db->query("UPDATE pw_activity SET txid='$txnID',updated='$time',status='3' WHERE txid='$activity[txid]'");
            $update = $db->query("UPDATE pw_transactions SET txid='$txnID',updated='$time',status='3' WHERE txid='$activity[txid]'");
            
            $GetRequest = $db->query("SELECT * FROM pw_requests WHERE (uid='$_SESSION[pw_uid]' and fromu='$recipient_id' and status='1' and cast(amount as FLOAT)<='$amount' and curreny='$currency') ");
            if($GetRequest->num_rows>0){
                $getr = $GetRequest->fetch_assoc();
                PW_InsertNotification($_SESSION[pw_uid],$recipient_id,'You have accepted and sent '.$amount.' '.$currency.' to '.idinfo($recipient_id,"first_name").' '.idinfo($recipient_id,"last_name"),$amount,$currency,'6',time());
                //notification for reciever
                PW_InsertNotification($recipient_id,$_SESSION[pw_uid],idinfo($_SESSION[pw_uid],"first_name").' '.idinfo($_SESSION[pw_uid],"last_name").' has sent your requested amount of '.$amount.' '.$currency,$amount,$currency,'7',time());
                //PW_EmailSys_PaymentNotification($email,$amount,$currency,$description,$txid);
                $update_request = $db->query("UPDATE pw_requests SET status='3' WHERE id='$getr[id]' ");
            }
            else{
                PW_InsertNotification($_SESSION['pw_uid'],$recipient_id,'You have sent '.$amount.' '.$currency.' to '.idinfo($recipient_id,"first_name").' '.idinfo($recipient_id,"last_name").' and it will be reflected in their balance within next working day',$amount,$currency,'8',time());
                //notification reciever
                PW_InsertNotification($recipient_id,$_SESSION['pw_uid'],'You have recieved '.$amount.' '.$currency.' from '.idinfo($_SESSION['pw_uid'],"first_name").' '.idinfo($_SESSION['pw_uid'],"last_name").' and it will be reflected in your balance within next working day',$amount,$currency,'1',time());
            }
            
            
        }
        
        
    }
    //$GetDeposit = $db->query("SELECT * FROM pw_activity WHERE id='$_GET[referenceId]'");
    //$row = $GetDeposit->fetch_assoc();
    //PW_UpdateUserWallet($row['uid'],$row['amount'],$row['currency'],1);
}
if(isset($_SESSION['msg']) || isset($_GET['msg'])){
    $msg = $_SESSION['msg'];
    $msg_type = $_SESSION['msg_type'];
    //echo $_GET['type'].' '.$_GET['msg'];
    if($_GET['type']=='success' && $_GET['msg']=='send'){
        $msg = success('<b>Your payment was successfull.</b><br>You have successfully sent the funds!');
        $msg_type = "Send Money";
    }
    elseif($_GET['type']=='success' && $_GET['msg']=='deposit'){
        $msg = success('<b>Your deposit was successfull.</b>');
        $msg_type = "Deposit Money";
    }
    //echo 'msg is: '.$msg;  
}

?>
<!doctype html>
    <html lang="en" class="deeppurple-theme">

    <!-- Crypto Wallet -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="icrypto">

        <title>Home</title>

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
        .modal-backdrop {
            z-index:0;
        }
        @media(max-width:476px){
            .col-mob {
                width:35%; 
            }    
        }
         
        </style>
    </head>

    <body>
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
        <?php include('includes/sidebar.php');?>
        <div class="wrapper homepage">
            <!-- header -->
            <?php include('includes/header.php');?>
            <!-- header ends -->
            <?php
                $FormBTN = protect($_POST['pw_invite']);
                if($FormBTN == "invite") {
                    $msg_type = 'Invitation';
                    $invite_to = protect($_POST['invite_to']);
                    $invite_by = idinfo($_SESSION['pw_uid'],"email");
                    if(!preg_match("/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/",$invite_to)){
                        $msg = error("The email you entered is invalid.");
                    }else{
                        if(PW_EmailSys_Send_Invite($invite_to,$invite_by)){
                        $insert_activity = $db->query("INSERT pw_invites (invite_to,invite_by) VALUES ('$invite_to','$invite_by')");
                        $msg = success("Sent invitation successfully!");
                        //notification reciever
                        PW_InsertNotification($_SESSION['pw_uid'],0,'You have sent an invitation to '.$invite_to.' to join '.$settings['name'],$amount,$currency,'11',time());
            
                        }
                        else{
                            $msg = error("The user you are trying to inivite has already registered!");
                        }
                    }
                    
                } 
            ?>
            <div class="container">
                <div class="card bg-template shadow mt-4 h-190">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <a href="<?php echo $settings['url'].'account/settings/profile'?>"><figure class="avatar avatar-60"><img src="<?php echo $img_url; ?>" alt=""></figure></a>
                            </div>
                            <div class="col pl-0 align-self-center">
                                <a href="<?php echo $settings['url'].'account/settings/profile'?>" style="color:white;"><h5 class="mb-1"><?php echo idinfo($_SESSION['pw_uid'],"first_name"); ?> <?php echo idinfo($_SESSION['pw_uid'],"last_name"); ?></h5></a>
                                <p class="text-mute small"><?php echo idinfo($_SESSION['pw_uid'],"city"); ?>, <?php echo idinfo($_SESSION['pw_uid'],"country"); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container top-100">
                <div class="card mb-4 shadow">
                    <div class="card-body border-bottom">
                        <div class="row">
                            <div class="col">
                                <?php
                                $balance = get_user_balance($_SESSION['pw_uid']);
                                echo '<style>sup{top:0;}</style>';
                                ?>
                                <h3 class="mb-0 font-weight-normal"><?php echo $balance['balance']; ?></h3>
                                <p class="text-mute">My Balance</p>
                            </div>
                            <div class="col-auto" style="width:min-content;">
                                <button class="btn btn-default btn-rounded-54 shadow" onclick="window.location.href='<?php echo $settings['url']; ?>account/money/deposit';"><i class="material-icons">add</i></button>
                                <p class="small mt-2">Deposit Money</p>
                            </div>
                            <div class="col-auto"  style="width:min-content;">
                                <button class="btn btn-default btn-rounded-54 shadow" onclick="window.location.href='<?php echo $settings['url']; ?>account/money/withdrawal';"><i class="material-icons">remove</i></button>
                                <p class="small mt-2">Withdraw To Bank</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="swiper-container icon-slide mb-4">
                        <div class="swiper-wrapper">
                            <a href="<?php echo $settings['url']; ?>account/money/request" class="swiper-slide text-center">
                                <div class="avatar avatar-60 no-shadow border-0">
                                    <div class="overlay bg-template"></div>
                                    <i class="material-icons text-template">local_atm</i>
                                </div>
                                <p class="small mt-2">Request</p>
                            </a>
                            <a href="<?php echo $settings['url']; ?>account/money/send" class="swiper-slide text-center">
                                <div class="avatar avatar-60 no-shadow border-0">
                                    <div class="overlay bg-template"></div>
                                    <i class="material-icons text-template">send</i>
                                </div>
                                <p class="small mt-2">Send</p>
                            </a>
                            <a href="#" class="swiper-slide text-center" data-toggle="modal" data-target="#bookmodal">
                            <div class="avatar avatar-60 no-shadow border-0">
                                <div class="overlay bg-template"></div>
                                <i class="material-icons text-template">directions_railway</i>
                            </div>
                            <p class="small mt-2">Book</p>
                            </a>
                            
                            <!--invite button-->
                            <a href="#" class="swiper-slide text-center" id="invitebtn" data-toggle="modal" data-target="#invitemodal">
                                <div class="avatar avatar-60 no-shadow border-0">
                                    <div class="overlay bg-template"></div>
                                    <i class="material-icons text-template">email</i>
                                </div>
                                <p class="small mt-2">Invite</p>
                            </a>
                            
                            <!--msg button-->
                            <a href="#" class="swiper-slide text-center" id="msgmodalbtn" style="display:none;" data-toggle="modal" data-target="#msgmodal">
                                <div class="avatar avatar-60 no-shadow border-0">
                                    <div class="overlay bg-template"></div>
                                    <i class="material-icons text-template">email</i>
                                </div>
                                <p class="small mt-2">Invite</p>
                            </a>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>

            <?php /*echo <div class="row mb-2">
                    <div class="container px-0">
                        <!-- Swiper -->
                        <div class="swiper-container two-slide">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="card shadow border-0">
                                        <div class="card-body">
                                            <div class="row no-gutters h-100">
                                                <div class="col">
                                                    <p>$ 1548.00<br><small class="text-secondary">Home Loan EMI</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card shadow border-0">
                                        <div class="card-body">
                                            <div class="row no-gutters h-100">
                                                <div class="col">
                                                    <p>$ 1548.00<br><small class="text-secondary">Cash Loan EMI</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card shadow border-0">
                                        <div class="card-body">
                                            <div class="row no-gutters h-100">
                                                <div class="col">
                                                    <p>$ 1548.00<br><small class="text-secondary">Car Loan EMI</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card shadow border-0">
                                        <div class="card-body">
                                            <div class="row no-gutters h-100">
                                                <div class="col">
                                                    <p>$ 1548.00<br><small class="text-secondary">Business Loan EMI</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card shadow border-0">
                                        <div class="card-body">
                                            <div class="row no-gutters h-100">
                                                <div class="col">
                                                    <p>$ 1548.00<br><small class="text-secondary">Edu Loan EMI</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card shadow border-0">
                                        <div class="card-body">
                                            <div class="row no-gutters h-100">
                                                <div class="col">
                                                    <p>$ 1548.00<br><small class="text-secondary">Home Loan EMI</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="container px-0">
                        <!-- Swiper -->
                        <div class="swiper-container offer-slide">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="card shadow border-0 bg-template">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto pr-0">
                                                    <img src="<?php echo $settings['url']; ?>icrypto_assets/img/graphics-carousel-scheme1.png" alt="" class="mw-100">
                                                </div>
                                                <div class="col align-self-center">
                                                    <h5 class="mb-2 font-weight-normal">Gold loan scheme</h5>
                                                    <p class="text-mute">Get all money at market rate of gold</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="card shadow border-0 bg-template">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col pr-0 align-self-center">
                                                    <h5 class="mb-2 font-weight-normal">Gold loan scheme</h5>
                                                    <p class="text-mute">Get all money at market rate of gold</p>
                                                </div>
                                                <div class="col-auto">
                                                    <img src="<?php echo $settings['url']; ?>icrypto_assets/img/graphics-carousel-scheme1.png" alt="" class="mw-100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <h6 class="subtitle">Recent Messages</h6>
                <div class="card shadow border-0 mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <div class="avatar avatar-60 no-shadow border-0">
                                    <img src="<?php echo $settings['url']; ?>icrypto_assets/img/user1.png" alt="">
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="font-weight-normal mb-1">Mrs. Magon Johnson </h6>
                                <p class="text-mute small text-secondary">"Thank you for your purchase with our shop and making online payment."</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-top bg-none">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Quick reply" aria-describedby="button-addon4">
                            <div class="input-group-append">
                                <button class="btn btn-default btn-rounded-36 shadow-sm" type="button" id="button-addon4"><i class="material-icons md-18">send</i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow border-0 mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <div class="avatar avatar-60 no-shadow border-0">
                                    <img src="<?php echo $settings['url']; ?>icrypto_assets/img/user2.png" alt="">
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="font-weight-normal mb-1">Ms. Shivani Dilux</h6>
                                <p class="text-mute small text-secondary">"Thank you for your purchase with our shop and making online payment."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>*/; ?>
            <?php
            $GetUserRequests = $db->query("SELECT * FROM pw_requests WHERE uid='$_SESSION[pw_uid]' and status='1'");
            if($GetUserRequests->num_rows>0) {
                ?>
            <div class="container">
                <h6 class="subtitle"><?php echo $lang['head_requests']; ?></h6>
                <?php while($gur = $GetUserRequests->fetch_assoc()) { ?>
                <div class="card shadow border-0 mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="font-weight-normal mb-1"><?php if(idinfo($gur['fromu'],"account_type") == "1") { echo idinfo($gur['fromu'],"first_name")." ".idinfo($gur['fromu'],"last_name"); } else { echo idinfo($gur['fromu'],"business_name"); } ?> request <?php echo $gur['amount']." ".$gur['currency']; ?> from you.</h5>
                                <p class="text-mute small text-secondary mb-2"><?php echo $gur['description']; ?></p>
                            </div>
                            <div class="col-auto pl-0">
                                <button onclick="window.location.href='<?php echo $settings['url']; ?>account/money/request/pay/<?php echo $gur['id']; ?>'" class="avatar avatar-50 no-shadow border-0 bg-template">
                                    <i class="material-icons">check</i>
                                </button>
                            </div>
                            <div class="col-auto pl-0">
                                <button onclick="window.location.href='<?php echo $settings['url']; ?>account/money/request/cancel/<?php echo $gur['id']; ?>'" class="avatar avatar-50 no-shadow border-0 bg-template">
                                    <i class="material-icons">close</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
            <?php 
            }?>
            <div class="container">
                <h6 class="subtitle"><?php echo $lang['head_recent_activity']; ?><a class="float-right small" href="<?php echo $settings['url']; ?>account/activity">View all</a></h6>
                <?php
                $GetUserActivity = $db->query("SELECT * FROM pw_activity WHERE uid='$_SESSION[pw_uid]' ORDER BY id DESC LIMIT 10");
                if($GetUserActivity->num_rows>0) {
                    while($gua = $GetUserActivity->fetch_assoc()) {
                        if($gua['status'] != '6'){
                            $amount = $gua['amount'];
                        if($gua['type'] == "2" or $gua['type'] == "4" or $gua['type'] == "6" or $gua['type'] == "7" or $gua['type'] == "8") {
                            $amount = '-'.$amount;
                        } else {
                            $amount = '+'.$amount;
                        }
                        
                        clearstatcache();
                        $target_dir = "uploads/";
                        $target_file = $target_dir.$gua['u_field_1'];
                        
                        //echo "targer is:".$target_file;
                        if (file_exists($target_file.".jpg")) {
                          $img_url_act = $settings['url'].'uploads/'.$gua['u_field_1'].'.jpg';
                          $file= $target_file.".jpg";
                          $jpg_time = filemtime($target_file.".jpg");
                          //echo "han jpg h";
                        }
                        else if (file_exists($target_file.".png") && (filemtime($target_file.".png") > $jpg_time)) {
                          $img_url_act = $settings['url'].'uploads/'.$gua['u_field_1'].'.png';
                          $png_time = filemtime($target_file.".png");
                          $file= $target_file.".png";
                           //echo "han jpg2 h";
                        }
                        else if (file_exists($target_file.".jpeg") && (filemtime($target_file.".jpeg") > $jpg_time) && (filemtime($target_file.".jpeg") > $png_time)) {
                          $img_url_act = $settings['url'].'uploads/'.$gua['u_field_1'].'.jpeg';
                          $file= $target_file.".jpeg";
                           //echo "han jpg3 h";
                        }
                        else if($gua['type']=='3' || $gua['type']=='4'){
                            $img_url_act = $img_url;
                        }
                        else {
                            $img_url_act = $settings['url'].'uploads/default.jpg';
                        }
                        $img_url_act= $img_url_act."?t=".time();
                echo '<a href="'.$settings[url].'account/transaction/'.$gua[txid].'"><div class="card shadow border-0 mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <div class="avatar avatar-50 no-shadow border-0">
                                    <img src="'.$img_url_act.'" alt="">
                                    <!--<div class="overlay bg-template"></div>
                                    <i class="material-icons vm text-template">local_atm</i>-->
                                </div>
                            </div>
                            <div class="col align-self-center pr-0">
                                <h6 class="font-weight-normal mb-1">'.PW_DecodeUserActivity($gua[id]).'</h6>
                                <p class="text-mute small text-secondary" style="margin-bottom:3px;">'.PW_DecodeTXStatus($gua[status]).'</p>
                                <p class="text-mute small text-secondary">';if($gua[deposit_via]!=''){echo 'From '.gatewayinfo($gua[deposit_via],"name");}
                                echo '</p>
                            </div>
                            <div class="col-auto col-mob">';
                            if($amount[0]=='+'){
                                echo '<h6 class="font-weight-normal mb-1 text-success">'.$amount.' '.$gua[currency].'</h6>';
                            }
                            else if($amount[0]=='-'){
                                echo '<h6 class="font-weight-normal mb-1 text-danger">'.$amount.' '.$gua[currency].'</h6>';
                            }
                            
                                echo '<p class="text-mute small text-secondary" style="margin-bottom: 0px;">'.PW_ActivityDate($gua[created]).'</p>
                                
                            </div>
                        </div>
                    </div>
                </div></a>';
                        }
                    }
                }
                else{
                    echo '<a><div class="card shadow border-0 mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto pr-0">
                                <div class="avatar avatar-50 no-shadow border-0">
                                    <div class="overlay bg-template"></div>
                                    <i class="material-icons vm text-template">local_atm</i>
                                </div>
                            </div>
                            <div class="col align-self-center pr-0">
                                <h6 class="font-weight-normal mb-1">Your transactions will appear here.</h6>
                                <p class="text-mute small text-secondary">Your transaction details.</p>
                            </div>
                            <div class="col-auto">
                            <h6 class="font-weight-normal mb-1 text-success">$0.00</h6>
                            <p class="text-mute small text-secondary">'.date("d M Y H:i a").'</p>
                            </div>
                        </div>
                    </div>
                </div></a>';
                }?>
            </div>
            <?php /* 
            <div class="container">
                <h6 class="subtitle">News Updates</h6>
                <div class="row">
                    <!-- Swiper -->
                    <div class="swiper-container news-slide">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="card shadow-sm border-0 bg-dark text-white">
                                    <figure class="background">
                                        <img src="<?php echo $settings['url']; ?>icrypto_assets/img/product2.jpg" alt="">
                                    </figure>
                                    <div class="card-body">
                                        <a href="#" class="btn btn-default btn-rounded-36 shadow-sm float-bottom-right"><i class="material-icons md-18">arrow_forward</i></a>
                                        <h5 class="small">Multipurpose Juice allows you to grow faster</h5>
                                        <p class="text-mute small">By Anand Mangal</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card shadow-sm border-0 bg-dark text-white">
                                    <figure class="background">
                                        <img src="<?php echo $settings['url']; ?>icrypto_assets/img/product3.jpg" alt="">
                                    </figure>
                                    <div class="card-body">
                                        <a href="#" class="btn btn-default btn-rounded-36 shadow-sm float-bottom-right"><i class="material-icons md-18">arrow_forward</i></a>
                                        <h5 class="small">Multipurpose Juice allows you to grow faster</h5>
                                        <p class="text-mute small">By Anand Mangal</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card shadow-sm border-0 bg-dark text-white">
                                    <figure class="background">
                                        <img src="<?php echo $settings['url']; ?>icrypto_assets/img/product2.jpg" alt="">
                                    </figure>
                                    <div class="card-body">
                                        <a href="#" class="btn btn-default btn-rounded-36 shadow-sm float-bottom-right"><i class="material-icons md-18">arrow_forward</i></a>
                                        <h5 class="small">Multipurpose Juice allows you to grow faster</h5>
                                        <p class="text-mute small">By Anand Mangal</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card shadow-sm border-0 bg-dark text-white">
                                    <figure class="background">
                                        <img src="<?php echo $settings['url']; ?>icrypto_assets/img/product3.jpg" alt="">
                                    </figure>
                                    <div class="card-body">
                                        <a href="#" class="btn btn-default btn-rounded-36 shadow-sm float-bottom-right"><i class="material-icons md-18">arrow_forward</i></a>
                                        <h5 class="small">Multipurpose Juice allows you to grow faster</h5>
                                        <p class="text-mute small">By Anand Mangal</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card shadow-sm border-0 bg-dark text-white">
                                    <figure class="background">
                                        <img src="<?php echo $settings['url']; ?>icrypto_assets/img/product2.jpg" alt="">
                                    </figure>
                                    <div class="card-body">
                                        <a href="#" class="btn btn-default btn-rounded-36 shadow-sm float-bottom-right"><i class="material-icons md-18">arrow_forward</i></a>
                                        <h5 class="small">Multipurpose Juice allows you to grow faster</h5>
                                        <p class="text-mute small">By Anand Mangal</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card shadow-sm border-0 bg-dark text-white">
                                    <figure class="background">
                                        <img src="<?php echo $settings['url']; ?>icrypto_assets/img/product3.jpg" alt="">
                                    </figure>
                                    <div class="card-body">
                                        <a href="#" class="btn btn-default btn-rounded-36 shadow-sm float-bottom-right"><i class="material-icons md-18">arrow_forward</i></a>
                                        <h5 class="small">Multipurpose Juice allows you to grow faster</h5>
                                        <p class="text-mute small">By Anand Mangal</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <h5 class="subtitle mb-1">Most Exciting Feature</h5>
                        <p class="text-secondary">Take a look at our services</p>
                    </div>
                </div>
                <div class="row text-center mt-4">
                    <div class="col-6 col-md-3">
                        <div class="card shadow border-0 mb-3">
                            <div class="card-body">
                                <div class="avatar avatar-60 no-shadow border-0">
                                    <div class="overlay bg-template"></div>
                                    <i class="material-icons vm md-36 text-template">card_giftcard</i>
                                </div>
                                <h3 class="mt-3 mb-0 font-weight-normal">2546</h3>
                                <p class="text-secondary text-mute small">Gift it out</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card shadow border-0 mb-3">
                            <div class="card-body">
                                <div class="avatar avatar-60 no-shadow border-0">
                                    <div class="overlay bg-template"></div>
                                    <i class="material-icons vm md-36 text-template">subscriptions</i>
                                </div>
                                <h3 class="mt-3 mb-0 font-weight-normal">635</h3>
                                <p class="text-secondary text-mute small">Monthly Billed</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card shadow border-0 mb-3">
                            <div class="card-body">
                                <div class="avatar avatar-60 no-shadow border-0">
                                    <div class="overlay bg-template"></div>
                                    <i class="material-icons vm md-36 text-template">local_florist</i>
                                </div>
                                <h3 class="mt-3 mb-0 font-weight-normal">1542</h3>
                                <p class="text-secondary text-mute small">Eco environment</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card shadow border-0 mb-3">
                            <div class="card-body">
                                <div class="avatar avatar-60 no-shadow border-0">
                                    <div class="overlay bg-template"></div>
                                    <i class="material-icons vm md-36 text-template">location_city</i>
                                </div>
                                <h3 class="mt-3 mb-0 font-weight-normal">154</h3>
                                <p class="text-secondary text-mute small">Four Offices</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>*/
            ?>

            <!-- footer-->
            <?php include('includes/footer.php');?>
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

        <!-- Modal -->
        <div class="modal fade" id="addmoney" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center pt-0">
                        <img src="<?php echo $settings['url']; ?>icrypto_assets/img/infomarmation-graphics2.png" alt="logo" class="logo-small">
                        <div class="form-group mt-4">
                            <input type="text" class="form-control form-control-lg text-center" placeholder="Enter amount" required="" autofocus="">
                        </div>
                        <p class="text-mute">You will be redirected to payment gatway to procceed further. Enter amount in USD.</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-default btn-lg btn-rounded shadow btn-block" class="close" data-dismiss="modal">Next</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal DEposite-->
        <div class="modal fade" id="sendmoney" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5>Send Money</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="form-group mt-4">
                            <select class="form-control form-control-lg text-center">
                                <option>Mrs. Magon Johnson</option>
                                <option selected>Ms. Shivani Dilux</option>
                            </select>
                        </div>

                        <div class="card shadow border-0 mb-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto pr-0">
                                        <div class="avatar avatar-60 no-shadow border-0">
                                            <img src="<?php echo $settings['url']; ?>icrypto_assets/img/user2.png" alt="">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="font-weight-normal mb-1">Ms. Shivani Dilux</h6>
                                        <p class="text-mute small text-secondary">London, UK</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center mt-4">
                            <input type="text" class="form-control form-control-lg text-center" placeholder="Enter amount" required="" autofocus="">
                        </div>
                        <p class="text-mute text-center">You will be redirected to payment gatway to procceed further. Enter amount in USD.</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-default btn-lg btn-rounded shadow btn-block" class="close" data-dismiss="modal">Next</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="paymodal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5>Pay</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input">
                            <label class="custom-control-label" for="customRadioInline1">To Bill</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input" checked>
                            <label class="custom-control-label" for="customRadioInline2">To Person</label>
                        </div>

                        <div class="form-group mt-4">
                            <select class="form-control text-center">
                                <option>Mrs. Magon Johnson</option>
                                <option selected>Ms. Shivani Dilux</option>
                            </select>
                        </div>

                        <div class="card shadow border-0 mb-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto pr-0">
                                        <div class="avatar avatar-60 no-shadow border-0">
                                            <img src="<?php echo $settings['url']; ?>icrypto_assets/img/user2.png" alt="">
                                        </div>
                                    </div>
                                    <div class="col align-self-center">
                                        <h6 class="font-weight-normal mb-1">Ms. Shivani Dilux</h6>
                                        <p class="text-mute small text-secondary">London, UK</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center mt-4">
                            <input type="text" class="form-control form-control-lg text-center" placeholder="Enter amount" required="" autofocus="">
                        </div>
                        <p class="text-mute text-center">You will be redirected to payment gatway to procceed further. Enter amount in USD.</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-default btn-lg btn-rounded shadow btn-block" class="close" data-dismiss="modal">Next</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Book-->
        <div class="modal fade" id="bookmodal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5>Pay</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline12" name="customRadioInline12" class="custom-control-input">
                            <label class="custom-control-label" for="customRadioInline12">Flight</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline22" name="customRadioInline12" class="custom-control-input" checked>
                            <label class="custom-control-label" for="customRadioInline22">Train</label>
                        </div>
                        <h6 class="subtitle">Select Location</h6>
                        <div class="form-group mt-4">
                            <input type="text" class="form-control text-center" placeholder="Select start point" required="" autofocus="">
                        </div>
                        <div class="form-group mt-4">
                            <input type="text" class="form-control text-center" placeholder="Select end point" required="">
                        </div>
                        <h6 class="subtitle">Select Date</h6>
                        <div class="form-group mt-4">
                            <input type="date" class="form-control text-center" placeholder="Select end point" required="">
                        </div>
                        <h6 class="subtitle">number of passangers</h6>
                        <div class="form-group mt-4">
                            <select class="form-control  text-center">
                                <option>1</option>
                                <option selected>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                            </select>
                        </div>                    
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-default btn-lg btn-rounded shadow btn-block" class="close" data-dismiss="modal">Next</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Invite-->
        <div class="modal fade" id="invitemodal" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content shadow">
                    <div class="modal-header">
                        <h5 class="header-title mb-0">Invite</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center pr-4 pl-4">
                        <h5 class="my-3">Enter the email to send invitation:</h5>
                        <form method="POST" action="">
                            <div class="form-group text-left float-label">
                                <input type="email" autocomplete=off class="form-control text-center" name="invite_to" placeholder="Email" required>
                                <button class="overlay btn btn-sm btn-link text-success">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="pw_invite" value="invite" class="btn btn-default btn-rounded btn-block col">Send Invitation</button>
                                <br>
                            </div>
                        </form>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if(isset($msg)){?>
        <!-- Modal Message-->
        <div class="modal fade" id="msgmodal" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content shadow">
                    <div class="modal-header" <?php if(isset($_SESSION['limit_reached'])){echo 'style="align-self:center;"';} ?>>
                        <h5 class="header-title mb-0"><?php echo $msg_type;?></h5>
                        <?php 
                            if(!isset($_SESSION['limit_reached'])){
                                echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>';
                            }
                            else{
                                unset($_SESSION['limit_reached']);
                            }
                        ?>
                    </div>
                    <div class="modal-body text-center pr-4 pl-4">
                        <?php echo $msg; ?>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        
        <?php } ?>
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
        <?php if(isset($msg)){?>
        <script>
            //$("body").addClass("modal-open");
            
        </script>
        <div class="modal-backdrop fade show" id="dimmer" style="z-index:9;display:block;"></div>
        <?php } ?>
        <div class="modal-backdrop fade show" id="dimmer" style="z-index:9;display:none;"></div>
        <!-- page level script -->
        <script>
            $('#msgmodalbtn').click();
            $(document).ready(function() {
                $("body").off("dblclick");
            });
            $('#invitebtn').on("click",function(){
                ///alert("click");
                $('#dimmer').css("display","block");
            });
            $('.close').on("click",function(){
                $('#dimmer').css("display","none");
            });
            $("#msgmodal").on("click",function(){
                $("#dimmer").css("display","none");
            });
            $("#invitemodal").on("click",function(){
                $("#dimmer").css("display","none");
            });
            

        </script>
    </body>
    </html>
    <?php
    if(isset($_SESSION['msg'])){
      unset($_SESSION['msg']);
      unset($_SESSION['msg_type']);
      //echo 'msg is: '.$msg;  
    }
    ?>
