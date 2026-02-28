<?php $title = "Ajouter un résident"; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-4">
    <div class="card-modern">
    <div class="card-header-pastel"><?= $title ?></div>
    <div class="card-body">
    <form method="post" action="/resident/store">
        <input type="hidden" name="token" value="<?= e($token) ?>">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label class="col-form-label">Gender</label>
                <select name="Gender" class="form-control">
                    <?php foreach ($options['Gender'] as $g): ?>
                        <option value="<?= e($g) ?>"><?= e($g) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Prénom *</label>
                <input type="text" name="Prenom" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <label>Nom *</label>
                <input type="text" name="Nom" class="form-control" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Date anniversaire</label>
                <input type="date" name="Anniversaire" class="form-control">
            </div>

            <div class="form-group col-md-4">
                <label>Date admission</label>
                <input type="date" name="Admission" class="form-control">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Téléphone 1</label>
                <input type="text" name="Tel1" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label>Téléphone 2</label>
                <input type="text" name="Tel2" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label>Téléphone 3</label>
                <input type="text" name="Tel3" class="form-control">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Famille</label>
                <input type="text" name="Famille" class="form-control">
            </div>

            <div class="form-group col-md-6">
                <label>Relation</label>
                <select name="Relation" class="form-control">
                    <?php foreach ($options['Relation'] as $g1): ?>
                        <option value="<?= e($g1) ?>"><?= e($g1) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button class="btn btn-info">Enregistrer</button>
        <a href="/resident" class="btn btn-secondary">Annuler</a>
    </form>
    </div>
    </div>
</div>  
</div> <!-- container -->
<?php require __DIR__ . '/../layout/footer.php'; ?>
