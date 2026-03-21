const API_BASE = '';
// Fallback to false if isAdmin is not defined globally via the PHP template
const isAdmin = window.isAdmin || false;

/**
 * Page Navigation
 * @param {string} pageName - The ID of the section to show
 * @param {Event} [event] - The click event (optional)
 */
function showPage(pageName, event) {
    // Hide all sections
    document.querySelectorAll('.page-section').forEach(el => el.classList.remove('active'));
    
    const targetPage = document.getElementById(pageName);
    if (targetPage) {
        targetPage.classList.add('active');
    }
    
    // Update Sidebar UI
    document.querySelectorAll('.sidebar .nav-link').forEach(el => el.classList.remove('active'));
    
    // Only try to highlight the clicked element if an event exists
    if (event && event.target) {
        event.target.classList.add('active');
    }

    const titles = {
        home: 'Welcome Back!',
        employers: 'Manage Employers',
        devices: 'Manage Devices',
        admin: 'Admin Panel',
        reports: 'Reports',
        settings: 'Settings'
    };
    
    const pageTitleEl = document.getElementById('pageTitle');
    if (pageTitleEl) {
        pageTitleEl.textContent = titles[pageName] || 'Dashboard';
    }

    // Trigger Data Loading
    if (pageName === 'home') {
        loadDashboardStats();
        loadRecentOrders();
    } else if (pageName === 'employers') {
        loadEmployers();
    } else if (pageName === 'devices') {
        loadDevices();
    } else if (pageName === 'admin' && isAdmin) {
        loadAdminStats();
        loadUsers();
        loadActivityLogs();
    }
}

// Logout
async function logout() {
    try {
        await fetch('api/auth.php?action=logout', { method: 'POST' });
        window.location.href = 'login.php';
    } catch (error) {
        console.error('Logout error:', error);
    }
}

// Load Dashboard Stats
async function loadDashboardStats() {
    try {
        const response = await fetch('api/users.php?action=stats');
        const result = await response.json();
        
        if (result.status === 'success') {
            document.getElementById('stat-employers').textContent = result.data.total_employers;
            document.getElementById('stat-devices').textContent = result.data.total_devices;
            document.getElementById('stat-active-employers').textContent = result.data.active_employers;
            document.getElementById('stat-active-devices').textContent = result.data.active_devices;
        }
    } catch (error) {
        console.error('Error loading stats:', error);
    }
}

// Load Recent Orders
async function loadRecentOrders() {
    try {
        const response = await fetch('api/users.php?action=recent-orders');
        const result = await response.json();
        
        if (result.status === 'success') {
            const tbody = document.getElementById('recentOrdersBody');
            if (!tbody) return;
            tbody.innerHTML = result.data.map(order => `
                <tr>
                    <td>${order.device_name}</td>
                    <td>${order.employee_name || 'Unassigned'}</td>
                    <td>${order.purchase_date}</td>
                    <td><span class="badge bg-${order.status === 'Active' ? 'success' : 'warning'}">${order.status}</span></td>
                </tr>
            `).join('');
        }
    } catch (error) {
        console.error('Error loading recent orders:', error);
    }
}

