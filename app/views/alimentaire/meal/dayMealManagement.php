<?php
$title = 'Gestion des meals du jour';

$custom_js = <<<'JS'
let currentMeal = null;

function checkAlergen(meal){
    currentMeal = meal;

    fetch("/meal/checkAllergen?meal=" + encodeURIComponent(meal))
    .then(r => r.json())
    .then(data => {
        document.querySelectorAll('.allergen-check').forEach(cb => {
            cb.checked = false;
        });

        let map = {};
        data.forEach(a => {
            map[a.toLowerCase().trim()] = true;
        });

        document.querySelectorAll('.allergen-check').forEach(cb => {
            let val = cb.value.toLowerCase().trim();
            cb.checked = !!map[val];
        });
    });
}

function checkIntolerance(meal){
    currentMeal = meal;

    fetch("/meal/checkIntolerance?meal=" + encodeURIComponent(meal))
    .then(r => r.json())
    .then(data => {
        document.querySelectorAll('.intolerance-check').forEach(cb => {
            cb.checked = false;
        });

        let map = {};
        data.forEach(a => {
            map[a.toLowerCase().trim()] = true;
        });

        document.querySelectorAll('.intolerance-check').forEach(cb => {
            let val = cb.value.toLowerCase().trim();
            cb.checked = !!map[val];
        });
    });
}

function openIngredientModal(plat)
{
    document.getElementById("ingredient_plat_display").textContent = plat;
    document.getElementById("ingredient_plat").value = plat;
    document.getElementById("ingredientNew").value = "";

    fetch("/preparation/getIngredients?v=" + Date.now())
    .then(r => r.json())
    .then(data => {
        let sel = document.getElementById("ingredientSelectModal");
        sel.innerHTML = "";

        data.sort((a,b)=>a.localeCompare(b,'fr',{sensitivity:'base'}));

        data.forEach(i => {
            let opt = document.createElement("option");
            opt.value = i;
            opt.textContent = i;
            sel.appendChild(opt);
        });
    });

    fetch(`/preparation/loadMealIngredients?plat=${encodeURIComponent(plat)}`)
    .then(r => r.json())
    .then(rows => {
        let tbody = document.getElementById("ingredientExistingTable");
        tbody.innerHTML = "";

        rows.forEach(ingredient => {
            tbody.innerHTML += `
                <tr>
                    <td>${ingredient}</td>
                    <td width="40">
                        <button class="btn btn-danger btn-sm"
                                onclick="removeIngredientFromMeal('${ingredient}')">
                            X
                        </button>
                    </td>
                </tr>
            `;
        });

        $('#ingredientModal').modal('show');
    });
}

function suggestIngredients()
    {
        let input = document.getElementById("ingredientNew");
        if (!input) return;

        let value = input.value.trim();

        if (value === "") {
            document.getElementById("ingredientSuggestions").innerHTML = "";
            return;
        }

        fetch("/preparation/suggestIngredient?term=" + encodeURIComponent(value))
        .then(r => r.json())
        .then(data => {
            let list = document.getElementById("ingredientSuggestions");
            list.innerHTML = "";

            data.forEach(i => {
                list.innerHTML += `<option value="${i}"></option>`;
            });
        });
    }


function addNewIngredient()
    {
        let ingredient = document.getElementById("ingredientNew").value.trim();

        if (ingredient === "") {
            alert("Entrer un ingrédient");
            return;
        }

        fetch("/preparation/addIngredientDictionary", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "ingredient=" + encodeURIComponent(ingredient)
        })
        .then(r => r.json())
        .then(res => {
            if (res.exists) {
                reloadIngredientModalSelect(res.ingredient || ingredient);
                document.getElementById("ingredientNew").value = "";
                return;
            }

            if (res.similar) {
                reloadIngredientModalSelect(res.similar);
                document.getElementById("ingredientNew").value = "";
                return;
            }

            if (res.success) {
                reloadIngredientModalSelect(res.ingredient);
                document.getElementById("ingredientNew").value = "";
                return;
            }

            alert(res.message || "Impossible d'ajouter l'ingrédient.");
        });
    }

