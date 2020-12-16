<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

if(checkSession()) {
    $redirect = $settings['url']."account/summary";
    header("Location: $redirect");
}
$type = protect($_GET['type']);
if($type == "personal") {
?>
<!doctype html>
    <html lang="en" class="deeppurple-theme">


    <!--Crypto Wallet -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="icrypto">

        <title><?php echo $lang['title_create_a_personal']; ?> <?php echo $settings['name']; ?> <?php echo $lang['title_account']; ?></title>

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
        
        <!-- For Country Flags -->
        <link rel="stylesheet" href="<?php echo $settings['url']; ?>icrypto_assets/intl-tel-input-master/build/css/intlTelInput.css">
        <style>
            #iti-0__country-listbox::-webkit-scrollbar {
              -webkit-appearance: none;
              width: 7px;
            }
            #iti-0__country-listbox::-webkit-scrollbar-thumb {
              border-radius: 4px;
              background-color: rgba(0, 0, 0, .5);
              -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5);
            }
            #phone:focus{
                border-color: rgba(0, 0, 0, 0.08);
            }
            #country_code:focus{
                border-color: rgba(0, 0, 0, 0.08);
            }
        </style>
    </head>

    <body>
        <!-- Loader -->
        <div class="row no-gutters vh-100 loader-screen">
            <div class="col align-self-center text-white text-center">
                <img src="<?php echo $settings['url']; ?>icrypto_assets/img/logo.png" alt="logo">
                <h1 class="mt-3"><span class="font-weight-light ">Fi</span>mobile</h1>
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

        <div class="wrapper">
            <!-- header -->
            <div class="header">
                <div class="row no-gutters">
                    <div class="col-auto">
                        <a href="<?php echo $settings['url']; ?>" class="btn  btn-link text-dark"><i class="material-icons">chevron_left</i></a>
                    </div>
                    <div class="col text-center"></div>
                    <div class="col-auto">
                    </div>
                </div>
            </div>
            <!-- header ends -->

            <div class="row no-gutters login-row">
                <div class="col align-self-center px-3 text-center">
                    <br>
                    <img src="<?php echo $settings['url']; ?>icrypto_assets/img/logo-login.png" alt="logo" class="logo-small">
                    <?php
                        $FormBTN = protect($_POST['pw_register']);
                        if($FormBTN == "reg") {
                            $first_name = protect($_POST['first_name']);
                            $last_name = protect($_POST['last_name']);
                            $email = protect($_POST['email']);
                            $password = protect($_POST['password']);
                            $cpassword = protect($_POST['cpassword']);
                            $country = protect($_POST['country']);
                            $city = protect($_POST['city']);
                            $zip_code = protect($_POST['zip_code']);
                            $address = protect($_POST['address']);
                            $accept_tou = protect($_POST['accept_tou']);
                            $country_code = protect($_POST['country_code']);
                            $phone_drop = protect($_POST['phone']);
                            $phone_ext = protect($_POST['phone_ext']);
                            $phone = $country_code.$phone_ext;
                            $phone = str_replace(' ', '', $phone);
                            //echo $phone.'<br>';
                            //echo $_POST['phone2'];
                            $phoneExists = false;
                            $GetP = $db->query("SELECT * FROM pw_users WHERE phone='$phone'");
                            //echo $GetP;
                            if($GetP->num_rows>0){
                                $phoneExists = true;
                            }
                            if($accept_tou == "yes") { $accept_tou = '1'; } else { $accept_tou = '0'; }
                            if(empty($first_name) or empty($last_name) or empty($email) or empty($password) or empty($cpassword) or empty($country) or empty($city) or empty($zip_code) or empty($address) or empty($phone)) {
                                echo error($lang['error_20']);
                            } elseif(!isValidEmail($email)) {
                                echo error($lang['error_45']);  
                            } elseif($phoneExists) {
                                echo error("This phone number is already associated with another account. Please try another phone number.");  
                            } elseif(PW_CheckUser($email)==true) {
                                echo error($lang['error_46']);
                            } elseif(strlen($password)<8) { 
                                echo error($lang['error_47']);
                            } elseif($password !== $cpassword) {
                                echo error($lang['error_48']);
                            } elseif($accept_tou==0) {
                                echo error($lang['error_49']);
                            } elseif($country == "United Kingdom" && postcode_check($zip_code) == false) {
                                echo error($lang['error_21']);	
                            } elseif(!preg_match('/^\+(?:[0-9] ?){10,14}[0-9]$/',$phone)) {
									echo error("Phone number pattern incorrect.<br>Please enter in form of +1 123 456 7890");	
							} elseif(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/',$password)) {
									echo error("Your password must contain following:<br>1 Uppercase Letter<br>1 Lowercase Letter<br>1 Number");	
							} else {
                                //echo "no error";
                                $password = password_hash($password, PASSWORD_DEFAULT);
                                $ip = $_SERVER['REMOTE_ADDR'];
                                $time = time();
                                $account_type = '1'; // personal
                                $insert = $db->query("INSERT pw_users (password,email,email_verified,status,account_type,ip,signup_time,first_name,last_name,country,city,zip_code,address,phone) VALUES ('$password','$email','1','1','$account_type','$ip','$time','$first_name','$last_name','$country','$city','$zip_code','$address','$phone')");
                                $GetU = $db->query("SELECT * FROM pw_users WHERE email='$email'");
                                $gu = $GetU->fetch_assoc();
                                $insert = $db->query("INSERT pw_users_wallets (uid,amount,currency) VALUES ('$gu[id]','0','$settings[default_currency]')");
                                
                                //insert notifs
                                $GetInvites = $db->query("SELECT * FROM pw_invites WHERE invite_to='$email' and status='0'");
                                if($GetInvites->num_rows>0) {
                                    $invite = $GetInvites->fetch_assoc();
                                    $GetUsers = $db->query("SELECT * FROM pw_users WHERE email='$invite[invite_by]'");
                                    $invite_by = $GetUsers->fetch_assoc();
                                    $notif_detail = 'Your friend '.$first_name.' '.$last_name.' has accepted your invite and has joined '.$settings['name'];
                                    $insert_notification = $db->query("INSERT pw_notifications (uid,activity_id,detail,is_read,amount,type,time) VALUES ('$invite_by[id]','0','$notif_detail','0','0','4','$time')");
                                    $update = $db->query("UPDATE pw_invites SET status='1' WHERE id='$invite[id]'");
                                }
                                
                                $file = 'uploads/default.jpg';
                                $newfile = 'uploads/'.$gu[id].'.jpg';
                                if (!copy($file, $newfile)) {
                                    echo error("failed to copy");
                                }
                                if($settings['require_email_verify'] == "1") {
                                    $email_hash = randomHash(25);
                                    $update = $db->query("UPDATE pw_users SET status='2',email_hash='$email_hash',email_verified='0' WHERE email='$email'");
                                    PW_EmailSys_Send_Email_Verification($email);
                                    echo success($lang['success_22']);
                                    //echo success($lang['success_23']."Redirecting to login");
                                    //sleep(30);
                                    session_start();
                                    $_SESSION['uid']=$gu[id];
                                    if($settings['require_phone_verify'] == "1") {
                                        $newURL=$settings['url'].'phone-verify/?id='.$gu[id];
                                        header('Location: '.$newURL);
                                    }else{
                                        $newURL=$settings['url'].'login?msg=email_verify';
                                        header('Location: '.$newURL);
                                    }
                                    
                                } else {
                                    echo success($lang['success_23']."Redirecting to login");
                                    //sleep(30);
                                    if($settings['require_phone_verify'] == "1") {
                                        $newURL=$settings['url'].'phone-verify/?id='.$gu[id];
                                        header('Location: '.$newURL);
                                    }else{
                                        $newURL=$settings['url'].'login';
                                        header('Location: '.$newURL);
                                    }
                                    
                                }
                            }
                        }
                        //form-control form-control-lg text-center
                        ?>
                    <form class="form-signin mt-3 " action="" method="POST">
                        <div class="row form-group">
                            <div class="col">
                                <input type="text" class="form-control form-control-lg text-center" value="<?php echo $first_name;?>" name="first_name" placeholder="<?php echo $lang['field_11']; ?>">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control form-control-lg text-center" value="<?php echo $last_name;?>" name="last_name" placeholder="<?php echo $lang['field_12']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control form-control-lg text-center" value="<?php echo $email;?>" name="email" placeholder="<?php echo $lang['field_25']; ?>">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-lg text-center" value="<?php echo $password;?>" name="password" placeholder="<?php echo $lang['field_29']; ?>">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-lg text-center" value="<?php echo $cpassword;?>" name="cpassword" placeholder="<?php echo $lang['field_30']; ?>">
                        </div>
                        <div class="row form-group">
                            <div class="col col-2">
                                <input class="form-control form-control-lg text-center" style="background: #e9ecef;border-right: 0px;border-top-right-radius: 0;border-bottom-right-radius: 0;" id="phone" name="phone"  type="tel">
                            </div>
                            <div class="col col-2" style="padding-left: 0;padding-right: 0;">
                                <input type="text" class="form-control form-control-lg text-center" id="country_code" value="<?php if(isset($country_code)){echo $country_code;}else{echo "+1";} ?>" name="country_code" style="border-bottom-right-radius: 0;border-top-right-radius: 0;border-bottom-left-radius: 0;border-top-left-radius: 0;border-left: 0px;padding-right: 0;padding-left: 0;" readonly="">
                            </div>
                            <div class="col col-8" style="padding-left: 0;">
                                <input type="text" class="form-control form-control-lg" id="phone_ext" value="<?php echo $phone_ext; ?>" name="phone_ext" placeholder="Phone Number" style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="form-control form-control-lg" name="country">
                                <option>Select Country</option>
                                <?php
                                $countries = getCountries();
                                    foreach($countries as $code=>$country) {
                                        if(protect($_POST['country'])==$country){
                                            $found = true;
                                            $sel = 'selected';
                                        }
                                        else{$sel='';}
                                        echo '<option value="'.$country.'" '.$sel.'>'.$country.'</option>';
                                    }
                                ?>
                            </select>
                            <?php 
                                    if(!$found){
                                        echo '<script>document.getElementsByName("country")[0].value="United States";</script>';
                                    }?>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <input type="text" class="form-control form-control-lg text-center" value="<?php echo $city;?>" name="city" placeholder="<?php echo $lang['field_14']; ?>">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control form-control-lg text-center" value="<?php echo $zip_code;?>" name="zip_code" placeholder="<?php echo $lang['field_15']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg text-center" value="<?php echo $address;?>" name="address" placeholder="<?php echo $lang['field_16']; ?>">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <div class="custom-checkbox-wrap">
                                    <input type="checkbox" class="custom-control-input" id="accept_tou" name="accept_tou" value="yes">
                                    <label class="custom-control-label" for="accept_tou">I have read and agree to the <a href="<?php echo $settings['url']; ?>page/terms-of-use">Terms of Use</a></label>
                                </div>
                            </div>
                        </div>
                        <p class="mt-4 d-block text-secondary">
                            By clicking register your are agree to the
                            <a href="javascript:void(0)">Terms and Condition.</a>
                        </p>
                        <input type="hidden" name="iso2" id="iso2" value="<?php echo $_POST['iso2']; ?>">
                        <button type="submit" name="pw_register" value="reg" class="btn btn-default btn-lg btn-rounded shadow btn-block"><?php echo $lang['btn_28']; ?></button>
                    </form>
                    <p style="margin-top:2%;"><?php echo $lang['already_have_account']; ?> <a href="<?php echo $settings['url']; ?>login"><?php echo $lang['btn_27']; ?></a></p>
                </div>
            </div>

            <!-- login buttons -->
            <!--<div class="row mx-0 bottom-button-container">
                <div class="col">
                    <a href="otp.html" class="btn btn-default btn-lg btn-rounded shadow btn-block">Next</a>
                </div>
            </div> -->
            <!-- login buttons -->
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
        
        <!-- Use as a jQuery plugin -->
        <script src="https://code.jquery.com/jquery-latest.min.js"></script>
        
        <script src="<?php echo $settings['url']; ?>icrypto_assets/intl-tel-input-master/build/js/intlTelInput-jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                // jQuery
                $("#phone").intlTelInput({
                    nationalMode:false,
                    placeholderNumberType:"MOBILE",
                    autoPlaceholder:"polite",
                    utilsScript: "<?php echo $settings['url']; ?>icrypto_assets/intl-tel-input-master/build/js/utils.js",
                    separateDialCode:false,
                    autoHideDialCode:false,
                    onlyCountries: [<?php 
                        $countries= getCountries();
                        foreach ($countries as $key => $value) {
                            echo '"'.$key.'",';
                        }
                    ?>],
                    //onlyCountries: ["pk","us","gb","in"],
                    // options here
                });
                intlTelInputGlobals.instances[0].setNumber("<?php echo $country_code; ?>");
                <?php 
                if(isset($_POST['iso2'])){
                    echo 'intlTelInputGlobals.instances[0].setCountry("'.$_POST['iso2'].'");';
                }
                else{
                    echo 'document.getElementById("iso2").value = intlTelInputGlobals.instances[0].getSelectedCountryData().iso2;';
                }
                ?>
                $('#iti-0__country-listbox').children().on("click",function(){
                    var country_name = this.children[1].innerText;
                    console.log(country_name);
                    $('select[name=country]').val(country_name);
                    $('#phone').val("");
                    document.getElementById("phone").value = "";
                });
                document.getElementById("phone").addEventListener("countrychange", function() {
                  // do something with iti.getSelectedCountryData()
                    document.getElementById("country_code").value = document.getElementById("phone").value;
                    document.getElementById("iso2").value = intlTelInputGlobals.instances[0].getSelectedCountryData().iso2;
                    //$('#country_code').val("");
                    //var code = $('#phone').val();
                    //$('#country_code').val(code);
                });
                document.getElementById("phone").addEventListener("open:countrydropdown", function() {
                    // triggered when the user opens the dropdown
                    $('#iti-0__country-listbox').children().on("click",function(){
                    var country_name = this.children[1].innerText;
                    console.log(country_name);
                    $('select[name=country]').val(country_name);
                    $('#phone').val("");
                    document.getElementById("phone").value = "";
                    });
                    document.getElementById("phone").addEventListener("countrychange", function() {
                      // do something with iti.getSelectedCountryData()
                        document.getElementById("country_code").value = document.getElementById("phone").value;
                        document.getElementById("iso2").value = intlTelInputGlobals.instances[0].getSelectedCountryData().iso2;
                        //$('#country_code').val("");
                        //var code = $('#phone').val();
                        //$('#country_code').val(code);
                        document.getElementById('country_code').blur();
                        document.getElementById('phone_ext').focus();
                    });
                });
                
                document.getElementById("phone").addEventListener("close:countrydropdown", function() {
                  // triggered when the user closes the dropdown
                });
            });
        </script>
    </body>


    <!--Crypto Wallet -->
    </html>
