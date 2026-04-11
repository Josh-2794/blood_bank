<?php
// ============================================================
//  db_connect.php  — Database Connection
//  Place this file in your project root.
//  Require it in every PHP file with:
//      require_once 'db_connect.php';
// ============================================================

define('DB_HOST',     'localhost');
define('DB_USER',     'root');       // change to your MySQL username
define('DB_PASS',     '');           // change to your MySQL password
define('DB_NAME',     'blood_bank_db');
define('DB_CHARSET',  'utf8mb4');

function getConnection(): mysqli {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        http_response_code(500);
        die(json_encode([
            'success' => false,
            'message' => 'Database connection failed: ' . $conn->connect_error
        ]));
    }

    $conn->set_charset(DB_CHARSET);
    return $conn;
}

// Helper: return JSON response and exit
function jsonResponse(bool $success, string $message, array $data = []): void {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $data));
    exit;
}

// Helper: sanitize input
function clean(mysqli $conn, $value): string {
    return $conn->real_escape_string(htmlspecialchars(strip_tags(trim($value))));
}
