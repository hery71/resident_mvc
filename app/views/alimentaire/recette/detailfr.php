<?php $title = 'Détails de la recette'; 
    $custom_js = <<<'JS'
    JS;
    $custom_style = <<<'CSS'
    CSS;

    $cles_exclues = [
    'titre', 
    'type', 
    'page',
    'fiche', 
    'pax', 
    'technique_de_realisation',
    'file_name',
    'bandeau',
    'duree_moyenne_de_preparation',
    'duree_moyenne_preparation',
    'duree_moyenne_de_cuisson'
    ];
    $groupes_ingredients = array_diff_key($r, array_flip($cles_exclues));
?>
<?php require __DIR__ . '/../../layout/header.php'; ?>
<div class="container mt-4">
    <div class="card-modern">
        <div class="card-header-pastel"><?= htmlspecialchars($title) ?></div>
        <div class="card-body">
            <p class="font-weight-bold text-center text-decoration-underline"><?= htmlspecialchars($r['titre']) ?></p>
            <p><strong>Pax :</strong> <?= htmlspecialchars($r['pax']) ?></p>

            <h5>Ingrédients</h5>
            <?php foreach ($groupes_ingredients as $groupe => $ingredients): ?>
                <h6 class="mt-3 text-capitalize"><?= htmlspecialchars(str_replace('_', ' ', $groupe)) ?></h6>
                <ul>
                    <?php foreach ($ingredients as $ing): ?>
                    <li>
                        <?= htmlspecialchars($ing['quantite'] ?? '') ?>
                        <?= htmlspecialchars($ing['unite'] ?? '') ?> —
                        <?= htmlspecialchars($ing['nom'] ?? '') ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>

            <h5>Technique de réalisation</h5>
            <ol>
                <?php foreach ($r['technique_de_realisation'] as $etape): ?>
                <li><?= htmlspecialchars($etape) ?></li>
                <?php endforeach; ?>
            </ol>
            <a href="/recette/indexfr" class="btn btn-secondary mt-3">← Retour</a>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>