<?php $title = 'Liste des plats'; 
$custom_js = <<<'JS'
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
                            <th style="width:200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($meals as $m): ?>
                            <tr>
                                <td><?= e($m['meal']) ?></td>
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
              Ajouterx
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

<?php require __DIR__ . '/../../layout/footer.php'; ?>