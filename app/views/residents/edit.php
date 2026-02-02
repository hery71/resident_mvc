<?php $title = "Modifier résident"; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">
    <h4>Modifier le résident</h4>

    <form method="post" action="/resident/update/<?= $resident['id'] ?>">

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Prénom</label>
                <input type="text" name="Prenom"
                       class="form-control"
                       value="<?= e($resident['Prenom']) ?>">
            </div>

            <div class="form-group col-md-6">
                <label>Nom</label>
                <input type="text" name="Nom"
                       class="form-control"
                       value="<?= e($resident['Nom']) ?>">
            </div>
        </div>

        <div class="form-group">
            <label>Date anniversaire</label>
            <input type="date" name="Anniversaire"
                   class="form-control"
                   value="<?= e($resident['Anniversaire']) ?>">
        </div>

        <div class="form-group">
            <label>Famille</label>
            <input type="text" name="Famille"
                   class="form-control"
                   value="<?= e($resident['Famille']) ?>">
        </div>

        <div class="form-row">
            <div class="form-group col">
                <label>Tél 1</label>
                <input type="text" name="Tel1"
                       class="form-control"
                       value="<?= e($resident['Tel1']) ?>">
            </div>
            <div class="form-group col">
                <label>Tél 2</label>
                <input type="text" name="Tel2"
                       class="form-control"
                       value="<?= e($resident['Tel2']) ?>">
            </div>
            <div class="form-group col">
                <label>Tél 3</label>
                <input type="text" name="Tel3"
                       class="form-control"
                       value="<?= e($resident['Tel3']) ?>">
            </div>
        </div>

        <div class="form-group">
            <label>Chambre</label>
            <input type="text" name="Chambre"
                   class="form-control"
                   value="<?= e($resident['Chambre']) ?>">
        </div>

        <button class="btn btn-success">💾 Enregistrer</button>
        <a href="/resident" class="btn btn-secondary">↩ Retour</a>
    </form>
</div>
</div> <!-- container -->
<?php require __DIR__ . '/../layout/footer.php'; ?>
