<?php $title = 'Editer Ingredients'; 
    $inspection=  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
    $custom_js = <<<JS
        // Custom JavaScript can be added here
        function addInput() {
        const div = document.createElement('div');
        div.className = 'input-group mb-2 ingredient-item new-ingredient';
        div.innerHTML = `
            <input type="text" name="ingredients[]" class="form-control" placeholder="Nouvel ingrédient">
            <button type="button" class="btn btn-light text-danger" onclick="this.parentNode.remove()">✕</button>
        `;
        const list = document.getElementById('ingredients-list');
        list.prepend(div);
        div.querySelector('input').focus();
    }

    // Trier A → Z
    function sortAZ() { sortIngredients(true); }
    // Trier Z → A
    function sortZA() { sortIngredients(false); }

    function sortIngredients(ascending = true) {
        const list = document.getElementById('ingredients-list');
        const items = Array.from(list.getElementsByClassName('ingredient-item'));

        items.sort((a, b) => {
            const valA = a.querySelector('input').value.toLowerCase();
            const valB = b.querySelector('input').value.toLowerCase();
            return ascending ? valA.localeCompare(valB) : valB.localeCompare(valA);
        });

        list.innerHTML = '';
        items.forEach(item => list.appendChild(item));
    }

    // Filtrage
    function filterList() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const items = document.getElementsByClassName('ingredient-item');

        Array.from(items).forEach(item => {
            const val = item.querySelector('input').value.toLowerCase();
            item.style.display = val.includes(input) ? '' : 'none';
        });
    }
    JS;
    $custom_style = <<<CSS
    /* Custom CSS can be added here */
    CSS;
?>
<?php require __DIR__ . '/../../../layout/header.php'; ?>
<div class="container center">
    <div class="card-modern">
        <div class="card-header-pastel"><?= $title ?></div>
        <div class="card-body">
            <form method="POST" id="formIngredients" action="/ingredient/update">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="sortAZ()">🔼 Trier A-Z</button>
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="sortZA()">🔽 Trier Z-A</button>
                        <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="🔍 Rechercher un ingrédient..." onkeyup="filterList()">
                    </div>
                    <div>
                        <button type="button" class="btn btn-info btn-sm" onclick="addInput()">+ Ajouter un ingrédient</button>
                    </div>
                </div>

                <div id="ingredients-list">
                    <?php foreach ($ingredients as $i => $ingredient): ?>
                        <div class="input-group mb-2 ingredient-item">
                            <input type="text" name="ingredients[]" value="<?= htmlspecialchars($ingredient) ?>" class="form-control">
                            <button type="button" class="btn btn-light text-danger" onclick="this.parentNode.remove()">✕</button>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="text-end mt-3">
                    <a href="index.php" class="btn btn-secondary me-2">Annuler</a>
                    <button type="submit" class="btn btn-info">💾 Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<!--------------------------FIN DIV PRINCIPALE-------------------------->
</div>
<?php require __DIR__ . '/../../../layout/footer.php'; ?>