function reloadIngredientModalSelect(selectedIngredient)
    {
        fetch("/preparation/getIngredients?v=" + Date.now())
        .then(r => r.json())
        .then(data => {
            let sel = document.getElementById("ingredientSelectModal");
            sel.innerHTML = "";

            data.sort((a,b)=>a.localeCompare(b,'fr',{sensitivity:'base'}));

            data.forEach(i => {
                let opt = document.createElement("option");
                opt.value = i;
                opt.textContent = i;

                if (i === selectedIngredient) {
                    opt.selected = true;
                }

                sel.appendChild(opt);
            });
        });
    }

function addIngredientToMeal()
    {
        let plat = document.getElementById("ingredient_plat").value;
        let ingredient = document.getElementById("ingredientSelectModal").value;

        if (!plat || !ingredient) {
            alert("Veuillez choisir un plat et un ingrédient.");
            return;
        }

        let existing = [];

        document.querySelectorAll("#ingredientExistingTable tr").forEach(row => {
            let name = row.children[0].innerText.trim();
            existing.push(name.toLowerCase());
        });

        if (existing.includes(ingredient.toLowerCase())) {
            alert("Cet ingrédient est déjà dans la liste.");
            return;
        }

        fetch("/preparation/addMealIngredient", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body:
                "plat=" + encodeURIComponent(plat) +
                "&ingredient=" + encodeURIComponent(ingredient)
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                openIngredientModal(plat);
            } else {
                alert(res.message || "Impossible d'ajouter l'ingrédient.");
            }
        });
    }

function saveAllergens(meal)
    {
        let selected = [];

        document.querySelectorAll('.allergen-check:checked').forEach(cb => {
            selected.push(cb.value.trim());
        });

        let allergenes = selected.join(',');

        fetch('/meal/saveAllergens', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body:
                'meal=' + encodeURIComponent(meal) +
                '&allergene=' + encodeURIComponent(allergenes)
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                $('#allergenModal').modal('hide');
                location.reload();
            } else {
                alert("Erreur");
            }
        });
    }

function saveIntolerances(meal)
    {
        let selected = [];

        document.querySelectorAll('.intolerance-check:checked').forEach(cb => {
            selected.push(cb.value.trim());
        });

        let intolerances = selected.join(',');

        fetch('/meal/saveIntolerances', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body:
                'meal=' + encodeURIComponent(meal) +
                '&intolerance=' + encodeURIComponent(intolerances)
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                $('#intoleranceModal').modal('hide');
                location.reload();
            } else {
                alert("Erreur");
            }
        });
    }

function addNewAllergen()
    {
        const value = document.getElementById('new-allergen').value.trim();

        if (!value) {
            alert('Champ vide');
            return;
        }

        fetch('/ajaxRestriction/addAllergen', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ value })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                $('#addAllergenModal').modal('hide');
                location.reload();
            } else {
                alert(data.error);
            }
        });
    }
function removeIngredientFromMeal(ingredient) 
    {

        let plat = document.getElementById("ingredient_plat").value;

        if (!confirm("Supprimer cet ingrédient ?")) return;

        fetch("/preparation/removeMealIngredient", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "plat=" + encodeURIComponent(plat) + "&ingredient=" + encodeURIComponent(ingredient)
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                openIngredientModal(plat);
            }
        });
    }

function addNewIntolerance()
    {
        const category = document.getElementById('intolerance-category').value;
        const value = document.getElementById('new-intolerance').value.trim();

        if (!category || !value) {
            alert('Champs requis');
            return;
        }

        fetch('/ajaxRestriction/addIntolerance', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ category, value })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                $('#addIntoleranceModal').modal('hide');
                location.reload();
            } else {
                alert(data.error);
            }
        });
    }

document.addEventListener('DOMContentLoaded', function () {
    $('#ingredientModal').on('hidden.bs.modal', function () {
        location.reload();
    });
});
JS;

