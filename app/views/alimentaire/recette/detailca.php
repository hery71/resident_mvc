<?php $title = 'Détails de la recette'; 
    $custom_js = <<<'JS'
    JS;
    $custom_style = <<<'CSS'
    CSS;
?>
<?php require __DIR__ . '/../../layout/header.php'; ?>
<div class="container mt-4">
    <div class="card-modern">
        <div class="card-header-pastel"><?= htmlspecialchars($title) ?></div>
        <div class="card-body">
            <p class="font-weight-bold text-center text-decoration-underline" ><?= htmlspecialchars($r['titre']) ?></p>
            <p><strong>Pax :</strong> <?= htmlspecialchars($r['pax']) ?></p>
            <h5>Ingrédients</h5>
            <ul>
                <?php foreach ($r['ingredients'] as $ing): ?>
                <li><?= htmlspecialchars($ing['quantite']) ?> <?= htmlspecialchars($ing['unite']) ?> — <?= htmlspecialchars($ing['nom']) ?></li>
                <?php endforeach; ?>
            </ul>
            <h5>Technique de réalisation</h5>
            <ol>
                <?php foreach ($r['technique_de_realisation'] as $etape): ?>
                <li><?= htmlspecialchars($etape) ?></li>
                <?php endforeach; ?>
            </ol>
            <a href="/recette/indexca" class="btn btn-secondary mt-3">← Retour</a>
            <a href="/recette/printRecipeCa?id=<?= $id ?>" class="btn btn-primary mt-3">Imprimer</a>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>