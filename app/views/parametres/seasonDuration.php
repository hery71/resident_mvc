<?php
$title = 'Durée des saisons';
$custom_js = <<<'JS'
// Aucun script spécifique requis.
JS;
$custom_style = <<<'CSS'
.season-duration-table td,
.season-duration-table th {
    vertical-align: middle;
}
CSS;

$isEditing = !empty($seasonDuration);
$values = $seasonDuration ?: [
    'id' => 0,
    'annee' => (int)date('Y'),
    'winter' => 13,
    'spring' => 13,
    'summer' => 13,
    'fall' => 13,
    'enabled' => 1,
];

$messages = [
    'created' => ['success', 'Configuration enregistrée avec succès.'],
    'updated' => ['success', 'Configuration modifiée avec succès.'],
    'duplicate_year' => ['danger', 'Une configuration existe déjà pour cette année. Utilisez le bouton Modifier.'],
    'invalid_year' => ['danger', 'L’année doit être comprise entre 2000 et 2100.'],
    'invalid_weeks' => ['danger', 'Chaque durée doit être comprise entre 1 et 53 semaines.'],
];
?>

<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">
    <?php if (isset($messages[$message])): ?>
        <div class="alert alert-<?= e($messages[$message][0]) ?>" role="alert">
            <?= e($messages[$message][1]) ?>
        </div>
    <?php endif; ?>

    <div class="card-modern mb-4">
        <div class="card-header-pastel">
            <?= $isEditing ? 'Modifier la durée des saisons' : 'Ajouter la durée des saisons' ?>
        </div>
        <div class="card-body">
            <form method="post" action="/parametres/saveSeasonDuration">
                <input type="hidden" name="token" value="<?= e($token) ?>">
                <input type="hidden" name="id" value="<?= (int)$values['id'] ?>">

                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="annee">Année</label>
                        <input type="number" id="annee" name="annee" class="form-control"
                               min="2000" max="2100" required
                               value="<?= (int)$values['annee'] ?>">
                    </div>

                    <?php foreach (['winter' => 'Winter', 'spring' => 'Spring', 'summer' => 'Summer', 'fall' => 'Fall'] as $field => $label): ?>
                        <div class="col-md-2 mb-3">
                            <label for="<?= $field ?>"><?= $label ?></label>
                            <input type="number" id="<?= $field ?>" name="<?= $field ?>"
                                   class="form-control" min="1" max="53" required
                                   value="<?= (int)$values[$field] ?>">
                            <small class="form-text text-muted">Semaines</small>
                        </div>
                    <?php endforeach; ?>

                    <div class="col-md-2 mb-3">
                        <label for="enabled">État</label>
                        <select id="enabled" name="enabled" class="form-control">
                            <option value="1" <?= (int)$values['enabled'] === 1 ? 'selected' : '' ?>>Actif</option>
                            <option value="0" <?= (int)$values['enabled'] === 0 ? 'selected' : '' ?>>Inactif</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <?= $isEditing ? 'Enregistrer les modifications' : 'Ajouter' ?>
                </button>

                <?php if ($isEditing): ?>
                    <a href="/parametres/seasonDuration" class="btn btn-secondary">Annuler</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="card-modern">
        <div class="card-header-pastel">Configurations enregistrées</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm season-duration-table">
                    <thead>
                        <tr>
                            <th>Année</th>
                            <th>Winter</th>
                            <th>Spring</th>
                            <th>Summer</th>
                            <th>Fall</th>
                            <th>État</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($seasonDurations)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Aucune configuration enregistrée.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($seasonDurations as $row): ?>
                                <tr>
                                    <td><?= (int)$row['annee'] ?></td>
                                    <td><?= (int)$row['winter'] ?> semaines</td>
                                    <td><?= (int)$row['spring'] ?> semaines</td>
                                    <td><?= (int)$row['summer'] ?> semaines</td>
                                    <td><?= (int)$row['fall'] ?> semaines</td>
                                    <td>
                                        <?php if ((int)$row['enabled'] === 1): ?>
                                            <span class="badge badge-success">Actif</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Inactif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="/parametres/seasonDuration?edit=<?= (int)$row['id'] ?>"
                                           class="btn btn-sm btn-info">Modifier</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
