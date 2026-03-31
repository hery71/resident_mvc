<?php $title = "Meals sans ingrédients"; 
$custom_js = <<<'JS'
    // Custom JavaScript can be added here
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
        })
        .catch(err => {
            console.error(err);
            alert("Erreur serveur.");
        });
    }
    function reloadIngredientSelect(selectedIngredient)
    {
      console.log("reloadIngredientSelect exécuté");
        fetch("/preparation/getIngredients?v=" + Date.now())
        .then(r => r.json())
        .then(data => {

            let sel = document.getElementById("ingredientsList");

            let groups = sel.querySelectorAll("optgroup");

            if(groups.length < 2) return;

            let otherGroup = groups[1]; // deuxième groupe = autres ingrédients

            otherGroup.innerHTML = "";

            data.sort((a,b)=>a.localeCompare(b,'fr',{sensitivity:'base'}));

            data.forEach(i => {
                let opt = document.createElement("option");

                opt.value = i;
                opt.textContent = i;

                if(i === selectedIngredient){
                    opt.selected = true;
                }

                otherGroup.appendChild(opt);

            });
  
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
?>
<?php require __DIR__ . '/../../layout/header.php'; ?>

<div class="container mt-4">
    <div class="card-modern">
        <div class="card-header-pastel"><?= $title ?></div>

        <div class="card-body">

            <?php if (empty($meals)): ?>
                <div class="alert alert-success">
                    Tous les meals ont des ingrédients ✔
                </div>
            <?php else: ?>

                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Meal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($meals as $m): ?>
                            <tr>
                                <td><?= (int)$m['id'] ?></td>
                                <td><?= e($m['meal']) ?></td>
                                <td>
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