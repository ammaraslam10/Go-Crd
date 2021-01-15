<?php include('/../assets/inc/config.php'); $template['header_link'] = 'DASHBOARD - SUPER ADMIN'; ?>
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
include('/../assets/inc/page_head.php'); ?>
<?php
    $file_url = '../uploads/su';
    $to_search = '../uploads/su';
    $img_url = get_image($file_url,$to_search);

    global $db; 
    $query = $db->query("SELECT * FROM card ORDER BY id ASC");
    $user_cards = 0;
    $admin_cards = 0;
    $active_cards = 0;
    $inactive_cards = 0;
    $trial_cards = 0;
    $total_earning = 0;
    $monthly_price = $settings['monthly_price'];
    $yearly_price = $settings['yearly_price'];
    while($row = $query->fetch_assoc()) {
        if($row['is_admin'] == 0){
            $user_cards++;
        }
        if($row['is_admin'] == 1){
            $admin_cards++;
        }
        if($row['card_status'] == 0){
            $inactive_cards++;
        }
        if($row['card_status'] == 1){
            $active_cards++;
        }
        if($row['subscription_type'] == 0){
            $trial_cards++;
        }
        if($row['subscription_type'] == 1){
            $total_earning+=$monthly_price;
        }
        if($row['subscription_type'] == 2){
            $total_earning+=$yearly_price;
        }
    }
    $query = $db->query("SELECT * FROM admin ORDER BY id ASC");
    $num_of_admins = $query->num_rows;
    $query = $db->query("SELECT * FROM user ORDER BY id ASC");
    $num_of_users = $query->num_rows;
