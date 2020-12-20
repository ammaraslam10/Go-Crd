<?php
// Crypto Wallet
// Author: Crypto Wallet
define('PWV1_INSTALLED',TRUE);
ob_start();
session_start();
error_reporting(0);
include("../configs/bootstrap.php");
include("../includes/bootstrap.php");
include(getLanguage($settings['url'],null,2));

if(checkSession()) {
    $id = protect($_GET['id']);
    
    $query = $db->query("SELECT * FROM pw_gateways_fields WHERE gateway_id='$id' ORDER BY id");
    if($query->num_rows>0) {
        $process_type = gatewayinfo($id,"process_type");
        $process_time = gatewayinfo($id,"process_time");
        $fee = gatewayinfo($id,"fee");
        $include_fee = gatewayinfo($id,"include_fee");
        $extra_fee = gatewayinfo($id,"extra_fee");
        if($include_fee == "1") {
            $efee = '+ '.$extra_fee.'%';
        } else {
            $efee = '';
        }
        if($process_type == "1") {
            if($process_time == "1") {
                $prcoessed_time = '1 '.$lang[minute];
            } else {
                $processed_time = $process_time.' '.$lang[minutes];
            }
        } elseif($process_type == "2") {
            if($process_time == "1") {
                $processed_time = '1 '.$lang[hour];
            } else {
                $processed_time = $process_time.' '.$lang[hours];
            }
        } elseif($process_type == "3") {
            if($process_time == "1") {
                $processed_time = '1 '.$lang[day];
            } else {
                $processed_time = $process_time.' '.$lang[days];
            }   
        } else {
            $processed_time = '';
        }
        $c_fee = $fee;
        echo '<div class="form-group">
                <label>'.$lang[will_be_debited].'</label>
                <input type="text" class="form-control form-control-lg text-center" disabled id="receive_amount">
                <input type="hidden" id="c_fee" value="'.$c_fee.'">
                <input type="hidden" id="d_fee" value="'.$c_fee.'">
                <input type="hidden" id="c_include_fee" value="'.$include_fee.'">
                <input type="hidden" id="c_extra_fee" value="'.$extra_fee.'">
            </div>';
        echo $lang[will_be_processed].' '.$processed_time.'<br/>
        '.$lang[withdrawal_fee].': <span id="wfee">'.$fee.' '.$settings[default_currency].'</span> '.$efee.'
        <br><br>';
        while($row = $query->fetch_assoc()) {
            echo '<div class="form-group">
                <input type="text" class="form-control form-control-lg text-center" name="fieldvalues['.$row[id].']" placeholder="'.$row[field_name].'" required>
            </div>';
        }
    } 
}
?>