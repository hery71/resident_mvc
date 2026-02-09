<?php $title = 'Editer Preparations'; 
    $annee = $_GET['annee'] ?? date("Y");
    $custom_js = <<<'JS'
    // Custom JavaScript can be added here
    function openPrepModal(plat) {

        document.getElementById("prep_plat_display").textContent = plat;
        document.getElementById("prep_plat").value = plat;

        checkExistingPreparations(plat);
         $('#prepModal').modal('show');

        //loadIngredientsAndOpenModal();
    }
    function openPrepModalView(plat, date) {
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


    function deletePrep(id) {
        if (!confirm("Supprimer cette préparation ?")) return;
        fetch("/preparation/delete?id=" + id)
        .then(r => r.text())
        .then(() => location.reload());
    }

    function loadIngredientsAndOpenModal() {
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
    function openPrepModalAddFromView() {
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
    function checkExistingPreparations(plat) {
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
    function selectDate() {
      let d = document.getElementById('date').value;
      if (d) window.location = "/preparation/edit?date=" + d;
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
    <div class="alert alert-info mt-3">
        <?php if (isset($_GET['success'])): ?>
            <strong>✔️ Préparation enregistrée avec succès !</strong>
        <?php endif; ?>
    </div>
    <h3> Editer Preparations</h3>
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
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <span><?= htmlspecialchars($p) ?></span>

    <?php if ($hasPrep): ?>
        <!-- Bouton BLEU si préparation existe -->
        <button class="btn btn-primary btn-sm"
                onclick="openPrepModalView('<?= addslashes($p) ?>', '<?= $xdate ?>')">
            Voir préparation
        </button>
    <?php else: ?>
        <!-- Bouton VERT si aucune préparation -->
        <button class="btn btn-success btn-sm"
                onclick="openPrepModal('<?= addslashes($p) ?>')">
            Créer préparation
        </button>
    <?php endif; ?>

  </li>
    <?php endforeach; ?>

    </ul>
    <?php else: ?>
        <div class="alert alert-warning mt-3">Aucun plat trouvé pour cette date.</div>
    <?php endif; ?>

</div>


<!-- ============================================================
     🟦 MODALE DE CRÉATION D'UNE PRÉPARATION 
     ============================================================ -->
<div class="modal fade" id="prepModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/preparation/save" method="POST">

        <!-- Date du menu -->
        <input type="hidden" name="date" value="<?= $xdate ?>">

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
          <select name="ingredient" id="ingredientsList" class="form-control">
            <?php foreach ($ingredients as $ingredient): ?> 
              <option value="<?= htmlspecialchars($ingredient) ?>">
                <?= htmlspecialchars($ingredient) ?>
              </option>
            <?php endforeach; ?>
          </select>

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
        <div class="modal-footer">
          <button class="btn btn-primary">Enregistrer</button>
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
    <button type="button" class="btn btn-success btn-sm ms-3"
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