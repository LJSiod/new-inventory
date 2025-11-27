<?php
include '../db.php';

$type = $_POST['type'];
$unitid = $_POST['unitid'];
$equipmentid = $_POST['equipmentid'];
$branchid = $_POST['branchid'];
$itemtype = $_POST['itemtype'];
$make = htmlspecialchars($_POST['make']);
$model = htmlspecialchars($_POST['model']);
$serialnumber = htmlspecialchars($_POST['serialnumber']);
$datepurchased = empty($_POST['datepurchased']) ? NULL : $_POST['datepurchased'];
$dateacquired = empty($_POST['dateacquired']) ? NULL : $_POST['dateacquired'];

if ($type === 'stock') {
    $query = "INSERT INTO equipment (item_type, make, model, serial_number, date_purchased, status) 
                    VALUES ('$itemtype', '$make', '$model', '$serialnumber', " . ($datepurchased ? "'$datepurchased'" : "NULL") . ",  'In Stock')";
} else if ($type === 'deploy') {
    $query = "INSERT INTO equipment (unitid, item_type, make, model, serial_number, date_purchased, status, branchid) 
                    VALUES ($unitid, '$itemtype', '$make', '$model', '$serialnumber', " . ($datepurchased ? "'$datepurchased'" : "NULL") . ",  'Deployed', $branchid)";
} else if ($type === 'assign') {
    $query = "UPDATE equipment
    SET unitid = $unitid, branchid = $branchid, status = 'Deployed'
    WHERE id = $equipmentid";
} else {
    $query = "UPDATE equipment
    SET make = '$make', 
    model = '$model', 
    serial_number = '$serialnumber',
    date_purchased = " . ($datepurchased ? "'$datepurchased'" : "NULL") . ", 
    date_acquired = " . ($dateacquired ? "'$dateacquired'" : "NULL") . "
    WHERE id = $equipmentid";
}

try {
    if (mysqli_query($conn, $query)) {
        echo json_encode(array('success' => true, 'status' => 'Operation successful!'));
    } else {
        throw new Exception('Something went wrong!');
    }
} catch (Exception $e) {
    echo json_encode(array('success' => false, 'status' => $e->getMessage()));
}

mysqli_close($conn);
?>