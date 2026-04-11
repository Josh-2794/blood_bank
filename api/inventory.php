<?php
// api/inventory.php  — Blood Inventory API
require_once 'db_connect.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }

$conn   = getConnection();
$method = $_SERVER['REQUEST_METHOD'];

// ── GET: fetch full inventory ────────────────────────────────
if ($method === 'GET') {
    $result = $conn->query(
        'SELECT blood_group, units, max_units,
                ROUND(units/max_units*100,1) AS stock_pct,
                CASE
                    WHEN units <= 10 THEN "Critical"
                    WHEN units <= 20 THEN "Low"
                    ELSE "OK"
                END AS status,
                updated_at
         FROM blood_inventory
         ORDER BY blood_group'
    );
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    jsonResponse(true, 'OK', ['inventory' => $rows]);
}

// ── PUT: update a blood group's units (admin) ────────────────
if ($method === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['blood_group']) || !isset($data['units'])) {
        jsonResponse(false, 'blood_group and units are required.');
    }

    $bg    = clean($conn, $data['blood_group']);
    $units = max(0, (int)$data['units']);

    $stmt = $conn->prepare('UPDATE blood_inventory SET units = ? WHERE blood_group = ?');
    $stmt->bind_param('is', $units, $bg);
    $stmt->execute();
    jsonResponse(true, 'Inventory updated.', ['blood_group' => $bg, 'units' => $units]);
}

// ── POST: log a donation & update inventory ──────────────────
if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['donor_id']) || empty($data['blood_group']) || empty($data['donated_on'])) {
        jsonResponse(false, 'donor_id, blood_group, and donated_on are required.');
    }

    $did   = (int)$data['donor_id'];
    $bg    = clean($conn, $data['blood_group']);
    $units = !empty($data['units']) ? (int)$data['units'] : 1;
    $date  = clean($conn, $data['donated_on']);

    $stmt = $conn->prepare('CALL add_donation(?,?,?,?)');
    $stmt->bind_param('isis', $did, $bg, $units, $date);
    $stmt->execute();
    jsonResponse(true, 'Donation logged and inventory updated.');
}

$conn->close();
