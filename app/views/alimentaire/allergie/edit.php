<?php $title = 'Editer Allergies'; 
    $inspection=  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
    $custom_js = <<<JS
        // Custom JavaScript can be added here
        function addInput() {
        const div = document.createElement('div');
        div.className = 'input-group mb-2 allergene-item new-allergene';
        div.innerHTML = `
            <input type="text" name="allergenes[]" class="form-control" placeholder="Nouvel allergène">
            <button type="button" class="btn btn-danger" onclick="this.parentNode.remove()">✕</button>
        `;
        const list = document.getElementById('allergenes-list');
        // Ajouter en première position
        list.prepend(div);
        // Mettre le focus sur la nouvelle case
        div.querySelector('input').focus();
    }

    // 🔼 Trier A-Z
    function sortAZ() { sortAllergenes(true); }
    // 🔽 Trier Z-A
    function sortZA() { sortAllergenes(false); }

    function sortAllergenes(ascending = true) {
        const list = document.getElementById('allergenes-list');
        const items = Array.from(list.getElementsByClassName('allergene-item'));

        items.sort((a, b) => {
            const valA = a.querySelector('input').value.toLowerCase();
            const valB = b.querySelector('input').value.toLowerCase();
            return ascending ? valA.localeCompare(valB) : valB.localeCompare(valA);
        });

        list.innerHTML = '';
        items.forEach(item => list.appendChild(item));
    }

    // 🔍 Filtrage instantané
    function filterList() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const items = document.getElementsByClassName('allergene-item');

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
<?php require __DIR__ . '/../../layout/header.php'; ?>
<div class="container center">
    <h3> Editer Allergies</h3>
    <div class="page-title">
        <h4 class="m-0">Gestion des Allergènes (allergie.json)</h4>
    </div>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="POST" id="formAllergies" action="/allergie/update">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="sortAZ()">🔼 Trier A-Z</button>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="sortZA()">🔽 Trier Z-A</button>
                        <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="🔍 Rechercher un allergène..." onkeyup="filterList()">
                    </div>
                    <div>
                        <button type="button" class="btn btn-info btn-sm" onclick="addInput()">+ Ajouter un allergène</button>
                    </div>
                </div>

                <div id="allergenes-list">
                    <?php foreach ($allergenes as $i => $allergene): ?>
                        <div class="input-group mb-2 allergene-item">
                            <input type="text" name="allergenes[]" value="<?= htmlspecialchars($allergene) ?>" class="form-control">
                            <button type="button" class="btn btn-danger" onclick="this.parentNode.remove()">✕</button>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="text-end mt-3">
                    <a href="index.php" class="btn btn-secondary me-2">Annuler</a>
                    <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
<!---------------------FIN DIV PRINCIPAL--------------------->
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>