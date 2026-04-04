<?php $title = 'Editer les boissons'; 

$custom_js = <<<JS
function addInput() {
    const div = document.createElement('div');
    div.className = 'input-group mb-2 drink-item new-drink';
    div.innerHTML = `
        <input type="text" name="drinks[]" class="form-control" placeholder="Nouvelle boisson">
        <button type="button" class="btn btn-light text-danger" onclick="this.parentNode.remove()">✕</button>
    `;
    const list = document.getElementById('drinks-list');
    list.prepend(div);
    div.querySelector('input').focus();
}

function sortAZ() { sortDrinks(true); }
function sortZA() { sortDrinks(false); }

function sortDrinks(ascending = true) {
    const list = document.getElementById('drinks-list');
    const items = Array.from(list.getElementsByClassName('drink-item'));

    items.sort((a, b) => {
        const valA = a.querySelector('input').value.toLowerCase();
        const valB = b.querySelector('input').value.toLowerCase();
        return ascending ? valA.localeCompare(valB) : valB.localeCompare(valA);
    });

    list.innerHTML = '';
    items.forEach(item => list.appendChild(item));
}

function filterList() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const items = document.getElementsByClassName('drink-item');

    Array.from(items).forEach(item => {
        const val = item.querySelector('input').value.toLowerCase();
        item.style.display = val.includes(input) ? '' : 'none';
    });
}
JS;
?>

<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container center">
    <div class="card-modern">
        <div class="card-header-pastel"><?= $title ?></div>
        <div class="card-body">

            <form method="POST" action="/resident/updateDrinksDictionary">

                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="sortAZ()">🔼 Trier A-Z</button>
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="sortZA()">🔽 Trier Z-A</button>
                        <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Rechercher..." onkeyup="filterList()">
                    </div>

                    <div>
                        <button type="button" class="btn btn-info btn-sm" onclick="addInput()">+ Ajouter</button>
                    </div>
                </div>

                <div id="drinks-list">
                    <?php foreach ($drinks as $drink): ?>
                        <div class="input-group mb-2 drink-item">
                            <input type="text" name="drinks[]" value="<?= htmlspecialchars($drink) ?>" class="form-control">
                            <button type="button" class="btn btn-light text-danger" onclick="this.parentNode.remove()">✕</button>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="text-end mt-3">
                    <a href="/resident/drinks" class="btn btn-secondary me-2">Annuler</a>
                    <button type="submit" class="btn btn-info">Enregistrer</button>
                </div>

            </form>

        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>