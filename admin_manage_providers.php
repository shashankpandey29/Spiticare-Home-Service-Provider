<?php
session_start();

// 1. Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// 2. Database configuration
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

// 3. Handle provider actions (verify, reject, delete) - SECURE VERSION
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    
    // Sanitize and Validate ID
    $provider_id = isset($_POST['provider_id']) ? intval($_POST['provider_id']) : 0;
    $action = $_POST['action'];

    if ($provider_id > 0) {
        // Fetch provider details first (needed for email/name)
        $stmt_check = $conn->prepare("SELECT * FROM service_providers WHERE id = ?");
        $stmt_check->bind_param("i", $provider_id);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        
        if ($result->num_rows > 0) {
            $provider = $result->fetch_assoc();

            if ($action == 'verify') {
                // Update provider status to verified
                $stmt = $conn->prepare("UPDATE service_providers SET status = 'verified' WHERE id = ?");
                $stmt->bind_param("i", $provider_id);
                
                if ($stmt->execute()) {
                    // Send Email Notification
                    sendProviderEmail($provider['email'], $provider['fullName'], 'verified');
                    
                    // Optional: Log SMS/WhatsApp (Placeholder)
                    // sendSMSNotification($provider['mobile'], $provider['fullName']);
                    
                    $_SESSION['message'] = "Provider verified successfully! Email notification sent.";
                } else {
                    $_SESSION['error'] = "Error verifying provider: " . $conn->error;
                }
                $stmt->close();

            } elseif ($action == 'reject') {
                // Update provider status to rejected
                $stmt = $conn->prepare("UPDATE service_providers SET status = 'rejected' WHERE id = ?");
                $stmt->bind_param("i", $provider_id);
                
                if ($stmt->execute()) {
                    // Send Email Notification
                    sendProviderEmail($provider['email'], $provider['fullName'], 'rejected');
                    
                    $_SESSION['message'] = "Provider rejected successfully.";
                } else {
                    $_SESSION['error'] = "Error rejecting provider: " . $conn->error;
                }
                $stmt->close();

            } elseif ($action == 'delete') {
                // Delete provider (Cascading deletes should handle related data if set up in DB)
                $stmt = $conn->prepare("DELETE FROM service_providers WHERE id = ?");
                $stmt->bind_param("i", $provider_id);
                
                if ($stmt->execute()) {
                    $_SESSION['message'] = "Provider deleted successfully.";
                } else {
                    $_SESSION['error'] = "Error deleting provider: " . $conn->error;
                }
                $stmt->close();
            }
        } else {
            $_SESSION['error'] = "Provider not found.";
        }
        $stmt_check->close();
    } else {
        $_SESSION['error'] = "Invalid Provider ID.";
    }

    header("Location: admin_manage_providers.php");
    exit();
}

// 4. Get filter parameters
 $status_filter = isset($_GET['status']) ? $_GET['status'] : '';
 $search = isset($_GET['search']) ? $_GET['search'] : '';

// Build the query with proper filtering
// Using real_escape_string for the search filter (Prepared statements for LIKE are complex, this is acceptable for search)
 $sql = "SELECT * FROM service_providers WHERE 1=1";
if (!empty($status_filter)) {
    $sql .= " AND status = '" . $conn->real_escape_string($status_filter) . "'";
}
if (!empty($search)) {
    $escaped_search = $conn->real_escape_string($search);
    $sql .= " AND (fullName LIKE '%$escaped_search%' OR email LIKE '%$escaped_search%' OR mobile LIKE '%$escaped_search%' OR service_type LIKE '%$escaped_search%')";
}
 $sql .= " ORDER BY created_at DESC";
 $result = $conn->query($sql);
 $providers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $providers[] = $row;
    }
}

