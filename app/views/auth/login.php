<?php $title = 'Connexion'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h4 class="text-center mb-3">
                <?= e($GLOBALS['organisation_name'] ?? '') ?>
            </h4>
            <div class="card">
                <div class="card-body">
                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?= e($_SESSION['error']) ?>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>
                    <form method="post" action="/auth/authenticate">
                        <input type="hidden" name="token" value="<?= e($token ?? '') ?>">
                        <div class="form-group">
                            <label>Login ou Email</label>
                            <input type="text" name="login" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Mot de passe</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button class="btn btn-primary btn-block">
                            Connexion
                        </button>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div> <!-- container -->
<?php require __DIR__ . '/../layout/footer.php'; ?>