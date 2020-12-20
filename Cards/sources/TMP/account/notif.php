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


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="icrypto">

    <title>Notifications</title>

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

    <!-- sidebar -->
    <?php include('includes/sidebar.php');?>
    <!-- sidebar ends -->

    <div class="wrapper">
        <!-- header -->
        <?php include('includes/header.php');?>
        <!-- header ends -->

        <div class="container">
            <div class="row">
                <div class="col-12 px-0">
                    <h4>Notifications</h4>
                    <div class="list-group list-group-flush ">
                    <?php
                        //$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                        //$limit = 15;
                        //$startpoint = ($page * $limit) - $limit;
                        if(isset($_POST['pw_remove_notification'])){
                            $id = $_POST['pw_remove_notification'];
                            $query = $db->query("delete FROM pw_notifications WHERE id='$id'");
                        }
                        
                        $statement = "pw_notifications WHERE uid='$_SESSION[pw_uid]'";
                        $query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC");
                        if($query->num_rows>0) {
                            while($row = $query->fetch_assoc()) {
                                if($row['type']=='1'){ //payment recieved 
                                    $GetActivity = $db->query("SELECT * FROM pw_activity WHERE id='$row[activity_id]' ORDER BY id DESC LIMIT 1");
                                    $activity = $GetActivity->fetch_assoc();
                                    $title = 'Payment received';
                                    //$detail = $title.' of '.$activity['amount'].' '.$activity['currency'].' from '.idinfo($activity['u_field_1'],"first_name").' '.idinfo($activity['u_field_1'],"last_name");
                                    $detail = $row['detail'];
                                    $icon = 'account_balance_wallet';
                                }
                                else if($row['type']=='2'){ //request recieved
                                    //$GetActivity = $db->query("SELECT * FROM pw_activity WHERE id='$row[activity_id]' ORDER BY id DESC LIMIT 1");
                                    //$activity = $GetActivity->fetch_assoc();
                                    $title = 'You have received a request for money/payment';
                                    $detail = $row['detail'];
                                    $icon = 'assignment_returned';
                                }
                                else if($row['type']=='3'){ //withdrawal request created
                                    //$GetActivity = $db->query("SELECT * FROM pw_activity WHERE id='$row[activity_id]' ORDER BY id DESC LIMIT 1");
                                    //$activity = $GetActivity->fetch_assoc();
                                    $title = 'You have made a withdrawal';
                                    $detail = $row['detail'];
                                    $icon ='assignment_turned_in';
                                }
                                else if($row['type']=='4'){  //accepted invite
                                    //$GetActivity = $db->query("SELECT * FROM pw_activity WHERE id='$row[activity_id]' ORDER BY id DESC LIMIT 1");
                                    //$activity = $GetActivity->fetch_assoc();
                                    $title = 'Your friend has accepted invite';
                                    $detail = $row['detail'];
                                    $icon ='assignment_turned_in';
                                }
                                else if($row['type']=='5'){  //payment request sent
                                    $title = 'Payment request sent';
                                    $detail = $row['detail'];
                                    $icon ='assignment_turned_in';
                                }
                                else if($row['type']=='6'){  //approved request sender
                                    $title = 'You have approved payment request';
                                    $detail = $row['detail'];
                                    $icon ='assignment_turned_in';
                                }
                                else if($row['type']=='7'){  //payment request accepted reciever
                                    $title = 'Payment request accepted';
                                    $detail = $row['detail'];
                                    $icon ='assignment_turned_in';
                                }
                                else if($row['type']=='8'){  //payment sent
                                    $title = 'Payment sent';
                                    $detail = $row['detail'];
                                    $icon ='assignment_turned_in';
                                }
                                else if($row['type']=='9'){  //payment recv complte
                                    $title = 'Payment received';
                                    $detail = $row['detail'];
                                    $icon ='assignment_turned_in';
                                }
                                else if($row['type']=='10'){  //payment send complte
                                    $title = 'Payment sent complete';
                                    $detail = $row['detail'];
                                    $icon ='assignment_turned_in';
                                }
                                else if($row['type']=='11'){  //payment send complte
                                    $title = 'Invitation to join '.$settings['name'].' sent';
                                    $detail = $row['detail'];
                                    $icon ='assignment_turned_in';
                                }
                                else if($row['type']=='12'){  //payment request reject requesteer
                                    $title = 'Payment Request Rejected';
                                    $detail = $row['detail'];
                                    $icon ='assignment_turned_in';
                                }
                                else if($row['type']=='13'){  //payment request reject sender
                                    $title = 'You have rejected payment request';
                                    $detail = $row['detail'];
                                    $icon ='assignment_turned_in';
                                }
                                else if($row['type']=='14'){  //deposit pending
                                    $title = 'You have made a deposit';
                                    $detail = $row['detail'];
                                    $icon ='assignment_turned_in';
                                }
                                else if($row['type']=='15'){  //deposit pending
                                    $title = 'Your deposit is complete';
                                    $detail = $row['detail'];
                                    $icon ='assignment_turned_in';
                                }
                                else if($row['type']=='16'){  //deposit pending
                                    $title = 'Your deposit is declined';
                                    $detail = $row['detail'];
                                    $icon ='assignment_turned_in';
                                }
                                else if($row['type']=='17'){  //deposit pending
                                    $title = 'Your withdrawal is declined';
                                    $detail = $row['detail'];
                                    $icon ='assignment_turned_in';
                                }
                                else if($row['type']=='18'){  //deposit pending
                                    $title = 'Your withdrawal is complete';
                                    $detail = $row['detail'];
                                    $icon ='assignment_turned_in';
                                }
                                
                    ?>
                        
                            <div class="row list-group-item border-top <?php if($row['is_read']==0){echo 'active';}?> text-dark" style="display:inherit;">
                                <!--<a class="list-group-item border-top <?php if($row['is_read']==0){echo 'active';}?> text-dark" href="notification-details.html">-->
                                <div class="col-auto align-self-center" style="max-width: fit-content;">
                                    <i class="material-icons text-template-primary"><?php echo $icon;?></i>
                                </div>
                                <div class="col pl-0">
                                    <div class="row mb-1">
                                        <div class="col">
                                            <p class="mb-0"><?php echo $title;?></p>
                                        </div>
                                        <div class="col-auto pl-0">
                                            <p class="small text-mute text-trucated mt-1"><?php echo PW_ActivityDate($row['time']); ?></p>
                                        </div>
                                    </div>
                                    <p class="small text-mute"><?php echo $detail; ?></p>
                                </div>
                                <div class="col-auto align-self-center" style="max-width: fit-content;">
                                    <form action="" method="POST">
                                        
                                        <button type="submit" name="pw_remove_notification" value="<?php echo $row['id'];?>" style="border: none;background: inherit;"><i class="material-icons text-template-primary">clear</i></button>
                                        
                                    </form>
                                </div>
                                <!--</a>-->
                            </div>
                        
                    <?php }
                            
                    }
                    else{
                        echo '<h4>No notifications yet.</h4>';
                    }
                    ?>
                    </div>

                </div>
            </div>
        </div>
        
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
            $("form").off();
            $("form").unbind();
        });

    </script>
</body>
</html>