$custom_style = <<<'CSS'
.table td,
.table th {
    vertical-align: middle;
}

.menu-label {
    width: 220px;
    font-weight: bold;
}
CSS;
?>

<?php require_once __DIR__ . '/../../layout/header.php'; ?>

<div class="container mt-4">

    <h3><?= e($title) ?></h3>
    <?php
    $wdate = new DateTime($xdate);
    $wdate->modify('-1 day');
    //echo $wdate->format('Y-m-d');
    $ydate =new DateTime($xdate);
    $ydate->modify('+1 day');
    //echo $ydate->format('Y-m-d');
    ?>
   <div class="d-flex align-items-end mb-4">

        <a href="/meal/dayMealManagement?date=<?= e($wdate->format('Y-m-d')) ?>" class="btn btn-primary mr-2">
            <i class="fas fa-arrow-left"></i>
        </a>

        <form method="get" action="/meal/dayMealManagement" class="d-flex align-items-end mb-0 mr-2">
            <div class="mr-2">
                <label>Date</label>
                <input type="date"
                    name="date"
                    value="<?= e($xdate) ?>"
                    class="form-control"
                    style="max-width:200px;">
            </div>
            <button type="submit" class="btn btn-primary">Afficher</button>
        </form>

        <a href="/meal/dayMealManagement?date=<?= e($ydate->format('Y-m-d')) ?>" class="btn btn-primary">
            <i class="fas fa-arrow-right"></i>
        </a>

    </div>

    <div class="alert alert-info">
        <strong>Date :</strong> <?= e($xdate) ?>

        <?php if (!empty($menu['type']) && $menu['type'] === 'unique'): ?>
            — <strong>Menu unique :</strong> <?= e($menu['nom'] ?? '') ?>
        <?php else: ?>
            — <strong>Menu standard</strong>
        <?php endif; ?>
    </div>

    <?php if (!empty($menu)): ?>

        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                Menu du jour
            </div>

            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <tr>
                            <th class="menu-label">Breakfast</th>
                            <td><?= e($menu['breakfast'] ?? '') ?></td>
                        </tr>
                        <tr>
                            <th>Lunch</th>
                            <td><?= e($menu['lunch'] ?? '') ?></td>
                        </tr>
                        <tr>
                            <th>Lunch dessert</th>
                            <td><?= e($menu['lunch_dessert'] ?? '') ?></td>
                        </tr>
                        <tr>
                            <th>Dinner</th>
                            <td><?= e($menu['dinner'] ?? '') ?></td>
                        </tr>
                        <tr>
                            <th>Dinner dessert</th>
                            <td><?= e($menu['dinner_dessert'] ?? '') ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    <?php else: ?>

        <div class="alert alert-warning">
            Aucun menu trouvé pour cette date.
        </div>

    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            Meals du jour
        </div>

        <div class="card-body">

            <?php if (empty($meals)): ?>

                <div class="alert alert-warning">
                    Aucun meal trouvé pour cette date.
                </div>

            <?php else: ?>

                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>Meal</th>
                            <th>Ingrédients</th>
                            <th>Allergènes</th>
                            <th>Intolérances</th>
                            <th style="width:260px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($meals as $m): ?>
                            <tr>
                                <td><strong><?= e($m['meal']) ?></strong></td>
                                <td><?= e($m['ingredients'] ?? '') ?></td>
                                <td><?= e($m['allergene'] ?? '') ?></td>
                                <td><?= e($m['intolerance'] ?? '') ?></td>
                                <td>
                                    <button type="button"
                                            class="btn btn-sm btn-primary mb-1"
                                            onclick="openIngredientModal('<?= addslashes($m['meal']) ?>')">
                                        Ingrédients
                                    </button>

                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary mb-1"
                                            onclick="checkAlergen('<?= addslashes($m['meal']) ?>')"
                                            data-toggle="modal"
                                            data-target="#allergenModal">
                                        Allergènes
                                    </button>

                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary mb-1"
                                            onclick="checkIntolerance('<?= addslashes($m['meal']) ?>')"
                                            data-toggle="modal"
                                            data-target="#intoleranceModal">
                                        Intolérances
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php endif; ?>

        </div>
    </div>

