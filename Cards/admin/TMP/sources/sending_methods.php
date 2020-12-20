<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}

$b = protect($_GET['b']);

if($b == "add") {
    ?>
    <br>
		<br>
		<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Deposit Methods</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
							<li>Add</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">
           <div class="col-md-12">
					<div class="card">
                        <div class="card-body">
                        <script type="text/javascript">
						function load_account_fiels(value) {
							var data_url = "requests/DepositGatewayFields.php?gateway="+value;
							$.ajax({
								type: "GET",
								url: data_url,
								dataType: "html",
								success: function (data) {
									$("#account_fields").html(data);
								}
							});
						}
						</script>
                            <?php
                            $FormBTN = protect($_POST['btn_add']);
                            if($FormBTN == "deposit_gateway") {
                                $name = protect($_POST['name']);
                                $status = protect($_POST['status']);
                                $a_field_1 = protect($_POST['a_field_1']);
                                $a_field_2 = protect($_POST['a_field_2']);
                                $a_field_3 = protect($_POST['a_field_3']);
                                $check = $db->query("SELECT * FROM pw_gateways WHERE name='$name' and type='1'");
                                if(empty($name)) {
                                    echo error("Please select gateway.");
                                } elseif($check->num_rows>0) { 
                                    echo error("Gateway <b>$name</b> is already exists.");
                                } elseif($name !== "Bank Transfer" && empty($a_field_1)) {
                                    echo error("Please enter a $name account.");
                                } else {
                                    $insert = $db->query("INSERT pw_gateways (name,type,a_field_1,a_field_2,a_field_3,status) VALUES ('$name','1','$a_field_1','$a_field_2','$a_field_3','$status')");
                                    $query = $db->query("SELECT * FROM pw_gateways ORDER BY id DESC LIMIT 1");
                                    $row = $query->fetch_assoc();
                                    if($name == "Bank Transfer") {
                                        $a_field_1 = protect($_POST['a_field_1']);
                                        $a_field_2 = protect($_POST['a_field_2']);
                                        $a_field_3 = protect($_POST['a_field_3']);
                                        $a_field_4 = protect($_POST['a_field_4']);
                                        $a_field_5 = protect($_POST['a_field_5']);
                                        $a_field_6 = protect($_POST['a_field_6']);
                                        $a_field_7 = protect($_POST['a_field_7']);
                                        $a_field_8 = protect($_POST['a_field_8']);
                                        $a_field_9 = protect($_POST['a_field_9']);
                                        $a_field_10 = protect($_POST['a_field_10']);
                                        $field_1 = protect($_POST['field_1']);
                                        $field_2 = protect($_POST['field_2']);
                                        $field_3 = protect($_POST['field_3']);
                                        $field_4 = protect($_POST['field_4']);
                                        $field_5 = protect($_POST['field_5']);
                                        $field_6 = protect($_POST['field_6']);
                                        $field_7 = protect($_POST['field_7']);
                                        $field_8 = protect($_POST['field_8']);
                                        $field_9 = protect($_POST['field_9']);
                                        $field_10 = protect($_POST['field_10']);
                                        if(!empty($field_1)) { $insert = $db->query("INSERT pw_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_1','1')"); }
                                        if(!empty($field_2)) { $insert = $db->query("INSERT pw_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_2','2')"); }
                                        if(!empty($field_3)) { $insert = $db->query("INSERT pw_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_3','3')"); }
                                        if(!empty($field_4)) { $insert = $db->query("INSERT pw_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_4','4')"); }
                                        if(!empty($field_5)) { $insert = $db->query("INSERT pw_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_5','5')"); }
                                        if(!empty($field_6)) { $insert = $db->query("INSERT pw_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_6','6')"); }
                                        if(!empty($field_7)) { $insert = $db->query("INSERT pw_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_7','7')"); }
                                        if(!empty($field_8)) { $insert = $db->query("INSERT pw_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_8','8')"); }
                                        if(!empty($field_9)) { $insert = $db->query("INSERT pw_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_9','9')"); }
                                        if(!empty($field_10)) { $insert = $db->query("INSERT pw_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_10','10')"); }
                                    }
                                    echo success("Gateway <b>$name</b> was added successfully.");
                                }
                            }
                            ?>

                            <form action="" method="POST">
                                <div class="form-group">
                                    <label>Gateway</label>
                                    <select class="form-control" name="name" onchange="load_account_fiels(this.value);">
                                        <option value=""></option>
                                        <option value="PayPal">PayPal</option>
                                        <option value="Paytm">Paytm</option>
                                        <option value="Stripe">Stripe (Visa/MasterCard)</option>
                                        <option value="Payeer">Payeer</option>
                                        <option value="AdvCash">AdvCash</option>
                                        <option value="Perfect Money">Perfect Money</option>
                                        <option value="Skrill">Skrill</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Active</label>
                                    <select class="form-control" name="status">
                                        <option value="1" <?php if($row['status'] == "1") { echo 'selected'; } ?>>Yes</option>
                                        <option value="0" <?php if($row['status'] == "0") { echo 'selected'; } ?>>No</option>
                                    </select>
                                </div>
                                <span id="account_fields"></span>
                                <button type="submit" class="btn btn-primary" name="btn_add" value="deposit_gateway"><i class="fa fa-plus"></i> Add</button>
                            </form>
		                </div>
                    </div>
            </div>
    
    <?php
} elseif($b == "edit") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM pw_gateways WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=sending_methods"); }
	$row = $query->fetch_assoc();
	?>
	<br>
		<br>
		<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Sending Methods</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
							<li>Edit</li>
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
                            $FormBTN = protect($_POST['btn_save']);
                            if($FormBTN == "info") {
                                if($row['name'] == "Bank Transfer") {
                                    foreach($_POST['fields'] as $k=>$v) {
                                        $field = protect($K);
                                        $field_v = protect($v);
                                        $field_e = protect($_POST['values'][$k]);
                                        $update = $db->query("UPDATE pw_gateways_fields SET field_name='$field_v',field_value='$field_e' WHERE id='$k'");
                                    }
                                } else {
                                    $a_field_1 = protect($_POST['a_field_1']);
                                    $a_field_2 = protect($_POST['a_field_2']);
                                    $a_field_3 = protect($_POST['a_field_3']);
                                    $a_field_4 = protect($_POST['a_field_4']);
                                    $a_field_5 = protect($_POST['a_field_5']);
                                   
                                    $update = $db->query("UPDATE pw_gateways SET a_field_1='$a_field_1',a_field_2='$a_field_2',a_field_3='$a_field_3',a_field_4='$a_field_4',a_field_5='$a_field_5' WHERE id='$row[id]'");
                                    $query = $db->query("SELECT * FROM pw_gateways WHERE id='$row[id]'");
                                    $row = $query->fetch_assoc();
                                }
                                $status = protect($_POST['status']);
                                $update = $db->query("UPDATE pw_gateways SET status='$status' WHERE id='$row[id]'");
                                $query = $db->query("SELECT * FROM pw_gateways WHERE id='$row[id]'");
                                $row = $query->fetch_assoc();
                                echo success("Your changes was saved successfully.");
                            }
                            ?>

                            <form action="" method="POST">
                            <div class="form-group">
                                    <label>Gateway</label>
                                    <input type="text" class="form-control" name="name" disabled value="<?php echo $row['name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Active</label>
                                    <select class="form-control" name="status">
                                        <option value="1" <?php if($row['status'] == "1") { echo 'selected'; } ?>>Yes</option>
                                        <option value="0" <?php if($row['status'] == "0") { echo 'selected'; } ?>>No</option>
                                    </select>
                                </div>
                                <?php
                                if($row['name'] == "Bank Transfer") {
                                    ?>
                                    <div class="row">
                                    <?php
                                    $fieldsquery = $db->query("SELECT * FROM pw_gateways_fields WHERE gateway_id='$row[id]' ORDER BY id");
                                    if($fieldsquery->num_rows>0) {
                                        $i=1;
                                        while($field = $fieldsquery->fetch_assoc()) {
                                            ?>
                                            <div class="col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Name of the Field <?php echo $i; ?></label>
                                                    <input type="text" class="form-control" name="fields[<?php echo $field['id']; ?>]" value="<?php echo $field['field_name']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Value of the Field <?php echo $i; ?></label>
                                                    <input type="text" class="form-control" name="values[<?php echo $field['id']; ?>]" value="<?php echo $field['field_value']; ?>">
                                                </div>
                                            </div>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                    </div>
                                    <?php     
                                } elseif($row['name'] == "PayPal") {
                                    ?>
                                    <div class="form-group">
                                        <label>Your PayPal account</label>
                                        <input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
                                    </div>
                                    <?php
                                } elseif($row['name'] == "Payeer") {
                                    ?>
                                    <div class="form-group">
                                        <label>Your Payeer account</label>
                                        <input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Your Payeer secret key</label>
                                        <input type="text" class="form-control" name="a_field_2" value="<?php echo $row['a_field_2']; ?>">
                                    </div>
                                    <?php    
                                } elseif($row['name'] == "Perfect Money") {
                                    ?>
                                    <div class="form-group">
                                        <label>Your Perfect Money account</label>
                                        <input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Account ID or API NAME</label>
                                        <input type="text" class="form-control" name="a_field_3" value="<?php echo $row['a_field_3']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Passpharse</label>
                                        <input type="text" class="form-control" name="a_field_2" value="<?php echo $row['a_field_2']; ?>">
                                        <small>Alternate Passphrase you entered in your Perfect Money account.</small>
                                    </div>
                                    <?php    
                                } elseif($row['name'] == "Stripe") {
                                    ?>
                                    <div class="form-group">
                                        <label>Your Stripe Public Key</label>
                                        <input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Your Stripe Secret Key</label>
                                        <input type="text" class="form-control" name="a_field_2" value="<?php echo $row['a_field_2']; ?>">
                                    </div>    
                                    <?php  
                                } elseif($row['name'] == "Paytm") {
                                    ?>
                                    <div class="form-group">
                                        <label>Your Paytm Merchant key</label>
                                        <input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Your Paytm Merchant ID</label>
                                        <input type="text" class="form-control" name="a_field_2" value="<?php echo $row['a_field_2']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Your Paytm Website name</label>
                                        <input type="text" class="form-control" name="a_field_3" value="<?php echo $row['a_field_3']; ?>">
                                    </div>
                                    <?php
                                } elseif($row['name'] == "Skrill") {
                                    ?>
                                    <div class="form-group">
                                        <label>Your Skrill account</label>
                                        <input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Your Skrill secret key</label>
                                        <input type="text" class="form-control" name="a_field_2" value="<?php echo $row['a_field_2']; ?>">
                                    </div>
                                    <?php   
                                } elseif($row['name'] == "AdvCash") {
                                    ?>
                                    <div class="form-group">
                                        <label>Your AdvCash account</label>
                                        <input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
                                    </div>
                                    <?php
                                } else { }
                                ?>
                                <button type="submit" class="btn btn-primary" name="btn_save" value="info"><i class="fa fa-check"></i> Save changes</button>
                            </form>
		                </div>
                    </div>
            </div>
    
	<?php
} elseif($b == "documents") {
    $id = protect($_GET['uid']);
    $query = $db->query("SELECT * FROM pw_users WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=users"); }
	$row = $query->fetch_assoc();
    $c = protect($_GET['c']);
    $did = protect($_GET['did']);
    if($c == "accept") {
        $check = $db->query("SELECT * FROM pw_users_documents WHERE uid='$id' and id='$did'");
        if($check->num_rows>0) {
            $update = $db->query("UPDATE pw_users_documents SET status='3' WHERE id='$did'");
            $redirect = './?a=users&b=edit&id='.$id.'#documents'; 
            header("Location: $redirect");
        } else {
            $redirect = './?a=users&b=edit&id='.$id.'#documents'; 
            header("Location: $redirect");
        }
    } elseif($c == "reject") {
        $check = $db->query("SELECT * FROM pw_users_documents WHERE uid='$id' and id='$did'");
        if($check->num_rows==0) {
            $redirect = './?a=users&b=edit&id='.$id.'#documents'; 
            header("Location: $redirect");
        }
        $doc = $check->fetch_assoc();
        ?>
        <br>
		<br>
		<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Users</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
							<li>Reject <b><?php echo $row['email']; ?></b> document</li>
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
                        $FormBTN = protect($_POST['btn_reject']);
                        if($FormBTN == "document") {
                            $comment = protect($_POST['comment']);
                            if(empty($comment)) {
                                echo error("Please provide a reason for rejection.");
                            } else {
                                $update = $db->query("UPDATE pw_users_documents SET status='2',u_field_5='$comment' WHERE id='$doc[id]'");
                                $redirect = './?a=users&b=edit&id='.$id.'#documents'; 
                                header("Location: $redirect");
                            }
                        }
                        ?>

                        <form action="" method="POST">
                            <div class="form-group">
                                <label>Reason for rejection</label>
                                <textarea class="form-control" name="comment" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" name="btn_reject" value="document">Reject</button>
                        </form>
                        </div>
                    </div>
            </div>
        <?php
    } else {
        header("Location: ./?a=users&b=edit&id=$id");
    }
} elseif($b == "delete") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM pw_gateways WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=deposit_methods"); }
	$row = $query->fetch_assoc();
	?>
	<br>
		<br>
		<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Deposit Methods</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
							<li>Delete</li>
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
			if(isset($_GET['confirm'])) {
				$delete = $db->query("DELETE FROM pw_gateways WHERE id='$row[id]'");
				echo success("Gateway <b>$row[name]</b> was deleted.");
			} else {
				echo info("Are you sure you want to delete gateway <b>$row[name]</b>?");
				echo '<a href="./?a=deposit_methods&b=delete&id='.$row[id].'&confirm=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a>&nbsp;&nbsp;
					<a href="./?a=deposit_methods" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
			}
			?>
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
                        <h1>Sending Methods</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
							<li><a href="./?a=deposit_methods&b=add"><i class="fa fa-plus"></i> Add</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">

           <div class="col-md-12">
					<div class="card">
                        <div class="card-body table-responsive">
                            
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="70%">Gateway</th>
                                    <th width="15%">Active</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                                $limit = 20;
                                $startpoint = ($page * $limit) - $limit;
                                if($page == 1) {
                                    $i = 1;
                                } else {
                                    $i = $page * $limit;
                                }
                                $statement = "pw_gateways WHERE type='1' and allow_send='1'";
                                $query = $db->query("SELECT * FROM {$statement} ORDER BY id LIMIT {$startpoint} , {$limit}");
                                if($query->num_rows>0) {
                                    while($row = $query->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php
                                                if($row['status'] == "1") {
                                                    echo '<span class="badge badge-success">Yes</span>';
                                                } else {
                                                    echo '<span class="badge badge-danger">No</span>';
                                                }
                                            ?></td>
                                            <td>
                                                <a href="./?a=sending_methods&b=edit&id=<?php echo $row['id']; ?>" title="Edit"><span class="badge badge-primary"><i class="fa fa-pencil"></i> Edit</span></a> 
                                                <a href="./?a=sending_methods&b=delete&id=<?php echo $row['id']; ?>" title="Delete"><span class="badge badge-danger"><i class="fa fa-trash"></i> Delete</span></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="3">No have gateways yet.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                            $ver = "./?a=sending_methods";
                            if(admin_pagination($statement,$ver,$limit,$page)) {
                                echo admin_pagination($statement,$ver,$limit,$page);
                            }
                        ?>
                    </div>
                </div>
            </div>
<?php
}
?>