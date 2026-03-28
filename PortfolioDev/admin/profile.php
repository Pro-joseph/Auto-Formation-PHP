<?php
require 'auth.php';
require '../includes/config.php';

$success = '';
$error = '';

// Ensure cv_file column exists
try {
    $pdo->exec("ALTER TABLE users ADD COLUMN cv_file VARCHAR(255) DEFAULT NULL");
} catch (PDOException $e) {
    // Ignore if column already exists
}

// Fetch current user details
$stmt = $pdo->prepare("SELECT email, password, cv_file FROM users WHERE id = ?");
$stmt->execute([$_SESSION['admin_id']]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_email') {
        $new_email = trim($_POST['email'] ?? '');
        if ($new_email && filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $update_stmt = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
            $update_stmt->execute([$new_email, $_SESSION['admin_id']]);
            $success = "Email address updated successfully.";
            $user['email'] = $new_email; // Update local variable to reflect new value
        } else {
            $error = "Please enter a valid email address.";
        }
    } elseif ($action === 'update_password') {
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        if ($current_password && $new_password && $confirm_password) {
            if ($new_password !== $confirm_password) {
                $error = "New passwords do not match.";
            } else {
                if ($user && password_verify($current_password, $user['password'])) {
                    // Update password
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $update_stmt->execute([$hashed_password, $_SESSION['admin_id']]);
                    $success = "Password updated successfully.";
                } else {
                    $error = "Incorrect current password.";
                }
            }
        } else {
            $error = "All fields are required.";
        }
    } elseif ($action === 'update_cv') {
        if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../uploads/cv/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            $cv_file_name = 'uploads/cv/' . time() . '_' . basename($_FILES['cv_file']['name']);
            if (move_uploaded_file($_FILES['cv_file']['tmp_name'], '../' . $cv_file_name)) {
                $update_stmt = $pdo->prepare("UPDATE users SET cv_file = ? WHERE id = ?");
                $update_stmt->execute([$cv_file_name, $_SESSION['admin_id']]);
                $success = "CV uploaded successfully.";
                $user['cv_file'] = $cv_file_name;
            } else {
                $error = "Failed to upload CV.";
            }
        } else {
            $error = "Please select a valid file to upload.";
        }
    }
}
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Profile | CMS Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
        body { background-color: #f8f9fa; color: #2b3437; font-family: 'Inter', sans-serif; min-height: 100vh; }
        .font-headline { font-family: 'Manrope', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Sidebar -->
    <aside class="h-screen w-64 fixed left-0 top-0 border-r border-slate-100 bg-white flex flex-col py-6 gap-2 z-40">
        <a href="../index.php" class="px-6 mb-8 flex items-center gap-3 hover:opacity-80 transition-opacity" title="Back to Main Site">
            <span class="material-symbols-outlined text-emerald-700 text-2xl" data-icon="terminal">terminal</span>
            <span class="text-lg font-black text-emerald-800 font-headline">Josephlab.dev</span>
        </a>
        <div class="px-6 mb-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center overflow-hidden">
                    <span class="material-symbols-outlined text-emerald-800">person</span>
                </div>
                <div>
                    <p class="font-inter text-sm font-bold text-gray-900 leading-tight"><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></p>
                    <p class="font-inter text-xs text-gray-500">CMS Administrator</p>
                </div>
            </div>
        </div>
        <nav class="flex-1 space-y-1">
            <a class="flex items-center gap-3 px-4 py-2.5 mx-2 text-slate-600 hover:bg-slate-50 transition-transform hover:translate-x-1 font-inter text-sm font-medium" href="dashboard.php">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span>Projects Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-2.5 mx-2 text-slate-600 hover:bg-slate-50 transition-transform hover:translate-x-1 font-inter text-sm font-medium" href="contacts.php">
                <span class="material-symbols-outlined" data-icon="email">email</span>
                <span>Contacts</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-2.5 mx-2 bg-emerald-50 text-emerald-800 rounded-lg font-inter text-sm font-medium" href="profile.php">
                <span class="material-symbols-outlined" data-icon="account_circle">account_circle</span>
                <span>Profile</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-2.5 mx-2 text-red-600 hover:bg-slate-50 transition-transform hover:translate-x-1 font-inter text-sm font-medium mt-auto" href="logout.php">
                <span class="material-symbols-outlined" data-icon="logout">logout</span>
                <span>Logout</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <main class="ml-64 min-h-screen flex flex-col">
        <!-- TopAppBar -->
        <header class="fixed top-0 left-64 right-0 z-30 bg-slate-50/80 backdrop-blur-xl shadow-sm h-20 flex justify-between items-center px-8 border-b border-transparent">
            <div class="flex flex-col">
                <h1 class="font-headline tracking-tight font-light text-emerald-800 text-xl">Admin Profile</h1>
                <span class="text-[10px] uppercase tracking-widest text-gray-500">System / Settings</span>
            </div>
        </header>

        <!-- Content Canvas -->
        <div class="pt-28 pb-12 px-12 max-w-7xl flex-1 space-y-8">
            <!-- Update Email Form -->
            <div class="max-w-2xl bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-headline font-bold text-lg text-gray-800">Email Address</h3>
                </div>
                
                <div class="p-8 pb-4">
                    <?php if ($success && ($_POST['action'] ?? '') === 'update_email'): ?>
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded relative mb-6 text-sm" role="alert">
                            <span class="block sm:inline"><?= htmlspecialchars($success) ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ($error && ($_POST['action'] ?? '') === 'update_email'): ?>
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative mb-6 text-sm" role="alert">
                            <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="profile.php" class="space-y-6">
                        <input type="hidden" name="action" value="update_email">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required class="w-full rounded border-gray-300 border p-3 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20">
                            <p class="text-xs text-gray-500 mt-2">This email will receive contact form notifications.</p>
                        </div>
                        <div class="pt-4 pb-4">
                            <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3 px-8 rounded flex items-center gap-2">
                                <span class="material-symbols-outlined">mail</span> Update Email
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password Form -->
            <div class="max-w-2xl bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-headline font-bold text-lg text-gray-800">Change Password</h3>
                </div>
                
                <div class="p-8">
                    <?php if ($error && ($_POST['action'] ?? '') === 'update_password'): ?>
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative mb-6 text-sm" role="alert">
                            <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ($success && ($_POST['action'] ?? '') === 'update_password'): ?>
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded relative mb-6 text-sm" role="alert">
                            <span class="block sm:inline"><?= htmlspecialchars($success) ?></span>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="profile.php" class="space-y-6">
                        <input type="hidden" name="action" value="update_password">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Current Password</label>
                            <input type="password" name="current_password" required class="w-full rounded border-gray-300 border p-3 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                            <input type="password" name="new_password" required class="w-full rounded border-gray-300 border p-3 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password</label>
                            <input type="password" name="confirm_password" required class="w-full rounded border-gray-300 border p-3 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20">
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3 px-8 rounded flex items-center gap-2">
                                <span class="material-symbols-outlined">key</span> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Upload CV Form -->
            <div class="max-w-2xl bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-headline font-bold text-lg text-gray-800">Upload CV</h3>
                </div>
                
                <div class="p-8">
                    <?php if ($success && ($_POST['action'] ?? '') === 'update_cv'): ?>
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded relative mb-6 text-sm" role="alert">
                            <span class="block sm:inline"><?= htmlspecialchars($success) ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ($error && ($_POST['action'] ?? '') === 'update_cv'): ?>
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative mb-6 text-sm" role="alert">
                            <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="profile.php" enctype="multipart/form-data" class="space-y-6">
                        <input type="hidden" name="action" value="update_cv">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Select CV File (PDF recommended)</label>
                            <input type="file" name="cv_file" accept=".pdf,.doc,.docx" required class="w-full rounded border-gray-300 border p-3 bg-gray-50 focus:bg-white">
                            <?php if (!empty($user['cv_file'])): ?>
                                <p class="text-sm text-gray-600 mt-3">Current CV: <a href="../<?= htmlspecialchars($user['cv_file']) ?>" target="_blank" class="text-emerald-700 font-semibold hover:underline border-b border-emerald-700">View/Download Uploaded CV</a></p>
                            <?php endif; ?>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3 px-8 rounded flex items-center gap-2">
                                <span class="material-symbols-outlined">upload_file</span> Upload New CV
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
