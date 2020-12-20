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
    <head><meta charset="gb18030">
        
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="icrypto">

        <title><?php echo $lang['title_activity'];?></title>

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

            <div class="container">
                <!-- page content here -->
                <h6 class="subtitle"><?php echo $lang['head_activity']; ?></h6>
                <div class="row">
                    <div class="col-12 px-0">
                        <ul class="list-group list-group-flush border-top border-bottom">
                    <?php
                        //$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                        //$limit = 15;
                        //$startpoint = ($page * $limit) - $limit;
                        $statement = "pw_activity WHERE uid='$_SESSION[pw_uid]'";
                        $query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC");
                        if($query->num_rows>0) {
                            while($row = $query->fetch_assoc()) {
                                if($row['status']!='6'){
                                    $amount = $row['amount'];
                                    if($row['type'] == "2" or $row['type'] == "4" or $row['type'] == "6" or $row['type'] == "7" or $row['type'] == "8") {
                                            $amount = '-'.$amount;
                                    } else {
                                            $amount = '+'.$amount;
                                    }
                                    clearstatcache();
                                    $target_dir = "uploads/";
                                    $target_file = $target_dir.$row['u_field_1'];
                                    
                                    //echo "targer is:".$target_file;
                                    if (file_exists($target_file.".jpg")) {
                                      $img_url_act = $settings['url'].'uploads/'.$row['u_field_1'].'.jpg';
                                      $file= $target_file.".jpg";
                                      $jpg_time = filemtime($target_file.".jpg");
                                      //echo "han jpg h";
                                    }
                                    else if (file_exists($target_file.".png") && (filemtime($target_file.".png") > $jpg_time)) {
                                      $img_url_act = $settings['url'].'uploads/'.$row['u_field_1'].'.png';
                                      $png_time = filemtime($target_file.".png");
                                      $file= $target_file.".png";
                                       //echo "han jpg2 h";
                                    }
                                    else if (file_exists($target_file.".jpeg") && (filemtime($target_file.".jpeg") > $jpg_time) && (filemtime($target_file.".jpeg") > $png_time)) {
                                      $img_url_act = $settings['url'].'uploads/'.$row['u_field_1'].'.jpeg';
                                      $file= $target_file.".jpeg";
                                       //echo "han jpg3 h";
                                    }
                                    else if($row['type']=='3' || $row['type']=='4'){
                                        $img_url_act = $img_url;
                                    }
                                    else {
                                        $img_url_act = $settings['url'].'uploads/default.jpg';
                                    }
                                    $img_url_act= $img_url_act."?t=".time();
                    ?>
                            <a href="<?php echo $settings['url']; ?>account/transaction/<?php echo $row['txid']; ?>">
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto pr-0">
                                            <div class="avatar avatar-50 no-shadow border-0">
                                                <img src="<?php echo $img_url_act; ?>" alt="">
                                            </div>
                                        </div>
                                        <div class="col align-self-center pr-0">
                                            <h6 class="font-weight-normal mb-1"><?php echo PW_DecodeUserActivity($row[id]); ?></h6>
                                            <?php if($row[deposit_via]!=''){ ?>
                                            <p class="text-mute small text-secondary" style="margin-bottom:2px;"><?php echo 'From '.gatewayinfo($row[deposit_via],"name"); ?></p>
                                            <?php } ?>
                                            <p class="text-mute small text-secondary"><?php echo PW_DecodeTXStatus($row[status]); ?></p>
                                        </div>
                                        <div class="col-auto">
                                            <?php if($amount[0] == "+"){?>
                                                <h6 class="text-success"><?php echo $amount.' '.$row[currency]; ?></h6>
                                            <?php 
                                            }
                                            else{?>
                                                <h6 class="text-danger"><?php echo $amount.' '.$row[currency]; ?></h6>
                                            <?php
                                            }
                                            echo '<p class="text-mute small text-secondary" style="margin-bottom:1%;line-height:1;">'.PW_ActivityDate($row[created]).'</p>';
                                            ?>
                                        </div>
                                    </div>
                                </li>
                            </a>
                                
                            <?php } }
                            }
                            else{?>
                            <a>
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto pr-0">
                                            <div class="avatar avatar-50 no-shadow border-0">
                                                <img src="<?php echo $img_url_act; ?>" alt="">
                                            </div>
                                        </div>
                                        <div class="col align-self-center pr-0">
                                            <h6 class="font-weight-normal mb-1">Your transactions will appear here</h6>
                                            <p class="text-mute small text-secondary" style="margin-bottom:1%;line-height:1;"><?php echo date("d M Y H:i a"); ?></p>							
                                        </div>
                                        <div class="col-auto">
                                             <h6 class="text-success">$0.00</h6>
                                        </div>
                                    </div>
                                </li>
                            </a>
                            <?php }?>
                        </ul>
                    </div>
                </div>
                <!-- page content ends -->
            </div>

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

        <!-- page level script -->
        <script>
            $(window).on('load', function() {

            });

        </script>

    </body>


    <!--Crypto Wallet -->
    </html>