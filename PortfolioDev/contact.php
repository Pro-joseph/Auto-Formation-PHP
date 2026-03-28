<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Contact | Josephlab.dev</title>
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
              "primary-container": "#c7e9e5",
              "surface": "#f8f9fa",
              "on-surface": "#2b3437",
              "on-background": "#2b3437",
              "surface-container-lowest": "#ffffff",
              "surface-container-low": "#f1f4f6",
              "outline-variant": "#abb3b7",
              "outline": "#737c7f",
              "inverse-surface": "#0c0f10",
              "primary-dim": "#395855"
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
    .text-glow { text-shadow: 0 0 20px rgba(69, 100, 97, 0.1); }
</style>
</head>
<body class="bg-surface text-on-background">
<!-- TopAppBar -->
<header class="fixed top-0 w-full z-50 bg-slate-50/80 backdrop-blur-xl shadow-sm">
<nav class="flex justify-between items-center max-w-7xl mx-auto px-8 h-20">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-emerald-800" data-icon="terminal">terminal</span>
<span class="text-xl font-bold tracking-tighter text-emerald-900 font-headline">Josephlab.dev</span>
</div>
<div class="hidden md:flex items-center gap-8 font-manrope tracking-tight font-light">
<a class="text-slate-500 hover:text-emerald-600 transition-colors" href="index.php">Home</a>
<a class="text-slate-500 hover:text-emerald-600 transition-colors" href="index.php#projects">Projects</a>
<a class="text-emerald-700 font-semibold border-b-2 border-emerald-700" href="#">Contact</a>
</div>
<a href="contact.php" class="bg-primary text-on-primary px-6 py-2 rounded-md font-medium hover:bg-primary-dim transition-all scale-95 duration-200 ease-in-out font-headline inline-block">
    Contact
</a>
</nav>
</header>
<main class="pt-32 pb-24 px-8 max-w-7xl mx-auto overflow-hidden">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
<!-- Left Column -->
<div class="lg:col-span-5 space-y-12">
<div class="space-y-4 ml-0 lg:ml-16">
<span class="text-primary font-label text-sm uppercase tracking-widest font-semibold">Inquiries</span>
<h1 class="text-6xl font-headline font-extrabold tracking-tighter text-on-background leading-none">
    Let's build <br/>
    <span class="text-emerald-700">something logical.</span>
</h1>
<p class="text-gray-600 text-lg max-w-md font-light leading-relaxed pt-4">
    Whether it's a backend systems review, a cloud migration strategy, or a specialized implementation, I'm ready to translate your requirements into clean, scalable code.
</p>
</div>
<div class="grid grid-cols-1 gap-4 ml-0 lg:ml-16">
<div class="group p-6 bg-surface-container-low rounded-xl transition-all hover:bg-primary-container">
<div class="flex items-center gap-4">
<div class="p-3 bg-surface-container-lowest rounded-lg">
<span class="material-symbols-outlined text-primary" data-icon="alternate_email">alternate_email</span>
</div>
<div>
<p class="text-xs uppercase tracking-widest text-outline font-bold">Primary Email</p>
<p class="text-on-background font-medium">hello@josephlab.dev</p>
</div>
</div>
</div>
</div>
<div class="flex items-center gap-6 ml-0 lg:ml-16 pt-4">
<a class="flex items-center gap-2 text-gray-600 hover:text-primary transition-colors font-medium" href="#">
<span class="material-symbols-outlined" data-icon="code">code</span> Github
</a>
<a class="flex items-center gap-2 text-gray-600 hover:text-primary transition-colors font-medium" href="#">
<span class="material-symbols-outlined" data-icon="hub">hub</span> LinkedIn
</a>
</div>
</div>

<!-- Right Column: Form -->
<div class="lg:col-span-7">
<div class="bg-surface-container-lowest p-10 lg:p-16 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden">
<?php if (isset($_GET['success'])): ?>
    <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center gap-3 text-emerald-800">
        <span class="material-symbols-outlined">check_circle</span>
        <span>Initialize connection successful. Your message has been routed.</span>
    </div>