// Get counts for different statuses
 $pending_count = $conn->query("SELECT COUNT(*) as count FROM service_providers WHERE status = 'pending'")->fetch_assoc()['count'];
 $verified_count = $conn->query("SELECT COUNT(*) as count FROM service_providers WHERE status = 'verified'")->fetch_assoc()['count'];
 $rejected_count = $conn->query("SELECT COUNT(*) as count FROM service_providers WHERE status = 'rejected'")->fetch_assoc()['count'];
 $conn->close();

// 5. Unified Email Function
function sendProviderEmail($email, $name, $status) {
    $subject = "";
    $body = "";
    
    if ($status == 'verified') {
        $subject = "Account Verified - SpitiCare";
        $body = "
        <html>
        <head><title>Account Verified</title></head>
        <body>
            <h2>Hello $name,</h2>
            <p>Great news! Your SpitiCare service provider account has been <strong>Verified</strong>.</p>
            <p>You can now login to your dashboard.</p>
            <br><p>Best regards,<br>The SpitiCare Team</p>
        </body>
        </html>";
    } else {
        $subject = "Account Update - SpitiCare";
        $body = "
        <html>
        <head><title>Account Status</title></head>
        <body>
            <h2>Hello $name,</h2>
            <p>We regret to inform you that your SpitiCare service provider account has been <strong>Rejected</strong>.</p>
            <p>Please contact support for more information.</p>
            <br><p>Best regards,<br>The SpitiCare Team</p>
        </body>
        </html>";
    }
    
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= 'From: <noreply@spiticare.com>' . "\r\n";
    
    @mail($email, $subject, $body, $headers);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Providers - SpitiCare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #5d3b66;
            --primary-light: #8e44ad;
            --secondary: #ff6b6b;
            --accent: #ff9f43;
            --light: #f8f9fa;
            --dark: #2c3e50;
            --success: #10ac84;
            --info: #0abde3;
            --text: #333;
            --white: #ffffff;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background-color: #f5f7fa; color: var(--text); line-height: 1.6; }
        
        .dashboard-container { display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar {
            width: 250px; background-color: var(--primary); color: white;
            padding: 20px 0; position: fixed; height: 100vh; overflow-y: auto; transition: var(--transition); z-index: 100;
        }
        .sidebar-header { padding: 0 20px 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); margin-bottom: 20px; }
        .sidebar-header h2 { font-size: 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .sidebar-menu { list-style: none; }
        .sidebar-menu li { margin-bottom: 5px; }
        .sidebar-menu a {
            display: block; padding: 12px 20px; color: rgba(255, 255, 255, 0.8);
            text-decoration: none; transition: var(--transition); font-weight: 500;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active { background-color: rgba(255, 255, 255, 0.1); color: white; border-left: 4px solid var(--accent); }
        .sidebar-menu i { margin-right: 10px; width: 20px; text-align: center; }
        
        /* Main Content */
        .main-content { margin-left: 250px; flex: 1; padding: 20px; transition: var(--transition); width: calc(100% - 250px); }
        
        .header {
            background-color: white; padding: 15px 20px; border-radius: 8px;
            box-shadow: var(--shadow); margin-bottom: 20px; display: flex;
            justify-content: space-between; align-items: center;
        }
        .header h1 { font-size: 1.8rem; color: var(--primary); }
        .admin-info { display: flex; align-items: center; }
        .admin-info img { width: 40px; height: 40px; border-radius: 50%; margin-right: 10px; border: 2px solid var(--primary); }
        .logout-btn {
            background-color: var(--secondary); color: white; border: none;
            padding: 8px 15px; border-radius: 5px; cursor: pointer; text-decoration: none; font-weight: 500;
        }
        .logout-btn:hover { background-color: #e55039; }
        
        /* Content Card */
        .content-card { background-color: white; border-radius: 10px; padding: 25px; box-shadow: var(--shadow); margin-bottom: 30px; }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px; }
        .section-header h2 { color: var(--primary); font-size: 1.5rem; }
        
        /* Filters */
        .filters { display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap; }
        .filter-group { display: flex; flex-direction: column; gap: 5px; flex: 1; min-width: 200px; }
        .filter-group label { font-weight: 500; color: var(--text); font-size: 0.9rem; }
        .filter-group select, .filter-group input { padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 0.9rem; width: 100%; }
        .filter-btn, .reset-btn { padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: 500; border: none; color: white; transition: var(--transition); align-self: flex-end; }
        .filter-btn { background-color: var(--primary); }
        .filter-btn:hover { background-color: var(--primary-light); }
        .reset-btn { background-color: var(--secondary); }
        .reset-btn:hover { background-color: #e55039; }
        
        /* Stats */
        .stats-container { display: flex; gap: 15px; margin-bottom: 20px; }
        .stat-card { background-color: #f8f9fa; border-radius: 8px; padding: 20px; flex: 1; text-align: center; transition: var(--transition); border-bottom: 4px solid transparent; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
        .stat-card h3 { font-size: 2rem; margin-bottom: 5px; color: var(--dark); }
        .stat-card p { color: var(--text-light); font-size: 0.9rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-card.all { border-color: var(--primary); }
        .stat-card.pending { border-color: var(--accent); }
        .stat-card.verified { border-color: var(--success); }
        .stat-card.rejected { border-color: var(--secondary); }
        
        /* Table */
        .table-container { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 800px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #f8f9fa; font-weight: 600; color: var(--dark); text-transform: uppercase; font-size: 0.85rem; }
        tr:hover { background-color: #fafafa; }
        .status { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; text-transform: capitalize; }
        .status.pending { background-color: #fff3cd; color: #856404; }
        .status.verified { background-color: #d4edda; color: #155724; }
        .status.rejected { background-color: #f8d7da; color: #721c24; }
        
        /* Buttons */
        .action-btn { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 0.8rem; font-weight: 500; margin-right: 5px; transition: var(--transition); color: white; display: inline-block; }
        .verify-btn { background-color: var(--success); }
        .verify-btn:hover { background-color: #0e9b6f; }
        .reject-btn { background-color: var(--secondary); }
        .reject-btn:hover { background-color: #e55039; }
        .delete-btn { background-color: var(--dark); }
        .delete-btn:hover { background-color: #1a252f; }
        .view-btn { background-color: var(--info); text-decoration: none; }
        .view-btn:hover { background-color: #0a8fc7; }
        
        .btn-link { background-color: var(--primary); color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 0.9rem; }
        .btn-link:hover { background-color: var(--primary-light); }

        /* Alerts */
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; font-size: 0.9rem; border-left: 4px solid; }
        .alert-success { background-color: rgba(16, 172, 132, 0.1); color: var(--success); border-color: var(--success); }
        .alert-danger { background-color: rgba(255, 107, 107, 0.1); color: var(--secondary); border-color: var(--secondary); }
        
        /* Mobile */
        .mobile-menu-btn { display: none; background: none; border: none; color: var(--primary); font-size: 1.5rem; cursor: pointer; margin-right: 15px; }
        
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; width: 100%; }
            .mobile-menu-btn { display: block; }
            .stats-container { flex-direction: column; }
            .filters { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-home"></i> SpitiCare</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="admin_manage_users.php"><i class="fas fa-users"></i> Manage Users</a></li>
                <li><a href="admin_manage_providers.php" class="active"><i class="fas fa-user-md"></i> Manage Providers</a></li>
                <li><a href="admin_verify_providers.php"><i class="fas fa-user-check"></i> Verify Providers</a></li>
                <li><a href="admin_manage_services.php"><i class="fas fa-concierge-bell"></i> Manage Services</a></li>
                <li><a href="admin_reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
            </ul>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <div style="display: flex; align-items: center;">
                    <button class="mobile-menu-btn" id="mobile-menu-btn"><i class="fas fa-bars"></i></button>
                    <h1>Manage Providers</h1>
                </div>
                <div class="admin-info">
                    <img src="https://picsum.photos/seed/admin/40/40.jpg" alt="Admin">
                    <span class="admin-name"><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></span>
                    <a href="admin_logout.php" class="logout-btn">Logout</a>
                </div>
            </div>
            
            <!-- Alert Messages -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <!-- Filters & Stats -->
            <div class="content-card">
                <div class="section-header">
                    <h2>Provider Management</h2>
                    <a href="admin_verify_providers.php" class="btn-link">
                        <i class="fas fa-filter"></i> Pending Verifications Only
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="stats-container">
                    <div class="stat-card all">
                        <h3><?php echo $pending_count + $verified_count + $rejected_count; ?></h3>
                        <p>Total Providers</p>
                    </div>
                    <div class="stat-card pending">
                        <h3><?php echo $pending_count; ?></h3>
                        <p>Pending</p>
                    </div>
                    <div class="stat-card verified">
                        <h3><?php echo $verified_count; ?></h3>
                        <p>Verified</p>
                    </div>
                    <div class="stat-card rejected">
                        <h3><?php echo $rejected_count; ?></h3>
                        <p>Rejected</p>
                    </div>
                </div>
                
                <!-- Filter Form -->
                <form method="get" class="filters">
                    <div class="filter-group">
                        <label for="status">Status Filter</label>
                        <select name="status" id="status">
                            <option value="">All Statuses</option>
                            <option value="pending" <?php echo $status_filter == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="verified" <?php echo $status_filter == 'verified' ? 'selected' : ''; ?>>Verified</option>
                            <option value="rejected" <?php echo $status_filter == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="search">Search Providers</label>
                        <input type="text" id="search" name="search" placeholder="Name, Email, Mobile, Service..." value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    
                    <button type="submit" class="filter-btn">Search</button>
                    <a href="admin_manage_providers.php" class="reset-btn">Reset</a>
                </form>
                
                <!-- Providers Table -->
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Service</th>
                                <th>Exp.</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($providers) > 0): ?>
                                <?php foreach ($providers as $provider): ?>
                                    <tr>
                                        <td>#<?php echo $provider['id']; ?></td>
                                        <td><?php echo htmlspecialchars($provider['fullName']); ?></td>
                                        <td><?php echo htmlspecialchars($provider['email']); ?></td>
                                        <td><?php echo htmlspecialchars($provider['service_type']); ?></td>
                                        <td><?php echo $provider['experience'] . ' yrs'; ?></td>
                                        <td>
                                            <span class="status <?php echo $provider['status']; ?>">
                                                <?php echo ucfirst($provider['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($provider['status'] == 'pending'): ?>
                                                <!-- Verify Form -->
                                                <form method="post" style="display: inline;">
                                                    <input type="hidden" name="provider_id" value="<?php echo $provider['id']; ?>">
                                                    <input type="hidden" name="action" value="verify">
                                                    <button type="submit" class="action-btn verify-btn" onclick="return confirm('Verify this provider and send email?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                
                                                <!-- Reject Form -->
                                                <form method="post" style="display: inline;">
                                                    <input type="hidden" name="provider_id" value="<?php echo $provider['id']; ?>">
                                                    <input type="hidden" name="action" value="reject">
                                                    <button type="submit" class="action-btn reject-btn" onclick="return confirm('Reject this provider?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            
                                            <a href="admin_view_provider.php?id=<?php echo $provider['id']; ?>" class="action-btn view-btn" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <!-- Delete Form -->
                                            <form method="post" style="display: inline;" onsubmit="return confirm('Are you sure you want to PERMANENTLY delete this provider?');">
                                                <input type="hidden" name="provider_id" value="<?php echo $provider['id']; ?>">
                                                <input type="hidden" name="action" value="delete">
                                                <button type="submit" class="action-btn delete-btn" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 30px; color: #777;">
                                        No providers found matching your criteria.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        
        if(mobileMenuBtn){
            mobileMenuBtn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        }

        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });
    </script>
</body>
</html>