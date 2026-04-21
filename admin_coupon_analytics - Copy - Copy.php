<?php
session_start();
// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}
// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'services_app';
// Create database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$total = $conn->query("SELECT COUNT(*) t FROM coupons")->fetch_assoc()['t'];
$active = $conn->query("SELECT COUNT(*) t FROM coupons WHERE status='active'")->fetch_assoc()['t'];
$expired = $conn->query("SELECT COUNT(*) t FROM coupons WHERE end_date < CURDATE()")->fetch_assoc()['t'];

$top = $conn->query(
    "SELECT code, used_count FROM coupons ORDER BY used_count DESC LIMIT 5"
);
?>

<!DOCTYPE html>
<html>
<head><title>Coupon Analytics</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root {
    --primary: #5d3b66;
    --primary-light: #7b4a88;
    --gradient: linear-gradient(135deg, #5d3b66, #7b4a88);
    --bg: #f5f7fa;
    --white: #ffffff;
    --text: #333;
    --muted: #6b7280;
    --border: #e5e7eb;
    --radius: 14px;
    --shadow: 0 15px 40px rgba(0,0,0,0.08);
}

/* BODY */
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: var(--bg);
}

/* MAIN */
.main-content {
    margin-left: 260px;
    padding: 35px;
}

/* PAGE HEADER */
.page-header {
    background: var(--gradient);
    color: var(--white);
    padding: 30px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.page-header i {
    font-size: 28px;
}

.page-header h1 {
    margin: 0;
    font-size: 26px;
}

/* STATS */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 25px;
    margin-bottom: 35px;
}

.stat-card {
    background: var(--white);
    padding: 25px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: 18px;
}

.stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.stat-icon.total {
    background: #ede9fe;
    color: var(--primary);
}

.stat-icon.active {
    background: #e6f7f0;
    color: #0f766e;
}

.stat-icon.expired {
    background: #fdecec;
    color: #b91c1c;
}

.stat-info h2 {
    margin: 0;
    font-size: 26px;
    color: var(--text);
}

.stat-info span {
    font-size: 13px;
    color: var(--muted);
}

/* CARD */
.card {
    background: var(--white);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 25px;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background: #f9fafb;
}

th {
    text-align: left;
    padding: 14px 12px;
    font-size: 13px;
    color: var(--muted);
    border-bottom: 1px solid var(--border);
}

td {
    padding: 16px 12px;
    font-size: 14px;
    border-bottom: 1px solid var(--border);
}

tbody tr:hover {
    background: #f9f5fa;
}

/* RESPONSIVE */
@media (max-width: 900px) {
    .main-content {
        margin-left: 0;
    }
}
</style>
</head>
<body>


<main class="main-content">

    <div class="page-header">
        <i class="fas fa-chart-pie"></i>
        <h1>Coupon Analytics</h1>
    </div>

    <!-- STATS -->
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="stat-info">
                <h2><?= $total ?></h2>
                <span>Total Coupons</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon active">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h2><?= $active ?></h2>
                <span>Active Coupons</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon expired">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-info">
                <h2><?= $expired ?></h2>
                <span>Expired Coupons</span>
            </div>
        </div>

    </div>

    <!-- TOP COUPONS -->
    <div class="card">
        <h3 style="margin-bottom:20px;color:var(--primary);">
            <i class="fas fa-star"></i> Top Used Coupons
        </h3>

        <table>
            <thead>
                <tr>
                    <th>Coupon Code</th>
                    <th>Used Count</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($t = $top->fetch_assoc()): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($t['code']) ?></strong></td>
                    <td><?= $t['used_count'] ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</main>

</body>
</html>
