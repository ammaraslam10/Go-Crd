<?php
error_reporting(0);
if (isset($_POST['m_operation_id']) && isset($_POST['m_sign'])) {
	$m_operation_id = protect($_POST['m_operation_id')];
	$m_operation_date = protect($_POST['m_operation_date']);
	$m_orderid = protect($_POST['m_orderid']);
	$m_amount = protect($_POST['m_amount']);
	$m_currency = protect($_POST['m_curr']);
	$query = $db->query("SELECT * FROM pw_deposits WHERE id='$m_orderid'");
		if($query->num_rows>0) {
			$row = $query->fetch_assoc();
			$m_key = gatewayinfo($row['method'],"a_field_2");
			$arHash = array($_POST['m_operation_id'],
				$_POST['m_operation_ps'],
				$_POST['m_operation_date'],
				$_POST['m_operation_pay_date'],
				$_POST['m_shop'],
				$_POST['m_orderid'],
				$_POST['m_amount'],
				$_POST['m_curr'],
				$_POST['m_desc'],
				$_POST['m_status'],
				$m_key);
			$sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));
			if($row['status'] !== "3") { 
				if ($_POST['m_sign'] == $sign_hash && $_POST['m_status'] == 'success') {
				if($m_amount == $row['amount'] or $m_currency == $row['currency']) {
					$time = time();
					$update = $db->query("UPDATE pw_deposits SET status='1',gateway_txid='$m_operation_id',processed_on='$time' WHERE id='$row[id]'");
					$update = $db->query("UPDATE pw_activity SET status='1' WHERE type='3' and u_field_1='$row[id]'");
					PW_UpdateUserWallet($row['uid'],$row['amount'],$row['currency'],1);		
				}
				}
			}
	}
}
?>