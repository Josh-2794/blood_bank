<?php
// api/admin_login.php  — Admin Authentication
require_once 'db_connect.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }

session_start();

$conn = getConnection();

// ── POST: login ──────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) $data = $_POST;

    if (empty($data['username']) || empty($data['password'])) {
        jsonResponse(false, 'Username and password are required.');
    }

    $username = clean($conn, $data['username']);

    $stmt = $conn->prepare('SELECT id, username, password, email FROM admins WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $admin = $stmt->get_result()->fetch_assoc();

    if ($admin && password_verify($data['password'], $admin['password'])) {
        $_SESSION['admin_id']   = $admin['id'];
        $_SESSION['admin_user'] = $admin['username'];
        jsonResponse(true, 'Login successful', [
            'admin' => ['id' => $admin['id'], 'username' => $admin['username'], 'email' => $admin['email']]
        ]);
    } else {
        jsonResponse(false, 'Invalid username or password.');
    }
}

// ── GET: check session ───────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    session_start();
    if (!empty($_SESSION['admin_id'])) {
        jsonResponse(true, 'Logged in', ['username' => $_SESSION['admin_user']]);
    } else {
        jsonResponse(false, 'Not authenticated');
    }
}

$conn->close();
