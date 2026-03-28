<?php
require 'auth.php';
require '../includes/config.php';

// Get counts
$stmt = $pdo->query("SELECT COUNT(*) FROM projects WHERE status IN ('Staging', 'Draft')");
$pending_count = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM projects");
$total_count = $stmt->fetchColumn();

// Get projects
$stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
$projects = $stmt->fetchAll();

// Get recent contacts
$stmt = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5");
$recent_contacts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Josephlab.dev | CMS Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
          tailwind.config = {
            darkMode: "class",
            theme: {
              extend: {
                colors: {
                  "primary": "#456461",
                  "on-primary": "#dcfffa",
                  "primary-container": "#c7e9e5",
                  "on-primary-container": "#385754",
                  "surface": "#f8f9fa",
                  "on-surface": "#2b3437",
                  "on-background": "#2b3437",
                  "surface-container-lowest": "#ffffff",
                  "surface-container-low": "#f1f4f6",
                  "surface-container": "#eaeff1",
                  "outline": "#737c7f",
                  "outline-variant": "#abb3b7",
                  "error": "#9f403d",
                  "inverse-surface": "#0c0f10",
                  "on-tertiary": "#f6f9ff"
                },
                fontFamily: {
                  "headline": ["Manrope"],
                  "body": ["Inter"],
                  "label": ["Inter"]
                }
              }
            }
          }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
        body { background-color: #f8f9fa; color: #2b3437; font-family: 'Inter', sans-serif; min-height: 100vh; }
    </style>
</head>
<body class="bg-surface text-on-background">
    <!-- Sidebar -->
    <aside class="h-screen w-64 fixed left-0 top-0 border-r border-slate-100 bg-white flex flex-col py-6 gap-2 z-40">
        <a href="../index.php" class="px-6 mb-8 flex items-center gap-3 hover:opacity-80 transition-opacity" title="Back to Main Site">
            <span class="material-symbols-outlined text-emerald-700 text-2xl" data-icon="terminal">terminal</span>
            <span class="text-lg font-black text-emerald-800 font-headline">Josephlab.dev</span>
        </a>
        <div class="px-6 mb-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center overflow-hidden">
                    <span class="material-symbols-outlined text-primary">person</span>
                </div>
                <div>
                    <p class="font-inter text-sm font-bold text-on-background leading-tight"><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></p>
                    <p class="font-inter text-xs text-outline">CMS Administrator</p>
                </div>
            </div>
        </div>
        <nav class="flex-1 space-y-1">
            <a class="flex items-center gap-3 px-4 py-2.5 mx-2 bg-emerald-50 text-emerald-800 rounded-lg font-inter text-sm font-medium" href="dashboard.php">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span>Projects Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-2.5 mx-2 text-slate-600 hover:bg-slate-50 transition-transform hover:translate-x-1 font-inter text-sm font-medium" href="contacts.php">
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
                <h1 class="font-headline tracking-tight font-light text-emerald-800 text-xl">Projects Management</h1>
                <span class="text-[10px] font-label uppercase tracking-widest text-outline">System / Repository / Main</span>
            </div>
            <div class="flex items-center gap-6">
                <a href="project_add.php" class="bg-primary text-on-primary px-5 py-2 rounded-lg flex items-center gap-2 hover:bg-[#395855] transition-colors shadow-sm text-sm font-medium">
                    <span class="material-symbols-outlined text-sm" data-icon="add">add</span>
                    <span>Add New Project</span>
                </a>
            </div>
        </header>

        <!-- Content Canvas -->
        <div class="pt-28 pb-12 px-12 max-w-7xl flex-1">
            <!-- Statistics Row -->
            <div class="grid grid-cols-12 gap-6 mb-12">
                <div class="col-span-12 md:col-span-8 bg-surface-container-lowest p-8 rounded-xl shadow-sm border border-gray-100 flex justify-between items-end overflow-hidden relative">
                    <div class="z-10">
                        <p class="text-xs uppercase tracking-widest text-outline mb-1 font-label">Total Projects</p>
                        <h2 class="text-4xl font-headline font-extrabold text-primary mb-2"><?= $total_count ?></h2>
                        <p class="text-sm text-outline"><?= $pending_count ?> projects pending final staging approval.</p>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-4 bg-inverse-surface p-8 rounded-xl text-on-tertiary shadow-lg">
                    <p class="text-xs uppercase tracking-widest text-gray-400 mb-4 font-label">Server Health</p>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-lg bg-white/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-emerald-400" data-icon="bolt">bolt</span>
                        </div>
                        <div>
                            <p class="text-lg font-headline font-bold">99.9%</p>
                            <p class="text-xs text-gray-400">Uptime this month</p>
                        </div>
                    </div>
                    <div class="w-full bg-white/10 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-400 h-full w-[99%]"></div>
                    </div>
                </div>
            </div>

            <!-- Recent Contacts Widget -->
            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-12">
                <div class="px-8 py-6 border-b border-surface-container-low flex justify-between items-center bg-surface-container-lowest">
                    <h3 class="font-headline font-bold text-on-background">Recent Inquiries</h3>
                    <a href="contacts.php" class="text-[13px] font-bold text-primary hover:underline flex items-center gap-1">View All <span class="material-symbols-outlined text-[16px]">arrow_forward</span></a>
                </div>
                <div class="divide-y divide-surface-container-low">
                    <?php if (empty($recent_contacts)): ?>
                        <div class="p-8 text-center text-outline text-sm">No new inquiries.</div>
                    <?php else: ?>
                        <?php foreach ($recent_contacts as $contact): ?>
                            <div class="p-6 flex items-start gap-4 hover:bg-primary-container/10 transition-colors <?= $contact['is_read'] ? 'opacity-75' : '' ?>">
                                <div class="w-10 h-10 rounded-full bg-primary-container text-primary flex items-center justify-center font-bold flex-shrink-0">
                                    <?= strtoupper(substr($contact['full_name'], 0, 1)) ?>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start mb-1">
                                        <p class="text-sm text-on-background font-bold truncate"><?= htmlspecialchars($contact['full_name']) ?> <span class="text-outline font-normal ml-2"><?= htmlspecialchars($contact['email']) ?></span></p>
                                        <p class="text-xs text-outline whitespace-nowrap ml-4"><?= date('M j, g:i A', strtotime($contact['created_at'])) ?></p>
                                    </div>
                                    <p class="text-sm text-outline truncate"><?= htmlspecialchars($contact['message']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Management Table -->
            <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-surface-container-low flex justify-between items-center bg-surface-container-lowest">
                    <div class="flex items-center gap-4">
                        <h3 class="font-headline font-bold text-on-background">All Projects</h3>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low">
                                <th class="px-8 py-4 text-[11px] font-label uppercase tracking-widest text-outline">Project Details</th>
                                <th class="px-6 py-4 text-[11px] font-label uppercase tracking-widest text-outline">Stack</th>
                                <th class="px-6 py-4 text-[11px] font-label uppercase tracking-widest text-outline">Status</th>
                                <th class="px-6 py-4 text-[11px] font-label uppercase tracking-widest text-outline">Last Modified</th>
                                <th class="px-8 py-4 text-[11px] font-label uppercase tracking-widest text-outline text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container-low">
                            <?php if (empty($projects)): ?>
                                <tr><td colspan="5" class="px-8 py-6 text-center text-outline">No projects found. Create one!</td></tr>
                            <?php else: ?>
                                <?php foreach ($projects as $project): ?>
                                    <tr class="hover:bg-primary-container/10 transition-colors group">
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded bg-surface-container flex-shrink-0 overflow-hidden">
                                                    <?php if ($project['thumbnail_image']): ?>
                                                        <img src="../<?= htmlspecialchars($project['thumbnail_image']) ?>" class="w-full h-full object-cover">
                                                    <?php else: ?>
                                                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                                            <span class="material-symbols-outlined text-gray-400">image</span>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    <p class="font-headline font-bold text-on-background group-hover:text-primary transition-colors"><?= htmlspecialchars($project['title']) ?></p>
                                                    <p class="text-xs text-outline font-inter"><?= htmlspecialchars($project['subtitle']) ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 text-sm text-outline">
                                            <?= htmlspecialchars($project['technologies']) ?>
                                        </td>
                                        <td class="px-6 py-6">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-surface-container text-outline">
                                                <?= htmlspecialchars($project['status']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-6 text-sm text-outline">
                                            <?= date('M j, Y', strtotime($project['updated_at'])) ?>
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <div class="flex justify-end gap-2">
                                                <a href="project_edit.php?id=<?= $project['id'] ?>" class="p-2 text-outline hover:text-primary rounded">
                                                    <span class="material-symbols-outlined text-xl" data-icon="edit">edit</span>
                                                </a>
                                                <a href="project_delete.php?id=<?= $project['id'] ?>" class="p-2 text-outline hover:text-error rounded" onclick="return confirm('Delete this project?')">
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