<?php }
elseif($type == "business") { ?>
<!doctype html>
    <html lang="en" class="deeppurple-theme">


    <!--Crypto Wallet -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="icrypto">

        <title><?php echo $lang['title_create_a_business']; ?> <?php echo $settings['name']; ?> <?php echo $lang['title_account']; ?></title>

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
        
        <!-- For Country Flags -->
        <link rel="stylesheet" href="<?php echo $settings['url']; ?>icrypto_assets/intl-tel-input-master/build/css/intlTelInput.css">
        <style>
            #iti-0__country-listbox::-webkit-scrollbar {
              -webkit-appearance: none;
              width: 7px;
            }
            #iti-0__country-listbox::-webkit-scrollbar-thumb {
              border-radius: 4px;
              background-color: rgba(0, 0, 0, .5);
              -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5);
            }
            #phone:focus{
                border-color: rgba(0, 0, 0, 0.08);
            }
            #country_code:focus{
                border-color: rgba(0, 0, 0, 0.08);
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

        <div class="wrapper">
            <!-- header -->
            <div class="header">
                <div class="row no-gutters">
                    <div class="col-auto">
                        <a href="<?php echo $settings['url'];?>" class="btn  btn-link text-dark"><i class="material-icons">chevron_left</i></a>
                    </div>
                    <div class="col text-center"></div>
                    <div class="col-auto">
                    </div>
                </div>
            </div>
            <!-- header ends -->

            <div class="row no-gutters login-row">
                <div class="col align-self-center px-3 text-center">
                    <br>
                    <img src="<?php echo $settings['url']; ?>icrypto_assets/img/logo-login.png" alt="logo" class="logo-small">
                    <?php
                            $FormBTN = protect($_POST['pw_register']);
                            if($FormBTN == "reg") {
                                $first_name = protect($_POST['first_name']);
                                $last_name = protect($_POST['last_name']);
                                $email = protect($_POST['email']);
                                $password = protect($_POST['password']);
                                $cpassword = protect($_POST['cpassword']);
                                $country = protect($_POST['country']);
                                $city = protect($_POST['city']);
                                $zip_code = protect($_POST['zip_code']);
                                $address = protect($_POST['address']);
                                $accept_tou = protect($_POST['accept_tou']);
                                $country_code = protect($_POST['country_code']);
                                $phone_drop = protect($_POST['phone']);
                                $phone_ext = protect($_POST['phone_ext']);
                                $phone = $country_code.$phone_ext;
                                $phone = str_replace(' ', '', $phone);
                                $business_name = protect($_POST['business_name']);
                                //echo $phone;
                                $phoneExists = false;
                                $GetP = $db->query("SELECT * FROM pw_users WHERE phone='$phone'");
                                //echo $GetP;
                                if($GetP->num_rows>0){
                                    $phoneExists = true;
                                }
                                if($accept_tou == "yes") { $accept_tou = '1'; } else { $accept_tou = '0'; }
                                if(empty($first_name) or empty($last_name) or empty($email) or empty($password) or empty($cpassword) or empty($country) or empty($city) or empty($zip_code) or empty($address) or empty($phone)) {
                                    echo error($lang['error_20']);
                                } elseif(!isValidEmail($email)) {
                                    echo error($lang['error_45']);  
                                } elseif($phoneExists) {
                                    echo error("There is already an account associated with this number, Please try with another number.");  
                                } elseif(PW_CheckUser($email)==true) {
                                    echo error($lang['error_46']);
                                } elseif(strlen($password)<8) { 
                                    echo error($lang['error_47']);
                                } elseif($password !== $cpassword) {
                                    echo error($lang['error_48']);
                                } elseif($accept_tou==0) {
                                    echo error($lang['error_49']);
                                } elseif($country == "United Kingdom" && postcode_check($zip_code) == false) {
									echo error($lang['error_21']);	
								} elseif(!preg_match('/^\+(?:[0-9] ?){10,14}[0-9]$/',$phone)) {
									echo error("Phone number pattern incorrect");	
								} elseif(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/',$password)) {
									echo error("Your password must contain following:<br>1 Uppercase Letter<br>1 Lowercase Letter<br>1 Number");	
							    } 
								else {
                                    $password = password_hash($password, PASSWORD_DEFAULT);
                                    $ip = $_SERVER['REMOTE_ADDR'];
                                    $time = time();
                                    $account_type = '2'; // busniess
                                    $insert = $db->query("INSERT pw_users (password,email,email_verified,status,account_type,ip,signup_time,first_name,last_name,business_name,country,city,zip_code,address,phone) VALUES ('$password','$email','1','1','$account_type','$ip','$time','$first_name','$last_name','$business_name','$country','$city','$zip_code','$address','$phone')");
                                    $GetU = $db->query("SELECT * FROM pw_users WHERE email='$email'");
                                    $gu = $GetU->fetch_assoc();
                                    $insert = $db->query("INSERT pw_users_wallets (uid,amount,currency,updated) VALUES ('$gu[id]','0','$settings[default_currency]','0')");
                                    $file = 'uploads/default.jpg';
                                    $newfile = 'uploads/'.$gu[id].'.jpg';
                                    //$_SESSION['id']
                                    if (!copy($file, $newfile)) {
                                        echo error("failed to copy");
                                    }
                                    if($settings['require_email_verify'] == "1") {
                                    $email_hash = randomHash(25);
                                    $update = $db->query("UPDATE pw_users SET status='2',email_hash='$email_hash',email_verified='0' WHERE email='$email'");
                                    PW_EmailSys_Send_Email_Verification($email);
                                    echo success($lang['success_22']);
                                    //echo success($lang['success_23']."Redirecting to login");
                                    //sleep(30);
                                    session_start();
                                    $_SESSION['uid']=$gu[id];
                                    if($settings['require_phone_verify'] == "1") {
                                        $newURL=$settings['url'].'phone-verify/?id='.$gu[id];
                                        header('Location: '.$newURL);
                                    }else{
                                        $newURL=$settings['url'].'login?msg=email_verify';
                                        header('Location: '.$newURL);
                                    }
                                    
                                } else {
                                    echo success($lang['success_23']."Redirecting to login");
                                    //sleep(30);
                                    if($settings['require_phone_verify'] == "1") {
                                        $newURL=$settings['url'].'phone-verify/?id='.$gu[id];
                                        header('Location: '.$newURL);
                                    }else{
                                        $newURL=$settings['url'].'login';
                                        header('Location: '.$newURL);
                                    }
                                    
                                }
                                }
                            }
                        ?>
                    <form class="form-signin mt-3 " action="" method="POST">
                    <div class="form-group">
                        <input type="email" class="form-control form-control-lg text-center" name="email" placeholder="<?php echo $lang['field_25']; ?>" value="<?php echo $_POST['email'];?>">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-lg text-center" name="password" placeholder="<?php echo $lang['field_29']; ?>" value="<?php echo $_POST['password'];?>">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-lg text-center" name="cpassword" placeholder="<?php echo $lang['field_30']; ?>" value="<?php echo $_POST['cpassword'];?>">
                    </div>
                    <h4><?php echo $lang['your_business_information']; ?></h4>
                    <div class="row form-group">
                        <div class="col">
                            <input type="text" class="form-control form-control-lg text-center" name="first_name" placeholder="<?php echo $lang['field_11']; ?>" value="<?php echo $_POST['first_name'];?>">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control-lg text-center" name="last_name" placeholder="<?php echo $lang['field_12']; ?>" value="<?php echo $_POST['last_name'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg text-center" name="business_name" placeholder="<?php echo $lang['field_17']; ?>" value="<?php echo $_POST['business_name'];?>">
                    </div>
                    <div class="row form-group">
                            <div class="col col-2">
                                <input class="form-control form-control-lg text-center" style="background: #e9ecef;border-right: 0px;border-top-right-radius: 0;border-bottom-right-radius: 0;" id="phone" name="phone"  type="tel">
                            </div>
                            <div class="col col-2" style="padding-left: 0;padding-right: 0;">
                                <input type="text" class="form-control form-control-lg text-center" id="country_code" value="<?php if(isset($country_code)){echo $country_code;}else{echo "+1";} ?>" name="country_code" style="border-bottom-right-radius: 0;border-top-right-radius: 0;border-bottom-left-radius: 0;border-top-left-radius: 0;border-left: 0px;padding-right: 0;padding-left: 0;" readonly="">
                            </div>
                            <div class="col col-8" style="padding-left: 0;">
                                <input type="text" class="form-control form-control-lg" id="phone_ext" value="<?php echo $phone_ext; ?>" name="phone_ext" placeholder="Phone Number" style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="form-control form-control-lg" name="country">
                                <option>Select Country</option>
                                <?php
                                $countries = getCountries();
                                    foreach($countries as $code=>$country) {
                                        if(protect($_POST['country'])==$country){
                                            $found = true;
                                            $sel = 'selected';
                                        }
                                        else{$sel='';}
                                        echo '<option value="'.$country.'" '.$sel.'>'.$country.'</option>';
                                    }
                                ?>
                            </select>
                            <?php 
                                    if(!$found){
                                        echo '<script>document.getElementsByName("country")[0].value="United States";</script>';
                                    }?>
                        </div>
                    <div class="row form-group">
                        <div class="col">
                            <input type="text" class="form-control form-control-lg text-center" name="city" placeholder="<?php echo $lang['field_14']; ?>" value="<?php echo $_POST['city'];?>">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control-lg text-center" name="zip_code" placeholder="<?php echo $lang['field_15']; ?>" value="<?php echo $_POST['zip_code'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg text-center" name="address" placeholder="<?php echo $lang['field_16']; ?>" value="<?php echo $_POST['address'];?>">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <div class="custom-checkbox-wrap">
                                <input type="checkbox" class="custom-control-input" id="accept_tou" name="accept_tou" value="yes">
                                <label class="custom-control-label" for="accept_tou">I have read and agree to the <a href="<?php echo $settings['url']; ?>page/terms-of-use">Terms of Use</a></label>
                            </div>
                        </div>
                    </div>
                    <p class="mt-4 d-block text-secondary">
                        By clicking register your are agree to the
                        <a href="javascript:void(0)">Terms and Condition.</a>
                    </p>
                    <input type="hidden" name="iso2" id="iso2" value="<?php echo $_POST['iso2']; ?>">
                    <button type="submit" name="pw_register" value="reg" class="btn btn-default btn-lg btn-rounded shadow btn-block"><?php echo $lang['btn_28']; ?></button>
                    </form>
                    <p style="margin-top:2%;"><?php echo $lang['already_have_account']; ?> <a href="<?php echo $settings['url']; ?>login"><?php echo $lang['btn_27']; ?></a></p>
                </div>
            </div>

            <!-- login buttons -->
            <!--<div class="row mx-0 bottom-button-container">
                <div class="col">
                    <a href="otp.html" class="btn btn-default btn-lg btn-rounded shadow btn-block">Next</a>
                </div>
            </div> -->
            <!-- login buttons -->
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
        
        <!-- Use as a jQuery plugin -->
        <script src="https://code.jquery.com/jquery-latest.min.js"></script>
        
        <script src="<?php echo $settings['url']; ?>icrypto_assets/intl-tel-input-master/build/js/intlTelInput-jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                // jQuery
                $("#phone").intlTelInput({
                    nationalMode:false,
                    placeholderNumberType:"MOBILE",
                    autoPlaceholder:"polite",
                    utilsScript: "<?php echo $settings['url']; ?>icrypto_assets/intl-tel-input-master/build/js/utils.js",
                    separateDialCode:false,
                    autoHideDialCode:false,
                    onlyCountries: [<?php 
                        $countries= getCountries();
                        foreach ($countries as $key => $value) {
                            echo '"'.$key.'",';
                        }
                    ?>],
                    //onlyCountries: ["pk","us","gb","in"],
                    // options here
                });
                intlTelInputGlobals.instances[0].setNumber("<?php echo $country_code; ?>");
                <?php 
                if(isset($_POST['iso2'])){
                    echo 'intlTelInputGlobals.instances[0].setCountry("'.$_POST['iso2'].'");';
                }
                else{
                    echo 'document.getElementById("iso2").value = intlTelInputGlobals.instances[0].getSelectedCountryData().iso2;';
                }
                ?>
                $('#iti-0__country-listbox').children().on("click",function(){
                    var country_name = this.children[1].innerText;
                    console.log(country_name);
                    $('select[name=country]').val(country_name);
                    $('#phone').val("");
                    document.getElementById("phone").value = "";
                });
                document.getElementById("phone").addEventListener("countrychange", function() {
                  // do something with iti.getSelectedCountryData()
                    document.getElementById("country_code").value = document.getElementById("phone").value;
                    document.getElementById("iso2").value = intlTelInputGlobals.instances[0].getSelectedCountryData().iso2;
                    //$('#country_code').val("");
                    //var code = $('#phone').val();
                    //$('#country_code').val(code);
                });
                document.getElementById("phone").addEventListener("open:countrydropdown", function() {
                    // triggered when the user opens the dropdown
                    $('#iti-0__country-listbox').children().on("click",function(){
                    var country_name = this.children[1].innerText;
                    console.log(country_name);
                    $('select[name=country]').val(country_name);
                    $('#phone').val("");
                    document.getElementById("phone").value = "";
                    });
                    document.getElementById("phone").addEventListener("countrychange", function() {
                      // do something with iti.getSelectedCountryData()
                        document.getElementById("country_code").value = document.getElementById("phone").value;
                        document.getElementById("iso2").value = intlTelInputGlobals.instances[0].getSelectedCountryData().iso2;
                        //$('#country_code').val("");
                        //var code = $('#phone').val();
                        //$('#country_code').val(code);
                        document.getElementById('country_code').blur();
                        document.getElementById('phone_ext').focus();
                    });
                });
                
                document.getElementById("phone").addEventListener("close:countrydropdown", function() {
                  // triggered when the user closes the dropdown
                });
            });
        </script>

    </body>


    <!--Crypto Wallet -->
    </html>
