<?php
error_reporting(0);
require '../db.php';

$unit = [];

$unitresult = $conn->query("SELECT unitname, id
FROM unitinfo
WHERE branch = '" . $_POST['branch'] . "'
");
while ($unitrow = $unitresult->fetch_assoc()) {
    $unit[] = $unitrow;
}

$data = [
    'unit' => $unit,
];

header('Content-Type: application/json');
echo json_encode($data);


