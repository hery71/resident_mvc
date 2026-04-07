<?php $title = 'Liste des plats'; 
$custom_js = <<<'JS'
let currentMeal = null;
function checkAlergen(meal){
    currentMeal = meal; 
    fetch("/meal/checkAllergen?meal=" + encodeURIComponent(meal))
    .then(r => r.json())
    .then(data => {

        // décocher tout
        document.querySelectorAll('.allergen-check').forEach(cb => {
            cb.checked = false;
        });

        // créer map pour perf
        let map = {};
        data.forEach(a => {
            map[a.toLowerCase().trim()] = true;
        });

        // cocher ceux correspondants
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

        // décocher tout
        document.querySelectorAll('.intolerance-check').forEach(cb => {
            cb.checked = false;
        });

        // créer map pour perf
        let map = {};
        data.forEach(a => {
            map[a.toLowerCase().trim()] = true;
        });

        // cocher ceux correspondants
        document.querySelectorAll('.intolerance-check').forEach(cb => {
            let val = cb.value.toLowerCase().trim();
            cb.checked = !!map[val];
        });

    });
}
function deleteMeal(id) {
    if (!confirm("Supprimer ce plat ?")) return;

    fetch('/meal/deleteMeal', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'id=' + encodeURIComponent(id)
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            location.reload();
        } else {
            alert("Erreur lors de la suppression");
        }
    });
}
function syncMeals() {
    if (!confirm("Mettre à jour meal_tbl à partir des menus ?")) return;

    fetch('/meal/syncMeals', {
        method: 'POST'
    })
    .then(r => r.json())
    .then(res => {
        alert(res.message);
        location.reload();
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
                        ❌
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
        })
        .catch(err => {
            console.error(err);
            alert("Erreur serveur.");
        });
    }
$('#ingredientModal').on('hidden.bs.modal', function () {
        location.reload();
    });
document.addEventListener('DOMContentLoaded', () => {
    $('#ingredientModal').on('hidden.bs.modal', function () {
        location.reload();
    });
});
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

                if(i === selectedIngredient){
                    opt.selected = true;
                }

                sel.appendChild(opt);

            });

        });
    }
function saveAllergens(meal)
    {
        //alert("meal = " + meal);
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
                if(res.success){
                    alert("Enregistré");
                    // fermer la modale APRES
                    $('#allergenModal').modal('hide');
                     location.reload();
                } else {
                    alert("Erreur");
                }
            });
            
    }
function saveIntolerances(meal)
    {
        alert("meal = " + meal);
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
                if(res.success){
                    alert("Enregistré");
                    // fermer la modale APRES
                    $('#intoleranceModal').modal('hide');
                     location.reload();
                } else {
                    alert("Erreur");
                }
            });
            
    }
function addIngredientToMeal() 
    {
        let plat = document.getElementById("ingredient_plat").value;
        let ingredient = document.getElementById("ingredientSelectModal").value;

        if (!plat || !ingredient ) {
            alert("Veuillez choisir un plat et un ingrédient.");
           return;
        }

        // vérifier si déjà présent
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

                // refresh modal
                openIngredientModal(plat);

            } else {

                alert(res.message || "Impossible d'ajouter l'ingrédient.");

            }

        })
        .catch(err => {
            console.error(err);
            alert("Erreur serveur.");
        });
    }
