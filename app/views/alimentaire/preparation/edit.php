<?php $title = 'Editer Preparations'; 
    $annee = $_GET['annee'] ?? date("Y");
    $custom_js = <<<'JS'
    // Custom JavaScript can be added here
    function openIngredientModal(plat, date) 
    {
      document.getElementById("ingredient_plat_display").textContent = plat;
      document.getElementById("ingredient_plat").value = plat;
      document.getElementById("ingredient_date").value = date;
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
    function openPrepModal(plat, date) 
    {
        document.getElementById("prep_plat_display").textContent = plat;
        document.getElementById("prep_plat").value = plat;
        document.getElementById("prep_date_hidden").value = date;

        loadUsedIngredientsForPrep(plat);
        loadPreparationTable(plat, date);
        checkExistingPreparations(plat);

        $('#prepModal').modal('show');
    }
    function openPrepModalView(plat, date) 
    {
      document.getElementById("view_plat_name").textContent = plat;
      fetch(`/preparation/load?date=${encodeURIComponent(date)}&plat=${encodeURIComponent(plat)}`)
          .then(r => r.json())
          .then(data => {
              const table = document.getElementById("viewPrepTable");
              table.innerHTML = "";

              data.forEach(row => {
                  table.insertAdjacentHTML('beforeend', `
                      <tr>
                          <td>${row.ingredient}</td>
                          <td>${row.action}</td>
                          <td>${row.nb}</td>
                          <td>${row.unite}</td>
                          <td>${row.jour}</td>
                          <td>
                              <button class="btn btn-danger btn-sm"
                                  onclick="deletePrep(${row.id})">
                                  Supprimer
                              </button>
                          </td>
                      </tr>
                  `);
              });

              $('#viewPrepModal').modal('show');
          });
    }

    function deletePrep(id) 
    {
        if (!confirm("Supprimer cette préparation ?")) return;
        fetch("/preparation/delete?id=" + id)
        .then(() => {
            let plat = document.getElementById("prep_plat").value;
            let date = document.getElementById("prep_date_hidden").value;
            loadPreparationTable(plat, date);
        });
    }

    function loadIngredientsAndOpenModal() 
    {
        // INGREDIENTS
        fetch("ingredients.json?v=" + Date.now())
            .then(r => r.json())
            .then(data => {
                let sel = document.getElementById("ingredientsList");
                sel.innerHTML = "";
                data.sort((a, b) => a.localeCompare(b, 'fr', { sensitivity: 'base' }));
                data.forEach(i => {
                    sel.innerHTML += `<option>${i}</option>`;
                });
            });

        // ACTIONS
        fetch("action.json?v=" + Date.now())
            .then(r => r.json())
            .then(data => {
                let sel = document.getElementById("actionList");
                sel.innerHTML = "";
                data.sort((a, b) => a.localeCompare(b, 'fr', { sensitivity: 'base' }));
                data.forEach(i => {
                    sel.innerHTML += `<option>${i}</option>`;
                });
            });

        // UNITES
        fetch("unite.json?v=" + Date.now())
            .then(r => r.json())
            .then(data => {
                let sel = document.getElementById("uniteList");
                sel.innerHTML = "";
                data.sort((a, b) => a.localeCompare(b, 'fr', { sensitivity: 'base' }));
                data.forEach(i => {
                    sel.innerHTML += `<option>${i}</option>`;
                });
            });

        // Ouvrir la modale d'ajout
        setTimeout(() => {
            $('#prepModal').modal('show');
        }, 200); // petit délai pour attendre les fetch
    }
    function openPrepModalAddFromView() 
    {
        let plat = document.getElementById("view_plat_name").textContent;

        document.getElementById("prep_plat_display").textContent = plat;
        document.getElementById("prep_plat").value = plat;

        checkExistingPreparations(plat); // ✅ AJOUT

        // fermeture forcée BS4
        $('#viewPrepModal').removeClass('show').css('display','none');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        loadIngredientsAndOpenModal();
    }
    function checkExistingPreparations(plat) 
    {
        fetch("check_preparation_by_plat.php?plat=" + encodeURIComponent(plat))
            .then(r => r.json())
            .then(res => {
                if (res.count > 0) {
                    document.getElementById("btnApplyExisting").style.display = "inline-block";
                } else {
                    document.getElementById("btnApplyExisting").style.display = "none";
                }
            });
    }
    function openApplyPreparationModal() {

        // Fermer la modale de création (BS4 safe)
        $('#prepModal').modal('hide');

        // Nettoyer la table
        let tbody = document.getElementById('applyPrepTable');
        tbody.innerHTML = '';

        let plat = document.getElementById('prep_plat').value;

        // Charger les préparations existantes (par plat)
        fetch("load_preparations_by_plat.php?plat=" + encodeURIComponent(plat))
            .then(r => r.json())
            .then(rows => {

                rows.forEach(row => {
                    tbody.innerHTML += `
                    <tr>
                        <td>
                        <input type="checkbox" value="${row.id}">
                        </td>
                        <td>${row.ingredient}</td>
                        <td>${row.action}</td>
                        <td>${row.nb}</td>
                        <td>${row.unite}</td>
                        <td>${row.jour}</td>
                    </tr>
                    `;
                });

                // Ouvrir la modale d’application
                $('#applyPrepModal').modal('show');
            });
    }
    function selectDate() 
    {
      let d = document.getElementById('date').value;
      if (d) window.location = "/preparation/edit?date=" + d;
    }
    function addIngredientToMeal() 
    {
        let plat = document.getElementById("ingredient_plat").value;
        let ingredient = document.getElementById("ingredientSelectModal").value;

        if (!plat || !ingredient) {
            alert("Veuillez choisir un ingrédient.");
            return;
        }

        // vérifier si l'ingrédient existe déjà dans la liste
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

                openIngredientModal(
                    plat,
                    document.getElementById("ingredient_date").value
                );

            } else {

                alert("Impossible d'ajouter l'ingrédient.");

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
                openIngredientModal(plat, document.getElementById("ingredient_date").value);
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
                alert("Cet ingrédient existe déjà.");
            }

            if (res.similar) {
                alert("Attention : ingrédient similaire : " + res.similar);
            }

            if (res.success) {

                reloadIngredientModalSelect(res.ingredient);

                document.getElementById("ingredientNew").value = "";

            }

        });
    }
    function loadUsedIngredientsForPrep(plat) {
        fetch(`/preparation/loadMealIngredients?plat=${encodeURIComponent(plat)}`)
        .then(r => r.json())
        .then(rows => {
            let used = rows.map(i => i.toLowerCase());
            let group = document.getElementById("usedIngredientsGroup");
            group.innerHTML = "";
            if (!rows || rows.length === 0) return;
            rows.sort((a,b)=>a.localeCompare(b,'fr',{sensitivity:'base'}));
            rows.forEach(i => {
                let opt = document.createElement("option");
                opt.value = i;
                opt.textContent = i;
                opt.style.color = "red";
                opt.style.fontStyle = "italic";
                //opt.disabled = true;
                group.appendChild(opt);
            });
            // 🔹 désactiver aussi dans la liste principale
            document.querySelectorAll("#ingredientsList option").forEach(opt => {
                let val = opt.value.toLowerCase();
                if(used.includes(val)){
                    opt.style.color = "red";
                    opt.style.fontStyle = "italic";
                    //opt.disabled = true;
                }
            });
        });
    }
    function loadPreparationTable(plat, date) 
    {
        fetch(`/preparation/load?date=${encodeURIComponent(date)}&plat=${encodeURIComponent(plat)}`)
        .then(r => r.json())
        .then(rows => {
            let table = document.getElementById("prepExistingTable");
            table.innerHTML = "";
            rows.forEach(row => {
                table.innerHTML += `
                <tr>
                    <td>${row.ingredient}</td>
                    <td>${row.action}</td>
                    <td>${row.nb}</td>
                    <td>${row.unite}</td>
                    <td>${row.jour}</td>
                    <td>
                        <button class="btn btn-danger btn-sm"
                            onclick="deletePrep(${row.id})">
                            Supprimer
                        </button>
                    </td>
                </tr>
                `;
            });
        });
    }
    document.getElementById("prepForm").addEventListener("submit", function(e)
    {
        e.preventDefault();

        let form = e.target;
        let data = new FormData(form);

        fetch("/preparation/save", {
            method: "POST",
            body: data
        })
        .then(r => r.json())
        .then(res => {

            if(res.success){

                let plat = document.getElementById("prep_plat").value;
                let date = document.getElementById("prep_date_hidden").value;

                // 🔹 recharge la table des préparations
                loadPreparationTable(plat, date);

                // 🔹 recharge la liste rouge des ingrédients du meal
                loadUsedIngredientsForPrep(plat);

                // reset formulaire
                form.reset();

            } else {

                alert("Erreur lors de l'enregistrement");

            }

        });

    });
        function normalizeText(str) {

        str = str.toLowerCase();

        str = str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");

        str = str.replace(/['’\-\s]/g, "");

        return str;
    }
    function searchIngredients() {
        let keyword = document.getElementById("ingredientSearch").value.trim();
        let cleanKeyword = normalizeText(keyword);
        let sel = document.getElementById("ingredientsList");
        let groups = sel.querySelectorAll("optgroup");
        if (groups.length < 2) return;
        let otherGroup = groups[1]; // deuxième groupe = "Autres ingrédients"
        let options = otherGroup.querySelectorAll("option");

        options.forEach(opt => {

            let text = opt.textContent;

            if (cleanKeyword === "" || normalizeText(text).includes(cleanKeyword)) {
                opt.style.display = "";
            } else {
                opt.style.display = "none";
            }

        });

    }
    function resetIngredientSearch()
    {

        document.getElementById("ingredientSearch").value = "";

        searchIngredients();

    }
    function addIngredientToDictionary()
    {
        let name = document.getElementById("newIngredientInput").value.trim();
        if(name === ""){
            alert("Entrer un ingrédient");
            return;
        }
        fetch("/preparation/addIngredientDictionary", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "ingredient=" + encodeURIComponent(name)
        })
        .then(r => r.json())
        .then(res => {
            if(!res.success){
                alert("Impossible d'ajouter l'ingrédient");
                return;
            }
            reloadIngredientSelect(name);
            document.getElementById("newIngredientInput").value = "";
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
    $custom_style = <<<CSS
    /* Custom CSS can be added here */
    CSS;

    /* ================================================================
   🔹 Transforme le menu → liste unique de plats
   ================================================================ */
$plats = [];

foreach (['breakfast','lunch','lunch_dessert','dinner','dinner_dessert'] as $cat) {
    if (!empty($menu[$cat])) {
        $items = explode(", ", $menu[$cat]);
        foreach ($items as $p) {
            $p = trim($p);
            if ($p !== "") $plats[] = $p;
        }
    }
}

?>
<?php require __DIR__ . '/../../layout/header.php'; ?>
<div class="container center">
  <div class="card-modern">
  <div class="card-header-pastel"><?= $title ?></div>
    <div class="card-body">

    <div class="alert alert-info mt-3">
        <?php if (isset($_GET['success'])): ?>
            <strong>✔️ Préparation enregistrée avec succès !</strong>
        <?php endif; ?>
    </div>
    <form class="form-inline mt-3 mb-4">
    <label class="mr-2">Choisissez une date :</label>
    <input type="date" name="date" id="date" class="form-control mr-2" value="<?= $xdate ?>">
    <button type="button" class="btn btn-primary" onclick="selectDate()">Afficher</button>
  </form>

  <?php if ($plats): ?>
  <h4 class="mb-3">Liste des plats :</h4>
  <?php

    // Indexation par plat
    $prepByPlat = [];
    foreach ($prepRows as $row) {
        $prepByPlat[$row['plat']][] = $row;
    }
  ?>
  <ul class="list-group">
    <?php foreach ($plats as $p): 
    $hasPrep = isset($prepByPlat[$p]); 
    ?>
 <li class="list-group-item d-flex align-items-center">
    <span class="flex-grow-1"><?= htmlspecialchars($p) ?></span>

    <div class="d-flex align-items-center gap-2 ml-3">
       <button class="btn btn-primary btn-sm mr-2"
        onclick="openIngredientModal('<?= addslashes($p) ?>', '<?= $xdate ?>')">
          Ajouter / Modifier Ingrédients  
      </button>
      <button class="btn btn-primary btn-sm"
            onclick="openPrepModal('<?= addslashes($p) ?>', '<?= $xdate ?>')">
          <?= $hasPrep ? 'Voir préparation' : 'Créer préparation' ?>
      </button>
    </div>
</li>
    <?php endforeach; ?>

    </ul>
    <?php else: ?>
        <div class="alert alert-warning mt-3">Aucun plat trouvé pour cette date.</div>
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
                  placeholder="Nouvel ingrédient"
                  list="ingredientSuggestions"
                  onkeyup="suggestIngredients()">
          <button type="button"
                  class="btn btn-success"
                  onclick="addNewIngredient()">
            Ajouter ingrédient
          </button>
          </div>

<datalist id="ingredientSuggestions"></datalist>
          <hr>

          <label class="mt-3"><strong>Ingrédients déjà enregistrés</strong></label>
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th>Ingrédient</th>
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
     🟦 MODALE DE CRÉATION D'UNE PRÉPARATION 
     ============================================================ -->
<div class="modal fade" id="prepModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="prepForm">

        <!-- Date du menu -->
        <input type="hidden" name="date" id="prep_date_hidden" value="<?= $xdate ?>">

        <!-- Plat (hidden) -->
        <input type="hidden" name="plat" id="prep_plat">

        <div class="modal-header">
          <h5 class="modal-title">Nouvelle préparation</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>

        <div class="modal-body">

          <!-- ❗ Affichage du plat sélectionné -->
          <div class="d-flex align-items-center mb-">
            <label class="form-label me-2 mb-0"><strong>Plat: </strong></label>
            <p id="prep_plat_display" class="form-control-plaintext fst-italic mb-0"></p>
            <button type="button"
                id="btnApplyExisting"
                class="btn btn-outline-info btn-sm mb-3"
                style="display:none"
                onclick="openApplyPreparationModal()">
                Appliquer préparation existante
            </button>
          </div>


          <label class="form-label">Ingrédient</label>
          <div class="d-flex mb-2">
            <input type="text"
                  id="ingredientSearch"
                  class="form-control mr-2"
                  placeholder="Rechercher ingrédient...">

            <button type="button"
                    class="btn btn-primary mr-2"
                    onclick="searchIngredients()">
                Search
            </button>

            <button type="button"
                    class="btn btn-secondary"
                    onclick="resetIngredientSearch()">
                X
            </button>
        </div>
          <select name="ingredient" id="ingredientsList" class="form-control">
            <optgroup label="Ingrédients déjà enregistrés" id="usedIngredientsGroup">
            </optgroup>

            <optgroup label="Autres ingrédients">
              <?php
              $ingredientsSorted = $ingredients;
              usort($ingredientsSorted, function($a, $b){
                  return strcasecmp(
                      iconv('UTF-8','ASCII//TRANSLIT',$a),
                      iconv('UTF-8','ASCII//TRANSLIT',$b)
                  );
              });
              ?>
              <?php foreach ($ingredientsSorted as $ingredient): ?> 
                <option value="<?= htmlspecialchars($ingredient) ?>">
                  <?= htmlspecialchars($ingredient) ?>
                </option>
              <?php endforeach; ?>
            </optgroup>
          </select>
          <div class="d-flex mt-2">
            <input type="text"
                  id="newIngredientInput"
                  class="form-control mr-2"
                  placeholder="Nouvel ingrédient">
            <button type="button"
                    class="btn btn-success"
                    onclick="addIngredientToDictionary()">
                Ajouter
            </button>
        </div>
          <label class="form-label mt-2">Action</label>
          <select name="action" id="actionList" class="form-control">
            <?php foreach ($actions as $action): ?> 
              <option value="<?= htmlspecialchars($action) ?>">
                <?= htmlspecialchars($action) ?>
              </option>
            <?php endforeach; ?>
            </select>
          <label class="mt-2">Quantité</label>
          <input type="number" class="form-control" name="nb" required>
          <label class="form-label mt-2">Unité</label>
          <select name="unite" id="uniteList" class="form-control">
            <?php foreach ($unites as $unite): ?> 
              <option value="<?= htmlspecialchars($unite) ?>">
                <?= htmlspecialchars($unite) ?>
              </option>
            <?php endforeach; ?>
          </select>
          <label class="mt-2">Nombre de jours avant</label>
          <input type="number" class="form-control" name="jour" min="0" required>

        </div>
        <hr>
        <h6>Préparations déjà enregistrées</h6>
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th>Ingrédient</th>
              <th>Action</th>
              <th>Qté</th>
              <th>Unité</th>
              <th>Jours</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="prepExistingTable"></tbody>
        </table>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- ============================================================
     MODALE : LISTE DES PRÉPARATIONS EXISTANTES
     ============================================================ -->
<div class="modal fade" id="viewPrepModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Préparations pour <span id="view_plat_name"></span></h5>
        <div class="modal-header">
    <!-- BOUTON AJOUTER PREPARATION -->
    <button type="button" class="btn btn-info btn-sm ms-3"
            onclick="openPrepModalAddFromView()">
        + Ajouter préparation
    </button>
    
</div>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Ingrédient</th>
              <th>Action</th>
              <th>Quantité</th>
              <th>Unité</th>
              <th>Jours avant</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="viewPrepTable"></tbody>
        </table>
      </div>

    </div>
  </div>
</div>
<!-- ============================================================
     𝟸 MODALE : APPLIQUER PRÉPARATION EXISTANTE
     ============================================================ -->
<div class="modal fade" id="applyPrepModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">
          Appliquer des préparations existantes
        </h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <table class="table table-sm">
          <thead>
            <tr>
              <th></th>
              <th>Ingrédient</th>
              <th>Action</th>
              <th>Qté</th>
              <th>Unité</th>
              <th>Jours</th>
            </tr>
          </thead>
          <tbody id="applyPrepTable"></tbody>
        </table>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button class="btn btn-primary" onclick="applySelectedPreparations()">
          Appliquer
        </button>
      </div>

    </div>
  </div>    
<!---------------------FIN DIV PRINCIPAL--------------------->
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>