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
                                            <h3><?php echo $lang['head_activity']; ?></h3>
                                            <hr/>
                                            <form class="user-connected-from user-signup-form" action="" method="POST">
                                            <div class="row form-group">
                                                <div class="col">
                                                    <input type="text" class="form-control" name="txid" placeholder="<?php echo $lang['field_24']; ?>">
                                                </div>
                                                <div class="col">
                                                    <input type="text" class="form-control" name="email" placeholder="<?php echo $lang['field_25']; ?>">
                                                </div>
                                                <div class="col">
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" name="start_date" id="datepicker1" placeholder="<?php echo $lang['field_26']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" name="end_date"  id="datepicker2" placeholder="<?php echo $lang['field_27']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <button type="submit" class="btn btn-primary btn-block" name="pw_search" value="search" style="padding:11px;"><i class="fa fa-search"></i> <?php echo $lang['btn_22']; ?></button>
                                                </div>
                                            </div>
                                            </form>
                                            <?php
                                            $PW_Searching = 0;
                                            $FormBTN = protect($_POST['pw_search']);
                                            if($FormBTN == "search") {
                                                $PW_Search = '';
                                                $transaction_id = protect($_POST['txid']);
                                                if(!empty($transaction_id)) {
                                                    $PW_Search .= " and txid='$transaction_id'";
                                                }
                                                $email = protect($_POST['email']);
                                                $email_id = PW_GetUserID($email);
                                                if($email_id !== false && $email_id > 0) {
                                                    $PW_Search .= " and u_field_1='$email_id'";
                                                }
                                                $start_date = protect($_POST['start_date']);
                                                if(!empty($start_date)) {
                                                    $start_date = strtotime($start_date);
                                                    $PW_Search .= " and created > $start_date";
                                                }
                                                $end_date = protect($_POST['end_date']);
                                                if(!empty($end_date)) {
                                                    $end_date = strtotime($end_date);
                                                    $PW_Search .= " and created < $start_date";
                                                }
                                                if(!empty($PW_Search)) {
                                                    $PW_Searching = 1;
                                                }
                                            }
                                            ?>
                                            <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $lang['date']; ?></th>
                                                        <th><?php echo $lang['transaction_id']; ?></th>
                                                        <th><?php echo $lang['activity']; ?></th>
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
                                                if($PW_Searching == "1") {
                                                    $statement = "pw_activity WHERE uid='$_SESSION[pw_uid]' $PW_Search";
                                                    $query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC");
                                                } else {
                                                    $statement = "pw_activity WHERE uid='$_SESSION[pw_uid]'";
                                                    $query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
                                                }
                                                if($query->num_rows>0) {
                                                    while($row = $query->fetch_assoc()) {
                                                        $amount = $row['amount'];
                                                        if($row['type'] == "2" or $row['type'] == "4" or $row['type'] == "6" or $row['type'] == "7" or $row['type'] == "8") {
                                                                $amount = '-'.$amount;
                                                        } else {
                                                                $amount = '+'.$amount;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?php echo PW_ActivityDate($row[created]); ?></td>
                                                            <td><a href="<?php echo $settings['url']; ?>account/transaction/<?php echo $row['txid']; ?>"><?php echo $row['txid']; ?></a></td>
                                                            <td><?php echo PW_DecodeUserActivity($row[id]); ?></td>
                                                            <td><?php echo $amount.' '.$row[currency]; ?></td>
                                                            <td><?php echo PW_DecodeTXStatus($row[status]); ?></td>
                                                            <td><a href="<?php echo $settings['url']; ?>account/transaction/<?php echo $row['txid']; ?>" class="btn btn-primary btn-sm">Details</a></td>
                                                        </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        if($PW_Searching == "1") {
                                                            echo '<tr><td colspan="6">'.$lang[info_7].'</td></tr>';
                                                        } else {
                                                            echo '<tr><td colspan="6">'.$lang[info_8].'</td></tr>';
                                                        }
                                                    }
                                                    ?>
                                                  </tbody>
                                            </table>
                                            <?php
                                            if($PW_Searching == "0") {
                                                $ver = $settings['url']."account/activity";
                                                if(web_pagination($statement,$ver,$limit,$page)) {
                                                    echo web_pagination($statement,$ver,$limit,$page);
                                                }
                                            }
                                            ?>
                                            </div>
                                        </div><!-- create-account-block -->
                                    </div>
                                </div>
                            </div><!-- user-login-signup-form-wrap -->
                </div>