<?php
error_reporting(0);
require '../db.php';

$totalquery = "SELECT COUNT(*) as total FROM equipment";
$deployedquery = "SELECT COUNT(*) as deployed FROM equipment WHERE status = 'Deployed'";
$inrepairquery = "SELECT COUNT(*) as in_repair FROM equipment WHERE status = 'In Repair'";
$damagedquery = "SELECT COUNT(*) as damaged FROM equipment WHERE status = 'Damaged'";
$instockquery = "SELECT COUNT(*) as in_stock FROM equipment WHERE status = 'In Stock'";

$totalresult = mysqli_fetch_assoc(mysqli_query($conn, $totalquery));
$deployedresult = mysqli_fetch_assoc(mysqli_query($conn, $deployedquery));
$inrepairresult = mysqli_fetch_assoc(mysqli_query($conn, $inrepairquery));
$damagedresult = mysqli_fetch_assoc(mysqli_query($conn, $damagedquery));
$instockresult = mysqli_fetch_assoc(mysqli_query($conn, $instockquery));

$data = [
    'total' => $totalresult['total'],
    'deployed' => $deployedresult['deployed'],
    'inrepair' => $inrepairresult['in_repair'],
    'damaged' => $damagedresult['damaged'],
    'instock' => $instockresult['in_stock'],
];

header('Content-Type: application/json');
echo json_encode($data);
?>