<?php
require 'includes/config.php';
$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) { header('Location: index.php'); exit; }
$techs = array_map('trim', explode(',', $project['technologies']));

// Get Next Project (for Next Case Study link)
$stmt2 = $pdo->prepare("SELECT * FROM projects WHERE id > ? AND status='Live' ORDER BY id ASC LIMIT 1");
$stmt2->execute([$id]);
$next_project = $stmt2->fetch();
if (!$next_project) {
    // Wrap around to first project
    $stmt3 = $pdo->query("SELECT * FROM projects WHERE status='Live' ORDER BY id ASC LIMIT 1");
    $next_project = $stmt3->fetch();
}

?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?= htmlspecialchars($project['title']) ?> - Josephlab.dev</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "#456461",
              "on-primary": "#dcfffa",
              "surface": "#f8f9fa",
              "on-surface": "#2b3437",
              "on-background": "#2b3437",
              "surface-container-low": "#f1f4f6",
              "surface-container-high": "#e3e9ec",
              "outline": "#737c7f",
              "secondary-container": "#e2e3e1",
              "on-secondary-container": "#505251",
              "on-surface-variant": "#586064",
              "inverse-surface": "#0c0f10",
              "on-primary-fixed-variant": "#42615e"
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
    body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; color: #2b3437; min-height: 100vh; }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; display: inline-block; vertical-align: middle; }
    .white-space-trap { margin-left: clamp(1rem, 15vw, 5.5rem); }
</style>
</head>
<body class="bg-surface text-on-background">
<!-- TopAppBar -->
<header class="fixed top-0 w-full z-50 bg-slate-50/80 backdrop-blur-xl shadow-sm">
<nav class="flex justify-between items-center max-w-7xl mx-auto px-8 h-20">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-emerald-800" data-icon="terminal">terminal</span>
<span class="text-xl font-bold tracking-tighter text-emerald-900 font-headline">Josephlab.dev</span>
</div>
<div class="hidden md:flex items-center gap-8 font-manrope tracking-tight font-light">
<a class="text-slate-500 hover:text-emerald-600 transition-colors" href="index.php">Home</a>
<a class="text-emerald-700 font-semibold border-b-2 border-emerald-700" href="index.php#projects">Projects</a>
<a class="text-slate-500 hover:text-emerald-600 transition-colors" href="contact.php">Contact</a>
</div>
<a href="contact.php" class="bg-primary text-on-primary px-6 py-2 rounded-md font-headline text-sm font-semibold hover:bg-[#395855] transition-all inline-block">
    Contact
</a>
</nav>
</header>
<main class="pt-32 pb-24 max-w-7xl mx-auto px-8">
<!-- Project Hero Section -->
<section class="mb-24">
<div class="white-space-trap mb-8">
<span class="text-primary font-label text-xs uppercase tracking-[0.2em] mb-4 block">Case Study: <?= htmlspecialchars($project['subtitle']) ?></span>
<h1 class="text-5xl md:text-7xl font-headline font-extrabold tracking-tighter leading-tight max-w-4xl">
    <?= htmlspecialchars($project['title']) ?>
</h1>
</div>
<div class="relative w-full aspect-[21/9] rounded-xl overflow-hidden mb-12 bg-surface-container-low shadow-sm">
    <?php if ($project['detail_image']): ?>
        <img src="<?= htmlspecialchars($project['detail_image']) ?>" class="w-full h-full object-cover">
    <?php else: ?>
        <div class="w-full h-full flex items-center justify-center bg-gray-200">
            <span class="material-symbols-outlined text-gray-400 text-6xl">image</span>
        </div>
    <?php endif; ?>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
