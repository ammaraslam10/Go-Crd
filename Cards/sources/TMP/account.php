<?php
// Crypto Wallet
// Author: Crypto Wallet
/*if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}*/

// Check if user is not logged, redirect it to login page
if(!checkSession()) {
    $redirect = $settings['url']."login";
    header("Location: $redirect");
}

//include("account/money.php");
$b = protect($_GET['b']);
//echo '<script>alert("'.$b.'");</script>';
if($b == "activity") {
    $redirect = $settings['url']."account/activity";
    //header("Location: $redirect");
    include("account/activity.php");
}
//case "money": include("account/money.php"); break;
else if($b == "money"){
    include("account/money.php");
}
else if($b == "summary"){
    include("account/summary.php");
}
else if($b == "notifications"){
    //echo "in notifs";
    include("account/notif.php");
    //include("account/notifications.php");
    //echo "after inc";
}
else if($b == "withdrawal"){
    include("account/withdraw.php");
}
else if($b == "settings"){
    include("account/settings.php");
}
else if($b == "transaction"){
    include("account/transaction.php");
}
else if($b == "balance"){
    include("account/balance.php");
}
else{ ?>

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
  <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/plugins/jquery-ui/jquery-ui.min.css" />
  <title>
  <?php
  // Get a current page and display different title for every page
  $b = protect($_GET['b']);
  if($b == "summary") { echo $lang['title_summary']; } 
  elseif($b == "transaction") { echo $lang['title_transaction_details']; } 
  elseif($b == "settings") { echo $lang['title_account_settings']; } 
  elseif($b == "balance") { echo $lang['title_balance']; }
  elseif($b == "money") {
      $c = protect($_GET['c']);
      if($c == "deposit") { echo $lang['title_deposit_money']; }
      elseif($c == "request") { echo $lang['title_request_money']; }
      elseif($c == "converter") { echo $lang['title_currencyconverter']; }
      elseif($c == "send") { echo $lang['title_send_money']; } 
      elseif($c == "withdrawal") { echo $lang['title_withdrawal_funds']; }
      else { }
  } elseif($b == "activity") { echo $lang['title_activity']; } 
  elseif($b == "disputes") { 
      $c = protect($_GET['c']);
      if($c == "open") { echo $lang['title_open_dispute']; }
      elseif($c == "close") { echo $lang['title_close_dispute']; }
      elseif($c == "escalate") { echo $lang['title_escalate_for_review']; }
      elseif($c == "dispute") { echo $lang['title_dispute_details']; }
      elseif($c == "disputes") { echo $lang['title_disputes']; }
      else { echo $lang['title_disputes']; }
  } else {}
  ?>
  - <?php echo $settings['name']; ?>
  </title>
  <meta name="description" content="<?php echo $settings['description']; ?>">
  <meta name="keywords" content="<?php echo $settings['keywords']; ?>">
  <meta name="author" content="CryptoExchanger">
</head>
<body class="prowallet-body-bg">
<div class="user-wallet-section modal-container">
<?php 
        if(checkSession()) {
            include("menu_logged.php"); 
        } else {
            include("menu_notlogged.php");
        }
        ?>
        <div class="container">
            <div class="row">
            <?php
            $b = protect($_GET['b']);
            switch($b) {
                case "summary": include("account/summary.php"); break;
                case "balance": include("account/balance.php"); break;
                case "activity": include("account/activity.php"); break;
                case "settings": include("account/settings.php"); break;
                case "disputes": include("account/disputes.php"); break;
                case "dispute": include("account/dispute.php"); break;
                case "money": include("account/money.php"); break;
                case "transaction": include("account/transaction.php"); break;
                default: include("account/summary.php");
            }
            ?>
            <div class="col-md-12 prowallet-footer-text-white">
                    <center>Copyright &copy; 2020 <?php echo $settings['name']; ?>.</center>
                </div>
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
    <script src="<?php echo $settings['url']; ?>assets/js/wallet.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript">
    $('#datepicker1').datepicker({ dateFormat: "dd-mm-yy"});
    $('#datepicker2').datepicker({ dateFormat: "dd-mm-yy"});
</script>
 </body>
</html>
<?php } ?>