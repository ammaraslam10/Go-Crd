<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
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
  <title><?php echo $lang['title_merchant']; ?> - <?php echo $settings['name']; ?></title>
  <meta name="description" content="<?php echo $settings['description']; ?>">
  <meta name="keywords" content="<?php echo $settings['keywords']; ?>">
  <meta name="author" content="CryptoExchanger">
</head>
<body>
    <div class="subheader">
        <?php 
        if(checkSession()) {
            include("menu_logged.php"); 
        } else {
            include("menu_notlogged.php");
        }
        ?>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="subheader-wrapper">
                        <h3><?php echo $lang['merchant_ipn']; ?></h3>
                        <p><?php echo $lang['accept_payments_with']; ?> <?php echo $settings['name']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- user-login-signup-section -->

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <br><br>
                    <div class="card">
                        <div class="card-body">
                            <h3><?php echo $lang['mp_text_1']; ?></h3>
                            <p><?php echo $lang['mp_text_2']; ?></p>    
                            <hr/>
                            <code class="prowallet-code-view">
						    &lt;form action="<?php echo $settings['url']; ?>payment" method="POST"><br/>
                                &lt;input type="hidden" name="merchant_account" value="merchant@email.com"><br/>
                                &lt;input type="hidden" name="item_number" value="2"><br/>
                                &lt;input type="hidden" name="item_name" value="iPhone 8 PLUS 64GB"><br/>
                                &lt;input type="hidden" name="item_price" value="1100"><br/>
                                &lt;input type="hidden" name="item_currency" value="USD"><br/>
                                &lt;input type="hidden" name="return_success" value="http://yourwebsite.com/success.php"><br/>
                                &lt;input type="hidden" name="return_fail" value="http://yourwebsite.com/fail.php"><br/>
                                &lt;input type="hidden" name="return_cancel" value="http://yourwebsite.com/cancel.php"><br/>
                                &lt;button type="submit">Pay via <?php echo $settings['name']; ?>&lt;/button><br/>
                            &lt;/form>
                            </code>
                            <br><br>
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="30%"><?php echo $lang['mp_text_3']; ?></th>
                                    <th width="30%"><?php echo $lang['mp_text_4']; ?></th>
                                    <th width="40%"><?php echo $lang['mp_text_5']; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><b>merchant_account</b></td>
                                    <td><?php echo $lang['mp_text_6']; ?>: merchant@email.com</td>
                                    <td><?php echo $lang['mp_text_7']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>item_number</b></td>
                                    <td><?php echo $lang['mp_text_6']; ?>: 2</td>
                                    <td><?php echo $lang['mp_text_8']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>item_name</b></td>
                                    <td><?php echo $lang['mp_text_6']; ?>: iPhone 8 PLUS 64GB</td>
                                    <td><?php echo $lang['mp_text_9']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>item_price</b></td>
                                    <td><?php echo $lang['mp_text_6']; ?>: 1100</td>
                                    <td><?php echo $lang['mp_text_10']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>item_currency</b></td>
                                    <td><?php echo $lang['mp_text_6']; ?>: USD/EUR/RUB</td>
                                    <td><?php echo $lang['mp_text_11']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>return_success</b></td>
                                    <td><?php echo $lang['mp_text_6']; ?>: http://yourwebsite.com/success.php</td>
                                    <td><?php echo $lang['mp_text_12']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>return_fail</b></td>
                                    <td><?php echo $lang['mp_text_6']; ?>: http://yourwebsite.com/fail.php</td>
                                    <td><?php echo $lang['mp_text_13']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>return_cancel</b></td>
                                    <td><?php echo $lang['mp_text_6']; ?>: http://yourwebsite.com/cancel.php</td>
                                    <td><?php echo $lang['mp_text_14']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <br><br>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3><?php echo $lang['mp_text_15']; ?></h3>
                            <p><?php echo $lang['mp_text_16']; ?></p>
                            <hr/>
                            <code class="prowallet-code-view">
                            &lt;?php<br/>
                            $merchant_key = '...'; // Enter here your merchant API Key<br/>
                            <br/>
                            $merchant_account = $_POST['merchant_account'];<br/>
                            $item_number = $_POST['item_number'];<br/>
                            $item_name = $_POST['item_name'];<br/>
                            $item_price = $_POST['item_price'];<br/>
                            $item_currency = $_POST['item_currency'];<br/>
                            $txid = $_POST['txid']; // Transaction ID<br/>
                            $payment_time = $_POST['payment_time']; // Current time of payment<br/>
                            $payee_account = $_POST['payee_account']; // The account of payee<br/>
                            $verification_link = "<?php echo $settings['url']; ?>payment_status.php?merchant_key=$merchant_key&merchant_account=$merchant_account&txid=$txid";<br/>
                            $ch = curl_init();<br/>
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);<br/>
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);<br/>
                            curl_setopt($ch, CURLOPT_URL,$verification_link);<br/>
                            $results=curl_exec($ch);<br/>
                            curl_close($ch);<br/>
                            $results = json_decode($results);<br/>
                            if($results->status == "success") {<br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;//Payment is successful<br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;//Run your php code here<br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;echo 'Payment is successful.';<br/>
                            } else {<br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;echo 'Payment was failed.';<br/>
                            }<br/>
                            ?>
                        </code>
                        </div>
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>

    <script src="<?php echo $settings['url']; ?>assets/js/jquery-1.12.4.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/popper.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/slick.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/jquery.peity.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo $settings['url']; ?>assets/js/custom.js"></script>
</body>
</html>