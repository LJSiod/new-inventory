<?php
include '../db.php';

$type = $_POST['type'];
$unitid = $_POST['unitid'];
$assignedto = $_POST['assignedto'];
$unitname = $_POST['unitname'];
$department = $_POST['department'];
$position = $_POST['position'];
$branch = $_POST['branch'];

if ($type === 'add') {
    $query = "INSERT INTO unitinfo (unitname, department, position, assignedto, branch) 
                            VALUES ('$unitname', '$department', '$position', '$assignedto', '$branch')";
} else {
    $query = "UPDATE unitinfo 
    SET unitname = '$unitname', 
    department = '$department', 
    position = '$position', 
    assignedto = '$assignedto', 
    branch = '$branch' 
    WHERE id = '$unitid'";
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