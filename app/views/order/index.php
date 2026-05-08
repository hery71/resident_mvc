<?php
$title = 'Gestion des meals du jour';

$custom_js = <<<'JS'
let currentMeal = null;

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
require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">

    <h3>Order - Liste des achats</h3>

    <form method="get" action="/order/index" class="mb-4">
        <label>Date</label>
        <div class="d-flex">
            <input type="date"
                   name="date"
                   value="<?= e($xdate) ?>"
                   class="form-control mr-2"
                   style="max-width:250px;">

            <button type="submit" class="btn btn-primary">
                Afficher
            </button> 
            &nbsp;&nbsp;
            <div class="custom-control custom-radio">
                <input type="radio" id="week1" name="range" value="7" class="custom-control-input" <?= $range == 7 ? 'checked' : '' ?>>
                <label class="custom-control-label" for="week1">1 Week</label>
            </div>
            &nbsp;&nbsp;
            <div class="custom-control custom-radio">
                <input type="radio" id="week2" name="range" value="14" class="custom-control-input" <?= $range == 14 ? 'checked' : '' ?>>
                <label class="custom-control-label" for="week2">2 Weeks</label>
            </div>
        </div>
    </form>

    <div class="alert alert-info">
        <strong>Semaine du :</strong> <?= e($weekStart) ?><strong>Nb jours :</strong> <?= e($range) ?>
    </div>
    <!-- Affichage des commandes --------------------------------->
     <div class="row mt-4">

    <?php
    $labels = [
        'breakfast' => 'Breakfast',
        'lunch' => 'Lunch + Dessert',
        'dinner' => 'Dinner + Dessert'
    ];
    ?>

    <?php foreach ($orderList as $group => $items): ?>
    <?php if ($group === 'mealsWithoutIngredients') continue; ?>

        <div class="col-md-4">

            <div class="card mb-3">
                <div class="card-header bg-dark text-white text-center">
                    <?= e($labels[$group] ?? $group) ?>
                </div>

                <div class="card-body p-0">

                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                            <tr>
                                <th style="width:60px;">Nb</th>
                                <th>Ingredient</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($items as $ingredient => $count): ?>
                            <tr>
                                <td><?= $count ?></td>
                                <td><?= e($ingredient) ?></td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>

                </div>
            </div>
            <div class="card-footer text-center">
                <a href="/order/print?date=<?= e($xdate) ?>&range=<?= e($range) ?>&type=<?= e($group) ?>"
                target="_blank"
                class="btn btn-sm btn-primary">
                    Imprimer
                </a>
            </div>
        </div>
        
        <?php endforeach; ?>
        <div class="text-center mt-4">
            <a href="/order/print?date=<?= e($xdate) ?>&range=<?= e($range) ?>&type=all"
            target="_blank"
            class="btn btn-success">
                Imprimer Tous
            </a>
        </div>
    </div>
    <?php if (!empty($orderList['mealsWithoutIngredients'])): ?>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-warning text-dark text-center">
                    Meals sans ingredients
                </div>

                <div class="card-body p-2">
                    <table class="table table-sm table-bordered mb-0 text-center">
                        <tbody>
                        <?php
                        $meals = $orderList['mealsWithoutIngredients'];
                        $cols = 6;
                        $total = count($meals);
                        ?>

                        <?php for ($i = 0; $i < $total; $i += $cols): ?>
                            <tr>
                                <?php for ($j = 0; $j < $cols; $j++): ?>
                                    <td>
                                        <?php if (isset($meals[$i + $j])): ?>
                                            <button type="button"
                                                    class="btn btn-link p-0 text-center"
                                                    onclick='openIngredientModal(<?= json_encode($meals[$i + $j]["meal"]) ?>)'>
                                                <?= e($meals[$i + $j]['meal']) ?>
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                <?php endfor; ?>
                            </tr>
                        <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
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
<!-- ----------------------------------- Fin Modale Ingredient-------------------------------------------------- -->
<?php require_once __DIR__ . '/../layout/footer.php'; ?>