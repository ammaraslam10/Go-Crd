<?php include('/../assets/inc/config.php'); $template['header_link'] = 'USER CARD INFORMATION'; 
$type='card c inner join user u on c.creator = u.admin_id WHERE c.is_admin = 0 ORDER BY c.id ASC';
?>
<?php include('excel.php');?>
<?php include('/../assets/inc/template_start.php'); ?>
<?php 
$primary_nav = array(
    array(
        'name'  => 'Admin Dashboard',
        'url'   => '.',
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
        'name'  => 'User Card Information',
        'icon'  => 'fa fa-rocket',
        'url'   => 'direct_user_card_information',
        'active'=> true
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
include('/../assets/inc/page_head.php'); ?>
<?php
    if(isset($_POST['delete_user'])){
        $id = $_POST['id'];
        $query = $db->query("DELETE FROM user where id='$id'");
        $query = $db->query("DELETE FROM card where creator='$id' and is_admin=0 ");
    }
    if(isset($_POST['change_sub_type'])){
        $id = $_POST['card_id'];
        $new_status = $_POST['new_sub_type'];
        $query = $db->query("UPDATE card SET subscription_type='$new_status' where id='$id'");
    }
    if(isset($_POST['change_status'])){
        $id = $_POST['card_id'];
        $new_status = $_POST['new_status'];
        $query = $db->query("UPDATE card SET card_status='$new_status' where id='$id'");
    }
    if(isset($_POST['new_payment_status'])){
        $id = $_POST['card_id'];
        $new_status = $_POST['new_payment_status'];
        $query = $db->query("UPDATE card SET payment_status='$new_status' where id='$id'");
    }
    if(isset($_POST['new_footer_status'])){
        $id = $_POST['card_id'];
        $new_status = $_POST['new_footer_status'];
        $query = $db->query("UPDATE card SET has_footer='$new_status' where id='$id'");
    }
    if(isset($_POST['delete_card'])){
        $id = $_POST['card_id'];
        $query = $db->query("DELETE FROM card where id='$id'");
    }
    
?>
<!-- Page content -->
<div id="page-content">
    <!-- Table Styles Header -->
    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1>Direct User Card Information</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- END Table Styles Header -->

    <!-- Datatables Block -->
    <!-- Datatables is initialized in js/pages/uiTables.js -->
    <div class="block full">
        <div class="block-title">
            <h2>List of all direct users cards:</h2>
        </div>
        <div class="table-responsive">
            <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">Sr.No</th>
                        <th>User Email</th>
                        <th>Card ID</th>
                        <th>Company Name</th>
                        <th>Payment Status</th>
                        <th>Creation Date</th>
                        <th>Trial Expiry Date</th>
                        <th>Plan Expiry Date</th>
                        <th>Subscription Type</th>
                        <th>Card Link</th>
                        <th>Card Status</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $labels_payment_status['1']['class'] = "label-success";
                        $labels_payment_status['1']['text'] = "Paid";
                        $labels_payment_status['0']['class'] = "label-danger";
                        $labels_payment_status['0']['text'] = "Unpaid";

                        $labels_card_status['1']['class'] = "label-success";
                        $labels_card_status['1']['text'] = "Active";
                        $labels_card_status['0']['class'] = "label-danger";
                        $labels_card_status['0']['text'] = "Disabled";
                        
                        $labels_subscription_type['0']['class'] = "label-danger";
                        $labels_subscription_type['0']['text'] = "Trial";
                        $labels_subscription_type['1']['class'] = "label-warning";
                        $labels_subscription_type['1']['text'] = "Monthly";
                        $labels_subscription_type['2']['class'] = "label-success";
                        $labels_subscription_type['2']['text'] = "Yearly";
                        ?>
                        <?php
                        global $db; 
                        $query = $db->query("SELECT DISTINCT c.* FROM card c inner join user u on c.creator = u.admin_id WHERE is_admin = 0 and u.admin_id='$_SESSION[id]' ORDER BY id ASC");
                        $i=1;
                        $items = array();
                        while($row = $query->fetch_assoc()) {
                            //print_r($row);
                            $items[] = $row;
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td><?php echo $row['user_email'];?></td>
                        <td><?php echo $row['id'];?></td>
                        <td><?php echo $row['company'];?></td>
                        <td class="text-center">
                            <labels name="change_status" class="label<?php echo ($labels_payment_status[$row['payment_status']]['class']) ? " " . $labels_payment_status[$row['payment_status']]['class'] : ""; ?>"><?php echo $labels_payment_status[$row['payment_status']]['text'] ?></labels>
                        </td>
                        <td><?php echo $row['creation_date'];?></td>
                        <td><?php echo $row['trial_expiry_date'];?></td>
                        <td><?php echo $row['plan_expiry_date'];?></td>
                        <!-- For Subscription -->
                        <td class="text-center">
                            <label name="change_sub_type" class="label<?php echo ($labels_subscription_type[$row['subscription_type']]['class']) ? " " . $labels_subscription_type[$row['subscription_type']]['class'] : ""; ?>"><?php echo $labels_subscription_type[$row['subscription_type']]['text'] ?></label>
                        </td>
                        <td><a href="<?php echo $row['card_link'];?>"><?php echo $row['card_link'];?></a></td>
                        <!-- For Card Status -->
                        <td class="text-center">
                            <label name="change_status" class="label<?php echo ($labels_card_status[$row['card_status']]['class']) ? " " . $labels_card_status[$row['card_status']]['class'] : ""; ?>"><?php echo $labels_card_status[$row['card_status']]['text'] ?></label>
                        </td>
                        <td class="text-center">
                            <!--<form action="" method="post" style="display:inline;" onsubmit="return confirm('Do you really want to delete this card?');">
                                <button name="delete_card" value="delete_card" data-toggle="tooltip" title="Delete Card" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-times"></i></button>
                                <input type="hidden" name="card_id" value="<?php echo $row['id'];?>">
                            </form>-->
                            <a href="./edit-card?card_id=<?php echo $row['id'];?>" data-toggle="tooltip" title="Edit User" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                        </td>
                    </tr>
                    <?php 
                    }
                    //Check the export button is pressed or not
                    //print_r($items);
                    ?>
                </tbody>
            </table>
        </div>
        <br>
        <form action="" method="post" id="excel_form">
            <div class="input-group">
                <button name="export" class="btn btn-primary" id="create_excel"><i class="fa fa-cloud-download"></i>  Save As Excel</button>
            </div>
        </form>
    </div>
    <!-- END Datatables Block -->
</div>
<!-- END Page Content -->




<?php include('\..\assets\inc\page_footer.php'); ?>
<?php include('\..\assets\inc\template_scripts.php'); ?>

<!-- Load and execute javascript code used only in this page -->
<script src="<?php echo $settings['url_assets'] ?>js/pages/uiTables.js"></script>
<script>$(function(){ UiTables.init(); });</script>
<script>
    /*$(document).ready(function(){  
        $('#create_excel').click(function(){
            var excel_data = $('.table-responsive').html();
            $('#excel_data').val(excel_data);  
            //var page = "excel.php?data=" + excel_data;  
            //window.location = page;
            console.log(excel_data);
            $('#excel_form').submit();  
        });  
    }); */
</script>
<?php include('\..\assets\inc\template_end.php'); ?>