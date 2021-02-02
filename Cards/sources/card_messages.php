<?php include('assets/inc/config.php'); ?>

<?php


if(!isset($_GET['b'])) {
    header("Location: home");
    exit;
}
include('includes/default_array_lists.php');
$error = []; 


if($_SESSION['type']=="su"){
    $uid = -1; 
} 
else{
    $uid = $_SESSION['id'];
}
if($_SESSION['type']=="admin" || $_SESSION['type']=="su") {
    $is_admin = 1;
}
else{
    $is_admin = 0;
}

$id = clean($db, intval($_GET['b']));
$data = mysqli_fetch_array(mysqli_query($db, 'select * from card where id='.$id));
if(!isset($data['id'])) {
	exit;
}
if($data['creator'] != $uid) {
	header('Location: login');
}
$template['header_link'] = 'Messages - '.ucfirst($data['card_link']); 

?>

<?php include('assets/inc/template_start.php'); ?>
<?php
$primary_nav = array(
    array(
        'name'  => 'Dashboard',
        'url'   => '.',
        'icon'  => 'gi gi-compass',
    ),
    array(
        'url'   => 'separator',
    ),
    array(
        'name'  => 'Create New Card',
        'url'   => 'create-card',
        'icon'  => 'gi gi-compass',
        'active'=> true
    ),
    array(
        'name'  => 'My Cards',
        'icon'  => 'fa fa-rocket',
        'url'   => 'direct_user_card_information',
    ),
    array(
        'name'  => 'Card Messages',
        'icon'  => 'fa fa-rocket',
        'url'   => 'view-card-messages',
    ),
    array(
        'url'   => 'separator',
    ),
    array(
        'name'  => 'Edit Profile',
        'icon'  => 'fa fa-rocket',
        'url'   => 'edit_profile',
    )
    
);
?>
<?php include('assets/inc/page_head.php'); ?>

<link href="<?php echo $settings['url_assets']; ?>libs/bootstrap-tagsinput.css" rel="stylesheet">
<link href="<?php echo $settings['url_assets']; ?>css/additional-css.css" rel="stylesheet">

<!-- Page content -->
<div id="page-content">
    <!-- Wizard Header -->
    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1><?php echo $template['header_link']; ?></h1>
                </div>
            </div>
            <!--<div class="col-sm-6 hidden-xs">
                <div class="header-section">
                    <ul class="breadcrumb breadcrumb-top">
                        <li>User Interface</li>
                        <li>Forms</li>
                        <li><a href="">Wizard</a></li>
                    </ul>
                </div>
            </div>-->
        </div>
    </div>
    <!-- END Wizard Header -->

    <!-- Wizards Content -->
    <!-- Form Wizards are initialized in js/pages/formsWizard.js -->
    <div class="row">
        <div class="col-sm-10 col-md-10 col-lg-10">

                                <table id="general-table" class="table table-striped table-vcenter table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
	$messages = mysqli_query($db, 'select * from card_messages where card_id='.$id.' order by id desc');
	while($m = mysqli_fetch_array($messages)) {
?>
                                        <tr>
                                            <td><strong><?php echo $m['name']; ?></strong></td>
                                            <td><?php echo $m['mobile']; ?></td>
                                            <td><?php echo $m['email']; ?></td>
                                            <td>
                                                 <?php echo $m['message']; ?>
                                            </td>
                                        </tr>
<?php } ?>
                                    </tbody>
                                </table>
        </div>

    </div>
</div>
<!-- END Page Content -->

<?php include('assets\inc\page_footer.php'); ?>
<?php include('assets\inc\template_scripts.php'); ?>
<script src="<?php echo $settings['url_assets']; ?>libs/bootstrap-tagsinput.min.js"></script>

<?php include('assets\inc\template_end.php'); ?>