?>
<!-- Page content -->
<div id="page-content">
    <!-- First Row -->
    <div class="row">
        <!-- Simple Stats Widgets -->
        <div class="col-sm-6 col-lg-3">
            <a href="javascript:void(0)" class="widget">
                <div class="widget-content widget-content-mini text-right clearfix">
                    <div class="widget-icon pull-left themed-background">
                        <i class="gi gi-credit_card text-light-op"></i>
                    </div>
                    <h2 class="widget-heading h3">
                        <strong><span data-toggle="counter" data-to="<?php echo $user_cards;?>"></span></strong>
                    </h2>
                    <span class="text-muted">USER CARDS</span>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a href="javascript:void(0)" class="widget">
                <div class="widget-content widget-content-mini text-right clearfix">
                    <div class="widget-icon pull-left themed-background-success">
                        <i class="fa fa-credit-card-alt text-light-op"></i>
                    </div>
                    <h2 class="widget-heading h3 text-success">
                        <strong><span data-toggle="counter" data-to="<?php echo $admin_cards;?>"></span></strong>
                    </h2>
                    <span class="text-muted">ADMIN CARDS</span>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a href="javascript:void(0)" class="widget">
                <div class="widget-content widget-content-mini text-right clearfix">
                    <div class="widget-icon pull-left themed-background-warning">
                        <i class="fa fa-user text-light-op"></i>
                    </div>
                    <h2 class="widget-heading h3 text-warning">
                        <strong><span data-toggle="counter" data-to="<?php echo $num_of_users;?>"></span></strong>
                    </h2>
                    <span class="text-muted">TOTAL USERS</span>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3">
            <a href="javascript:void(0)" class="widget">
                <div class="widget-content widget-content-mini text-right clearfix">
                    <div class="widget-icon pull-left themed-background-danger">
                        <i class="fa fa-users text-light-op"></i>
                    </div>
                    <h2 class="widget-heading h3 text-danger">
                        <strong><span data-toggle="counter" data-to="<?php echo $num_of_admins;?>"></span></strong>
                    </h2>
                    <span class="text-muted">TOTAL ADMINS</span>
                </div>
            </a>
        </div>
        <!-- END Simple Stats Widgets -->
    </div>
    <!-- END First Row -->

    <!-- Second Row -->
    <div class="row">
        <div class="col-sm-6 col-lg-8">
            <!-- Chart Widget -->
            <div class="widget">
                <div class="widget-content border-bottom">
                    <span class="pull-right text-muted">2013</span>
                    Last Year's Data
                </div>
                <div class="widget-content border-bottom themed-background-muted">
                    <!-- Flot Charts (initialized in js/pages/readyDashboard.js), for more examples you can check out http://www.flotcharts.org/ -->
                    <div id="chart-classic-dash" style="height: 393px;"></div>
                </div>
                <div class="widget-content widget-content-full">
                    <div class="row text-center">
                        <div class="col-xs-4 push-inner-top-bottom border-right">
                            <h3 class="widget-heading"><i class="gi gi-wallet text-dark push-bit"></i> <br><small>$ 41k</small></h3>
                        </div>
                        <div class="col-xs-4 push-inner-top-bottom">
                            <h3 class="widget-heading"><i class="gi gi-cardio text-dark push-bit"></i> <br><small>17k Sales</small></h3>
                        </div>
                        <div class="col-xs-4 push-inner-top-bottom border-left">
                            <h3 class="widget-heading"><i class="gi gi-life_preserver text-dark push-bit"></i> <br><small>3k+ Tickets</small></h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Chart Widget -->
        </div>
        <div class="col-sm-6 col-lg-4">
            <!-- Stats User Widget -->
            <a href="edit_profile" class="widget">
                <div class="widget-content border-bottom text-dark">
                    <span class="pull-right text-muted">Edit Profile</span>
                    Super Admin Profile
                </div>
                <div class="widget-content border-bottom text-center themed-background-muted">
                    <img src="<?php echo $img_url;?>" alt="avatar" class="img-circle img-thumbnail img-thumbnail-avatar-2x">
                    <h2 class="widget-heading h3 text-dark"><?php echo $settings['su_name'];?></h2>
                </div>
                <div class="widget-content widget-content-full-top-bottom">
                    <div class="row text-center">
                        <div class="col-xs-6 push-inner-top-bottom border-right">
                            <h3 class="widget-heading"><i class="gi gi-credit_card text-dark push-bit"></i> <br><small><?php echo $trial_cards;?> Trial Cards</small></h3>
                        </div>
                        <div class="col-xs-6 push-inner-top-bottom">
                            <h3 class="widget-heading"><i class="gi gi-usd text-dark push-bit"></i> <br><small>$<?php echo $total_earning;?> Earned Overall</small></h3>
                        </div>
                    </div>
                </div>
            </a>
            <!-- END Stats User Widget -->

            <!-- Mini Widgets Row -->
            <div class="row">
                <div class="col-xs-6">
                    <a href="javascript:void(0)" class="widget">
                        <div class="widget-content themed-background-success text-light-op text-center">
                            <div class="widget-icon">
                                <i class="fa fa-credit-card"></i>
                            </div>
                        </div>
                        <div class="widget-content text-dark text-center">
                            <strong><?php echo $active_cards;?></strong><br>Active Cards
                        </div>
                    </a>
                </div>
                <div class="col-xs-6">
                    <a href="inactive_cards" class="widget">
                        <div class="widget-content themed-background-danger text-light-op text-center">
                            <div class="widget-icon">
                                <i class="fa fa-credit-card-alt"></i>
                            </div>
                        </div>
                        <div class="widget-content text-dark text-center">
                            <strong><?php echo $inactive_cards;?></strong><br>
                            Inactive Cards
                        </div>
                    </a>
                </div>
            </div>
            <!-- END Mini Widgets Row -->
        </div>
    </div>
    <!-- END Second Row -->

    <!-- Third Row -->
    <!-- END Third Row -->
</div>
<!-- END Page Content -->

<?php include('\..\assets\inc\page_footer.php'); ?>
<?php include('\..\assets\inc\template_scripts.php'); ?>

<!-- Load and execute javascript code used only in this page -->
<script src="<?php echo $settings['url_assets'] ?>js/pages/readyDashboard.js"></script>
<script>$(function(){ ReadyDashboard.init(); });</script>

<?php include('\..\assets\inc\template_end.php'); ?>