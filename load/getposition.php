<?php
error_reporting(0);
require '../db.php';

$position = [];

$positionresult = $conn->query("SELECT p.name
FROM position p
JOIN department d
ON p.departmentid = d.id
WHERE d.name = '" . $_POST['department'] . "'
");
while ($posrow = $positionresult->fetch_assoc()) {
    $position[] = $posrow['name'];
}

$data = [
    'position' => $position,
];

header('Content-Type: application/json');
echo json_encode($data);


