<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeFlow — Blood Bank & Donation Management System</title>

    <!-- ── Stylesheets ─────────────────────────────────────── -->
    <link rel="stylesheet" href="css/variables.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/tables.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/animations.css">
</head>
<body>

<!-- ══════════════════════════════════════════════════════════
     NAVBAR
══════════════════════════════════════════════════════════ -->
<nav class="navbar">
    <a class="nav-logo" href="#" onclick="showPage('home');return false">
        <div class="nav-logo-icon">
            <svg viewBox="0 0 24 24"><path d="M12 2C8.5 2 4 7.5 4 13a8 8 0 0016 0c0-5.5-4.5-11-8-11z"/></svg>
        </div>
        <span class="nav-logo-text">LifeFlow Blood Bank</span>
    </a>
    <div class="nav-links">
        <button class="nav-link active" data-page="home"      onclick="showPage('home')">Home</button>
        <button class="nav-link"        data-page="donate"    onclick="showPage('donate')">Donate</button>
        <button class="nav-link"        data-page="request"   onclick="showPage('request')">Find Blood</button>
        <button class="nav-link"        data-page="inventory" onclick="showPage('inventory')">Inventory</button>
        <button class="nav-link"        data-page="about"     onclick="showPage('about')">About</button>
        <button class="nav-admin-btn"   data-page="admin"     onclick="showPage('admin')">Admin Panel</button>
    </div>
</nav>

<!-- ══════════════════════════════════════════════════════════
     PAGES  (each page lives in its own file under pages/)
══════════════════════════════════════════════════════════ -->
<?php include 'pages/home.php';      ?>
<?php include 'pages/donate.php';    ?>
<?php include 'pages/request.php';   ?>
<?php include 'pages/inventory.php'; ?>
<?php include 'pages/admin.php';     ?>
<?php include 'pages/about.php';     ?>

<!-- ══════════════════════════════════════════════════════════
     FOOTER
══════════════════════════════════════════════════════════ -->
<footer>
    <div class="footer-grid">
        <div>
            <div class="footer-logo">LifeFlow Blood Bank</div>
            <p>A comprehensive blood bank and donation management system connecting donors to patients in need, 24 hours a day, 7 days a week across Bangladesh.</p>
        </div>
        <div class="footer-col">
            <h4>Quick Links</h4>
            <a class="footer-link" href="#" onclick="showPage('donate');return false">Donor Registration</a>
            <a class="footer-link" href="#" onclick="showPage('request');return false">Find Blood</a>
            <a class="footer-link" href="#" onclick="showPage('inventory');return false">Blood Inventory</a>
            <a class="footer-link" href="#" onclick="showPage('admin');return false">Admin Panel</a>
            <a class="footer-link" href="#" onclick="showPage('about');return false">About Us</a>
        </div>
        <div class="footer-col">
            <h4>Contact</h4>
            <p>Dhanmondi, Dhaka-1205<br>+880 1700-25663<br>contact@lifeflow.org<br>Emergency: 16001</p>
        </div>
    </div>
    <div class="footer-bottom">
        <span>© 2026 LifeFlow Blood Bank Management System</span>
        <span>DBMS Project — Blood Bank &amp; Donation Management</span>
    </div>
</footer>

<!-- ── JavaScript (load order matters) ────────────────────── -->
<script src="js/utils.js"></script>
<script src="js/router.js"></script>
<script src="js/donors.js"></script>
<script src="js/requests.js"></script>
<script src="js/inventory.js"></script>
<script src="js/admin.js"></script>
<script src="js/main.js"></script>

</body>
</html>
