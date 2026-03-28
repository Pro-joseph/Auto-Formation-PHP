<?php
require 'auth.php';
require '../includes/config.php';

// Mark a message as read if requested
if (isset($_GET['mark_read'])) {
    $stmt = $pdo->prepare("UPDATE contacts SET is_read = 1 WHERE id = ?");
    $stmt->execute([$_GET['mark_read']]);
    header('Location: contacts.php');
    exit;
}

// Delete a message if requested
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header('Location: contacts.php');
    exit;
}

// Get contacts
$stmt = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC");
$contacts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Contacts | CMS Admin Dashboard</title>
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
            <a class="flex items-center gap-3 px-4 py-2.5 mx-2 bg-emerald-50 text-emerald-800 rounded-lg font-inter text-sm font-medium" href="contacts.php">
                <span class="material-symbols-outlined" data-icon="email">email</span>
                <span>Contacts</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-2.5 mx-2 text-slate-600 hover:bg-slate-50 transition-transform hover:translate-x-1 font-inter text-sm font-medium" href="profile.php">
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
                <h1 class="font-headline tracking-tight font-light text-emerald-800 text-xl">Contact Submissions</h1>
                <span class="text-[10px] uppercase tracking-widest text-gray-500">System / Messages</span>
            </div>
        </header>

        <!-- Content Canvas -->
        <div class="pt-28 pb-12 px-12 max-w-7xl flex-1">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-headline font-bold text-lg text-gray-800">Inbox</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-8 py-4 text-[11px] font-semibold uppercase tracking-widest text-gray-500">Details</th>
                                <th class="px-6 py-4 text-[11px] font-semibold uppercase tracking-widest text-gray-500">Inquiry & Budget</th>
                                <th class="px-6 py-4 text-[11px] font-semibold uppercase tracking-widest text-gray-500">Date received</th>
                                <th class="px-8 py-4 text-[11px] font-semibold uppercase tracking-widest text-gray-500 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if (empty($contacts)): ?>
                                <tr><td colspan="4" class="px-8 py-6 text-center text-gray-500">No contact messages yet.</td></tr>
                            <?php else: ?>
                                <?php foreach ($contacts as $contact): ?>
                                    <tr class="hover:bg-emerald-50/50 transition-colors <?= $contact['is_read'] ? 'opacity-75' : 'bg-white font-semibold' ?>">
                                        <td class="px-8 py-6">
                                            <div class="flex items-start gap-4">
                                                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                                                    <?= strtoupper(substr($contact['full_name'], 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-900"><?= htmlspecialchars($contact['full_name']) ?> &middot; <a href="mailto:<?= htmlspecialchars($contact['email']) ?>" class="text-emerald-600 font-normal hover:underline"><?= htmlspecialchars($contact['email']) ?></a></p>
                                                    <p class="text-sm mt-1 font-normal text-gray-600 max-w-md line-clamp-2"><?= nl2br(htmlspecialchars($contact['message'])) ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 text-sm text-gray-500">
                                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium inline-block mb-2">
                                                <?= htmlspecialchars($contact['inquiry_type']) ?>
                                            </span>
                                            <br>
                                            <?php if (!empty($contact['price_range'])): ?>
                                            <span class="bg-emerald-50 text-emerald-700 border border-emerald-100 px-3 py-1 rounded-full text-[10px] font-bold inline-block">
                                                <?= htmlspecialchars($contact['price_range']) ?>
                                            </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-6 text-sm text-gray-500 font-normal">
                                            <?= date('M j, Y g:i A', strtotime($contact['created_at'])) ?>
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <div class="flex justify-end gap-2">
                                                <?php if (!$contact['is_read']): ?>
                                                    <a href="?mark_read=<?= $contact['id'] ?>" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded" title="Mark as Read">
                                                        <span class="material-symbols-outlined text-xl" data-icon="check_circle">check_circle</span>
                                                    </a>
                                                <?php endif; ?>
                                                <a href="?delete=<?= $contact['id'] ?>" class="p-2 text-red-500 hover:bg-red-50 rounded" onclick="return confirm('Delete this message?')" title="Delete">
                                                    <span class="material-symbols-outlined text-xl" data-icon="delete">delete</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
