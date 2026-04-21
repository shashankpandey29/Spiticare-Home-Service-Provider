<?php
session_start();

// ✅ Admin login check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// ✅ DB CONNECTION
 $conn = new mysqli("localhost", "root", "", "services_app");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ HANDLE VERIFY / REJECT
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = intval($_POST['provider_id']);
    $action = $_POST['action'];

    if ($action == "verify") {
        $status = "verified";
    } else {
        $status = "rejected";
    }

    $stmt = $conn->prepare("UPDATE service_providers SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "Provider updated successfully!";
    } else {
        $_SESSION['msg'] = "Error updating provider!";
    }

    $stmt->close();

    header("Location: admin_verify_providers.php");
    exit();
}

// ✅ 🔥 NO FILTER (EXAM SAFE → ALL DATA SHOW)
 $sql = "SELECT * FROM service_providers ORDER BY id DESC";

 $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Providers - SpitiCare</title>
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #5d3b66;
            --primary-light: #8e44ad;
            --secondary: #ff6b6b;
            --success: #10ac84;
            --text: #333;
            --text-light: #666;
            --bg: #f4f6f9;
            --white: #ffffff;
            --shadow: 0 5px 15px rgba(0,0,0,0.08);
            --border: #e0e0e0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            background-color: var(--bg);
            color: var(--text);
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header Section */
        .header {
            background-color: var(--white);
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 5px solid var(--primary);
        }

        .header h1 {
            font-size: 1.5rem;
            color: var(--primary);
            font-weight: 600;
        }

        .header p {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-top: 5px;
        }

        /* Success Message */
        .alert {
            background-color: rgba(16, 172, 132, 0.1);
            color: var(--success);
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid rgba(16, 172, 132, 0.2);
            font-weight: 500;
        }

        /* Table Card */
        .table-card {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            overflow: hidden; /* For rounded corners */
            border: 1px solid var(--border);
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        thead {
            background-color: #f8f9fa;
            border-bottom: 2px solid var(--border);
        }

        th {
            text-align: left;
            padding: 15px 20px;
            font-weight: 600;
            color: var(--primary);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            color: var(--text);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: #fcfcfc;
        }

        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: capitalize;
        }
        .status-verified { background-color: rgba(16, 172, 132, 0.1); color: var(--success); }
        .status-rejected { background-color: rgba(255, 107, 107, 0.1); color: var(--secondary); }
        .status-pending { background-color: rgba(255, 159, 67, 0.1); color: #ee5a24; }
        .status-active { background-color: rgba(52, 152, 219, 0.1); color: #3498db; }

        /* Buttons */
        .action-form {
            display: inline-block;
            margin-right: 5px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s ease;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-verify {
            background-color: var(--success);
        }
        .btn-verify:hover { background-color: #0e9b6f; transform: translateY(-1px); }

        .btn-reject {
            background-color: var(--secondary);
        }
        .btn-reject:hover { background-color: #e55039; transform: translateY(-1px); }

        /* No Data State */
        .no-data {
            text-align: center;
            padding: 40px;
            color: var(--text-light);
            font-size: 1.1rem;
        }
        .no-data i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #ccc;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .header { flex-direction: column; align-items: flex-start; gap: 10px; }
            .header h1 { font-size: 1.2rem; }
        }
    </style>
</head>
<body>

<div class="container">
    
    <!-- Header -->
    <div class="header">
        <div>
            <h1><i class="fas fa-user-check"></i> Provider Verification</h1>
            <p>Manage and verify service provider applications</p>
        </div>
    </div>

    <!-- Success Message -->
    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert">
            <i class="fas fa-check-circle"></i> <?php echo $_SESSION['msg']; ?>
        </div>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>

    <!-- Table Section -->
    <div class="table-card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Service Type</th>
                        <th>Current Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Determine badge class based on status
                            $status = $row['status'] ? strtolower($row['status']) : 'pending';
                            $badgeClass = 'status-pending';
                            if($status == 'verified') $badgeClass = 'status-verified';
                            if($status == 'rejected') $badgeClass = 'status-rejected';
                            if($status == 'active') $badgeClass = 'status-active';
                    ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['fullName']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['service_type']); ?></td>
                        <td>
                            <span class="status-badge <?php echo $badgeClass; ?>">
                                <?php echo ucfirst($status); ?>
                            </span>
                        </td>
                        <td>
                            <!-- Verify Button -->
                            <form method="post" class="action-form" onsubmit="return confirm('Verify this provider?');">
                                <input type="hidden" name="provider_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="action" value="verify">
                                <button type="submit" class="btn btn-verify">
                                    <i class="fas fa-check"></i> Verify
                                </button>
                            </form>

                            <!-- Reject Button -->
                            <form method="post" class="action-form" onsubmit="return confirm('Reject this provider?');">
                                <input type="hidden" name="provider_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="action" value="reject">
                                <button type="submit" class="btn btn-reject">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                    ?>
                    <tr>
                        <td colspan="6">
                            <div class="no-data">
                                <i class="fas fa-inbox"></i>
                                <p>No providers found in the database.</p>
                            </div>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>

<?php $conn->close(); ?>