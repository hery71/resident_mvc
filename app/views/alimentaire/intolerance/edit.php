<?php $title = 'Editer intolérances'; 
    $inspection=  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
    $custom_js = <<<'JS'
        // Custom JavaScript can be added here
        function addInput(category) {
        const div = document.createElement('div');
        div.className = 'input-group mb-2 intoler-item new-input';
        div.innerHTML = `
            <input type="text" name="${category}[]" class="form-control" placeholder="Nouvel aliment / ingrédient">
            <button type="button" class="btn btn-light text-danger" onclick="this.parentNode.remove()">✕</button>
        `;
        const section = document.getElementById('section-' + category);
        section.prepend(div);
        div.querySelector('input').focus();
    }

    // Tri d'une section
    function sortSection(category, ascending = true) {
        const section = document.getElementById('section-' + category);
        const items = Array.from(section.getElementsByClassName('intoler-item'));
        items.sort((a, b) => {
            const valA = a.querySelector('input').value.toLowerCase();
            const valB = b.querySelector('input').value.toLowerCase();
            return ascending ? valA.localeCompare(valB) : valB.localeCompare(valA);
        });
        section.innerHTML = '';
        items.forEach(item => section.appendChild(item));
    }

    // Filtrage d'une section
    function filterSection(category, searchValue) {
        const section = document.getElementById('section-' + category);
        const items = section.getElementsByClassName('intoler-item');
        const term = searchValue.toLowerCase();

        Array.from(items).forEach(item => {
            const text = item.querySelector('input').value.toLowerCase();
            item.style.display = text.includes(term) ? '' : 'none';
        });
    }
    JS;
    $custom_style = <<<CSS
    /* Custom CSS can be added here */
    CSS;
?>
<?php require __DIR__ . '/../../layout/header.php'; ?>
<div class="container center">
    <div class="card-modern">
    <div class="card-header-pastel"><?= $title ?></div>
        <div class="card-body">

     <form method="POST" action="/intolerance/update">
        <?php foreach ($categories as $catName => $items): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light d-flex flex-wrap justify-content-between align-items-center">
                    <span class="fw-bold text-primary"><?= htmlspecialchars(str_replace('_', ' ', $catName)) ?></span>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-primary btn-sm btn-sort" onclick="sortSection('<?= $catName ?>', true)">🔼 A-Z</button>
                        <button type="button" class="btn btn-outline-primary btn-sm btn-sort" onclick="sortSection('<?= $catName ?>', false)">🔽 Z-A</button>
                        <input type="text" class="form-control form-control-sm" placeholder="🔍 Rechercher..." onkeyup="filterSection('<?= $catName ?>', this.value)">
                        <button type="button" class="btn btn-info btn-sm" onclick="addInput('<?= $catName ?>')">+ Ajouter</button>
                    </div>
                </div>

                <div class="card-body" id="section-<?= $catName ?>">
                    <?php foreach ($items as $i => $item): ?>
                        <div class="input-group mb-2 intoler-item">
                            <input type="text" name="<?= $catName ?>[]" value="<?= htmlspecialchars($item) ?>" class="form-control">
                            <button type="button" class="btn btn-light text-danger" onclick="this.parentNode.remove()">✕</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="text-end mb-4">
            <a href="index.php" class="btn btn-secondary me-2">Annuler</a>
            <button type="submit" class="btn btn-primary">💾 Enregistrer toutes les catégories</button>
        </div>
    </form>
        </div>
    </div>
<!---------------------FIN DIV PRINCIPAL--------------------->
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>