function addNewAllergen() {
    const value = document.getElementById('new-allergen').value.trim();
    if (!value) return alert('Champ vide');
    fetch('/ajaxRestriction/addAllergen', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ value })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            $('#addAllergenModal').modal('hide');
            location.reload(); // ou reload partiel
        } else {
            alert(data.error);
        }
    });
    }
    function addNewIntolerance() {
    const category = document.getElementById('intolerance-category').value;
    const value    = document.getElementById('new-intolerance').value.trim();

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

JS;

$custom_style = <<<'CSS'
.table td, .table th {
    vertical-align: middle;
}
CSS;
?>
<?php require __DIR__ . '/../../layout/header.php'; ?>

<div class="container mt-4">
    <div class="card-modern">
        <div class="card-header-pastel"><?= $title ?></div>

        <div class="card-body">

            <h3>Liste des Plats actifs</h3>
            <div class="mb-3">
                <button class="btn btn-success" onclick="syncMeals()">
                    Synchroniser les meals
                </button>
            </div>
            <?php if (empty($meals)): ?>
                <div class="alert alert-info">
                    Aucun plat trouvé
                </div>
            <?php else: ?>

                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Plat</th>
                            <th>Ingrédients</th>
                            <th>Allergenes</th>
                            <th>Intolérances</th>
                            <th style="width:200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($meals as $m): ?>
                            <tr>
                                <td><?= e($m['meal']) ?></td>
                                <td><?= e($m['ingredients']) ?></td>
                                <td><?= e($m['allergene']) ?></td>
                                <td><?= e($m['intolerance']) ?></td>
                                <td>
                                    <button class="btn btn-danger btn-sm"
                                        onclick="deleteMeal(<?= (int)$m['id'] ?>)">
                                        Supprimer
                                    </button>
                                     <button
                                        type="button"
                                        class="btn btn-sm btn-primary"
                                        onclick="openIngredientModal('<?= e($m['meal']) ?>', '')">
                                        Ajouter ingrédients
                                    </button>    
                                    <button type="button"
                                            class="btn btn-outline-primary btn-sm"
                                            onclick="checkAlergen('<?= addslashes($m['meal']) ?>')"
                                            data-toggle="modal"
                                            data-target="#allergenModal">
                                        Allergènes
                                    </button>
                                    <button type="button"
                                            class="btn btn-outline-primary btn-sm"
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
<!-- ============================================================
     🟦 MODALE DE GESTION DES INGRÉDIENTS D'UNE PRÉPARATION 
     ============================================================ -->
<div class="modal fade" id="ingredientModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

        <input type="hidden" name="date" id="ingredient_date">
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
          <div class="d-flex">
            <select name="ingredient" id="ingredientSelectModal" class="form-control">
              <?php foreach ($ingredients as $ingredient): ?> 
                <option value="<?= htmlspecialchars($ingredient) ?>">
                  <?= htmlspecialchars($ingredient) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <button type="button" class="btn btn-primary" onclick="addIngredientToMeal()">
              Ajouter
            </button>
          </div>
          <div class="d-flex mb-2">
         <input type="text"
                  id="ingredientNew"
                  class="form-control mr-2"
                  placeholder="Nouvel ingrédient - Ajouter- Rechercher..."
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
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ============================================================
     🟦 MODALE DE GESTION DES ALLERGÈNES + Intolerances
     ============================================================ -->   
<!---------------------------------------MODALES--------------------------------------->
    <!-- MODALE ALLERGENES -->
    <div class="modal fade" id="allergenModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Allergènes</h5>
                    <button type="button"
                        class="btn btn-sm btn-outline-secondary mt-2"
                        data-toggle="modal"
                        data-target="#addAllergenModal">
                        ➕ Ajouter un allergène
                    </button>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <?php foreach ($allergenList as $a): ?>
                        <div class="col-md-4">
                        <div class="form-check">
                        <input class="form-check-input allergen-check"
                            type="checkbox"
                            value="<?= htmlspecialchars($a) ?>"
                            id="allergen_<?= md5($a) ?>">
                        <label class="form-check-label" for="allergen_<?= md5($a) ?>">
                            <?= htmlspecialchars($a) ?>
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
    <!-- MODALE INTOLERANCES -->
     <div class="modal fade" id="intoleranceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Intolérances alimentaires</h5>
                    <button type="button"
                            class="btn btn-sm btn-outline-secondary mt-2"
                            data-toggle="modal"
                            data-target="#addIntoleranceModal">
                        ➕ Ajouter une intolérance
                    </button>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                         <?php foreach ($intoleranceList as $i): ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-check">
                                    <input class="form-check-input intolerance-check"
                                        type="checkbox"
                                        value="<?= htmlspecialchars($i) ?>"
                                        id="intol_<?= md5($i) ?>">
                                    <label class="form-check-label" for="intol_<?= md5($i) ?>">
                                    <?= htmlspecialchars($i) ?>
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
<!-----------------------------------MODALE AJOUTER ALLERGENES-------------------------------------------->
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
        <button class="btn btn-primary" onclick="addNewAllergen()">Enregistrer</button>
      </div>

    </div>
  </div>
</div>
<!-----------------------------------mODALE AJOUTER INTOLERANCES-------------------------------------------->
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
        <button class="btn btn-primary" onclick="addNewIntolerance()">Enregistrer</button>
      </div>

    </div>
  </div>
</div>

<?php require __DIR__ . '/../../layout/footer.php'; ?>