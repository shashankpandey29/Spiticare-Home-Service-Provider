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

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$min_loyalty = isset($_POST['min_loyalty_score'])
    ? (int)$_POST['min_loyalty_score']
    : 0;
    $code  = strtoupper(trim($_POST['code']));
    $type  = $_POST['discount_type'];
    $value = (float) $_POST['discount_value'];

    $min   = !empty($_POST['min_order']) ? (float) $_POST['min_order'] : NULL;
    $max   = !empty($_POST['max_discount']) ? (float) $_POST['max_discount'] : NULL;
    $limit = !empty($_POST['usage_limit']) ? (int) $_POST['usage_limit'] : 0;

    $start = $_POST['start_date'];
    $end   = $_POST['end_date'];

    if ($start > $end) {
        $msg = "❌ Start date cannot be greater than end date";
    } else {

        $stmt = $conn->prepare(
"INSERT INTO coupons 
(code, discount_type, discount_value, min_order, max_discount, start_date, end_date, usage_limit, min_loyalty_score) 
VALUES (?,?,?,?,?,?,?,?,?)"
        );

        // ✅ Correct data types
      $stmt->bind_param(
    "ssdddssii",
    $code,
    $type,
    $value,
    $min,
    $max,
    $start,
    $end,
    $limit,
    $min_loyalty
);

        if ($stmt->execute()) {
            $msg = "✅ Coupon created successfully";
        } else {
            $msg = "❌ Coupon code already exists";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Coupon</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root {
    --primary: #5d3b66;
    --primary-light: #7b4a88;
    --gradient: linear-gradient(135deg, #5d3b66, #7b4a88);
    --bg: #f5f7fa;
    --white: #ffffff;
    --text: #333;
    --muted: #777;
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

/* MAIN CONTENT */
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
    opacity: 0.9;
}

.page-header h1 {
    margin: 0;
    font-size: 26px;
    font-weight: 600;
}

/* FORM CARD */
.form-card {
    background: var(--white);
    padding: 35px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    max-width: 820px;
}

/* ALERT */
.alert {
    padding: 14px 18px;
    border-radius: 10px;
    margin-bottom: 25px;
    font-size: 14px;
    font-weight: 500;
}

.alert.success {
    background: #e6f7f0;
    color: #0f766e;
    border-left: 5px solid #10b981;
}

.alert.error {
    background: #fdecec;
    color: #b91c1c;
    border-left: 5px solid #ef4444;
}

/* FORM GRID */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 22px;
}

/* FORM GROUP */
.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full {
    grid-column: span 2;
}

label {
    font-size: 13px;
    color: var(--muted);
    margin-bottom: 6px;
    font-weight: 500;
}

small {
    font-size: 12px;
    color: #9ca3af;
    margin-top: 4px;
}

/* INPUTS */
input, select {
    padding: 14px 15px;
    border-radius: 10px;
    border: 1px solid var(--border);
    font-size: 14px;
    outline: none;
    transition: 0.3s;
    background: #fafafa;
}

input:focus, select:focus {
    border-color: var(--primary);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(93,59,102,0.12);
}

/* BUTTON */
.btn-primary {
    background: var(--gradient);
    color: var(--white);
    padding: 14px;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 25px rgba(93,59,102,0.35);
}

/* RESPONSIVE */
@media (max-width: 900px) {
    .main-content {
        margin-left: 0;
    }
    .form-grid {
        grid-template-columns: 1fr;
    }
}
</style>

</head>
<body>


<main class="main-content">
<div class="form-group full">
    <label>Minimum Loyalty Score</label>
    <input type="number"
           name="min_loyalty_score"
           min="0"
           max="100"
           placeholder="Eg: 50">
    <small>Only users with this loyalty score or higher can use this coupon</small>
</div>


    <div class="page-header">
        <h1>Create Coupon</h1>
    </div>

    <div class="form-card">

        <?php if ($msg): ?>
            <div class="alert <?= str_contains($msg,'✅') ? 'success' : 'error'; ?>">
                <?= htmlspecialchars($msg); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">

            <div class="form-grid">

                <div class="form-group full">
                    <label>Coupon Code</label>
                    <input type="text" name="code" placeholder="SAVE20" required>
                </div>

                <div class="form-group">
                    <label>Discount Type</label>
                    <select name="discount_type" required>
                        <option value="percentage">Percentage</option>
                        <option value="flat">Flat Amount</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Discount Value</label>
                    <input type="number" name="discount_value" required>
                </div>

                <div class="form-group">
                    <label>Minimum Order</label>
                    <input type="number" name="min_order">
                </div>

                <div class="form-group">
                    <label>Max Discount</label>
                    <input type="number" name="max_discount">
                </div>

                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="start_date" required>
                </div>

                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="end_date" required>
                </div>

                <div class="form-group full">
                    <label>Usage Limit</label>
                    <input type="number" name="usage_limit">
                </div>

                <div class="form-group full">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-ticket-alt"></i> Create Coupon
                    </button>
                </div>

            </div>

        </form>
    </div>

</main>

</body>
</html>
