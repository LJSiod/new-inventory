<?php
error_reporting(0);
require '../db.php';

$employee = [];

$employeeResult = $conn->query("
SELECT CONCAT(e.firstname, ' ', e.middlename, '. ', e.lastname) AS fullname, b.name as branch, d.name as department, p.name as position
FROM payroll.employee e
JOIN payroll.department d
ON d.id = e.departmentid
JOIN payroll.position p
ON e.positionid = p.id
JOIN inventory.branch b
ON b.branchorder = e.branchid
WHERE b.id = '" . $_POST['branch'] . "'
AND e.employmentstatus <> 'RESIGNED'
AND e.positionid <> 4");
while ($employeeRow = $employeeResult->fetch_assoc()) {
    $employee[] = $employeeRow;
}

$data = [
    'employee' => $employee,
];

header('Content-Type: application/json');
echo json_encode($data);