// EMPLOYER FUNCTIONS
async function loadEmployers() {
    try {
        const response = await fetch('api/employers.php?action=list');
        const result = await response.json();
        
        if (result.status === 'success') {
            const tbody = document.getElementById('employersTableBody');
            if (!tbody) return;
            tbody.innerHTML = result.data.map(emp => `
                <tr>
                    <td>${emp.id}</td>
                    <td>${emp.name}</td>
                    <td>${emp.email}</td>
                    <td>${emp.phone || '-'}</td>
                    <td>${emp.position}</td>
                    <td>${emp.department}</td>
                    <td><span class="badge bg-${emp.status === 'Active' ? 'success' : emp.status === 'Inactive' ? 'danger' : 'warning'}">${emp.status}</span></td>
                    <td>${emp.hire_date}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editEmployer(${emp.id})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteEmployer(${emp.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
            
            populateEmployerSelect();
        }
    } catch (error) {
        console.error('Error loading employers:', error);
        if (typeof showAlert === 'function') showAlert('Error loading employers', 'danger');
    }
}

async function editEmployer(id) {
    try {
        const response = await fetch(`api/employers.php?action=single&id=${id}`);
        const result = await response.json();
        
        if (result.status === 'success') {
            const emp = result.data;
            document.getElementById('employerId').value = emp.id;
            document.getElementById('employerName').value = emp.name;
            document.getElementById('employerEmail').value = emp.email;
            document.getElementById('employerPhone').value = emp.phone;
            document.getElementById('employerPosition').value = emp.position;
            document.getElementById('employerDepartment').value = emp.department;
            document.getElementById('employerStatus').value = emp.status;
            document.getElementById('employerHireDate').value = emp.hire_date;
            document.getElementById('employerModalTitle').textContent = 'Edit Employer';
            new bootstrap.Modal(document.getElementById('employerModal')).show();
        }
    } catch (error) {
        console.error('Error editing employer:', error);
    }
}

async function saveEmployer() {
    const id = document.getElementById('employerId').value;
    const data = {
        id: id,
        name: document.getElementById('employerName').value,
        email: document.getElementById('employerEmail').value,
        phone: document.getElementById('employerPhone').value,
        position: document.getElementById('employerPosition').value,
        department: document.getElementById('employerDepartment').value,
        status: document.getElementById('employerStatus').value,
        hire_date: document.getElementById('employerHireDate').value
    };

    try {
        const url = id ? 'api/employers.php?action=update' : 'api/employers.php?action=add';
        const response = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        if (result.status === 'success') {
            showAlert(result.message, 'success');
            resetEmployerForm();
            bootstrap.Modal.getInstance(document.getElementById('employerModal')).hide();
            loadEmployers();
        } else {
            showAlert(result.message, 'danger');
        }
    } catch (error) {
        console.error('Error saving employer:', error);
    }
}

async function deleteEmployer(id) {
    if (confirm('Are you sure you want to delete this employer?')) {
        try {
            const response = await fetch(`api/employers.php?id=${id}`, { method: 'DELETE' });
            const result = await response.json();
            
            if (result.status === 'success') {
                showAlert(result.message, 'success');
                loadEmployers();
            } else {
                showAlert(result.message, 'danger');
            }
        } catch (error) {
            console.error('Error deleting employer:', error);
        }
    }
}

function resetEmployerForm() {
    const form = document.getElementById('employerForm');
    if (form) form.reset();
    document.getElementById('employerId').value = '';
    document.getElementById('employerModalTitle').textContent = 'Add Employer';
}

// DEVICE FUNCTIONS
async function loadDevices() {
    try {
        const response = await fetch('api/devices.php?action=list');
        const result = await response.json();
        
        if (result.status === 'success') {
            const tbody = document.getElementById('devicesTableBody');
            if (!tbody) return;
            tbody.innerHTML = result.data.map(dev => `
                <tr>
                    <td>${dev.id}</td>
                    <td>${dev.device_name}</td>
                    <td>${dev.device_type}</td>
                    <td>${dev.serial_number}</td>
                    <td>${dev.assigned_to_name || 'Unassigned'}</td>
                    <td><span class="badge bg-${dev.status === 'Active' ? 'success' : dev.status === 'Maintenance' ? 'warning' : 'Inactive' ? 'danger' : 'secondary'}">${dev.status}</span></td>
                    <td>${dev.purchase_date}</td>
                    <td>${dev.warranty_expiry || '-'}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editDevice(${dev.id})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteDevice(${dev.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        }
    } catch (error) {
        console.error('Error loading devices:', error);
    }
}

async function editDevice(id) {
    try {
        const response = await fetch(`api/devices.php?action=single&id=${id}`);
        const result = await response.json();
        
        if (result.status === 'success') {
            const dev = result.data;
            document.getElementById('deviceId').value = dev.id;
            document.getElementById('deviceName').value = dev.device_name;
            document.getElementById('deviceType').value = dev.device_type;
            document.getElementById('deviceSerial').value = dev.serial_number;
            document.getElementById('deviceAssignedTo').value = dev.assigned_to || '';
            document.getElementById('deviceStatus').value = dev.status;
            document.getElementById('devicePurchaseDate').value = dev.purchase_date;
            document.getElementById('deviceWarrantyExpiry').value = dev.warranty_expiry || '';
            document.getElementById('deviceModalTitle').textContent = 'Edit Device';
            new bootstrap.Modal(document.getElementById('deviceModal')).show();
        }
    }
}