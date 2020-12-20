<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$hash = protect($_GET['hash']);
if(empty($hash)) {
    $hash = strtoupper(randomHash(30));
    $time = time();
    $merchant_account = protect($_POST['merchant_account']);
    $item_number = protect($_POST['item_number']);
    $item_name = protect($_POST['item_name']);
    $item_price = protect($_POST['item_price']);
    $item_currency = protect($_POST['item_currency']);
    $return_success = protect($_POST['return_success']);
    $return_fail = protect($_POST['return_fail']);
    $return_cancel = protect($_POST['return_cancel']);
    $merchant_id = PW_GetUserID($merchant_account);
    if($merchant_id==false) {
        $results = error("Merchant does not exists.");
    } elseif(idinfo($merchant_id,"account_type") !== "2") {
        $results = error("$merchant_account cannot accept payments. Only Business accounts can accept payments.");
    } elseif(empty($item_number) or empty($item_name) or empty($item_price) or empty($item_currency) or empty($return_success) or empty($return_fail) or empty($return_cancel)) {
        $devlink = $settings['url']."merchant";
        $devlink = '<a href="'.$devlink.'">'.$devlink.'</a>';
        $results = error("Some data from HTML form is missing. Please read merchant integration page $devlink");
    } else {
        $insert = $db->query("INSERT pw_payments (hash,merchant_account,item_number,item_name,item_price,item_currency,return_success,return_fail,return_cancel,payment_time,payment_status) VALUES ('$hash','$merchant_account','$item_number','$item_name','$item_price','$item_currency','$return_success','$return_fail','$return_cancel','$time','1')");
		$_SESSION['bb_payment_hash'] = $hash;
	    $_SESSION['bb_payment_time'] = $time+600;
		$redirect = $settings['url']."payment/".$hash;
		header("Location: $redirect");
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/slick.css">
    <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/responsive.css">
    <title>Payment Error - <?php echo $settings['name']; ?></title>
    <meta name="description" content="<?php echo $settings['description']; ?>">
    <meta name="keywords" content="<?php echo $settings['keywords']; ?>">
    <meta name="author" content="CryptoExchanger">
    </head>
    <body class="prowallet-body-bg">
        <div class="user-login-signup-section modal-container">
            <?php 
            if(checkSession()) {
                include("menu_logged.php"); 
            } else {
                include("menu_notlogged.php");
            }
            ?>
            <div class="container">
                <div class="user-login-signup-form-wrap">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="user-connected-form-block">
                                <h3>Payment Error</h3>
                                <hr/>
                                <?php echo $results; ?>
                                
                            </div><!-- create-account-block -->
                        </div>
                    </div>
                </div><!-- user-login-signup-form-wrap -->
            </div>
            <div class="container">
                    <div class="col-md-12 prowallet-footer-text-white">
                        <center>Copyright &copy; 2020 <?php echo $settings['name']; ?>.</center>
                    </div>  
            </div>
        </div><!-- user-login-signup-section -->
        <script src="<?php echo $settings['url']; ?>assets/js/jquery-1.12.4.min.js"></script>
        <script src="<?php echo $settings['url']; ?>assets/js/popper.min.js"></script>
        <script src="<?php echo $settings['url']; ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo $settings['url']; ?>assets/js/slick.min.js"></script>
        <script src="<?php echo $settings['url']; ?>assets/js/jquery.peity.min.js"></script>
        <script src="<?php echo $settings['url']; ?>assets/js/jquery.slimscroll.min.js"></script>
        <script src="<?php echo $settings['url']; ?>assets/js/custom.js"></script>
    </body>
    </html>
    <?php
} else { 
$hash = protect($_GET['hash']);
$query = $db->query("SELECT * FROM pw_payments WHERE hash='$hash'");
if($query->num_rows==0) {
    header("Location: $settings[url]");
}
$row = $query->fetch_assoc();
$merchant_id = PW_GetUserID($row['merchant_account']);
$results = '';
$hide_info = '0';
$FormBTN = protect($_POST['pw_action']);
if($FormBTN == "pay") {
    if($row['payment_status'] == "1") {
        $item_price = $row['item_price'];
        $user_balance = get_wallet_balance($_SESSION['pw_uid'],$row['item_currency']);
        if($user_balance>$item_price) {
            $amount = number_format($item_price, 2, '.', '');
            $currency = $row['item_currency'];
            $recipient_id = PW_GetUserID($row['merchant_account']);
            $fee = ($amount * $settings['payfee_percentage']) / 100;
            $amount_with_fee = $amount - $fee;
            PW_UpdateUserWallet($_SESSION['pw_uid'],$amount,$currency,2);
            PW_UpdateUserWallet($recipient_id,$amount_with_fee,$currency,1);
            $txid = strtoupper(randomHash(30));
            $time = time();
            $create_transaction = $db->query("INSERT pw_transactions (txid,type,sender,recipient,description,amount,currency,fee,status,created,item_id,item_name) VALUES ('$txid','1','$_SESSION[pw_uid]','$recipient_id','$description','$amount','$currency','$fee','1','$time','$row[item_number]','$row[item_name]')");
            $insert_activity = $db->query("INSERT pw_activity (txid,type,uid,u_field_1,amount,currency,status,created) VALUES ('$txid','2','$_SESSION[pw_uid]','$recipient_id','$amount','$currency','1','$time')");
            $insert_activity = $db->query("INSERT pw_activity (txid,type,uid,u_field_1,amount,currency,status,created) VALUES ('$txid','1','$recipient_id','$_SESSION[pw_uid]','$amount_with_fee','$currency','1','$time')");
            $update = $db->query("UPDATE pw_payments SET payment_status='4',txid='$txid' WHERE id='$row[id]'");
            $row['payment_status'] = '4';
            $row['txid'] = $txid;
            PW_UpdateAdminWallet($fee,$currency);
            $insert_admin_log = $db->query("INSERT pw_admin_logs (type,time,u_field_1,u_field_2,u_field_3) VALUES ('1','$time','$fee','$currency','$txid')");
            PW_EmailSys_PaymentNotification($email,$amount,$currency,$description,$txid);
            $results = '<form id="PW_Payment_Success_Form" method="POST" action="'.$row[return_success].'">
                    <input type="hidden" name="merchant_account" value="'.$row[merchant_account].'">
                    <input type="hidden" name="item_number" value="'.$row[item_number].'">
                    <input type="hidden" name="item_name" value="'.$row[item_name].'">
                    <input type="hidden" name="item_price" value="'.$row[item_price].'">
                    <input type="hidden" name="item_currency" value="'.$row[item_currency].'">
                    <input type="hidden" name="txid" value="'.$row[txid].'">
                    <input type="hidden" name="payment_time " value="'.$time.'">
                    <input type="hidden" name="payee_account " value="'.idinfo($_SESSION[pw_uid],"email").'">
                </form><script src="'.$settings[url].'assets/js/jquery-1.12.4.min.js"></script>';
            $results .= " <script type='text/javascript'>
                $(document).ready(function() {
                    $('#PW_Payment_Success_Form')[0].submit();
                }); 
                </script>";
            $results .= success("Payment was successful. Redirecting to merchant website, please wait...");
        } else {
            $update = $db->query("UPDATE pw_payments SET payment_status='3' WHERE id='$row[id]'");
            $row['payment_status'] = '3';
            $results = '<meta http-equiv="refresh" content="0;URL='.$row[return_fail].'" />';
            $results .= error("Payment was failed. You do not have enough funds. Redirecting to merchant website...");
        }
    }
} 
if($FormBTN == "cancel") {
    if($row['payment_status'] == "1") {
        $update = $db->query("UPDATE pw_payments SET payment_status='2' WHERE id='$row[id]'");
        $row['payment_status'] = '2';
        $results = '<meta http-equiv="refresh" content="0;URL='.$row[return_cancel].'" />';
        $results .= success("Payment was canceled. Redirecting to merchant website...");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/fontawesome-all.min.css">
  <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/themify-icons.css">
  <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/slick.css">
  <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/css/responsive.css">
  <title>Payment - <?php echo $settings['name']; ?></title>
  <meta name="description" content="<?php echo $settings['description']; ?>">
  <meta name="keywords" content="<?php echo $settings['keywords']; ?>">
  <meta name="author" content="CryptoExchanger">
</head>
<body class="prowallet-body-bg">
    <div class="user-login-signup-section modal-container">
        <?php 
        if(checkSession()) {
            include("menu_logged.php"); 
        } else {
            include("menu_notlogged.php");
        }
        ?>
        <div class="container">
            <div class="user-login-signup-form-wrap">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="user-connected-form-block">
                            <h3><?php echo idinfo($merchant_id,"business_name"); ?> <small class="text text-muted">merchant</small></h3>
                            <?php if($results) { echo $results; } ?>
                            <p>Payment ID: <?php echo $row['hash']; ?>
                            <?php if($row['txid']) { ?><br/>Transaction ID: <?php echo $row['txid']; ?><?php } ?><br><br></p>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Item ID</th>
                                        <th>Item Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $row['item_number']; ?></td>
                                        <td><?php echo $row['item_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <span class="float-right">Amount: <?php echo $row['item_price']." ".$row['item_currency']; ?></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <?php if(checkSession()) { 
                                if($_SESSION['pw_payorder_url']) {
                                    $_SESSION['pw_payorder_url'] = false;
                                 }
                                ?>
                                <?php if($_SESSION['pw_uid'] !== $merchant_id) { ?>
                                    <?php if($row['payment_status'] == "1") { ?>
                                    <br>
                                    <p><center>You are logged as <b><?php if(idinfo($_SESSION['pw_uid'],"account_type") == "1") { echo idinfo($_SESSION[pw_uid],"first_name").' '.idinfo($_SESSION[pw_uid],"last_name"); } else { echo idinfo($_SESSION['pw_uid'],"busness_name"); } ?></b><br/>Balance: <?php echo get_wallet_balance($_SESSION['pw_uid'],$row['item_currency']); ?> <?php echo $row['item_currency']; ?></center><br/></p>
                                    <p><center>
                                        <form action="" method="POST">
                                            <button type="submit" name="pw_action" value="pay" class="btn btn-primary">Pay</button> 
                                            <button type="submit" name="pw_action" value="cancel" class="btn btn-danger">Cancel</button>
                                        </form>
                                    </center>
                                    </p>
                                    <?php } ?>
                                <?php } ?>
                            <?php } else { 
                                $_SESSION['pw_payorder_url'] = $settings['url']."payment/".$row['hash'];
                                ?>
                                <br/>
                                <p><center>Pay with your <?php echo $settings['name']; ?> account</center><br/></p>
                                <p><center>
                                    <a href="<?php echo $settings['url']; ?>login" class="btn btn-primary">Login</a> or 
                                    <a href="<?php echo $settings['url']; ?>register" class="btn btn-primary">Register</a>
                                </center></p>
                            <?php } ?>
                            
                        </div><!-- create-account-block -->
                    </div>
                </div>
            </div><!-- user-login-signup-form-wrap -->
        </div>
        <div class="container">
                <div class="col-md-12 prowallet-footer-text-white">
                    <center>Copyright &copy; 2020 <?php echo $settings['name']; ?>.</center>
                </div>  
        </div>
    </div><!-- user-login-signup-section -->
    <script src="<?php echo $settings['url']; ?>assets/js/jquery-1.12.4.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/popper.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/slick.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/jquery.peity.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/custom.js"></script>
</body>
</html>
<?php
}
?>