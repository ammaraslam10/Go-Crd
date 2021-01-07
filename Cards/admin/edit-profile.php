<?php include('/../assets/inc/config.php'); $template['header_link'] = 'EDIT PROFILE - SUPER ADMIN'; ?>
<?php include('/../assets/inc/template_start.php'); ?>

<?php 
$primary_nav = array(
    array(
        'name'  => 'Super Admin Dashboard',
        'url'   => 'su',
        'icon'  => 'gi gi-compass',
        'active'=> true
    ),
    array(
        'url'   => 'separator',
    ),
    array(
        'name'  => 'Create New Card',
        'url'   => 'create-card',
        'icon'  => 'gi gi-compass'
    ),
    array(
        'url'   => 'separator',
    ),
    array(
        'name'  => 'User Information',
        'icon'  => 'fa fa-rocket',
        'url'   => 'user_information',
    ),
    array(
        'name'  => 'Admin Information',
        'icon'  => 'fa fa-rocket',
        'url'   => 'admin_information',
    ),
    array(
        'name'  => 'User Card Information',
        'icon'  => 'fa fa-rocket',
        'url'   => 'direct_user_card_information',
    ),
    array(
        'name'  => 'Admin Card Information',
        'icon'  => 'fa fa-rocket',
        'url'   => 'admin_user_card_information',
    ),
    array(
        'url'   => 'separator',
    ),
    array(
        'name'  => 'Edit Profile',
        'icon'  => 'fa fa-rocket',
        'url'   => 'edit_profile',
    ),
    
);
include('/../assets/inc/page_head.php');?>

<!-- Page content -->
<div id="page-content">
    <!-- Validation Header -->
    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1>Edit Profile</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- END Validation Header -->
    
    <!-- Form Validation Content -->
    <div class="row">
        
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
        <?php
        if(isset($_POST['update_profile'])){
            $email=$_POST['val-email'];
            $name=$_POST['val-name'];
            $phone=$_POST['val-phone'];
            $password=$_POST['val-password'];
            $stripe_key=$_POST['val-stripe_key'];
            $razorpay_key=$_POST['val-razorpay_key'];
            $query = $db->query("UPDATE settings SET su_email='$email',su_password='$password',su_phone='$phone',su_name='$name',stripe_key='$stripe_key',razorpay_key='$razorpay_key'");
            //print_r($_FILES);
            if(isset($_FILES['fileToUpload']) && $_FILES['error'] != 4) {
                $target_dir = "../uploads/";
                $to_search = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                //echo $to_search;
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($to_search,PATHINFO_EXTENSION));
                
                
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 2000000  || $_FILES["fileToUpload"]["size"] == 0) {
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
                    
                $to_search = $target_dir.'su';
                //echo 'file name will be: '.$to_search;
                  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $to_search.'.'.$imageFileType)) {
                    echo success("Profile picture has been updated.");
                    clearstatcache();
                  } 
                  else {
                    echo error("Sorry, there was an error uploading your file.");
                  }
                }
            }
               
            $settingsQuery = $db->query("SELECT * FROM settings ORDER BY id DESC LIMIT 1");
            $settings = $settingsQuery->fetch_assoc();
            echo success("Your changes were saved.");
        }
        ?>
            <!-- Form Validation Block -->
            <div class="block">
                <!-- Form Validation Title -->
                <div class="block-title">
                    <h2>Edit Profile</h2>
                </div>
                <!-- END Form Validation Title -->

                <!-- Form Validation Form -->

                <form id="form-validation" action="" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    <div>
                        <div class="text-center">
                            <div class="figure-profile shadow my-4">
                            <?php
                                $file_url = '../uploads/su';
                                $to_search = '../uploads/su';
                                $img_url = get_image($file_url,$to_search);
                                
                            ?>
                                <div class="widget-image widget-image-sm" style="height: 167px;background-color: white;">
                                    <div class="widget-image-content text-center" style="
                                        background-color: #454e59;
                                        ">
                                        <img id="dp" src="<?php echo $img_url;?>" alt="avatar" class="img-circle img-thumbnail img-thumbnail-transparent img-thumbnail-avatar-2x push">
                                        <div class="btn btn-dark text-white floating-btn" style="top: 66%;right: 38%;color: #fafbfc;background-color: #6cd1e1;">
                                            <i class="fa fa-camera"></i>
                                            <input type="file" name="fileToUpload" id="changeimage_input" onchange="file_changed()" class="float-file">
                                        </div>
                                    </div>
                                </div>
                                <!--<figure><img id="dp" src="<?php //echo $img_url;?>" alt=""></figure>-->
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="email">Login Email <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input type="text" id="val-email" name="val-email" class="form-control" placeholder="Enter your valid email.." value="<?php echo $settings['su_email'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="val-digits">Contact Number <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input type="text" id="val-phone" name="val-phone" class="form-control" placeholder="Enter phone number" value="<?php echo $settings['su_phone'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="val-name">Name <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input type="text" id="val-name" name="val-name" class="form-control" placeholder="Enter your name" value="<?php echo $settings['su_name'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="val-password">Password <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input type="password" id="val-password" name="val-password" class="form-control" placeholder="Enter password" value="<?php echo $settings['su_password'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="val-confirm-password">Confirm Password <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input type="password" id="val-confirm-password" name="val-confirm-password" class="form-control" placeholder="Enter new password" value="<?php echo $settings['su_password'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="val-stripe_key">Stripe Key <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input type="text" id="val-stripe_key" name="val-stripe_key" class="form-control" placeholder="Enter Stripe Key" value="<?php echo $settings['stripe_key'];?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="val-razorpay_key">RazorPay Key <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input type="text" id="val-razorpay_key" name="val-razorpay_key" class="form-control" placeholder="Enter RazorPay Key" value="<?php echo $settings['razorpay_key'];?>" required>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-md-8 col-md-offset-3">
                            <button type="submit" name="update_profile" class="btn btn-effect-ripple btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
                <!-- END Form Validation Form -->
            </div>
            <!-- END Form Validation Block -->
        </div>
    </div>
    <!-- END Form Validation Content -->
</div>
<!-- END Page Content -->

<?php include('\..\assets\inc\page_footer.php'); ?>
<?php include('\..\assets\inc\template_scripts.php'); ?>

<!-- Load and execute javascript code used only in this page -->
<!-- Load and execute javascript code used only in this page -->
<script src="<?php echo $settings['url_assets'] ?>js/pages/formsValidation.js"></script>
<script>$(function() { FormsValidation.init(); });</script>
<script src="<?php echo $settings['url_assets'] ?>js/pages/uiTypography.js"></script>
<script>$(function(){ UiTypography.init(); });</script>
<script>
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
<?php include('\..\assets\inc\template_end.php'); ?>