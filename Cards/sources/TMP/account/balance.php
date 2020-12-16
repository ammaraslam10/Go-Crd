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
?>
<!doctype html>
    <html lang="en" class="deeppurple-theme">
    <!--Crypto Wallet -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="icrypto">

        <title> Balance - <?php echo $settings['name']; ?></title>

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
        #currency-col{
            margin-right:25px;
        }
        @media(max-width:476px){
            #currency-col{
                margin-right:0px;
            }
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
        <div class="container">
            <br>
            <div class="row no-gutters login-row">
                <div class="col-md-3" style="margin-bottom: 5%;" id="currency-col">
                    <div class="user-wallet-wrap">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="user-connected-form-block">
                                    <h3><?php echo $lang['head_add_wallet']; ?></h3>
                                    <hr/>
                                    <?php
                                    $FormBTN = protect($_POST['pw_add']);
                                    if($FormBTN == "add") {
                                        $currency = protect($_POST['currency']);
                                        $CheckWallet = $db->query("SELECT * FROM pw_users_wallets WHERE uid='$_SESSION[pw_uid]' and currency='$currency'");
                                        if($CheckWallet->num_rows>0) {
                                            $error_33 = str_ireplace("%currency%",$currency,$lang['error_33']);
                                            echo error($error_33);
                                        } else {
                                            $insert = $db->query("INSERT pw_users_wallets (uid,amount,currency) VALUES ('$_SESSION[pw_uid]','0','$currency')");
                                            $success_16 = str_ireplace("%currency%",$currency,$lang['success_16']);
                                            echo success($success_16);
                                        }
                                    }
                                    ?>
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label><?php echo $lang['field_28']; ?></label>
                                            <select class="form-control" name="currency">
                                                <?php
                                                $currencies = getFiatCurrencies();
                                                foreach($currencies as $code=>$name) {
                                                    echo '<option value="'.$code.'" '.$sel.'>'.$code.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block" name="pw_add" value="add"><i class="fa fa-plus"></i> <?php echo $lang['btn_23']; ?></button>
                                    </form> 
                                </div><!-- create-account-block -->
                            </div>
                        </div>
                    </div><!-- user-login-signup-form-wrap -->
                </div>
                <div class="col-md-8">
                    <div class="user-wallet-wrap">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="user-connected-form-block">
                                        <h3><?php echo $lang['head_balance']; ?></h3>
                                        <hr/>
                                        <table class="table table-striped">
                                                <tbody>
                                                    <?php
                                                    $GetUserWallets = $db->query("SELECT * FROM pw_users_wallets WHERE uid='$_SESSION[pw_uid]' ORDER BY id");
                                                    if($GetUserWallets->num_rows>0) {
                                                        while($guw = $GetUserWallets->fetch_assoc()) {
                                                            echo '<tr>
                                                                    <td>'.$guw[currency].'</td>
                                                                    <td><span class="float-right">'.get_wallet_balance($_SESSION[pw_uid],$guw[currency]).' '.$guw[currency].'</span></td>
                                                                </tr>';
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
    
                                        </div>
                                    </div><!-- create-account-block -->
                                </div>
                            </div>
                </div><!-- user-login-signup-form-wrap -->
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