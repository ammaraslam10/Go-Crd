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
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!doctype html>
<html lang="en" class="deeppurple-theme">


<!--Crypto Wallet -->
<head><meta charset="gb18030">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="icrypto">

    <title>Profile</title>

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
            

            <h6 class="subtitle"><?php echo $lang['head_profile']; ?></h6>
            <?php if(idinfo($_SESSION['pw_uid'],"account_type") == "1") { ?>
                <?php
                $FormBTN = protect($_POST['pw_save_profile']);
                if($FormBTN == "save_profile") {
                    $first_name = protect($_POST['first_name']);
                    $last_name = protect($_POST['last_name']);
                    $country = protect($_POST['country']);
                    $city = protect($_POST['city']);
                    $zip_code = protect($_POST['zip_code']);
                    $address = protect($_POST['address']);
                    //$extensions = array('jpg','jpeg','png'); 
                    //$fileextension = end(explode('.',$_FILES['uploadFile']['name'])); 
                    //$fileextension = strtolower($fileextension); 
                    //$maxfilesize = '5242880'; // 5MB
                    if(empty($first_name) or empty($last_name) or empty($country) or empty($city) or empty($zip_code) or empty($address)) {
                        echo error($lang['error_20']);
                    } 
                    else {
                        if(isset($_FILES['fileToUpload']) && $_FILES["fileToUpload"]["size"] > 0) {
                            //echo 'yes upload';
                            $target_dir = "uploads/";
                            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                            //echo $target_file;
                            $uploadOk = 1;
                            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                            
                            
                            // Check file size
                            if ($_FILES["fileToUpload"]["size"] > 2000000) {
                              echo error("Your file is too large. Try cropping to reduce the file size");
                              $uploadOk = 0;
                            }
                            // Allow certain file formats
                            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                            && $imageFileType != "gif" ) {
                              echo error("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                              $uploadOk = 0;
                            }
                            // Check if $uploadOk is set to 0 by an error
                            if ($uploadOk == 0) {
                              echo error("Sorry, your file was not uploaded.");
                            // if everything is ok, try to upload file
                            } 
                            else {
                                
                            $target_file = $target_dir.$_SESSION['pw_uid'];
                            //echo 'file name will be: '.$target_file;
                              if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file.'.'.$imageFileType)) {
                                echo success("Profile picture has been updated.");
                                clearstatcache();
                              } 
                              else {
                                echo error("Sorry, there was an error uploading your file.");
                              }
                            }
                        }
                            $update = $db->query("UPDATE pw_users SET first_name='$first_name',last_name='$last_name',country='$country',city='$city',zip_code='$zip_code',address='$address' WHERE id='$_SESSION[pw_uid]'");
                            echo success($lang['success_10']);
                        }
                    }
                    ?>
                <form class="user-connected-from user-signup-form" id="myform" action="" method="POST" enctype="multipart/form-data">
                    <div class="container">
                        <div class="text-center">
                        <div class="figure-profile shadow my-4">
                            
                        <?php
                        clearstatcache();
                        $target_dir = "uploads/";
                        $target_file = $target_dir.$_SESSION['pw_uid'];
                        clearstatcache();
                        $target_dir = "uploads/";
                        $target_file = $target_dir.$_SESSION['pw_uid'];
                        
                        //echo "targer is:".$target_file;
                        if (file_exists($target_file.".jpg")) {
                          $img_url = $settings['url'].'uploads/'.$_SESSION['pw_uid'].'.jpg';
                          $file= $target_file.".jpg";
                          $jpg_time = filemtime($target_file.".jpg");
                          //echo "han jpg h";
                        }
                        if (file_exists($target_file.".png") && (filemtime($target_file.".png") > $jpg_time)) {
                          $img_url = $settings['url'].'uploads/'.$_SESSION['pw_uid'].'.png';
                          $png_time = filemtime($target_file.".png");
                          $file= $target_file.".png";
                           //echo "han jpg2 h";
                        }
                        if (file_exists($target_file.".jpeg") && (filemtime($target_file.".jpeg") > $jpg_time) && (filemtime($target_file.".jpeg") > $png_time)) {
                          $img_url = $settings['url'].'uploads/'.$_SESSION['pw_uid'].'.jpeg';
                          $file= $target_file.".jpeg";
                           //echo "han jpg3 h";
                        }
                        $img_url= $img_url."?t=".time();
                        ?>
                            <figure><img id="dp" src="<?php echo $img_url;?>" alt=""></figure>
                            <div class="btn btn-dark text-white floating-btn">
                                <i class="material-icons">camera_alt</i>
                                    <input type="file" name="fileToUpload" id="changeimage_input" onchange="file_changed()" class="float-file">
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row form-group">
                        <div class="col">
                            <label><?php echo $lang['field_11']; ?></label>
                            <input type="text" class="form-control" name="first_name" value="<?php echo idinfo($_SESSION['pw_uid'],"first_name"); ?>">
                        </div>
                        <div class="col">
                            <label><?php echo $lang['field_12']; ?></label>
                            <input type="text" class="form-control" name="last_name" value="<?php echo idinfo($_SESSION['pw_uid'],"last_name"); ?>">
                        </div>
                    </div>
                    <div class="form-group float-label active">
                        <label><?php echo $lang['field_13']; ?></label>
                        <select class="form-control form-control-lg" name="country">
                            <?php
                            $countries = getCountries();
                            foreach($countries as $code=>$country) {
                                if(idinfo($_SESSION['pw_uid'],"country") == $country) { $sel = 'selected'; } else { $sel = ''; } 
                                echo '<option value="'.$country.'" '.$sel.'>'.$country.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row form-group">
                        <div class="col">
                            <label><?php echo $lang['field_14']; ?></label>
                            <input type="text" class="form-control" name="city" value="<?php echo idinfo($_SESSION['pw_uid'],"city"); ?>">
                        </div>
                        <div class="col">
                            <label><?php echo $lang['field_15']; ?></label>
                            <input type="text" class="form-control" name="zip_code" value="<?php echo idinfo($_SESSION['pw_uid'],"zip_code"); ?>">
                        </div>
                    </div>
                    <div class="form-group float-label active">
                        <label><?php echo $lang['field_16']; ?></label>
                        <input type="text" class="form-control" name="address" value="<?php echo idinfo($_SESSION['pw_uid'],"address"); ?>">
                    </div>
                    <div class="row form-group">
                        <div class="col">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" value="<?php echo idinfo($_SESSION['pw_uid'],"email"); ?>" disabled>
                        </div>
                        <div class="col">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="phone" value="<?php echo idinfo($_SESSION['pw_uid'],"phone"); ?>" disabled>
                        </div>
                    </div>
                    <button type="submit" name="pw_save_profile" value="save_profile"  class="btn btn-lg btn-default text-white btn-block btn-rounded shadow" style="padding:12px;margin-top:4%;"><?php echo $lang['btn_18']; ?></button>
                </form>
                <?php } elseif(idinfo($_SESSION['pw_uid'],"account_type") == "2") { ?>
                <?php
                $FormBTN = protect($_POST['pw_save_profile']);
                if($FormBTN == "save_profile") {
                    $first_name = protect($_POST['first_name']);
                    $last_name = protect($_POST['last_name']);
                    $country = protect($_POST['country']);
                    $business_name = protect($_POST['business_name']);
                    $city = protect($_POST['city']);
                    $zip_code = protect($_POST['zip_code']);
                    $address = protect($_POST['address']);
                    if(empty($first_name) or empty($last_name) or empty($business_name) or empty($country) or empty($city) or empty($zip_code) or empty($address)) {
                        echo error($lang['error_20']);
                    } else {
                        if(isset($_FILES['fileToUpload']) && $_FILES["fileToUpload"]["size"] > 0) {
                            //echo 'yes upload';
                            $target_dir = "uploads/";
                            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                            //echo $target_file;
                            $uploadOk = 1;
                            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                            
                            
                            // Check file size
                            if ($_FILES["fileToUpload"]["size"] > 500000) {
                              echo error("Sorry, your file is too large.");
                              $uploadOk = 0;
                            }
                            // Allow certain file formats
                            else if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                            && $imageFileType != "gif" && $_FILES["fileToUpload"]["size"] == 0) {
                              echo error("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                              $uploadOk = 0;
                            }
                            // Check if $uploadOk is set to 0 by an error
                            else if ($uploadOk == 0 || $_FILES["fileToUpload"]["size"] == 0) {
                              echo error("Sorry, your file was not uploaded.");
                            // if everything is ok, try to upload file
                            } 
                            else {
                                
                            $target_file = $target_dir.$_SESSION['pw_uid'];
                            //echo 'file name will be: '.$target_file;
                              if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file.'.'.$imageFileType)) {
                                echo success("Profile picture has been updated.");
                                clearstatcache();
                              } 
                              else {
                                echo error("Sorry, there was an error uploading your file.");
                              }
                            }
                        }
                        $update = $db->query("UPDATE pw_users SET business_name='$business_name',first_name='$first_name',last_name='$last_name',country='$country',city='$city',zip_code='$zip_code',address='$address' WHERE id='$_SESSION[pw_uid]'");
                        echo success($lang['success_10']);
                    }
                }
                ?>
                    <form class="user-connected-from user-signup-form" id="myform" action="" method="POST" enctype="multipart/form-data">
                    <div class="container">
                        <div class="text-center">
                        <div class="figure-profile shadow my-4">
                            
                        <?php
                        clearstatcache();
                        $target_dir = "uploads/";
                        $target_file = $target_dir.$_SESSION['pw_uid'];
                        
                        //echo "targer is:".$target_file;
                        if (file_exists($target_file.".jpg")) {
                          $img_url = $settings['url'].'uploads/'.$_SESSION['pw_uid'].'.jpg';
                          $file= $target_file.".jpg";
                          $jpg_time = filemtime($target_file.".jpg");
                          //echo "han jpg h";
                        }
                        if (file_exists($target_file.".png") && (filemtime($target_file.".png") > $jpg_time)) {
                          $img_url = $settings['url'].'uploads/'.$_SESSION['pw_uid'].'.png';
                          $png_time = filemtime($target_file.".png");
                          $file= $target_file.".png";
                           //echo "han jpg2 h";
                        }
                        if (file_exists($target_file.".jpeg") && (filemtime($target_file.".jpeg") > $jpg_time) && (filemtime($target_file.".jpeg") > $png_time)) {
                          $img_url = $settings['url'].'uploads/'.$_SESSION['pw_uid'].'.jpeg';
                          $file= $target_file.".jpeg";
                           //echo "han jpg3 h";
                        }
                        $img_url= $img_url."?t=".time();
                        ?>
                            <figure><img id="dp" src="<?php echo $img_url;?>" alt=""></figure>
                            <div class="btn btn-dark text-white floating-btn">
                                <i class="material-icons">camera_alt</i>
                                    <input type="file" name="fileToUpload" id="changeimage_input" onchange="file_changed()" class="float-file">
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row form-group">
                        <div class="col">
                            <label><?php echo $lang['field_11']; ?></label>
                            <input type="text" class="form-control" name="first_name" value="<?php echo idinfo($_SESSION['pw_uid'],"first_name"); ?>">
                        </div>
                        <div class="col">
                            <label><?php echo $lang['field_12']; ?></label>
                            <input type="text" class="form-control" name="last_name" value="<?php echo idinfo($_SESSION['pw_uid'],"last_name"); ?>">
                        </div>
                    </div>
                    <h4><?php echo $lang['your_business_information']; ?></h4>
                    <div class="form-group float-label active">
                        <label><?php echo $lang['field_17']; ?></label>
                        <input type="text" class="form-control" name="business_name" value="<?php echo idinfo($_SESSION['pw_uid'],"business_name"); ?>">
                    </div>
                    <div class="form-group float-label active">
                        <label><?php echo $lang['field_13']; ?></label>
                        <select class="form-control form-control-lg" name="country">
                            <?php
                            $countries = getCountries();
                            foreach($countries as $code=>$country) {
                                if(idinfo($_SESSION['pw_uid'],"country") == $country) { $sel = 'selected'; } else { $sel = ''; } 
                                echo '<option value="'.$country.'" '.$sel.'>'.$country.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row form-group">
                        <div class="col">
                            <label><?php echo $lang['field_14']; ?></label>
                            <input type="text" class="form-control" name="city" value="<?php echo idinfo($_SESSION['pw_uid'],"city"); ?>">
                        </div>
                        <div class="col">
                            <label><?php echo $lang['field_15']; ?></label>
                            <input type="text" class="form-control" name="zip_code" value="<?php echo idinfo($_SESSION['pw_uid'],"zip_code"); ?>">
                        </div>
                    </div>
                    <div class="form-group float-label active">
                        <label><?php echo $lang['field_16']; ?></label>
                        <input type="text" class="form-control" name="address" value="<?php echo idinfo($_SESSION['pw_uid'],"address"); ?>">
                    </div>
                    <div class="row form-group">
                        <div class="col">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" value="<?php echo idinfo($_SESSION['pw_uid'],"email"); ?>" disabled>
                        </div>
                        <div class="col">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="phone" value="<?php echo idinfo($_SESSION['pw_uid'],"phone"); ?>" disabled>
                        </div>
                    </div>
                    <button type="submit" name="pw_save_profile" value="save_profile"  class="btn btn-lg btn-default text-white btn-block btn-rounded shadow" style="padding:12px;margin-top:4%;"><?php echo $lang['btn_18']; ?></button>
                </form>
                <?php } ?>
            <br>
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
        });
        
        function file_changed(){
          var selectedFile = document.getElementById('changeimage_input').files[0];
          var img = document.getElementById('dp')
          var reader = new FileReader();
          reader.onload = function(){
             img.src = this.result
          }
          reader.readAsDataURL(selectedFile);
         }
        
    </script>

</body>


<!--Crypto Wallet -->
</html>
