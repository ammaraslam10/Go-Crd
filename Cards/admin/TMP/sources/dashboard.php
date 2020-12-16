<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}
?>
		<br>
		<br><div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Dashboard</h1>
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

            <div class="col-sm-12">
                <div class="alert  alert-success alert-dismissible fade show" role="alert">
                  <span class="badge badge-pill badge-success">GREAT</span> Current ProWallet version is <b><?php echo $version;?></b>. If have some problem please contact with <b>support@cryptoexchangerscript.com</b>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

			<div class="col-md-12">
				<?php
				if(isset($_POST['btn_update_reserve'])) {
					$gateway_id = protect($_POST['gateway_id']);
					$reserve = protect($_POST['reserve']);
					if(empty($gateway_id) or empty($reserve)) { echo error("Please select gateway and enter reserve."); }
					elseif(!is_numeric($reserve)) { echo error("Please enter reserve with numbers."); }
					else {
						$update = $db->query("UPDATE bit_gateways SET reserve='$reserve' WHERE id='$gateway_id'");
						echo success("Reserve was updated successfully.");
					}
				}
				
				if(isset($_POST['btn_update_rate'])) {
					$rid = protect($_POST['rid']);
					$rate_from = protect($_POST['rate_from']);
					$rate_to = protect($_POST['rate_to']);
					if(empty($rid) or empty($rate_from) or empty($rate_to)) { echo error("Please select exchange rate and enter rate from and rate to."); }
					elseif(!is_numeric($rate_from)) { echo error("Please enter rate from with numbers."); }
					elseif(!is_numeric($rate_to)) { echo error("Please enter rate to with numbers."); } 
					else {
						$update = $db->query("UPDATE bit_rates SET rate_from='$rate_from',rate_to='$rate_to' WHERE id='$rid'");
						echo success("Exchange rate was updated successfully.");
					}
				}
				?>
			</div>

           <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-1">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <i class="fa fa-users"></i>
                        </div>
                        <h4 class="mb-0">
                            <span class="count"><?php $query = $db->query("SELECT * FROM pw_users"); echo $query->num_rows; ?></span>
                        </h4>
                        <p class="text-light">Users</p>

                    </div>

                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-2">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
							<i class="fa fa-refresh"></i>
						</div>
                        <h4 class="mb-0">
                             <span class="count"><?php $query = $db->query("SELECT * FROM pw_transactions"); echo $query->num_rows; ?></span>
                        </h4>
                        <p class="text-light">Transactions</p>

                    </div>
                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-3">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <i class="fa fa-comments-o"></i>
                        </div>
                        <h4 class="mb-0">
                            <span class="count"><?php $query = $db->query("SELECT * FROM pw_deposits"); echo $query->num_rows; ?></span>
                        </h4>
                        <p class="text-light">Deposits</p>

                    </div>

                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-flat-color-4">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <i class="fa fa-dollar"></i>
                        </div>
                        <h4 class="mb-0">
                            <span class="count"><?php $get_stats = $db->query("SELECT * FROM pw_withdrawals"); echo $get_stats->num_rows; ?></span>
                        </h4>
                        <p class="text-light">Withdrawals</p>

                    </div>
                </div>
            </div>
            <!--/.col-->

            <div class="col-lg-12 col-md-12">
                <p>Here you can add some Widget to see your website visitors.</p>
            </div><!--/.col-->

            <div class="col-md-12">
				<div class="card">
                        <div class="card-header">
                            <strong class="card-title">Pending <b>Deposits</b></strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                              <thead>
                                <tr>
									<th width="25%">User</th>
                                    <th width="15%">Amount</th>
                                    <th width="15%">Deposit ID</th>
                                    <th width="15%">Gateway</th>
                                    <th width="18%">Status</th>
                                    <th width="15%">Action</th>
								</tr>
                              </thead>
                              <tbody>
								<?php
								$i=1;
								$query = $db->query("SELECT * FROM pw_deposits WHERE status='3' ORDER BY id");
								if($query->num_rows>0) {
									while($row = $query->fetch_assoc()) {
										?>
										<tr>
                                            <td><a href="./?a=users&b=edit&id=<?php echo $row['uid']; ?>"><?php echo idinfo($row['uid'],"email"); ?></a></td>
                                            <td><?php echo $row['amount']; ?> <?php echo $row['currency']; ?></td>
                                            <td><?php echo $row['txid']; ?></td>
                                            <td><?php echo gatewayinfo($row['method'],"name"); ?></td>
                                            <td>
                                                <?php
                                                $status = $row['status'];
                                                if($status == "1") {
                                                    echo '<span class="badge badge-success">Completed</span>';
                                                } elseif($status == "2") {
                                                    echo '<span class="badge badge-danger">Canceled</span>';
                                                } elseif($status == "3") {
                                                    echo '<span class="badge badge-warning">Pending</span>';
                                                } else { }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="./?a=deposits&b=view&id=<?php echo $row['id']; ?>" title="View"><span class="badge badge-primary"><i class="fa fa-search"></i> View</span></a> 
                                            </td>
                                        </tr>
										<?php
									}
								} else {
									echo '<tr><td colspan="6">You no have new deposit requests.</td></tr>';
								}
								?>
                              </tbody>
                            </table>
                        </div>
                    </div>
			</div>
			
			<div class="col-md-12">
				<div class="card">
                        <div class="card-header">
                            <strong class="card-title">Pending <b>Withdrawals</b></strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
							  <thead>
							  <tr>
                                    <th width="25%">User</th>
                                    <th width="15%">Amount</th>
                                    <th width="15%">Withdrawal ID</th>
                                    <th width="15%">Gateway</th>
                                    <th width="18%">Status</th>
                                    <th width="15%">Action</th>
                                </tr>
							  </thead>
							  <tbody>
							  <?php
							  $i=1;
							  $query = $db->query("SELECT * FROM pw_withdrawals WHERE status='1' ORDER BY id");
							  if($query->num_rows>0) {
								while($row = $query->fetch_assoc()) {
								?>
										<tr>
                                            <td><a href="./?a=users&b=edit&id=<?php echo $row['uid']; ?>"><?php echo idinfo($row['uid'],"email"); ?></a></td>
                                            <td><?php echo $row['amount']; ?> <?php echo $row['currency']; ?></td>
                                            <td><?php echo $row['txid']; ?></td>
                                            <td><?php echo gatewayinfo($row['method'],"name"); ?></td>
                                            <td>
                                                <?php
                                                $status = $row['status'];
                                                if($status == "3") {
                                                    echo '<span class="badge badge-success">Completed</span>';
                                                } elseif($status == "2") {
                                                    echo '<span class="badge badge-danger">Canceled</span>';
                                                } elseif($status == "1") {
                                                    echo '<span class="badge badge-warning">Pending</span>';
                                                } else { }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="./?a=withdrawals&b=view&id=<?php echo $row['id']; ?>" title="View"><span class="badge badge-primary"><i class="fa fa-search"></i> View</span></a> 
                                            </td>
                                        </tr>
								<?php 
								$i++;
								}
							  } else {
								echo '<tr><td colspan="6">You no have new withdrawal requests.</td></tr>';
							  }
							  ?>
							  </tbody>
							</table>
                        </div>
                    </div>
			</div>
			
			<div class="col-md-12">
				<div class="card">
                        <div class="card-header">
                            <strong class="card-title">Pending <b>Documents</b></strong>
                        </div>
                        <div class="card-body">
                           	<table class="table table-striped">
		      <thead>
		        <tr>
					<th width="15%">User</th>
					<th>Document Type</th>
                            <th>Document Number</th>
                            <th>Attached file</th>
                            <th>Action</th>
				</tr>
		      </thead>
		      <tbody>
		      <?php
			  $i=1;
			  $query = $db->query("SELECT * FROM pw_users_documents WHERE status='1' ORDER BY id");
			  if($query->num_rows>0) {
			    while($doc = $query->fetch_assoc()) {
				?>
						<tr>
						<td><a href="./?a=users&b=edit&id=<?php echo $dic['uid']; ?>"><?php echo idinfo($doc['uid'],"email"); ?></a></td>
                                            
							<td><?php if($doc['document_type'] == "1") { echo 'Personal ID'; } elseif($doc['document_type'] == "2") { echo 'National Passport'; } elseif($doc['document_type'] == "3") { echo 'Driving License'; } elseif($doc['document_type'] == "4") { echo 'Invoice'; } else { echo 'Unknown'; } ?></td>
                                <td><?php echo $doc['u_field_1']; ?></td>
                                
                                <td><a href="<?php echo $settings['url'].$doc['document_path']; ?>" target="_blank"><span class="badge badge-primary"><i class="fa fa-search"></i> Preview</span></a><br/><small>Uploaded on <?php echo date("d/m/Y H:i:s",$doc['uploaded']); ?></td>
                                <td>
                                    <?php if($doc['status'] == "1") { ?>
                                    <a href="./?a=users&b=documents&c=accept&uid=<?php echo $row['id']; ?>&did=<?php echo $doc['id']; ?>"><span class="badge badge-success"><i class="fa fa-check"></i> Accept</span></a> 
                                    <a href="./?a=users&b=documents&c=reject&uid=<?php echo $doc['uid']; ?>&did=<?php echo $doc['id']; ?>"><span class="badge badge-danger"><i class="fa fa-times"></i> Reject</span></a>
                                    <?php } ?>
                                </td>
						</tr>
				<?php 
				$i++;
				}
			  } else {
				echo '<tr><td colspan="5">You no have new documents for review.</td></tr>';
			  }
			  ?>
		      </tbody>
		    </table>
                        </div>
                    </div>
			</div>
        </div> <!-- .content -->