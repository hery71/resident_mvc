<?php $title = 'Liste des recettes CANADA'; 
    $custom_js = <<<'JS'
    JS;
    $custom_style = <<<'CSS'
    CSS;
?>
<?php require __DIR__ . '/../../layout/header.php'; ?>
<div class="container mt-4">
    <div class="card-modern">
        <div class="card-header-pastel"><?= $title ?></div>
        <div class="card-body">
            <h3>Recettes</h3>
            <a href="/recette/add_Recipe_Ca" class="btn btn-primary mb-3">Ajouter une recette</a>
            <ul class="list-group">
                <?php foreach ($recettes as $r): ?>
                <li class="list-group-item">
                    <a href="/recette/detailca?id=<?= urlencode($r['fichier']) ?>">
                        <?= htmlspecialchars($r['titre']) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>