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
            <div class="col-md-12">
                    
                        <div class="user-wallet-wrap">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="user-connected-form-block">
                                            <h3><?php echo $lang['head_disputes']; ?></h3>
                                            
                                            <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $lang['date']; ?></th>
                                                        <th><?php echo $lang['dispute']; ?></th>
                                                        <th><?php echo $lang['sender']; ?></th>
                                                        <th><?php echo $lang['recipient']; ?></th>
                                                        <th><?php echo $lang['amount']; ?></th>
                                                        <th><?php echo $lang['status']; ?></th>
                                                        <th><?php echo $lang['action']; ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                                                    $limit = 15;
                                                    $startpoint = ($page * $limit) - $limit;
                                                    if($page == 1) {
                                                        $i = 1;
                                                    } else {
                                                        $i = $page * $limit;
                                                    }
                                                    $statement = "pw_disputes WHERE sender='$_SESSION[pw_uid]' or recipient='$_SESSION[pw_uid]'";
                                                    $query = $db->query("SELECT * FROM {$statement} ORDER BY status, id DESC LIMIT {$startpoint} , {$limit}");
                                                    if($query->num_rows>0) {
                                                        while($row = $query->fetch_assoc()) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo date("d M Y H:i",$row['created']); ?></td>
                                                            <td><a href="<?php echo $settings['url']; ?>account/dispute/<?php echo $row['hash']; ?>"><?php echo $row['hash']; ?></a></td>
                                                            <td><?php if(idinfo($row['sender'],"account_type") == "1") { echo idinfo($row['sender'],"first_name")." ".idinfo($row['sender'],"last_name"); } else { echo idinfo($row['sender'],"business_name"); } if($_SESSION['pw_uid'] == $row['sender']) { echo ' (You)'; } ?></td>
                                                            <td><?php if(idinfo($row['recipient'],"account_type") == "1") { echo idinfo($row['recipient'],"first_name")." ".idinfo($row['recipient'],"last_name"); } else { echo idinfo($row['recipient'],"business_name"); } if($_SESSION['pw_uid'] == $row['recipient']) { echo ' (You)'; } ?></td>
                                                            <td><?php echo $row['amount']." ".$row['currency']; ?></td>
                                                            <td>
                                                                <?php
                                                                $status = $row['status'];
                                                                if($row['status'] == "1") {
                                                                    echo '<span class="label label-info">'.$lang[status_dispute_1].'</span>';
                                                                } elseif($row['status'] == "2") {
                                                                    echo '<span class="label label-primary">'.$lang[status_dispute_2].'</span>';
                                                                } elseif($row['status'] == "3") {
                                                                    echo '<span class="label label-success">'.$lang[status_dispute_3].'</span>';
                                                                } elseif($row['status'] == "4") {
                                                                    echo '<span class="label label-default">'.$lang[status_dispute_4].'</span>';
                                                                } else {
                                                                    echo '<span class="label label-default">'.$lang[status_unknown].'</span>';
                                                                }
                                                                ?> 
                                                            </td>
                                                            <td>
                                                                <?php if($row['status']<2) { ?>
                                                                <a href="<?php echo $settings['url']; ?>account/dispute/<?php echo $row['hash']; ?>" class="btn btn-primary btn-sm"><?php echo $lang['btn_6']; ?></a>
                                                                <?php } else { ?>
                                                                <a href="<?php echo $settings['url']; ?>account/dispute/<?php echo $row['hash']; ?>" class="btn btn-primary btn-sm"><?php echo $lang['btn_7']; ?></a>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        echo '<tr><td colspan="7">'.$lang[info_3].'</td></tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <?php
                                            $ver = $settings['url']."account/disputes";
                                            if(web_pagination($statement,$ver,$limit,$page)) {
                                                echo web_pagination($statement,$ver,$limit,$page);
                                            }
                                            ?>
                                            </div>

                                        </div><!-- create-account-block -->
                                    </div>
                                </div>
                            </div><!-- user-login-signup-form-wrap -->
                </div>