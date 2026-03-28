<?php
session_start();
 require '../includes/config.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}



$error = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    } else {
        $error = 'Please enter username and password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Josephlab.dev</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; color: #2b3437; }
        .font-headline { font-family: 'Manrope', sans-serif; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-gray-100 to-emerald-50 opacity-50 z-0"></div>
    <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-md relative z-10 border border-gray-100">
        <div class="absolute top-6 left-6">
            <a href="../index.php" class="text-gray-400 hover:text-emerald-700 flex items-center gap-2 text-sm font-semibold transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Site
            </a>
        </div>
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold font-headline text-emerald-800 tracking-tight">Josephlab.dev</h2>
            <p class="text-sm text-gray-500 mt-2 uppercase tracking-widest font-semibold">CMS Administration</p>
        </div>
        
        <?php if ($error): ?>
            <div class="bg-red-50 text-red-700 p-4 rounded-lg mb-6 text-sm flex items-center gap-3 border border-red-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="login.php" class="space-y-5">
            <div>
                <label class="block text-xs uppercase tracking-widest font-bold text-gray-500 mb-2">Username</label>
                <input type="text" name="username" class="w-full bg-gray-50 border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-emerald-500/20 focus:bg-white transition-all text-sm" required autofocus>
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest font-bold text-gray-500 mb-2">Password</label>
                <input type="password" name="password" class="w-full bg-gray-50 border-none rounded-lg px-4 py-3 focus:ring-2 focus:ring-emerald-500/20 focus:bg-white transition-all text-sm" required>
            </div>
            <button type="submit" class="w-full bg-[#456461] text-white py-4 rounded-lg font-headline font-bold text-lg hover:bg-[#395855] transition-all shadow-lg flex items-center justify-center gap-2 mt-4">
                Authenticate
            </button>
        </form>
    </div>
</body>
</html>
