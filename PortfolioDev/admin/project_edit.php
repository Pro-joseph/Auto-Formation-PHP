<?php
require 'auth.php';
require '../includes/config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $subtitle = $_POST['subtitle'] ?? '';
    $description = $_POST['description'] ?? '';
    $challenge_content = $_POST['challenge_content'] ?? '';
    $thumbnail_image = $_POST['existing_thumbnail_image'] ?? '';
    if (isset($_FILES['thumbnail_image']) && $_FILES['thumbnail_image']['error'] === UPLOAD_ERR_OK) {
        if (!is_dir('uploads')) mkdir('../uploads', 0777, true);
        $thumbnail_image = 'uploads/' . time() . '_' . basename($_FILES['thumbnail_image']['name']);
        move_uploaded_file($_FILES['thumbnail_image']['tmp_name'], '../' . $thumbnail_image);
    }
    
    $detail_image = $_POST['existing_detail_image'] ?? '';
    if (isset($_FILES['detail_image']) && $_FILES['detail_image']['error'] === UPLOAD_ERR_OK) {
        if (!is_dir('uploads')) mkdir('../uploads', 0777, true);
        $detail_image = 'uploads/' . time() . '_' . basename($_FILES['detail_image']['name']);
        move_uploaded_file($_FILES['detail_image']['tmp_name'], '../' . $detail_image);
    }
    $status = $_POST['status'] ?? 'Draft';
    $technologies = $_POST['technologies'] ?? '';
    $demo_link = $_POST['demo_link'] ?? '';
    $repo_link = $_POST['repo_link'] ?? '';

    $stmt = $pdo->prepare("UPDATE projects SET title=?, subtitle=?, description=?, challenge_content=?, thumbnail_image=?, detail_image=?, status=?, technologies=?, demo_link=?, repo_link=? WHERE id=?");
    $stmt->execute([$title, $subtitle, $description, $challenge_content, $thumbnail_image, $detail_image, $status, $technologies, $demo_link, $repo_link, $id]);
    
    header('Location: dashboard.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Edit Project - Josephlab.dev CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Inter:wght@300..700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
</head>
<body class="bg-gray-50 text-gray-800 font-['Inter']">
    <header class="bg-white shadow-sm border-b border-gray-200 h-16 flex items-center px-8">
        <a href="dashboard.php" class="flex items-center gap-2 text-emerald-800 font-['Manrope'] font-bold text-lg hover:underline"><span class="material-symbols-outlined">arrow_back</span> Back to Dashboard</a>
    </header>

    <div class="max-w-4xl mx-auto py-12 px-6">
        <h1 class="text-3xl font-bold font-['Manrope'] text-emerald-900 mb-8">Edit Project</h1>
        
        <form method="POST" action="project_edit.php?id=<?= $id ?>" enctype="multipart/form-data" class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 space-y-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Title *</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($project['title']) ?>" required class="w-full rounded border-gray-300 border p-3 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Subtitle / Short Description *</label>
                    <input type="text" name="subtitle" value="<?= htmlspecialchars($project['subtitle']) ?>" required class="w-full rounded border-gray-300 border p-3 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Description (Frontend Intro)</label>
                <textarea name="description" rows="3" class="w-full rounded border-gray-300 border p-3 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20"><?= htmlspecialchars($project['description']) ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Challenge Content (Detail Page Article HTML/Text)</label>
                <textarea name="challenge_content" rows="6" class="w-full rounded border-gray-300 border p-3 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500/20"><?= htmlspecialchars($project['challenge_content']) ?></textarea>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload New Thumbnail Image</label>
                    <?php if($project['thumbnail_image']): ?>
                        <img src="../<?= htmlspecialchars($project['thumbnail_image']) ?>" class="h-16 w-16 object-cover rounded mb-2 border">
                    <?php endif; ?>
                    <input type="hidden" name="existing_thumbnail_image" value="<?= htmlspecialchars($project['thumbnail_image']) ?>">
                    <input type="file" accept="image/*" name="thumbnail_image" class="w-full rounded border-gray-300 border p-2 bg-gray-50 focus:bg-white">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload New Detail Image</label>
                    <?php if($project['detail_image']): ?>
                        <img src="../<?= htmlspecialchars($project['detail_image']) ?>" class="h-16 w-32 object-cover rounded mb-2 border">
                    <?php endif; ?>
                    <input type="hidden" name="existing_detail_image" value="<?= htmlspecialchars($project['detail_image']) ?>">
                    <input type="file" accept="image/*" name="detail_image" class="w-full rounded border-gray-300 border p-2 bg-gray-50 focus:bg-white">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Demo Link</label>
                    <input type="url" name="demo_link" value="<?= htmlspecialchars($project['demo_link']) ?>" class="w-full rounded border-gray-300 border p-3 bg-gray-50">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Repo Link</label>
                    <input type="url" name="repo_link" value="<?= htmlspecialchars($project['repo_link']) ?>" class="w-full rounded border-gray-300 border p-3 bg-gray-50">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full rounded border-gray-300 border p-3 bg-gray-50">
                        <option value="Draft" <?= $project['status'] === 'Draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="Staging" <?= $project['status'] === 'Staging' ? 'selected' : '' ?>>Staging</option>
                        <option value="Live" <?= $project['status'] === 'Live' ? 'selected' : '' ?>>Live</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Technologies (Comma separated)</label>
                    <input type="text" name="technologies" value="<?= htmlspecialchars($project['technologies']) ?>" placeholder="e.g. React, Node.js, Docker" class="w-full rounded border-gray-300 border p-3 bg-gray-50">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3 px-8 rounded flex items-center gap-2">
                    <span class="material-symbols-outlined">save</span> Update Project
                </button>
            </div>
        </form>
    </div>
</body>
</html>
