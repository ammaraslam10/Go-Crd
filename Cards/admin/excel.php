<?php
if(isset($_POST["export"])) {
    global $db; 
    $query = $db->query("SELECT * FROM $type ORDER BY id ASC");
    $items = array();
    while($row = $query->fetch_assoc()) {
        $items[] = $row;
    }
    //Define the filename with current date
    $fileName = $template['header_link']."-".date('d-m-Y').".xls";
    
    //Set header information to export data in excel format
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename='.$fileName);
    
    //Set variable to false for heading
    $heading = false;
    
    //Add the MySQL table data to excel file
    if(!empty($items)) {
        foreach($items as $item) {
            if(!$heading) {
                echo implode("\t", array_keys($item)) . "\n";
                $heading = true;
            }
            echo implode("\t", array_values($item)) . "\n";
        }
    }
    exit();
}
 ?>  