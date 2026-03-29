<?php $title = 'Liste des recettes FRANCE'; 
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
            <div class="d-flex justify-content-between mb-3">
                <a href="/recette/add_Recipe_Fr" class="btn btn-primary">Ajouter une recette</a>
                <form method="get" class="d-flex" style="gap:5px;">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Rechercher..."
                        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    <button class="btn btn-secondary">Search</button>
                </form>
            </div>
            <ul class="list-group">
                <?php
                $search = strtolower(trim($_GET['search'] ?? ''));

                if ($search !== '') {
                    $recettes = array_filter($recettes, function($r) use ($search) {
                        return strpos(strtolower($r['titre']), $search) !== false;
                    });
                }
                ?>
                <?php foreach ($recettes as $r): ?>
                <li class="list-group-item">
                    <a href="/recette/detailfr?id=<?= urlencode($r['fichier']) ?>">
                        <?= htmlspecialchars($r['titre']) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>