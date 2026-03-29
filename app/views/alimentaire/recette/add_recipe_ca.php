<?php
$title = 'Ajouter une recette canadienne';

$custom_js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
    const ingredientsBody = document.getElementById('ingredients-body');
    const techniquesBody = document.getElementById('techniques-body');
    const addIngredientBtn = document.getElementById('add-ingredient');
    const addTechniqueBtn = document.getElementById('add-technique');

    function createIngredientRow(nom = '', unite = '', quantite = '') {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <input type="text" name="ingredient_nom[]" class="form-control" value="${nom}" required>
            </td>
            <td>
                <input type="text" name="ingredient_unite[]" class="form-control" value="${unite}" required>
            </td>
            <td>
                <input type="number" step="0.01" name="ingredient_quantite[]" class="form-control" value="${quantite}" required>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger remove-row">Supprimer</button>
            </td>
        `;
        ingredientsBody.appendChild(tr);
    }

    function createTechniqueRow(texte = '') {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <textarea name="technique_de_realisation[]" class="form-control" rows="2" required>${texte}</textarea>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger remove-row">Supprimer</button>
            </td>
        `;
        techniquesBody.appendChild(tr);
    }

    addIngredientBtn.addEventListener('click', function () {
        createIngredientRow();
    });

    addTechniqueBtn.addEventListener('click', function () {
        createTechniqueRow();
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            const row = e.target.closest('tr');
            if (row) {
                row.remove();
            }
        }
    });

    createIngredientRow();
    createTechniqueRow();
});
JS;

$custom_style = <<<'CSS'
.table td, .table th {
    vertical-align: middle;
}
textarea.form-control {
    resize: vertical;
}
CSS;
?>
<?php require __DIR__ . '/../../layout/header.php'; ?>

<div class="container mt-4">
    <div class="card-modern">
        <div class="card-header-pastel"><?= htmlspecialchars($title) ?></div>
        <div class="card-body">

            <form method="post" action="/recette/save_recipe_ca">
                
                <div class="form-group mb-3">
                    <label for="titre">Titre</label>
                    <input type="text" name="titre" id="titre" class="form-control" required>
                </div>

                <div class="form-group mb-4">
                    <label for="pax">Pax</label>
                    <input type="number" name="pax" id="pax" class="form-control" min="1" required>
                </div>

                <h4>Ingrédients</h4>
                <div class="table-responsive mb-2">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Unité</th>
                                <th>Quantité</th>
                                <th style="width:120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="ingredients-body"></tbody>
                    </table>
                </div>

                <div class="mb-4">
                    <button type="button" id="add-ingredient" class="btn btn-sm btn-secondary">
                        Ajouter un ingrédient
                    </button>
                </div>

                <h4>Technique de réalisation</h4>
                <div class="table-responsive mb-2">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Étape</th>
                                <th style="width:120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="techniques-body"></tbody>
                    </table>
                </div>

                <div class="mb-4">
                    <button type="button" id="add-technique" class="btn btn-sm btn-secondary">
                        Ajouter une étape
                    </button>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="/recette/indexca" class="btn btn-outline-secondary">Annuler</a>
                </div>

            </form>

        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layout/footer.php'; ?>