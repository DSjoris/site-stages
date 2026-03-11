<?php include "./includes/header.php"; ?>
<?php include "./includes/navbar.php"; ?>

<main>
    <div class="login-form">
        <form action="">
            <div class="input-field">
                <label for="email" class="input-label">Email</label>
                <input type="text" name="email" class="input" autocomplete="off" placeholder="you@example.fr">
            </div>

            <div class="input-field">
                <label for="email" class="input-label">Mot de passe</label>
                <input type="password" name="password" class="input" placeholder="••••••••••••">
            </div>

            <p class="form-error">Identifiant invalide.</p>

            <button class="btn-primary">S'identifier</button>
        </form>
    </div>
</main>

<?php include "./includes/footer.php"; ?>