</div>
<!-- ----------------------------------- Modale Ingredient -------------------------------------------------- -->
<div class="modal fade" id="ingredientModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <input type="hidden" name="plat" id="ingredient_plat">

            <div class="modal-header">
                <h5 class="modal-title">
                    Ajouter / Modifier ingrédients pour
                    <span id="ingredient_plat_display"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <label><strong>Choisir un ingrédient</strong></label>

                <div class="d-flex mb-2">
                    <select name="ingredient" id="ingredientSelectModal" class="form-control mr-2"></select>

                    <button type="button"
                            class="btn btn-primary"
                            onclick="addIngredientToMeal()">
                        Ajouter
                    </button>
                </div>

                <div class="d-flex mb-2">
                    <input type="text"
                           id="ingredientNew"
                           class="form-control mr-2"
                           placeholder="Nouvel ingrédient - Ajouter - Rechercher"
                           list="ingredientSuggestions"
                           onkeyup="suggestIngredients()">

                    <button type="button"
                            class="btn btn-success"
                            onclick="addNewIngredient()">
                        Rechercher Ajouter
                    </button>
                </div>

                <datalist id="ingredientSuggestions"></datalist>

                <hr>

                <label class="mt-3"><strong>Ingrédients déjà enregistrés</strong></label>

                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Ingrédient</th>
                            <th width="40">Action</th>
                        </tr>
                    </thead>
                    <tbody id="ingredientExistingTable"></tbody>
                </table>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Fermer
                </button>
            </div>

        </div>
    </div>
</div>
<!-------------------------------------- Modale Allergène-------------------------------------------------- -->
<div class="modal fade" id="allergenModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Allergènes</h5>

                <button type="button"
                        class="btn btn-sm btn-outline-secondary"
                        data-toggle="modal"
                        data-target="#addAllergenModal">
                    Ajouter un allergène
                </button>

                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <?php foreach ($allergenList as $a): ?>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input allergen-check"
                                       type="checkbox"
                                       value="<?= e($a) ?>"
                                       id="allergen_<?= md5($a) ?>">

                                <label class="form-check-label" for="allergen_<?= md5($a) ?>">
                                    <?= e($a) ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="saveAllergens(currentMeal)">
                    Appliquer
                </button>
            </div>

        </div>
    </div>
</div>
<!-------------------------------------- Modale Intolérance-------------------------------------------------- -->
<div class="modal fade" id="intoleranceModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Intolérances alimentaires</h5>

                <button type="button"
                        class="btn btn-sm btn-outline-secondary"
                        data-toggle="modal"
                        data-target="#addIntoleranceModal">
                    Ajouter une intolérance
                </button>

                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <?php foreach ($intoleranceList as $i): ?>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-check">
                                <input class="form-check-input intolerance-check"
                                       type="checkbox"
                                       value="<?= e($i) ?>"
                                       id="intol_<?= md5($i) ?>">

                                <label class="form-check-label" for="intol_<?= md5($i) ?>">
                                    <?= e($i) ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="saveIntolerances(currentMeal)">
                    Appliquer
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addAllergenModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Ajouter un allergène</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <input type="text"
                       id="new-allergen"
                       class="form-control"
                       placeholder="Ex: Sésame">
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="addNewAllergen()">
                    Enregistrer
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="addIntoleranceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Ajouter une intolérance</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <select id="intolerance-category" class="form-control mb-2">
                    <option value="">-- Catégorie --</option>

                    <?php foreach ($intoleranceCategories as $cat): ?>
                        <option value="<?= e($cat) ?>">
                            <?= e(str_replace('_', ' ', $cat)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="text"
                       id="new-intolerance"
                       class="form-control"
                       placeholder="Ex: Porc">

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="addNewIntolerance()">
                    Enregistrer
                </button>
            </div>

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>