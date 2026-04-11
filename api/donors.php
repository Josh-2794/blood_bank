<?php
// api/donors.php  — Donor Registration & Listing API
require_once 'db_connect.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }

$conn   = getConnection();
$method = $_SERVER['REQUEST_METHOD'];

// ── GET: fetch / search donors ──────────────────────────────
if ($method === 'GET') {
    $where = ['d.is_active = 1'];
    $params = [];
    $types  = '';

    if (!empty($_GET['blood_group'])) {
        $where[]  = 'd.blood_group = ?';
        $params[] = $_GET['blood_group'];
        $types   .= 's';
    }
    if (!empty($_GET['city'])) {
        $where[]  = 'd.city LIKE ?';
        $params[] = '%' . $_GET['city'] . '%';
        $types   .= 's';
    }
    if (!empty($_GET['availability'])) {
        $where[]  = 'd.availability = ?';
        $params[] = $_GET['availability'];
        $types   .= 's';
    }

    $sql = 'SELECT d.id, d.first_name, d.last_name, d.blood_group,
                   d.city, d.phone, d.availability, d.last_donation
            FROM donors d
            WHERE ' . implode(' AND ', $where) . '
            ORDER BY d.created_at DESC';

    $stmt = $conn->prepare($sql);
    if ($types) $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    jsonResponse(true, 'OK', ['donors' => $rows, 'count' => count($rows)]);
}

// ── POST: register new donor ────────────────────────────────
if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) $data = $_POST;

    $required = ['first_name','last_name','email','phone','date_of_birth','gender','blood_group','city'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            jsonResponse(false, "Field '$field' is required.");
        }
    }

    // Check duplicate email
    $stmt = $conn->prepare('SELECT id FROM donors WHERE email = ?');
    $stmt->bind_param('s', $data['email']);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        jsonResponse(false, 'A donor with this email is already registered.');
    }

    $fn   = clean($conn, $data['first_name']);
    $ln   = clean($conn, $data['last_name']);
    $em   = clean($conn, $data['email']);
    $ph   = clean($conn, $data['phone']);
    $dob  = clean($conn, $data['date_of_birth']);
    $gen  = clean($conn, $data['gender']);
    $bg   = clean($conn, $data['blood_group']);
    $city = clean($conn, $data['city']);
    $wt   = !empty($data['weight_kg'])    ? (float)$data['weight_kg']    : null;
    $ld   = !empty($data['last_donation']) ? clean($conn, $data['last_donation']) : null;
    $av   = !empty($data['availability'])  ? clean($conn, $data['availability'])  : 'Available Now';
    $mn   = !empty($data['medical_notes']) ? clean($conn, $data['medical_notes']) : '';

    $stmt = $conn->prepare(
        'INSERT INTO donors
            (first_name,last_name,email,phone,date_of_birth,gender,blood_group,city,weight_kg,last_donation,availability,medical_notes)
         VALUES (?,?,?,?,?,?,?,?,?,?,?,?)'
    );
    $stmt->bind_param('ssssssssssss', $fn, $ln, $em, $ph, $dob, $gen, $bg, $city, $wt, $ld, $av, $mn);

    if ($stmt->execute()) {
        jsonResponse(true, 'Donor registered successfully!', ['donor_id' => $conn->insert_id]);
    } else {
        jsonResponse(false, 'Registration failed: ' . $conn->error);
    }
}

$conn->close();
