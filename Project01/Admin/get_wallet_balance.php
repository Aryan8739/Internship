<?php
include '../conn.php';
header('Content-Type: application/json');

if (!isset($_GET['user_id']) || !is_numeric($_GET['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid user']);
    exit;
}

$user_id = (int)$_GET['user_id'];

$stmt = $conn->prepare("SELECT balance FROM wallets WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($balance);

if ($stmt->fetch()) {
    echo json_encode(['success' => true, 'balance' => $balance]);
} else {
    echo json_encode(['success' => true, 'balance' => 0.00]); // Return 0 if wallet not found
}