<?php } 
else { ?>
<!doctype html>
    <html lang="en" class="deeppurple-theme">
    <!--Crypto Wallet -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="icrypto">

        <title><?php echo $lang['title_create_a_personal']; ?> <?php echo $settings['name']; ?> <?php echo $lang['title_account']; ?></title>

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

        <div class="wrapper">
            <!-- header -->
            <div class="header">
                <div class="row no-gutters">
                    <div class="col-auto">
                        <a href="<?php echo $settings['url']; ?>" class="btn  btn-link text-dark"><i class="material-icons">chevron_left</i></a>
                    </div>
                    <div class="col text-center"></div>
                    <div class="col-auto">
                    </div>
                </div>
            </div>
            <!-- header ends -->

            <div class="row no-gutters login-row">
                <div class="col align-self-center px-3 text-center">
                    <br>
                    <img src="<?php echo $settings['url']; ?>icrypto_assets/img/logo-login.png" alt="logo" class="logo-small">
                    <form class="form-signin mt-3 " action="" method="POST">
                    <a href="<?php echo $settings['url']; ?>register/personal">
                        <div class="alert alert-primary">
                            <h4><i class="fa fa-user"></i> <?php echo $lang['acc_type_personal']; ?></h4>
                            <p><?php echo $lang['acc_personal_info']; ?></p>
                        </div>
                    </a>
                    <a href="<?php echo $settings['url']; ?>register/business">
                        <div class="alert alert-primary">
                                <h4><i class="fa fa-user-tie"></i> <?php echo $lang['acc_type_business']; ?></h4>       
                            <p><?php echo $lang['acc_business_info']; ?></p>
                        </div>
                    </a>
                    </form>
                    <p style="margin-top:2%;"><?php echo $lang['already_have_account']; ?> <a href="<?php echo $settings['url']; ?>login"><?php echo $lang['btn_27']; ?></a></p>
                </div>
            </div>

            <!-- login buttons -->
            <!--<div class="row mx-0 bottom-button-container">
                <div class="col">
                    <a href="otp.html" class="btn btn-default btn-lg btn-rounded shadow btn-block">Next</a>
                </div>
            </div> -->
            <!-- login buttons -->
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
    </html>
<?php } ?>

