<?php $pageTitle = 'Connexion'; ?>
<?php require_once __DIR__ . '../../layouts/header.php'; ?>

<div class="form-page">
    <h1>Connexion</h1>

    <?php if ($error !== ''): ?>
        <p class="alert alert-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>

    <p class="form-link">Pas encore de compte ? <a href="/php chalenges/surfo/register.php">S'inscrire</a></p>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
