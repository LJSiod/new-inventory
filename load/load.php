<?php
date_default_timezone_set('Asia/Manila');
error_reporting(0);
include '../db.php';

$branch = $_POST['branch'];

$sql =
    "SELECT u.*, b.name
FROM unitinfo u
JOIN branch b ON u.branch = b.id
" . (($branch == 'All') ? '' : " WHERE u.branch = '" . $branch . "'") . "
ORDER BY u.id DESC
";
$result = $conn->query($sql);
$data = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
        $unitid = $row['id'];
        $unitdata = array(
            'unitid' => $unitid,
            'name' => $row['assignedto'],
            'department' => $row['department'],
            'position' => $row['position'],
            'unitname' => $row['unitname'],
            'branchid' => $row['branch'],
            'branch' => $row['name'],
        );

        $equipment_query = "SELECT e.*, b.name FROM equipment e JOIN branch b ON e.branchid = b.id WHERE unitid = '$unitid' AND e.status <> 'Deleted' ORDER BY e.id DESC";
        $equipment_result = $conn->query($equipment_query);
        $equipments = array();
        if (mysqli_num_rows($equipment_result) > 0) {
            while ($equipment_row = $equipment_result->fetch_assoc()) {
                $equipments[] = array(
                    'equipmentid' => $equipment_row['id'],
                    'type' => $equipment_row['item_type'] ?? '',
                    'make' => $equipment_row['make'] ?? '',
                    'model' => $equipment_row['model'] ?? '',
                    'serialnumber' => $equipment_row['serial_number'] ?? '',
                    'datepurchased' => empty($equipment_row['date_purchased']) ? '' : $equipment_row['date_purchased'],
                    'dateacquired' => empty($equipment_row['date_acquired']) ? '' : $equipment_row['date_acquired'],
                    'status' => $equipment_row['status'] ?? '',
                    'employeeid' => $employee_id,
                    'branch' => $equipment_row['name'],
                );
            }
        }

        $data[] = array_merge($unitdata, array('equipments' => $equipments));
    }

    $instock_query = "SELECT * FROM equipment WHERE status = 'In Stock'";
    $instock_result = $conn->query($instock_query);
    $instock = array();
    if (mysqli_num_rows($instock_result) > 0) {
        while ($instock_row = $instock_result->fetch_assoc()) {
            $instock[] = array(
                'equipmentid' => $instock_row['id'],
                'type' => $instock_row['item_type'] ?? '',
                'make' => $instock_row['make'] ?? '',
                'model' => $instock_row['model'] ?? '',
                'serialnumber' => $instock_row['serial_number'] ?? '',
                'datepurchased' => (empty($instock_row['date_purchased'])) ? '' : date_format(new DateTime($instock_row['date_purchased']), 'M j, Y'),
                'dateacquired' => (empty($instock_row['date_acquired'])) ? '' : date_format(new DateTime($instock_row['date_acquired']), 'M j, Y'),
                'status' => $instock_row['status'] ?? '',
            );
        }
    }

    $data[] = array('instock' => $instock);
}

echo json_encode($data);

?>