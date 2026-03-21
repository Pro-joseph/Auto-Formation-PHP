<?php
require_once 'config/database.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="px-3 mb-4 mt-3">
                <h5 class="fw-bold"><i class="bi bi-speedometer2"></i> Dashboard</h5>
                <small class="text-muted">Company Management</small>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link active" onclick="showPage('home')"><i class="bi bi-house-door"></i> Home</a>
                <a class="nav-link" onclick="showPage('employers')"><i class="bi bi-people"></i> Employers</a>
                <a class="nav-link" onclick="showPage('devices')"><i class="bi bi-laptop"></i> Devices</a>
                <?php if (isAdmin()): ?>
                <a class="nav-link" onclick="showPage('admin')"><i class="bi bi-shield-lock"></i> Admin Panel</a>
                <?php endif; ?>
                <a class="nav-link" onclick="showPage('reports')"><i class="bi bi-file-earmark"></i> Reports</a>
                <a class="nav-link" onclick="showPage('settings')"><i class="bi bi-gear"></i> Settings</a>
            </nav>
            <hr>
            <div class="px-3">
                <button class="btn btn-danger btn-sm w-100" onclick="logout()"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content w-100">
            <!-- Top Navbar -->
            <nav class="navbar navbar-custom sticky-top">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1" id="pageTitle">Welcome Back!</span>
                    <div class="d-flex gap-3">
                        <button class="btn btn-light position-relative">
                            <i class="bi bi-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                        </button>
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> <?php echo $_SESSION['full_name'] ?? $_SESSION['username']; ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" onclick="logout()" style="cursor: pointer;"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="p-4">
                
                <!-- HOME PAGE -->
                <div id="home" class="page-section active">
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card card-stat">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <p class="text-muted mb-1">Total Employers</p>
                                            <h3 class="mb-0" id="stat-employers">0</h3>
                                        </div>
                                        <div class="stat-icon icon-blue">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card card-stat">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <p class="text-muted mb-1">Total Devices</p>
                                            <h3 class="mb-0" id="stat-devices">0</h3>
                                        </div>
                                        <div class="stat-icon icon-green">
                                            <i class="bi bi-laptop"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card card-stat">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <p class="text-muted mb-1">Active Employers</p>
                                            <h3 class="mb-0" id="stat-active-employers">0</h3>
                                        </div>
                                        <div class="stat-icon icon-warning">
                                            <i class="bi bi-check-circle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card card-stat">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <p class="text-muted mb-1">Active Devices</p>
                                            <h3 class="mb-0" id="stat-active-devices">0</h3>
                                        </div>
                                        <div class="stat-icon icon-danger">
                                            <i class="bi bi-check2-square"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="table-container">
                                <h5 class="mb-3">Recent Device Assignments</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="recentOrdersTable">
                                        <thead>
                                            <tr>
                                                <th>Device</th>
                                                <th>Assigned To</th>
                                                <th>Purchase Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="recentOrdersBody">
                                            <!-- Data loaded dynamically -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- EMPLOYERS PAGE -->
                <div id="employers" class="page-section">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3>Manage Employers</h3>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#employerModal" onclick="resetEmployerForm()">
                            <i class="bi bi-plus-circle"></i> Add Employer
                        </button>
                    </div>

                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="employersTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Position</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                        <th>Hire Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="employersTableBody">
                                    <!-- Data loaded dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- DEVICES PAGE -->
                <div id="devices" class="page-section">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3>Manage Devices</h3>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deviceModal" onclick="resetDeviceForm()">
                            <i class="bi bi-plus-circle"></i> Add Device
                        </button>
                    </div>

                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="devicesTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Device Name</th>
                                        <th>Type</th>
                                        <th>Serial Number</th>
                                        <th>Assigned To</th>
                                        <th>Status</th>
                                        <th>Purchase Date</th>
                                        <th>Warranty</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="devicesTableBody">
                                    <!-- Data loaded dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ADMIN PANEL -->
                <?php if (isAdmin()): ?>
                <div id="admin" class="page-section">
                    <div class="row mb-4">
                        <div class="col-md-2 mb-3">
                            <div class="card card-stat">
                                <div class="card-body">
                                    <p class="text-muted mb-1">Total Users</p>
                                    <h3 class="mb-0" id="admin-stat-users">0</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="card card-stat">
                                <div class="card-body">
                                    <p class="text-muted mb-1">Admin Users</p>
                                    <h3 class="mb-0" id="admin-stat-admins">0</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="card card-stat">
                                <div class="card-body">
                                    <p class="text-muted mb-1">Active Users</p>
                                    <h3 class="mb-0" id="admin-stat-active">0</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="table-container">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5>Manage Users</h5>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#userModal" onclick="resetUserForm()">
                                        <i class="bi bi-plus-circle"></i> Add User
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="usersTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Full Name</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Last Login</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="usersTableBody">
                                            <!-- Data loaded dynamically -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="table-container">
                                <h5 class="mb-3">Recent Activity</h5>
                                <div id="activityLogContainer" style="max-height: 500px; overflow-y: auto;">
                                    <!-- Activity logs loaded dynamically -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- REPORTS PAGE -->
                <div id="reports" class="page-section">
                    <h3 class="mb-4">Reports</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-container">
                                <h5>Employer Reports</h5>
                                <div class="list-group">
                                    <button class="list-group-item list-group-item-action">
                                        <i class="bi bi-file-pdf"></i> Export Employers List
                                    </button>
                                    <button class="list-group-item list-group-item-action">
                                        <i class="bi bi-file-pdf"></i> Employee Status Report
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-container">
                                <h5>Device Reports</h5>
                                <div class="list-group">
                                    <button class="list-group-item list-group-item-action">
                                        <i class="bi bi-file-pdf"></i> Device Inventory
                                    </button>
                                    <button class="list-group-item list-group-item-action">
                                        <i class="bi bi-file-pdf"></i> Warranty Status
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SETTINGS PAGE -->
                <div id="settings" class="page-section">
                    <h3 class="mb-4">Settings</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-container">
                                <h5>Profile Settings</h5>
                                <form>
                                    <div class="mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['full_name'] ?? ''; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" disabled>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Employer Modal (same as before) -->
    <div class="modal fade" id="employerModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employerModalTitle">Add Employer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="employerForm">
                        <input type="hidden" id="employerId">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="employerName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" id="employerEmail" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="employerPhone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Position *</label>
                                <input type="text" class="form-control" id="employerPosition" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Department *</label>
                                <select class="form-select" id="employerDepartment" required>
                                    <option value="">Select Department</option>
                                    <option value="IT">IT</option>
                                    <option value="HR">HR</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Sales">Sales</option>
                                    <option value="Operations">Operations</option>
                                    <option value="Marketing">Marketing</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status *</label>
                                <select class="form-select" id="employerStatus" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="On Leave">On Leave</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Hire Date *</label>
                                <input type="date" class="form-control" id="employerHireDate" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveEmployer()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Device Modal (same as before) -->
    <div class="modal fade" id="deviceModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deviceModalTitle">Add Device</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="deviceForm">
                        <input type="hidden" id="deviceId">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Device Name *</label>
                                <input type="text" class="form-control" id="deviceName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Device Type *</label>
                                <select class="form-select" id="deviceType" required>
                                    <option value="">Select Type</option>
                                    <option value="Laptop">Laptop</option>
                                    <option value="Desktop">Desktop</option>
                                    <option value="Tablet">Tablet</option>
                                    <option value="Mobile">Mobile</option>
                                    <option value="Printer">Printer</option>
                                    <option value="Server">Server</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Serial Number *</label>
                                <input type="text" class="form-control" id="deviceSerial" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Assigned To</label>
                                <select class="form-select" id="deviceAssignedTo">
                                    <option value="">Select Employer</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status *</label>
                                <select class="form-select" id="deviceStatus" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Maintenance">Maintenance</option>
                                    <option value="Retired">Retired</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Purchase Date *</label>
                                <input type="date" class="form-control" id="devicePurchaseDate" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Warranty Expiry</label>
                                <input type="date" class="form-control" id="deviceWarrantyExpiry">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveDevice()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- User Modal (Admin Only) -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalTitle">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <input type="hidden" id="userId">
                        <div class="mb-3">
                            <label class="form-label">Username *</label>
                            <input type="text" class="form-control" id="userName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" id="userEmail" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="userFullName">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password *</label>
                            <input type="password" class="form-control" id="userPassword" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role *</label>
                            <select class="form-select" id="userRole" required>
                                <option value="user">User</option>
                                <option value="manager">Manager</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status *</label>
                            <select class="form-select" id="userStatus" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveUser()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/app.js"></script>
</body>
</html>