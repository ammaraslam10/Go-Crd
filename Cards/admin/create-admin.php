<?php include('/../assets/inc/config.php'); $template['header_link'] = 'CREATE ADMIN - SUPER ADMIN'; ?>
<?php include('/../assets/inc/template_start.php'); ?>

<?php 
$primary_nav = array(
    array(
        'name'  => 'Super Admin Dashboard',
        'url'   => 'su',
        'icon'  => 'gi gi-compass',
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
                    <h1>Create Admin</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- END Validation Header -->
    
    <!-- Form Validation Content -->
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
        <?php
        if(isset($_POST['create_admin'])){
            $email=$_POST['val-email'];
            $username=$_POST['val-username'];
            $phone=$_POST['val-phone'];
            $password=$_POST['val-password'];
            $date = date('Y-m-d H:i:s');
            if(!UserAlreadyExists($email)){
                $query = $db->query("INSERT admin (email,contact,password,username,is_active,total_cards,date) VALUES ('$email','$phone','$password','$username','1','0','$date')");

                $GetU = $db->query("SELECT * FROM admin WHERE email='$email'");
                $gu = $GetU->fetch_assoc();
                    
                $file = '../uploads/default.jpg';
                $newfile = '../uploads/'.$gu[id].'.jpg';
                if (!copy($file, $newfile)) {
                    echo error("failed to copy");
                }
                echo success("Admin is created.");
            }
            else{
                echo error("This email is already associated with an account.");
            }
        }
        ?>
            <!-- Form Validation Block -->
            <div class="block">
                <!-- Form Validation Title -->
                <div class="block-title">
                    <h2>Create Admin</h2>
                </div>
                <!-- END Form Validation Title -->

                <!-- Form Validation Form -->

                <form id="form-validation" action="" method="post" class="form-horizontal form-bordered" autocomplete="off">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="email">Login Email <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input type="text" id="val-email" name="val-email" class="form-control" placeholder="Enter admin valid email.." required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="val-digits">Contact Number <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input type="text" id="val-phone" name="val-phone" class="form-control" placeholder="Enter phone number" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="val-name">Username <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input type="text" id="val-username" name="val-username" class="form-control" placeholder="Enter admin username" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="val-password">Password <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input type="password" id="val-password" name="val-password" class="form-control" placeholder="Enter password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="val-confirm-password">Confirm Password <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input type="password" id="val-confirm-password" name="val-confirm-password" class="form-control" placeholder="Enter new password" required>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-md-8 col-md-offset-3">
                            <button type="submit" name="create_admin" class="btn btn-effect-ripple btn-success">Create Admin</button>
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