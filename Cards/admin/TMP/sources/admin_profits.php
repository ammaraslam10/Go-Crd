<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}
?><br>
		<br>
		<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Admin Profits</h1>
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
            <div class="col-md-12">
                <?php
                if(isset($_POST['btn_update'])) {
                    $wallet = protect($_POST['wallet']);
                    $amount = protect($_POST['amount']);
                    $walletinfo = $db->query("SELECT * FROM pw_admin_earnings WHERE id='$wallet'");
                    $wi = $walletinfo->fetch_assoc();
                    if(empty($wallet)) {
                        echo error("Please select a wallet.");
                    } elseif(empty($amount)) { 
                        echo error("Please enter a amount.");
                    } elseif(!is_numeric($amount)) {
                        echo error("Invalid amount.");
                    } elseif($amount > $wi['amount']) {
                        echo error("Maximum amount for withdrawal is $wi[amount] $wi[currency].");
                    } else {
                        $balance = $wi['amount'] - $amount;
                        $update = $db->query("UPDATE pw_admin_earnings SET amount='$balance' WHERE id='$wallet'");
                        echo success("Your changes was saved successfully.");
                    }
                }
                ?>
</div>
           <div class="col-md-8">
				<div class="card">
                    <div class="card-body">
                        <h4>Admin Wallets</h4>
                    <br>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="50%">Amount</th>
                                <th width="50%">Last profit on</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = $db->query("SELECT * FROM pw_admin_earnings ORDER BY id");
                            if($query->num_rows>0) {
                                while($row = $query->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['amount']; ?> <?php echo $row['currency']; ?></td>
                                        <td><?php echo date("d/m/Y H:i",$row['updated']); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="5">No have pages yet. <a href="./?a=pages&b=add">Click here</a> to add.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4>Withdrawal</h4>
                        <small>If you use money from your profits, please withdrawal it from this form.</small>
                        <hr/>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label>Wallet</label>
                                <select class="form-control" name="wallet">
                                    <?php
                                    $wallets = $db->query("SELECT * FROM pw_admin_earnings ORDER BY id");
                                    if($wallets->num_rows>0) {
                                        while($wallet = $wallets->fetch_assoc()) {
                                            echo '<option value="'.$wallet[id].'">'.$wallet[amount].' '.$wallet[currency].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>  
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="text" class="form-control" name="amount">
                                </div>
                            <button type="submit" class="btn btn-primary" name="btn_update">Update</button>
                        </form>
                    </div>
                </div>
            </div>