<!-- Project Meta -->
<div class="lg:col-span-4 space-y-12">
<div>
<h3 class="text-xs font-label uppercase tracking-widest text-outline mb-6">Core Objectives</h3>
<ul class="space-y-4 font-body text-on-surface-variant leading-relaxed">
    <li class="flex items-start gap-3">
        <span class="material-symbols-outlined text-primary text-sm mt-1" data-icon="check_circle">check_circle</span>
        <span><?= htmlspecialchars($project['description']) ?></span>
    </li>
    <!-- Dynamic objectives not fully implemented in schema but could be added, just showing description for now -->
</ul>
</div>
<div>
<h3 class="text-xs font-label uppercase tracking-widest text-outline mb-6">Technologies</h3>
<div class="flex flex-wrap gap-2">
    <?php foreach($techs as $tech): if(!$tech) continue; ?>
        <span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-xs font-medium"><?= htmlspecialchars($tech) ?></span>
    <?php endforeach; ?>
</div>
</div>
<div class="flex flex-col gap-4 pt-4">
    <?php if ($project['demo_link']): ?>
        <a href="<?= htmlspecialchars($project['demo_link']) ?>" target="_blank" class="flex items-center justify-center gap-3 bg-primary text-on-primary py-4 px-8 rounded-lg font-headline font-bold hover:bg-[#395855] transition-all group">
            <span>View Live Demo</span>
            <span class="material-symbols-outlined transition-transform group-hover:translate-x-1" data-icon="arrow_forward">arrow_forward</span>
        </a>
    <?php endif; ?>
    <?php if ($project['repo_link']): ?>
        <a href="<?= htmlspecialchars($project['repo_link']) ?>" target="_blank" class="flex items-center justify-center gap-3 bg-surface-container-low text-primary py-4 px-8 rounded-lg font-headline font-bold hover:bg-surface-container-high transition-all">
            <span class="material-symbols-outlined" data-icon="code">code</span>
            <span>GitHub Repository</span>
        </a>
    <?php endif; ?>
</div>
</div>

<!-- Project Content -->
<div class="lg:col-span-8 space-y-16">
<article class="prose prose-slate max-w-none text-on-surface-variant font-body leading-relaxed text-lg">
    <!-- Challenge Content -->
    <?php if ($project['challenge_content']): ?>
        <?= ($project['challenge_content']) ?> <!-- Already raw HTML in schema -->
    <?php else: ?>
        <p class="text-lg">No detailed content available for this project yet.</p>
    <?php endif; ?>
</article>
</div>
</div>
</section>

<!-- Next Navigation -->
<?php if ($next_project && $next_project['id'] != $project['id']): ?>
<section class="mt-32 pt-24 border-t border-gray-200">
<div class="flex flex-col md:flex-row justify-between items-end gap-8">
<div>
<span class="text-primary font-label text-xs uppercase tracking-[0.2em] mb-4 block">Next Case Study</span>
<h2 class="text-4xl font-headline font-bold tracking-tight"><?= htmlspecialchars($next_project['title']) ?></h2>
</div>
<a href="project_detail.php?id=<?= $next_project['id'] ?>" class="group flex items-center gap-4 text-primary font-headline font-bold text-xl hover:text-[#395855]">
    View Project 
    <span class="material-symbols-outlined transition-transform group-hover:translate-x-2" data-icon="east">east</span>
</a>
</div>
</section>
<?php endif; ?>
</main>

<!-- Footer -->
<footer class="w-full py-12 mt-24 bg-slate-100 font-inter text-xs uppercase tracking-widest">
<div class="flex flex-col md:flex-row justify-between items-center max-w-7xl mx-auto px-16">
<div class="text-emerald-900 opacity-80">© 2024 Digital Curator. Built with logic.</div>
<div class="flex gap-8 mt-8 md:mt-0">
<a class="text-slate-500 hover:text-emerald-700 transition-opacity" href="#">Github</a>
<a class="text-slate-500 hover:text-emerald-700 transition-opacity" href="#">LinkedIn</a>
<a class="text-slate-500 hover:text-emerald-700 transition-opacity" href="#">Source</a>
</div></div>
</footer>
</body></html>
