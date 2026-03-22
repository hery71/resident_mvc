<?php
$dateFete = date(
    'Y-m-d',
    strtotime($cake['annee'] . '-' . date('m-d', strtotime($cake['Anniversaire'])))
);
$title = "Editer Commande de gâteau"; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-4">
    <div class="card-modern">
    <div class="card-header-pastel"><?= $title ?></div>
    <div class="card-body">

    <p>
        Résident :
        <strong><?= e($cake['Prenom']) ?> <?= e($cake['Nom']) ?></strong>
        (<?= e($cake['annee']) ?>)
    </p>
     <p>
        Date fete :
        <strong><?= e((new DateTime($cake['date']))->format('d/m/Y')) ?></strong>
    </p>

    <form method="post" action="/cake/store">
        <input type="hidden" name="token" value="<?= e($token) ?>">
        <input type="hidden" name="idResident" value="<?= e($cake['idResident']) ?>">
        <input type="hidden" name="annee" value="<?= e($cake['annee']) ?>">
        <input type="hidden" name="dateAnniversaire" value="<?= e($cake['dateAnniversaire']) ?>">
        <div class="form-group">
            <label>Date livraison</label>
            <input type="date" name="dateLivraison" class="form-control" value ="<?= e($cake['dateLivraison']) ?>" required>
        </div>

        <div class="form-group">
            <label>Message sur le gâteau</label>
            <input type="text" name="message" value="<?= e($cake['message']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label>Couleur</label>
            <select name="couleur" class="form-control">
            <?php foreach ($options['Couleur'] as $h): ?>
                        <option value="<?= e($h)?>"<?= $h==$cake['couleur']?' selected':''; ?>><?= e($h) ?></option>
                    <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Observation</label>
            <textarea name="observation" class="form-control"><?= e($cake['observation'] ?? '') ?></textarea>
        </div>
        <button class="btn btn-info">Enregistrer la commande</button>
        <a href="/birthday" class="btn btn-secondary">Retour</a>
    </form>
</div>
</div>
</div>
</div> <!-- container -->
<?php require __DIR__ . '/../layout/footer.php'; ?>
