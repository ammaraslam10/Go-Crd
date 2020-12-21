<?php include('/../assets/inc/config.php'); $template['header_link'] = 'USER INFORMATION'; ?>
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
        'active'=> true
    ),
    array(
        'name'  => 'Admin Information',
        'icon'  => 'fa fa-rocket',
        'url'   => 'admin_information',
    ),
    array(
        'name'  => 'Direct User Card Information',
        'icon'  => 'fa fa-rocket',
        'url'   => 'direct_user_card_information',
    ),
    array(
        'name'  => 'Admin User Card Information',
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
    }
    if(isset($_POST['change_status'])){
        $id = $_POST['id'];
        $new_status = $_POST['new_status'];
        $query = $db->query("UPDATE user SET is_active='$new_status' where id='$id'");
    }
?>
<!-- Page content -->
<div id="page-content">
    <!-- Table Styles Header -->
    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1>User Information</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- END Table Styles Header -->

    <!-- Datatables Block -->
    <!-- Datatables is initialized in js/pages/uiTables.js -->
    <div class="block full">
        <div class="block-title">
            <h2>List of all registered users:</h2>
        </div>
        <div class="table-responsive">
            <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">ID</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Login Password</th>
                        <th>Username</th>
                        <th>Active</th>
                        <th>Total Cards</th>
                        <th>Date</th>
                        <th class="text-center" style="width: 75px;">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $labels['1']['class'] = "label-success";
                    $labels['1']['text'] = "Active";
                    $labels['0']['class'] = "label-danger";
                    $labels['0']['text'] = "Disabled";
                    ?>
                    <?php
                    global $db; 
                    $query = $db->query("SELECT * FROM user ORDER BY id ASC");
                    $i=1;
                    while($row = $query->fetch_assoc()) {
                        ?>
                    <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td><?php echo $row['email'];?></td>
                        <td><?php echo $row['contact'];?></td>
                        <td><?php echo $row['password'];?></td>
                        <td><?php echo $row['username'];?></td>
                        <td class="text-center">
                            <form action="" method="post">
                                <button name="change_status" class="label<?php echo ($labels[$row['is_active']]['class']) ? " " . $labels[$row['is_active']]['class'] : ""; ?>"><?php echo $labels[$row['is_active']]['text'] ?></button>
                                <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                                <input type="hidden" name="new_status" value="<?php  echo ($row['is_active']) ? "0" : "1"; ?>">
                            </form>
                        </td>
                        <td><?php echo $row['total_cards'];?></td>
                        <td><?php echo $row['date'];?></td>
                        <td class="text-center">
                            <form action="" method="post">
                                <button name="delete_user" value="delete_user" data-toggle="tooltip" title="Delete User" class="btn btn-effect-ripple btn-xs btn-danger"><i class="fa fa-times"></i></button>
                                <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                            </form>
                        </td>
                    </tr>
                    <?php 
                    ++$i;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END Datatables Block -->
</div>
<!-- END Page Content -->




<?php include('\..\assets\inc\page_footer.php'); ?>
<?php include('\..\assets\inc\template_scripts.php'); ?>

<!-- Load and execute javascript code used only in this page -->
<script src="<?php echo $settings['url_assets'] ?>js/pages/uiTables.js"></script>
<script>$(function(){ UiTables.init(); });</script>

<?php include('\..\assets\inc\template_end.php'); ?>