<?php endif; ?>
<?php if (isset($_GET['error'])): ?>
    <div class="mb-8 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3 text-red-800">
        <span class="material-symbols-outlined">error</span>
        <span>A payload error occurred. Please ensure all text nodes are populated.</span>
    </div>
<?php endif; ?>

<form action="contact_process.php" method="POST" class="relative space-y-8 z-10">
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
<div class="space-y-2">
<label class="block text-xs uppercase tracking-widest font-bold text-outline" for="name">Full Name</label>
<input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-4 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all placeholder:text-outline-variant" id="name" name="name" placeholder="John Doe" type="text" required />
</div>
<div class="space-y-2">
<label class="block text-xs uppercase tracking-widest font-bold text-outline" for="email">Email Address</label>
<input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-4 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all placeholder:text-outline-variant" id="email" name="email" placeholder="john@example.com" type="email" required />
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
<div class="space-y-2">
<label class="block text-xs uppercase tracking-widest font-bold text-outline" for="subject">Inquiry Type</label>
<select class="w-full bg-surface-container-low border-none rounded-lg px-4 py-4 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-gray-700" id="subject" name="subject">
<option>Project Collaboration</option>
<option>Consulting Inquiry</option>
<option>Speaking Engagement</option>
<option>Other</option>
</select>
</div>
<div class="space-y-2">
<label class="block text-xs uppercase tracking-widest font-bold text-outline" for="price_range">Project Budget</label>
<select class="w-full bg-surface-container-low border-none rounded-lg px-4 py-4 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-gray-700" id="price_range" name="price_range">
<option value="3000 - 5000 dh">3000 et 5000 dh</option>
<option value="5000 - 7000 dh">5000 et 7000 dh</option>
<option value="7000 - 10000 dh">7000 et 10000 dh</option>
</select>
</div>
</div>
<div class="space-y-2">
<label class="block text-xs uppercase tracking-widest font-bold text-outline" for="message">Message Body</label>
<textarea class="w-full bg-surface-container-low border-none rounded-lg px-4 py-4 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all placeholder:text-outline-variant resize-none" id="message" name="message" placeholder="Describe your technical needs..." rows="5" required></textarea>
</div>
<button class="w-full bg-primary text-on-primary py-5 rounded-lg font-headline font-bold text-lg tracking-tight hover:bg-primary-dim shadow-lg shadow-primary/10 transition-all flex items-center justify-center gap-3" type="submit">
    Initialize Connection
    <span class="material-symbols-outlined text-sm" data-icon="arrow_forward">arrow_forward</span>
</button>
</form>
</div>
<div class="mt-8 bg-inverse-surface rounded-xl p-6 font-mono text-sm overflow-hidden border border-gray-800">
<div class="flex gap-2 mb-4">
<div class="w-3 h-3 rounded-full bg-red-500/20"></div>
<div class="w-3 h-3 rounded-full bg-amber-500/20"></div>
<div class="w-3 h-3 rounded-full bg-emerald-500/20"></div>
</div>
<div class="text-gray-400 space-y-1">
<p class="text-emerald-500"><span class="text-gray-500">$</span> josephlab --status</p>
<p>&gt; System operational. Awaiting input.</p>
<p class="animate-pulse">_</p>
</div>
</div>
</div>
</div>
</main>
<!-- Footer -->
<footer class="w-full py-12 mt-24 bg-slate-100 font-inter text-xs uppercase tracking-widest">
<div class="flex flex-col md:flex-row justify-between items-center max-w-7xl mx-auto px-16">
<div class="text-gray-500">© 2024 Digital Curator. Built with logic.</div>
<div class="flex gap-8 mt-8 md:mt-0">
<a class="text-gray-400 hover:text-emerald-500 transition-opacity" href="#">Github</a>
<a class="text-gray-400 hover:text-emerald-500 transition-opacity" href="#">LinkedIn</a>
<a class="text-gray-400 hover:text-emerald-500 transition-opacity" href="#">Source</a>
</div>
</div>
</footer>
</body></html>
