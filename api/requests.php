<?php
// api/requests.php  — Blood Request API
require_once 'db_connect.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }

$conn   = getConnection();
$method = $_SERVER['REQUEST_METHOD'];

// ── GET: list requests ──────────────────────────────────────
if ($method === 'GET') {
    $status = !empty($_GET['status']) ? clean($conn, $_GET['status']) : null;

    $sql = 'SELECT * FROM blood_requests';
    if ($status) $sql .= " WHERE status = '$status'";
    $sql .= ' ORDER BY created_at DESC';

    $result = $conn->query($sql);
    if ($result === false) jsonResponse(false, 'Query failed: ' . $conn->error);
    $rows   = $result->fetch_all(MYSQLI_ASSOC);
    jsonResponse(true, 'OK', ['requests' => $rows, 'count' => count($rows)]);
}

// ── POST: submit new blood request ─────────────────────────
if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) $data = $_POST;

    $required = ['patient_name','contact_number','blood_group','units_required','hospital','required_by'];
    foreach ($required as $f) {
        if (empty($data[$f])) jsonResponse(false, "Field '$f' is required.");
    }

    $pn   = clean($conn, $data['patient_name']);
    $cn   = clean($conn, $data['contact_number']);
    $bg   = clean($conn, $data['blood_group']);
    $ur   = (int)$data['units_required'];
    $hosp = clean($conn, $data['hospital']);
    $rb   = clean($conn, $data['required_by']);
    $an   = !empty($data['additional_notes']) ? clean($conn, $data['additional_notes']) : '';

    $stmt = $conn->prepare(
        'INSERT INTO blood_requests
            (patient_name,contact_number,blood_group,units_required,hospital,required_by,additional_notes)
         VALUES (?,?,?,?,?,?,?)'
    );
    $stmt->bind_param('sssisss', $pn, $cn, $bg, $ur, $hosp, $rb, $an);

    if ($stmt->execute()) {
        jsonResponse(true, 'Blood request submitted successfully!', ['request_id' => $conn->insert_id]);
    } else {
        jsonResponse(false, 'Submission failed: ' . $conn->error);
    }
}

// ── PUT: update request status (admin action) ───────────────
if ($method === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['id']) || empty($data['status'])) {
        jsonResponse(false, 'Request ID and status are required.');
    }

    $id     = (int)$data['id'];
    $status = clean($conn, $data['status']);

    // If fulfilling, also deduct from inventory
    if ($status === 'Fulfilled') {
        $stmt = $conn->prepare('CALL fulfill_request(?)');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        jsonResponse(true, 'Request fulfilled and inventory updated.');
    }

    $stmt = $conn->prepare('UPDATE blood_requests SET status = ? WHERE id = ?');
    $stmt->bind_param('si', $status, $id);
    $stmt->execute();
    jsonResponse(true, 'Request status updated.', ['affected' => $stmt->affected_rows]);
}

$conn->close();
