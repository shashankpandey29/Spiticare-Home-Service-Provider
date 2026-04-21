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

if (isset($_GET['toggle'])) {
    $id = $_GET['toggle'];
    $conn->query(
        "UPDATE coupons 
         SET status = IF(status='active','inactive','active') 
         WHERE id=$id"
    );
}

if (isset($_GET['delete'])) {
    $conn->query("DELETE FROM coupons WHERE id=".(int)$_GET['delete']);
}

$result = $conn->query("SELECT * FROM coupons ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head><title>Manage Coupons</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root {
    --primary: #5d3b66;
    --primary-light: #7b4a88;
    --bg: #f5f7fa;
    --white: #ffffff;
    --text: #333;
    --muted: #6b7280;
    --border: #e5e7eb;
    --radius: 14px;
    --shadow: 0 15px 40px rgba(0,0,0,0.08);
}

/* PAGE */
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: var(--bg);
}

.main-content {
    margin-left: 260px;
    padding: 35px;
}

/* HEADER */
.page-header {
    background: linear-gradient(135deg, #5d3b66, #7b4a88);
    color: #fff;
    padding: 28px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.page-header i {
    font-size: 26px;
}

/* CARD */
.card {
    background: var(--white);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 25px;
}

/* TABLE */
.table-wrapper {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background: #f9fafb;
}

th {
    text-align: left;
    font-size: 13px;
    color: var(--muted);
    padding: 14px 12px;
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

/* BADGES */
.badge {
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.badge.active {
    background: #e6f7f0;
    color: #0f766e;
}

.badge.inactive {
    background: #fdecec;
    color: #b91c1c;
}

/* ACTION BUTTONS */
.actions {
    display: flex;
    gap: 10px;
}

.btn {
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: 0.3s;
}

.btn-toggle {
    background: #ede9fe;
    color: var(--primary);
}

.btn-toggle:hover {
    background: #ddd6fe;
}

.btn-delete {
    background: #fee2e2;
    color: #b91c1c;
}

.btn-delete:hover {
    background: #fecaca;
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
        <i class="fas fa-ticket-alt"></i>
        <h1>Manage Coupons</h1>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                   <tr>
    <th>Code</th>
    <th>Type</th>
    <th>Value</th>
    <th>Status</th>
    <th>Used</th>
    <th>Min Loyalty</th>
    <th>Actions</th>
</tr>
                </thead>

                <tbody>
                <?php while ($c = $result->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($c['code']) ?></strong></td>
                        <td><?= ucfirst($c['discount_type']) ?></td>
                        <td><?= $c['discount_value'] ?></td>

                        <td>
                            <span class="badge <?= $c['status'] ?>">
                                <?= ucfirst($c['status']) ?>
                            </span>
                        </td>

                        <td><?= $c['used_count'] ?> / <?= $c['usage_limit'] ?></td>
<td>
    <span class="badge" style="background:#ede9fe;color:#5d3b66;">
        <?= (int)$c['min_loyalty_score'] ?>
    </span>
</td>

                        <td>
                            <div class="actions">
                                <a href="?toggle=<?= $c['id'] ?>" class="btn btn-toggle">
                                    <i class="fas fa-sync"></i> Toggle
                                </a>
                                <a href="?delete=<?= $c['id'] ?>" 
                                   class="btn btn-delete"
                                   onclick="return confirm('Delete coupon?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>


</body>
</html>
