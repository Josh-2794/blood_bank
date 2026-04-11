-- ============================================================
--  LifeFlow Blood Bank & Donation Management System
--  MySQL Database Schema
--  Run this file first in phpMyAdmin or MySQL CLI:
--     mysql -u root -p < blood_bank.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS blood_bank_db;
USE blood_bank_db;

-- ============================================================
-- TABLE: admins
-- ============================================================
CREATE TABLE IF NOT EXISTS admins (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,   -- store hashed passwords
    email       VARCHAR(100) NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default admin (password: admin123 — change in production!)
INSERT INTO admins (username, password, email) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@lifeflow.org');

-- ============================================================
-- TABLE: donors
-- ============================================================
CREATE TABLE IF NOT EXISTS donors (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    first_name      VARCHAR(50)  NOT NULL,
    last_name       VARCHAR(50)  NOT NULL,
    email           VARCHAR(100) NOT NULL UNIQUE,
    phone           VARCHAR(20)  NOT NULL,
    date_of_birth   DATE         NOT NULL,
    gender          ENUM('Male','Female','Other') NOT NULL,
    blood_group     ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
    city            VARCHAR(100) NOT NULL,
    weight_kg       DECIMAL(5,2),
    last_donation   DATE,
    availability    ENUM('Available Now','Available this Week','Not Available') DEFAULT 'Available Now',
    medical_notes   TEXT,
    is_active       TINYINT(1) DEFAULT 1,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Sample donor data
INSERT INTO donors (first_name, last_name, email, phone, date_of_birth, gender, blood_group, city, weight_kg, availability) VALUES
('Md. Alamin',   'Hossain',  'alamin@email.com',   '01712-345678', '1990-05-15', 'Male',   'A+',  'Dhaka',      72.0, 'Available Now'),
('Sharmin',      'Akter',    'sharmin@email.com',  '01812-456789', '1995-08-22', 'Female', 'B+',  'Chittagong', 55.0, 'Available Now'),
('Rafiqul',      'Islam',    'rafiqul@email.com',  '01612-567890', '1988-03-10', 'Male',   'O+',  'Sylhet',     80.0, 'Available this Week'),
('Nasima',       'Khatun',   'nasima@email.com',   '01512-678901', '1992-11-30', 'Female', 'AB+', 'Dhaka',      58.0, 'Not Available'),
('Jahangir',     'Alam',     'jahangir@email.com', '01912-789012', '1985-07-04', 'Male',   'O-',  'Rajshahi',   75.0, 'Available Now'),
('Ritu',         'Begum',    'ritu@email.com',     '01312-111222', '1997-01-18', 'Female', 'A-',  'Dhaka',      52.0, 'Available Now'),
('Sakib',        'Hassan',   'sakib@email.com',    '01412-222333', '1993-06-25', 'Male',   'B-',  'Khulna',     68.0, 'Available this Week'),
('Tania',        'Akter',    'tania@email.com',    '01612-333444', '1996-09-12', 'Female', 'AB-', 'Dhaka',      54.0, 'Available Now');

-- ============================================================
-- TABLE: blood_requests
-- ============================================================
CREATE TABLE IF NOT EXISTS blood_requests (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    patient_name    VARCHAR(100) NOT NULL,
    contact_number  VARCHAR(20)  NOT NULL,
    blood_group     ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
    units_required  INT          NOT NULL DEFAULT 1,
    hospital        VARCHAR(150) NOT NULL,
    required_by     DATE         NOT NULL,
    additional_notes TEXT,
    status          ENUM('Pending','Approved','Fulfilled','Rejected') DEFAULT 'Pending',
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Sample requests
INSERT INTO blood_requests (patient_name, contact_number, blood_group, units_required, hospital, required_by, status) VALUES
('Fatima Begum',  '01711-001001', 'O+',  2, 'DMCH, Dhaka',       '2026-04-05', 'Pending'),
('Karim Hossain', '01811-002002', 'AB-', 1, 'Apollo, Dhaka',     '2026-04-06', 'Approved'),
('Rina Akter',    '01611-003003', 'B+',  3, 'Square, Dhaka',     '2026-04-07', 'Approved'),
('Sabbir Ahmed',  '01511-004004', 'A+',  1, 'IBN Sina, Dhaka',   '2026-04-04', 'Rejected'),
('Nusrat Jahan',  '01911-005005', 'O-',  2, 'BSMMU, Dhaka',      '2026-04-08', 'Pending');

-- ============================================================
-- TABLE: blood_inventory
-- ============================================================
CREATE TABLE IF NOT EXISTS blood_inventory (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    blood_group ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL UNIQUE,
    units       INT     NOT NULL DEFAULT 0,
    max_units   INT     NOT NULL DEFAULT 100,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Initial inventory stock
INSERT INTO blood_inventory (blood_group, units, max_units) VALUES
('A+',  45, 80),
('A-',  12, 50),
('B+',  38, 70),
('B-',   8, 40),
('AB+', 22, 40),
('AB-',  4, 30),
('O+',   6, 90),
('O-',   9, 50);

-- ============================================================
-- TABLE: donations  (log of all donations)
-- ============================================================
CREATE TABLE IF NOT EXISTS donations (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    donor_id    INT NOT NULL,
    blood_group ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL,
    units       INT NOT NULL DEFAULT 1,
    donated_on  DATE NOT NULL,
    notes       TEXT,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (donor_id) REFERENCES donors(id) ON DELETE CASCADE
);

-- Sample donation log
INSERT INTO donations (donor_id, blood_group, units, donated_on) VALUES
(1, 'A+',  1, '2026-04-03'),
(2, 'B+',  1, '2026-04-02'),
(5, 'O-',  1, '2026-04-01'),
(6, 'A-',  1, '2026-03-30'),
(8, 'AB-', 1, '2026-03-28');

-- ============================================================
-- VIEWS  (useful for reports)
-- ============================================================

-- View: donors with low inventory blood groups
CREATE OR REPLACE VIEW v_critical_blood AS
SELECT blood_group, units, max_units,
       ROUND(units/max_units * 100, 1) AS stock_pct,
       CASE
           WHEN units <= 10 THEN 'Critical'
           WHEN units <= 20 THEN 'Low'
           ELSE 'OK'
       END AS status
FROM blood_inventory
ORDER BY units ASC;

-- View: pending requests
CREATE OR REPLACE VIEW v_pending_requests AS
SELECT id, patient_name, blood_group, units_required, hospital, required_by,
       DATEDIFF(required_by, CURDATE()) AS days_left
FROM blood_requests
WHERE status = 'Pending'
ORDER BY required_by ASC;

-- ============================================================
-- STORED PROCEDURE: Add donation & update inventory
-- ============================================================
DELIMITER //
CREATE PROCEDURE add_donation(
    IN p_donor_id    INT,
    IN p_blood_group VARCHAR(3),
    IN p_units       INT,
    IN p_date        DATE
)
BEGIN
    INSERT INTO donations (donor_id, blood_group, units, donated_on)
    VALUES (p_donor_id, p_blood_group, p_units, p_date);

    UPDATE blood_inventory
    SET units = units + p_units
    WHERE blood_group = p_blood_group;

    UPDATE donors
    SET last_donation = p_date
    WHERE id = p_donor_id;
END//
DELIMITER ;

-- ============================================================
-- STORED PROCEDURE: Fulfill request & deduct inventory
-- ============================================================
DELIMITER //
CREATE PROCEDURE fulfill_request(IN p_request_id INT)
BEGIN
    DECLARE v_bg    VARCHAR(3);
    DECLARE v_units INT;

    SELECT blood_group, units_required INTO v_bg, v_units
    FROM blood_requests WHERE id = p_request_id;

    UPDATE blood_inventory
    SET units = GREATEST(0, units - v_units)
    WHERE blood_group = v_bg;

    UPDATE blood_requests
    SET status = 'Fulfilled'
    WHERE id = p_request_id;
END//
DELIMITER ;
