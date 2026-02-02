<?php
$dateFete = date(
    'Y-m-d',
    strtotime($annee . '-' . date('m-d', strtotime($resident['Anniversaire'])))
);
$title = "Commande de gâteau"; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<?php 
    //definition de la couleur par defaut
    $xcolor ="Bleu";
    if($resident['Gender'] =="Femme"){
        $xcolor ="Rose";
    }
    //var_dump($resident['Gender'] ."/" .$xcolor);
    //exit;
?>
<div class="container mt-4">
    <h4>Commande de gâteau</h4>

    <p>
        Résident :
        <strong><?= e($resident['Prenom']) ?> <?= e($resident['Nom']) ?></strong>
        (<?= e($annee) ?>)
    </p>

    <?php if (!empty($cake)): ?>
        <div class="alert alert-info">
            ⚠️ Une commande existe déjà pour cet anniversaire.
        </div>
    <?php endif; ?>

    <form method="post" action="/cake/store">
        <input type="hidden" name="token" value="<?= e($token) ?>">
        <input type="hidden" name="idResident" value="<?= e($resident['id']) ?>">
        <input type="hidden" name="idAnniversaire" value="<?= e($idAniversaire) ?>">
        <input type="hidden" name="annee" value="<?= e($annee) ?>">
        <input type="hidden" name="dateAnniversaire" value="<?= e($resident['Anniversaire']) ?>">

        <div class="form-group">
            <label>Date livraison</label>
            <input type="date" name="dateLivraison" class="form-control" value ="<?=  $dateFete ?>" required>
        </div>

        <div class="form-group">
            <label>Message sur le gâteau</label>
            <input type="text" name="message" value="Bonnes fetes <?= $resident['Prenom']; ?>" class="form-control">
        </div>

        <div class="form-group">
            <label>Couleur</label>
            <select name="couleur" class="form-control">
            <?php foreach ($options['Couleur'] as $h): ?>
                        <option value="<?= e($h)?>"<?= $h==$xcolor?' selected':''; ?>><?= e($h) ?></option>
                    <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Observation</label>
            <textarea name="observation" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">Enregistrer la commande</button>
        <a href="/birthday" class="btn btn-secondary">Retour</a>
    </form>
</div>
</div> <!-- container -->
<?php require __DIR__ . '/../layout/footer.php'; ?>
