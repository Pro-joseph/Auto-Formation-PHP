<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --sidebar-bg: #f8f9fa;
        }
        body {
            background-color: #f5f7fa;
        }
        .sidebar {
            background-color: var(--sidebar-bg);
            min-height: 100vh;
            padding: 20px 0;
            border-right: 1px solid #dee2e6;
            position: fixed;
            width: 16.66%;
            left: 0;
            top: 0;
        }
        .main-content {
            margin-left: 16.66%;
        }
        .sidebar .nav-link {
            color: #495057;
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 8px;
            cursor: pointer;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }
        .navbar-custom {
            background-color: white;
            border-bottom: 1px solid #dee2e6;
        }
        .card-stat {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .card-stat:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .icon-blue {
            background-color: #cfe2ff;
            color: var(--primary-color);
        }
        .icon-green {
            background-color: #d1e7dd;
            color: #198754;
        }
        .icon-warning {
            background-color: #fff3cd;
            color: #ffc107;
        }
        .icon-danger {
            background-color: #f8d7da;
            color: #dc3545;
        }
        .chart-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .table-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .page-section {
            display: none;
        }
        .page-section.active {
            display: block;
        }
        .btn-action {
            padding: 5px 10px;
            font-size: 12px;
        }
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="px-3 mb-4">
                <h5 class="fw-bold"><i class="bi bi-speedometer2"></i> Dashboard</h5>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link active" onclick="showPage('home')"><i class="bi bi-house-door"></i> Home</a>
                <a class="nav-link" onclick="showPage('employers')"><i class="bi bi-people"></i> Employers</a>
                <a class="nav-link" onclick="showPage('devices')"><i class="bi bi-laptop"></i> Devices</a>
                <a class="nav-link" onclick="showPage('reports')"><i class="bi bi-file-earmark"></i> Reports</a>
                <a class="nav-link" onclick="showPage('settings')"><i class="bi bi-gear"></i> Settings</a>
            </nav>
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
                        <img src="https://via.placeholder.com/40" alt="Profile" class="rounded-circle">
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
                                            <p class="text-muted mb-1">Total Users</p>
                                            <h3 class="mb-0">12,456</h3>
                                        </div>
                                        <div class="stat-icon icon-blue">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                    <small class="text-success"><i class="bi bi-arrow-up"></i> +5.2%</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card card-stat">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <p class="text-muted mb-1">Revenue</p>
                                            <h3 class="mb-0">$45,231</h3>
                                        </div>
                                        <div class="stat-icon icon-green">
                                            <i class="bi bi-cash-coin"></i>
                                        </div>
                                    </div>
                                    <small class="text-success"><i class="bi bi-arrow-up"></i> +12.5%</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card card-stat">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <p class="text-muted mb-1">Orders</p>
                                            <h3 class="mb-0">8,234</h3>
                                        </div>
                                        <div class="stat-icon icon-warning">
                                            <i class="bi bi-bag"></i>
                                        </div>
                                    </div>
                                    <small class="text-danger"><i class="bi bi-arrow-down"></i> -2.1%</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card card-stat">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <p class="text-muted mb-1">Conversion</p>
                                            <h3 class="mb-0">3.2%</h3>
                                        </div>
                                        <div class="stat-icon icon-danger">
                                            <i class="bi bi-percent"></i>
                                        </div>
                                    </div>
                                    <small class="text-success"><i class="bi bi-arrow-up"></i> +1.8%</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-lg-8">
                            <div class="chart-container">
                                <h5 class="mb-3">Revenue Overview</h5>
                                <div style="height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                    <span>Chart Placeholder</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="chart-container">
                                <h5 class="mb-3">Traffic Source</h5>
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item d-flex justify-content-between">
                                        <span>Direct</span>
                                        <span class="badge bg-primary">45%</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between">
                                        <span>Referral</span>
                                        <span class="badge bg-success">30%</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between">
                                        <span>Social</span>
                                        <span class="badge bg-warning">20%</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between">
                                        <span>Other</span>
                                        <span class="badge bg-secondary">5%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- EMPLOYERS PAGE -->
                <div id="employers" class="page-section">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3>Manage Employers</h3>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#employerModal">
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
                                        <th>Position</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="employersTableBody">
                                    <!-- Data will be populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- DEVICES PAGE -->
                <div id="devices" class="page-section">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3>Manage Devices</h3>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deviceModal">
                            <i class="bi bi-plus-circle"></i> Add Device
                        </button>
                    </div>

                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="devicesTable">
                                <thead>
                                    <tr>
                                        <th>Device ID</th>
                                        <th>Device Name</th>
                                        <th>Type</th>
                                        <th>Serial Number</th>
                                        <th>Assigned To</th>
                                        <th>Status</th>
                                        <th>Purchase Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="devicesTableBody">
                                    <!-- Data will be populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- REPORTS PAGE -->
                <div id="reports" class="page-section">
                    <h3>Reports</h3>
                    <div class="alert alert-info">Reports page content goes here</div>
                </div>

                <!-- SETTINGS PAGE -->
                <div id="settings" class="page-section">
                    <h3>Settings</h3>
                    <div class="alert alert-info">Settings page content goes here</div>
                </div>

            </div>
        </div>
    </div>

    <!-- Employer Modal -->
    <div class="modal fade" id="employerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employerModalTitle">Add Employer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="employerForm">
                        <input type="hidden" id="employerId">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="employerName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="employerEmail" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Position</label>
                            <input type="text" class="form-control" id="employerPosition" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <select class="form-select" id="employerDepartment" required>
                                <option value="">Select Department</option>
                                <option value="IT">IT</option>
                                <option value="HR">HR</option>
                                <option value="Finance">Finance</option>
                                <option value="Sales">Sales</option>
                                <option value="Operations">Operations</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="employerStatus" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="On Leave">On Leave</option>
                            </select>
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

    <!-- Device Modal -->
    <div class="modal fade" id="deviceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deviceModalTitle">Add Device</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="deviceForm">
                        <input type="hidden" id="deviceId">
                        <div class="mb-3">
                            <label class="form-label">Device Name</label>
                            <input type="text" class="form-control" id="deviceName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Device Type</label>
                            <select class="form-select" id="deviceType" required>
                                <option value="">Select Type</option>
                                <option value="Laptop">Laptop</option>
                                <option value="Desktop">Desktop</option>
                                <option value="Tablet">Tablet</option>
                                <option value="Mobile">Mobile</option>
                                <option value="Printer">Printer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="deviceSerial" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Assigned To</label>
                            <select class="form-select" id="deviceAssignedTo" required>
                                <option value="">Select Employer</option>
                                <!-- Options populated dynamically -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="deviceStatus" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="Retired">Retired</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Purchase Date</label>
                            <input type="date" class="form-control" id="devicePurchaseDate" required>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Data Storage
        let employers = [
            { id: 1, name: 'John Doe', email: 'john@company.com', position: 'Senior Developer', department: 'IT', status: 'Active' },
            { id: 2, name: 'Jane Smith', email: 'jane@company.com', position: 'HR Manager', department: 'HR', status: 'Active' },
            { id: 3, name: 'Mike Johnson', email: 'mike@company.com', position: 'Sales Executive', department: 'Sales', status: 'Inactive' }
        ];

        let devices = [
            { id: 1, name: 'MacBook Pro 1', type: 'Laptop', serial: 'SN001', assignedTo: 'John Doe', status: 'Active', purchaseDate: '2023-01-15' },
            { id: 2, name: 'Dell Desktop 1', type: 'Desktop', serial: 'SN002', assignedTo: 'Jane Smith', status: 'Active', purchaseDate: '2023-02-20' },
            { id: 3, name: 'iPad Pro', type: 'Tablet', serial: 'SN003', assignedTo: 'Mike Johnson', status: 'Maintenance', purchaseDate: '2023-03-10' }
        ];

        let nextEmployerId = 4;
        let nextDeviceId = 4;

        // Page Navigation
        function showPage(pageName) {
            document.querySelectorAll('.page-section').forEach(el => el.classList.remove('active'));
            document.getElementById(pageName).classList.add('active');
            
            document.querySelectorAll('.sidebar .nav-link').forEach(el => el.classList.remove('active'));
            event.target.classList.add('active');

            // Update page title
            const titles = {
                home: 'Welcome Back!',
                employers: 'Manage Employers',
                devices: 'Manage Devices',
                reports: 'Reports',
                settings: 'Settings'
            };
            document.getElementById('pageTitle').textContent = titles[pageName];

            if (pageName === 'employers') {
                renderEmployers();
            } else if (pageName === 'devices') {
                renderDevices();
            }
        }

        // EMPLOYER FUNCTIONS
        function renderEmployers() {
            const tbody = document.getElementById('employersTableBody');
            tbody.innerHTML = employers.map(emp => `
                <tr>
                    <td>${emp.id}</td>
                    <td>${emp.name}</td>
                    <td>${emp.email}</td>
                    <td>${emp.position}</td>
                    <td>${emp.department}</td>
                    <td><span class="badge bg-${emp.status === 'Active' ? 'success' : emp.status === 'Inactive' ? 'danger' : 'warning'}">${emp.status}</span></td>
                    <td>
                        <button class="btn btn-sm btn-warning btn-action" onclick="editEmployer(${emp.id})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-action" onclick="deleteEmployer(${emp.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        function editEmployer(id) {
            const employer = employers.find(e => e.id === id);
            document.getElementById('employerId').value = employer.id;
            document.getElementById('employerName').value = employer.name;
            document.getElementById('employerEmail').value = employer.email;
            document.getElementById('employerPosition').value = employer.position;
            document.getElementById('employerDepartment').value = employer.department;
            document.getElementById('employerStatus').value = employer.status;
            document.getElementById('employerModalTitle').textContent = 'Edit Employer';
            new bootstrap.Modal(document.getElementById('employerModal')).show();
        }

        function saveEmployer() {
            const id = document.getElementById('employerId').value;
            const name = document.getElementById('employerName').value;
            const email = document.getElementById('employerEmail').value;
            const position = document.getElementById('employerPosition').value;
            const department = document.getElementById('employerDepartment').value;
            const status = document.getElementById('employerStatus').value;

            if (id) {
                const employer = employers.find(e => e.id == id);
                employer.name = name;
                employer.email = email;
                employer.position = position;
                employer.department = department;
                employer.status = status;
            } else {
                employers.push({ id: nextEmployerId++, name, email, position, department, status });
            }

            document.getElementById('employerForm').reset();
            document.getElementById('employerId').value = '';
            document.getElementById('employerModalTitle').textContent = 'Add Employer';
            bootstrap.Modal.getInstance(document.getElementById('employerModal')).hide();
            renderEmployers();
        }

        function deleteEmployer(id) {
            if (confirm('Are you sure you want to delete this employer?')) {
                employers = employers.filter(e => e.id !== id);
                renderEmployers();
            }
        }

        // DEVICE FUNCTIONS
        function renderDevices() {
            const tbody = document.getElementById('devicesTableBody');
            tbody.innerHTML = devices.map(dev => `
                <tr>
                    <td>${dev.id}</td>
                    <td>${dev.name}</td>
                    <td>${dev.type}</td>
                    <td>${dev.serial}</td>
                    <td>${dev.assignedTo}</td>
                    <td><span class="badge bg-${dev.status === 'Active' ? 'success' : dev.status === 'Maintenance' ? 'warning' : dev.status === 'Inactive' ? 'danger' : 'secondary'}">${dev.status}</span></td>
                    <td>${dev.purchaseDate}</td>
                    <td>
                        <button class="btn btn-sm btn-warning btn-action" onclick="editDevice(${dev.id})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-action" onclick="deleteDevice(${dev.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        function populateEmployerSelect() {
            const select = document.getElementById('deviceAssignedTo');
            select.innerHTML = '<option value="">Select Employer</option>' + employers.map(emp => `<option value="${emp.name}">${emp.name}</option>`).join('');
        }

        function editDevice(id) {
            const device = devices.find(d => d.id === id);
            document.getElementById('deviceId').value = device.id;
            document.getElementById('deviceName').value = device.name;
            document.getElementById('deviceType').value = device.type;
            document.getElementById('deviceSerial').value = device.serial;
            document.getElementById('deviceAssignedTo').value = device.assignedTo;
            document.getElementById('deviceStatus').value = device.status;
            document.getElementById('devicePurchaseDate').value = device.purchaseDate;
            document.getElementById('deviceModalTitle').textContent = 'Edit Device';
            new bootstrap.Modal(document.getElementById('deviceModal')).show();
        }

        function saveDevice() {
            const id = document.getElementById('deviceId').value;
            const name = document.getElementById('deviceName').value;
            const type = document.getElementById('deviceType').value;
            const serial = document.getElementById('deviceSerial').value;
            const assignedTo = document.getElementById('deviceAssignedTo').value;
            const status = document.getElementById('deviceStatus').value;
            const purchaseDate = document.getElementById('devicePurchaseDate').value;

            if (id) {
                const device = devices.find(d => d.id == id);
                device.name = name;
                device.type = type;
                device.serial = serial;
                device.assignedTo = assignedTo;
                device.status = status;
                device.purchaseDate = purchaseDate;
            } else {
                devices.push({ id: nextDeviceId++, name, type, serial, assignedTo, status, purchaseDate });
            }

            document.getElementById('deviceForm').reset();
            document.getElementById('deviceId').value = '';
            document.getElementById('deviceModalTitle').textContent = 'Add Device';
            bootstrap.Modal.getInstance(document.getElementById('deviceModal')).hide();
            renderDevices();
        }

        function deleteDevice(id) {
            if (confirm('Are you sure you want to delete this device?')) {
                devices = devices.filter(d => d.id !== id);
                renderDevices();
            }
        }

        // Modal event listeners
        document.getElementById('employerModal').addEventListener('show.bs.modal', function() {
            if (!document.getElementById('employerId').value) {
                document.getElementById('employerForm').reset();
                document.getElementById('employerModalTitle').textContent = 'Add Employer';
            }
        });

        document.getElementById('deviceModal').addEventListener('show.bs.modal', function() {
            populateEmployerSelect();
            if (!document.getElementById('deviceId').value) {
                document.getElementById('deviceForm').reset();
                document.getElementById('deviceModalTitle').textContent = 'Add Device';
            }
        });

        // Initialize
        renderEmployers();
        renderDevices();
    </script>
</body>
</html>