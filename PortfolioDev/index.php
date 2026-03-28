<?php
require 'includes/config.php';
$stmt = $pdo->query("SELECT * FROM projects WHERE status = 'Live' ORDER BY created_at DESC");
$projects = $stmt->fetchAll();

// Fetch admin CV file
$admin_stmt = $pdo->query("SELECT cv_file FROM users LIMIT 1");
$admin = $admin_stmt->fetch();
$cv_file = $admin['cv_file'] ?? null;
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Josephlab.dev | Lead Josephlab Portfolio</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
       tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "#000000ff",
              "on-primary": "#dcfffa",
              "primary-container": "#c7e9e5",
              "surface": "#f8f9fa",
              "on-surface": "#2b3437",
              "on-background": "#2b3437",
              "surface-container-low": "#f1f4f6",
              "outline-variant": "#abb3b7",
              "secondary-container": "#e2e3e1",
              "on-secondary-fixed": "#3e403f",
              "on-surface-variant": "#586064",
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
    body {font-family: 'Inter', sans-serif; background-color: #f8f9fa; color: #2b3437; scroll-behavior: smooth; min-height: 100vh; }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    .headline-font { font-family: 'Manrope', sans-serif; }
    .white-space-trap { margin-left: clamp(1rem, 15vw, 5.5rem); }
</style>
</head>
<body class="bg-surface text-on-background selection:bg-primary-container selection:text-on-primary-container">
<!-- TopAppBar -->
<header class="fixed top-0 w-full z-50 bg-slate-50/80 backdrop-blur-xl shadow-sm h-20">
<nav class="flex justify-between items-center max-w-7xl mx-auto px-8 h-full">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-emerald-800" data-icon="terminal">terminal</span>
<span class="text-xl font-bold tracking-tighter text-emerald-900 headline-font">Josephlab.dev</span>
</div>
<div class="hidden md:flex gap-10 items-center font-manrope tracking-tight font-light">
<a class="text-emerald-700 font-semibold border-b-2 border-emerald-700 py-1 transition-colors" href="index.php">Home</a>
<a class="text-slate-500 hover:text-emerald-600 transition-colors py-1" href="#projects">Projects</a>
<a class="text-slate-500 hover:text-emerald-600 transition-colors py-1" href="contact.php">Contact</a>
</div>
<a href="contact.php" class="bg-primary text-on-primary px-6 py-2 rounded-lg hover:bg-[#395855] transition-colors duration-200 ease-in-out active:scale-95 headline-font font-medium inline-block">
    Contact
</a>
</nav>
</header>
<main class="pt-32">
<!-- Hero Section -->
<section class="min-h-[707px] flex flex-col justify-center px-8 mb-24 relative overflow-hidden">
<div class="absolute inset-0 -z-10 bg-gradient-to-br from-surface via-surface to-primary-container opacity-30" style="transform: skewY(-2deg); transform-origin: top left;"></div>
<div class="max-w-7xl mx-auto w-full">
<div class="white-space-trap">
<p class="font-label text-primary font-semibold tracking-widest uppercase mb-6 text-sm">Backend Systems</p>
<h1 class="font-headline text-6xl md:text-8xl font-extrabold tracking-tighter text-on-background leading-tight mb-8">
    Engineering <br/>Invisible <span class="text-primary italic">Logic.</span>
</h1>
<p class="font-body text-xl text-on-surface-variant max-w-2xl leading-relaxed">
    Building the high-performance foundations that power modern digital experiences. Specializing in distributed systems, API orchestration, and cloud-native infrastructure.
</p>
<div class="mt-12 flex gap-6">
<div class="bg-inverse-surface text-on-tertiary px-5 py-3 rounded-lg flex items-center gap-3">
<span class="material-symbols-outlined text-emerald-300" data-icon="terminal">terminal</span>
<code class="font-mono text-sm">npm install efficiency</code>
</div>
</div>
</div>
</div>
</section>

<!-- Projects List (Scroll-Focused) -->
<section class="py-24 space-y-48" id="projects">
    <?php if (empty($projects)): ?>
        <div class="max-w-7xl mx-auto px-8 text-center text-gray-500 text-xl font-light">
            No live projects found. Please add some via the admin dashboard.
        </div>
    <?php else: ?>
        <?php foreach ($projects as $index => $project): 
            $num = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
            $techs = array_map('trim', explode(',', $project['technologies']));
            // Alternate layout for odd/even
            $is_even = ($index % 2 != 0);
        ?>
            <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                <?php if ($is_even): ?>
                    <div class="lg:col-span-7 order-2 lg:order-1">
                        <a href="project_detail.php?id=<?= $project['id'] ?>" class="block bg-surface-container-low rounded-xl overflow-hidden shadow-sm aspect-video flex items-center justify-center p-8 group">
                            <?php if ($project['thumbnail_image']): ?>
                                <img src="<?= htmlspecialchars($project['thumbnail_image']) ?>" class="w-full h-full object-cover rounded-lg group-hover:scale-105 transition-transform duration-700 text-gray-400" alt="Thumbnail">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-gray-200 rounded-lg group-hover:scale-105 transition-transform duration-700 text-gray-400">
                                    <span class="material-symbols-outlined text-6xl">image</span>
                                </div>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endif; ?>

                <div class="<?= $is_even ? 'lg:col-span-5 order-1 lg:order-2' : 'lg:col-span-5 white-space-trap' ?>">
                    <span class="text-xs font-bold text-outline-variant tracking-widest uppercase mb-4 block">
                        <?= $num ?> / <?= htmlspecialchars($project['subtitle']) ?>
                    </span>
                    <h2 class="font-headline text-4xl font-bold mb-6 text-on-background"><?= htmlspecialchars($project['title']) ?></h2>
                    <p class="font-body text-lg text-on-surface-variant leading-relaxed mb-8">
                        <?= htmlspecialchars($project['description']) ?>
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach($techs as $tech): if(!$tech) continue; ?>
                            <span class="px-3 py-1 bg-secondary-container text-on-secondary-fixed text-xs font-medium rounded-full uppercase tracking-wider">
                                <?= htmlspecialchars($tech) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <a href="project_detail.php?id=<?= $project['id'] ?>" class="mt-10 group flex items-center gap-2 text-primary font-semibold hover:text-[#395855] transition-colors">
                        View Case Study 
                        <span class="material-symbols-outlined transition-transform group-hover:translate-x-1" data-icon="arrow_forward">arrow_forward</span>
                    </a>
                </div>

                <?php if (!$is_even): ?>
                    <div class="lg:col-span-7">
                        <a href="project_detail.php?id=<?= $project['id'] ?>" class="block bg-surface-container-low rounded-xl overflow-hidden shadow-sm aspect-video flex items-center justify-center p-8 group">
                             <?php if ($project['thumbnail_image']): ?>
                                <img src="<?= htmlspecialchars($project['thumbnail_image']) ?>" class="w-full h-full object-cover rounded-lg group-hover:scale-105 transition-transform duration-700 text-gray-400" alt="Thumbnail">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-gray-200 rounded-lg group-hover:scale-105 transition-transform duration-700 text-gray-400">
                                    <span class="material-symbols-outlined text-6xl">image</span>
                                </div>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<!-- Technical Philosophy Section -->
<section class="bg-surface-container-low py-32">
<div class="max-w-7xl mx-auto px-8">
<div class="grid grid-cols-1 md:grid-cols-2 gap-24 items-start">
<div class="white-space-trap">
<h3 class="font-headline text-5xl font-extrabold text-on-background mb-8 tracking-tighter">Structured <br/>Serenity.</h3>
<p class="font-body text-on-surface-variant text-lg leading-relaxed">
    I believe backend development is an art of reduction. Great system design isn't about how much you can add, but how much you can remove while maintaining absolute reliability.
</p>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
<div class="p-8 bg-surface-container-lowest rounded-xl">
<span class="material-symbols-outlined text-primary text-4xl mb-6" data-icon="code">code</span>
<h4 class="font-headline font-bold text-xl mb-3">Modular Design</h4>
<p class="text-on-surface-variant text-sm">Scalable components built for longevity and ease of maintenance.</p>
</div>
<div class="p-8 bg-surface-container-lowest rounded-xl">
<span class="material-symbols-outlined text-primary text-4xl mb-6" data-icon="speed">speed</span>
<h4 class="font-headline font-bold text-xl mb-3">Performance First</h4>
<p class="text-on-surface-variant text-sm">Optimization at the kernel level for maximum throughput.</p>
</div>
<div class="p-8 bg-surface-container-lowest rounded-xl">
<span class="material-symbols-outlined text-primary text-4xl mb-6" data-icon="security">security</span>
<h4 class="font-headline font-bold text-xl mb-3">Fortified Logic</h4>
<p class="text-on-surface-variant text-sm">Security-first mindset integrated into every line of code.</p>
</div>
<div class="p-8 bg-surface-container-lowest rounded-xl">
<span class="material-symbols-outlined text-primary text-4xl mb-6" data-icon="cloud_sync">cloud_sync</span>
<h4 class="font-headline font-bold text-xl mb-3">Cloud Native</h4>
<p class="text-on-surface-variant text-sm">Born in the cloud, designed for global elasticity.</p>
</div>
</div>
</div>
</div>
</section>

<!-- Contact Section -->
<section class="py-32" id="contact">
<div class="max-w-7xl mx-auto px-8 text-center">
<h2 class="font-headline text-5xl font-bold mb-8">Let's build the <span class="text-primary italic">next layer</span>.</h2>
<p class="font-body text-xl text-on-surface-variant max-w-xl mx-auto mb-12">
    Looking for a Lead Backend Developer to design your next mission-critical system? I'm currently open to selective collaborations.
</p>
<div class="flex flex-col md:flex-row justify-center gap-6 items-center">
<a href="contact.php" class="bg-primary text-on-primary px-10 py-4 rounded-lg font-headline font-bold text-lg hover:bg-[#395855] transition-all shadow-lg shadow-primary/10">
    Work with me
</a>
<a href="<?= !empty($cv_file) ? htmlspecialchars($cv_file) : '#' ?>" <?= !empty($cv_file) ? 'target="_blank" download' : '' ?> class="text-on-background font-headline font-semibold flex items-center gap-2 px-8 py-4 border border-outline-variant rounded-lg hover:bg-surface-container-low transition-all">
<span class="material-symbols-outlined" data-icon="description">description</span>
    Download CV
</a>
</div>
</div>
</section>
</main>
<!-- Footer -->
<footer class="w-full py-12 mt-24 bg-slate-100 font-inter text-xs uppercase tracking-widest">
<div class="flex flex-col md:flex-row justify-between items-center max-w-7xl mx-auto px-16">
<div class="text-emerald-900 opacity-60">
    © 2026 Built By JosephLab.dev.
</div>
<div class="flex gap-8 mt-6 md:mt-0">
<a class="text-slate-500 hover:text-emerald-700 transition-opacity" href="#">Github</a>
<a class="text-slate-500 hover:text-emerald-700 transition-opacity" href="#">LinkedIn</a>
<a class="text-slate-500 hover:text-emerald-700 transition-opacity" href="#">Source</a>
</div>
</div>
</footer>
</body></html>
