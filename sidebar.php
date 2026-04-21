<?php
// Optional: highlight active menu
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h2><i class="fas fa-home"></i> SpitiCare</h2>
    </div>

    <ul class="sidebar-menu">

        <li>
            <a href="admin_dashboard.php"
               class="<?= ($currentPage == 'admin_dashboard.php') ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>

        <!-- USERS -->
        <li>
            <a href="#">
                <i class="fas fa-users"></i> Users
                <i class="fas fa-chevron-down" style="float:right;"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="admin_manage_users.php">Manage Users</a></li>
                <li><a href="admin_user_analytics.php">User Analytics</a></li>
            </ul>
        </li>

        <!-- PROVIDERS -->
        <li>
            <a href="#">
                <i class="fas fa-user-md"></i> Providers
                <i class="fas fa-chevron-down" style="float:right;"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="admin_manage_providers.php">Manage Providers</a></li>
                <li><a href="admin_verify_providers.php">Verify Providers</a></li>
            </ul>
        </li>

        <!-- SERVICES -->
        <li>
            <a href="#">
                <i class="fas fa-concierge-bell"></i> Services
                <i class="fas fa-chevron-down" style="float:right;"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="admin_manage_services.php">Manage Services</a></li>
            </ul>
        </li>

        <!-- COUPONS -->
        <li>
            <a href="#">
                <i class="fas fa-ticket-alt"></i> Coupons
                <i class="fas fa-chevron-down" style="float:right;"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="admin_create_coupon.php">Create Coupon</a></li>
                <li><a href="admin_manage_coupons.php">Manage Coupons</a></li>
                <li><a href="admin_coupon_analytics.php">Coupon Analytics</a></li>
            </ul>
        </li>

        <!-- SUPPORT -->
        <li>
            <a href="#">
                <i class="fas fa-life-ring"></i> Support
                <i class="fas fa-chevron-down" style="float:right;"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="admin_support_tickets.php">Support Tickets</a></li>
            </ul>
        </li>

        <!-- REVENUE -->
        <li>
            <a href="#">
                <i class="fas fa-chart-line"></i> Revenue
                <i class="fas fa-chevron-down" style="float:right;"></i>
            </a>
            <ul class="sidebar-submenu">
                <li><a href="admin_revenue_reports.php">Revenue Reports</a></li>
                <li><a href="admin_transactions.php">Transactions</a></li>
            </ul>
        </li>

        <!-- SETTINGS -->
        <li>
            <a href="admin_settings.php">
                <i class="fas fa-cog"></i> Settings
            </a>
        </li>

        <!-- LOGOUT -->
        <li>
            <a href="admin_logout.php" style="color:#ff6b6b;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>

    </ul>
</aside>
