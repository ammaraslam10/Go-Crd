<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$b = protect($_GET['b']);

if($b == "view") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM pw_transactions WHERE type='1' and id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=transactions"); }
	$row = $query->fetch_assoc();
	?>
	<br>
		<br>
		<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Transactions</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
							<li>View</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">

           <div class="col-md-12">
					<div class="card">
                        <div class="card-body">
                            <?php
                            $FormBTN = protect($_POST['btn_action']);
                            if($FormBTN == "process_sending") {
                                $row['status'] = '1';
                                //$update = $db->query("UPDATE pw_withdrawals SET status='3' WHERE id='$row[id]'");
                                $update = $db->query("UPDATE pw_activity SET status='1' WHERE txid='$row[txid]'");
                                $update = $db->query("UPDATE pw_transactions SET status='1' WHERE txid='$row[txid]'");
                                PW_UpdateUserWallet($row['recipient'],$row['amount'],$row['currency'],1);
                                $account = idinfo($row['uid'],"email");
                                echo success("Transaction was approved successfully.");
                                $transaction = $row;
                                $recipient_id = $transaction['recipient'];
                                $currency = $transaction['currency'];
                                
                                //send notification to recipient
                                $to = idinfo($transaction['recipient'],"email");
                                $amount = $transaction['amount'] - $transaction['fee'];
                                $subject = "Congratulations! Your payment is approved in ".$settings['name'];
                                $text = "You have received ".$amount.$transaction['currency']." from ".idinfo($transaction['sender'],"first_name")." ".idinfo($transaction['sender'],"last_name")." and the balance is now reflected in your wallet.";
                                //echo $text;
                                $link = $settings['url'].'account/transaction/'.$transaction['txid'];
                                PW_EmailSys_Send_Generic($to,$subject,$text,$link);
                                PW_InsertNotification($recipient_id,$_SESSION['pw_uid'],'The amount '.$amount.' '.$currency.' received from '.idinfo($_SESSION['pw_uid'],"first_name").' '.idinfo($_SESSION['pw_uid'],"last_name").' is now reflected in your balance',$amount,$currency,'9',time());
                                
                                //send notification to sender
                                $to = idinfo($transaction['sender'],"email");
                                $amount = $transaction['amount'];
                                $subject = "Congratulations! Your payment is approved in ".$settings['name'];
                                $text = "You have sent ".$amount.$transaction['currency']." to ".idinfo($transaction['recipient'],"first_name")." ".idinfo($transaction['recipient'],"last_name")." has been approved and the balance is now reflected in users wallet.";
                                $link = $settings['url'].'account/settings/verification';
                                PW_EmailSys_Send_Generic($to,$subject,$text,$link);
                                PW_InsertNotification($transaction['sender'],$recipient_id,idinfo($recipient_id,"first_name").' '.idinfo($recipient_id,"last_name").' has receieved your sent amount of '.$amount.' '.$currency.' and it is now reflected in their balance',$amount,$currency,'10',time());
                                //$update = $db->query("UPDATE pw_activity SET status='1' WHERE txid='$row[txid]'");
                            	
                            	
                            	if($query->num_rows==0) { header("Location: ./?a=transactions"); }
                            	$row = $query->fetch_assoc();
                            }

                            if($FormBTN == "cancel_sending") {
                                $row['status'] = '2';
                                //$update = $db->query("UPDATE pw_withdrawals SET status='2' WHERE id='$row[id]'");
                                $update = $db->query("UPDATE pw_activity SET status='2' WHERE txid='$row[txid]'");
                                $update = $db->query("UPDATE pw_transactions SET status='2' WHERE txid='$row[txid]'");
                                echo success("Transaction was canceled successfully.");
                                
                                $transaction = $row;
                                //send notification to sender
                                $to = idinfo($transaction['sender'],"email");
                                $amount = $transaction['amount'];
                                $subject = "Oh no! Your payment is declined in ".$settings['name'];
                                $text = "You sent ".$amount.$transaction['currency']." to ".idinfo($transaction['recipient'],"first_name")." ".idinfo($transaction['recipient'],"last_name")." has been declined See the link for more information.";
                                $link = $settings['url'].'account/transaction/'.$transaction['txid'];
                                PW_EmailSys_Send_Generic($to,$subject,$text,$link);
                            }
                            ?>

                            <table class="table table-striped">
                                <tbody>
                                <tr>
                                        <td>Transaction ID:</td>
                                        <td><?php echo $row['id']; ?></td>
                                    </tr>
                                <tr>
                                        <td>Transaction Hash:</td>
                                        <td><?php echo $row['txid']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Sender:</td>
                                        <td><a href="./?a=users&b=edit&id=<?php echo $row['sender']; ?>"><?php echo idinfo($row['sender'],"email"); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td>Recipient:</td>
                                        <td><a href="./?a=users&b=edit&id=<?php echo $row['recipient']; ?>"><?php echo idinfo($row['recipient'],"email"); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td>Gross amount:</td>
                                        <td><?php echo $row['amount']; ?> <?php echo $row['currency']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $settings['name']; ?> transaction fee:</td>
                                        <td><?php echo $row['fee']; ?> <?php echo $row['currency']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Net amount:</td>
                                        <td><?php echo $row['amount']-$row['fee']; ?> <?php echo $row['currency']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Date:</td>
                                        <td><?php if($row['created']>0) { echo date("d/m/Y H:i:s",$row['created']); } else { echo 'n/a'; } ?></td>
                                    </tr>
                                    <tr>
                                        <td>Status:</td>
                                        <td>
                                                <?php
                                                $status = $row['status'];
                                                if($status == "1") {
                                                    echo '<span class="badge badge-success">Completed</span>';
                                                } elseif($status == "2") {
                                                    echo '<span class="badge badge-danger">Canceled</span>';
                                                } elseif($status == "3") {
                                                    echo '<span class="badge badge-warning">Pending</span>';
                                                } elseif($status == "6") {
                                                    echo '<span class="badge badge-danger">Incomplete</span>';
                                                } else { }
                                                ?>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td>Sent via:</td>
                                        <td>
                                                <?php
                                                echo gatewayinfo($row['sent_via'],"name");
                                                ?>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td>Updated:</td>
                                        <td><?php if($row['updated']>0) { echo date("d/m/Y H:i:s",$row['updated']); } else { echo 'n/a'; } ?></td>
                                    </tr>
                                    <tr>
                                        <td>Payment Description:</td>
                                        <td><?php if($row['description']) { echo $row['description']; } else { echo 'n/a'; }  ?></td>
                                    </tr>
                                    <?php if($row['item_id']) { ?>
                                        <tr>
                                        <td>Item Number:</td>
                                        <td><?php if($row['item_id']) { echo $row['item_id']; } else { echo 'n/a'; }  ?></td>
                                    </tr>
                                    <tr>
                                        <td>Item Name:</td>
                                        <td><?php if($row['item_name']) { echo $row['item_name']; } else { echo 'n/a'; }  ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php if($row['status'] == "3") { ?>
                            <form action="" method="POST">
                                <button type="submit" class="btn btn-success" name="btn_action" value="process_sending">Approve Sending</button> 
                                <button type="submit" class="btn btn-danger" name="btn_action" value="cancel_sending">Cancel Sending</button>
                            </form>
                            <?php } ?>
		                </div>
	                </div>
	        </div>
	<?php
} else {
?>
<br>
		<br>
		<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Transactions</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">

        <!--<div class="col-md-12">
				<div class="card">
                    <div class="card-body">
                        <form action="" method="POST">
                        <div class="row">
                        <div class="col-md-5" style="padding:10px;">
                                <input type="text" class="form-control" name="txid" placeholder="Transaction ID" value="<?php if(isset($_POST['txid'])) { echo $_POST['txid']; } ?>">
                            </div>
                            <div class="col-md-5" style="padding:10px;">
                                <input type="text" class="form-control" name="email" placeholder="Email address" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>">
                            </div>
                            <div class="col-md-2" style="padding:10px;">
                                <button type="submit" class="btn btn-primary btn-block" name="btn_search" value="deposits">Search</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>-->

           <div class="col-md-12">
					<div class="card">
                        <div class="card-body table-responsive">
                            
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="25%">Sender</th>
                                    <th>Recipient</th>
                                    <th width="15%">Amount</th>
                                    <th width="15%">Transaction ID</th>
                                    <th width="18%">Status</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                /*$searching=0;
                                $FormBTN = protect($_POST['btn_search']);
                                if($FormBTN == "deposits") {
                                    $searching=1;
                                    $search_query = array();
                                    $s_email = protect($_POST['email']);
                                    if(!empty($s_email)) {
                                        if(PW_GetUserID($s_email)) {
                                            $s_uid = PW_GetUserID($s_email);
                                            $search_query[] = "sender='$s_uid' or recipient='$s_uid'";
                                        }
                                    }
                                    $s_txid = protect($_POST['txid']);
                                    if(!empty($s_txid)) { $search_query[] = "txid='$s_txid'"; }
                                    $search_query[] = "type='1'";
                                    $p_query = implode(" and ",$search_query);
                                }
                                $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                                $limit = 20;
                                $startpoint = ($page * $limit) - $limit;
                                if($page == 1) {
                                    $i = 1;
                                } else {
                                    $i = $page * $limit;
                                }
                                
                                if($searching==1) {
                                    if(empty($p_query)) {
                                        $qry = 'empty query';
                                    }
                                    $statement = "pw_transactions WHERE $p_query";
                                    $query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC");
                                } else {
                                    $statement = "pw_transactions WHERE type='1'";
                                    $query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
                                }*/
                                $query = $db->query("SELECT * FROM pw_transactions WHERE type='1' ORDER BY id DESC");
                                if($query->num_rows>0) {
                                    while($row = $query->fetch_assoc()) {
                                        ?>
                                        <tr>
                                        <td><a href="./?a=users&b=edit&id=<?php echo $row['sender']; ?>"><?php echo idinfo($row['sender'],"email"); ?></a></td>
                                        <td><a href="./?a=users&b=edit&id=<?php echo $row['recipient']; ?>"><?php echo idinfo($row['recipient'],"email"); ?></a></td>
                                            <td><?php echo $row['amount']; ?> <?php echo $row['currency']; ?></td>
                                            <td><?php echo $row['txid']; ?></td>
                                            <td>
                                                <?php
                                                $status = $row['status'];
                                                if($status == "1") {
                                                    echo '<span class="badge badge-success">Completed</span>';
                                                } elseif($status == "2") {
                                                    echo '<span class="badge badge-danger">Canceled</span>';
                                                } elseif($status == "3") {
                                                    echo '<span class="badge badge-warning">Pending</span>';
                                                } elseif($status == "6") {
                                                    echo '<span class="badge badge-danger">Incomplete</span>';
                                                } else { }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="./?a=transactions&b=view&id=<?php echo $row['id']; ?>" title="View"><span class="badge badge-primary"><i class="fa fa-search"></i> View</span></a> 
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    if($searching == "1") {
                                        echo '<tr><td colspan="6">No found results.</td></tr>';
                                    } else {
                                        echo '<tr><td colspan="6">No have transactions yet.</td></tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        
                        <?php
                        if($searching == "0") {
                            $ver = "./?a=transactions";
                            if(admin_pagination($statement,$ver,$limit,$page)) {
                                echo admin_pagination($statement,$ver,$limit,$page);
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
<?php
}
?>