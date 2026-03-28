<?php
require 'auth.php';
require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $subtitle = $_POST['subtitle'] ?? '';
    $description = $_POST['description'] ?? '';
    $challenge_content = $_POST['challenge_content'] ?? '';
    $thumbnail_image = '';
    if (isset($_FILES['thumbnail_image']) && $_FILES['thumbnail_image']['error'] === UPLOAD_ERR_OK) {
        if (!is_dir('uploads')) mkdir('../uploads', 0777, true);
        $thumbnail_image = 'uploads/' . time() . '_' . basename($_FILES['thumbnail_image']['name']);
        move_uploaded_file($_FILES['thumbnail_image']['tmp_name'], '../' . $thumbnail_image);
    }
    
    $detail_image = '';
    if (isset($_FILES['detail_image']) && $_FILES['detail_image']['error'] === UPLOAD_ERR_OK) {
        if (!is_dir('uploads')) mkdir('../uploads', 0777, true);
        $detail_image = 'uploads/' . time() . '_' . basename($_FILES['detail_image']['name']);
        move_uploaded_file($_FILES['detail_image']['tmp_name'], '../' . $detail_image);
    }
    $status = $_POST['status'] ?? 'Draft';
    $technologies = $_POST['technologies'] ?? '';
    $demo_link = $_POST['demo_link'] ?? '';
    $repo_link = $_POST['repo_link'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO projects (title, subtitle, description, challenge_content, thumbnail_image, detail_image, status, technologies, demo_link, repo_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $subtitle, $description, $challenge_content, $thumbnail_image, $detail_image, $status, $technologies, $demo_link, $repo_link]);
    
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Add Project - Josephlab.dev CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Inter:wght@300..700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
</head>
<body class="bg-gray-50 text-gray-800 font-['Inter']">
    <header class="bg-white shadow-sm border-b border-gray-200 h-16 flex items-center px-8">
        <a href="dashboard.php" class="flex items-center gap-2 text-emerald-800 font-['Manrope'] font-bold text-lg hover:underline"><span class="material-symbols-outlined">arrow_back</span> Back to Dashboard</a>
    </header>

    <div class="max-w-4xl mx-auto py-12 px-6">
        <h1 class="text-3xl font-bold font-['Manrope'] text-emerald-900 mb-8">Add New Project</h1>
        
        <form method="POST" action="project_add.php" enctype="multipart/form-data" class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 space-y-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Title *</label>
                    <input type="text" name="title" required class="w-full rounded border-gray-300 border p-3 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Subtitle / Short Description *</label>
                    <input type="text" name="subtitle" required class="w-full rounded border-gray-300 border p-3 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Description (Frontend Intro)</label>
                <textarea name="description" rows="3" class="w-full rounded border-gray-300 border p-3 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20"></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Challenge Content (Detail Page Article HTML/Text)</label>
                <textarea name="challenge_content" rows="6" class="w-full rounded border-gray-300 border p-3 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Thumbnail Image</label>
                    <input type="file" accept="image/*" name="thumbnail_image" class="w-full rounded border-gray-300 border p-3 bg-gray-50 focus:bg-white">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Detail Image</label>
                    <input type="file" accept="image/*" name="detail_image" class="w-full rounded border-gray-300 border p-3 bg-gray-50 focus:bg-white">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Demo Link</label>
                    <input type="url" name="demo_link" class="w-full rounded border-gray-300 border p-3 bg-gray-50">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Repo Link</label>
                    <input type="url" name="repo_link" class="w-full rounded border-gray-300 border p-3 bg-gray-50">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full rounded border-gray-300 border p-3 bg-gray-50">
                        <option value="Draft">Draft</option>
                        <option value="Staging">Staging</option>
                        <option value="Live">Live</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Technologies (Comma separated)</label>
                    <input type="text" name="technologies" placeholder="e.g. React, Node.js, Docker" class="w-full rounded border-gray-300 border p-3 bg-gray-50">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3 px-8 rounded flex items-center gap-2">
                    <span class="material-symbols-outlined">save</span> Save Project
                </button>
            </div>
        </form>
    </div>
</body>
</html>
