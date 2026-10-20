<?php $title = '2ème choix'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">
    <div class="card-modern">
        <div class="card-header-pastel"><?= e($title) ?></div>
        <div class="card-body">
            <?php if ($saved): ?>
                <div class="alert alert-success" role="alert">Le 2ème choix a été enregistré.</div>
            <?php endif; ?>
            <?php if ($error !== ''): ?>
                <div class="alert alert-danger" role="alert"><?= e($error) ?></div>
            <?php endif; ?>

            <form method="post" action="/parametres/secondChoice">
                <input type="hidden" name="token" value="<?= e($token) ?>">
                <?php foreach (['Breakfast' => 'Breakfast', 'lunch' => 'Lunch', 'diner' => 'Dinner'] as $field => $label): ?>
                    <div class="form-group">
                        <label for="<?= e($field) ?>"><?= e($label) ?></label>
                        <input type="text" class="form-control" id="<?= e($field) ?>"
                               name="<?= e($field) ?>" maxlength="1000" value="<?= e($values[$field]) ?>">
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
