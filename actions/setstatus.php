<?php
include '../db.php';

$equipmentid = $_POST['equipmentid'];
$action = $_POST['action'];

switch ($action) {
    case 'damaged':
        $query = "UPDATE equipment SET status = 'Damaged' WHERE id = '$equipmentid'";
        break;
    case 'return':
        $query = "UPDATE equipment SET status = 'In Stock', unitid = NULL WHERE id = '$equipmentid'";
        break;
    case 'delete':
        $query = "UPDATE equipment SET status = 'Deleted' WHERE id = '$equipmentid'";
        break;
}


try {
    if (mysqli_query($conn, $query)) {
        echo json_encode(array('success' => true, 'status' => 'Status updated successfully!'));
    } else {
        throw new Exception('Something went wrong!');
    }
} catch (Exception $e) {
    echo json_encode(array('success' => false, 'status' => $e->getMessage()));
}

mysqli_close($conn);
?>