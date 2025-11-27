<?php
error_reporting(0);
require '../db.php';

$branch = [];

$branchResult = $conn->query("SELECT * FROM branch");
while ($branchRow = $branchResult->fetch_assoc()) {
    $branch[] = $branchRow;
}

$data = [
    'branch' => $branch,
];

header('Content-Type: application/json');
echo json_encode($data);

