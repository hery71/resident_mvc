<?php $title = 'Editer les restrictions alimentaires';
    $link='<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">';
    $inspection=  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
    $custom_js = <<<'JS'
    //au chargement de la page
    document.addEventListener('DOMContentLoaded', function () {
    applySelection('allergen-check', 'allergen-tags', 'allergen-final');
    applySelection('intolerance-check', 'intol-tags', 'intol-final');
    });
    // Custom JavaScript can be added here
    function applySelection(checkClass, containerId, hiddenId) {

    const checks = document.querySelectorAll('.' + checkClass + ':checked');
    const container = document.getElementById(containerId);
    const hidden = document.getElementById(hiddenId);

    container.innerHTML = '';
    const values = [];

    checks.forEach(chk => {
        const value = chk.value;
        values.push(value);

        // Création du tag
        const tag = document.createElement('span');
        tag.className = 'tag bg-warning text-dark me-1 mb-1';
        tag.dataset.value = value;
        tag.style.cursor = 'pointer';

        tag.innerHTML = `
            ${value}
            <i class="bi bi-x remove-tag ms-1"></i>
        `;

        // Click sur ❌ = décocher la checkbox + refresh
        tag.querySelector('.remove-tag').addEventListener('click', function (e) {
            e.stopPropagation();
            chk.checked = false;
            applySelection(checkClass, containerId, hiddenId);
        });

        container.appendChild(tag);
    });

    // Valeur finale envoyée au POST
    hidden.value = values.join(',');
    }
    document.addEventListener('DOMContentLoaded', () => {
    applySelection('allergen-check', 'allergen-tags', 'allergen-final');
    applySelection('intolerance-check', 'intolerance-tags', 'intolerance-final');
    });
    function saveAllergen() {
    const value = document.getElementById('new-allergen').value.trim();
    if (!value) return alert('Champ vide');
    alert("1");
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
    function saveIntolerance() {
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
    $custom_style = <<<CSS
    /* Custom CSS can be added here */
    CSS;
?>
<?php require __DIR__ . '/../../layout/header.php'; ?>
<div class="container center">
    <div class="card-modern">
        <div class="card-header-pastel"><?= $title ?> - Année <?= e($annee) ?></div>
        <div class="card-body">
    <?php if(isset($success)): ?>
        <div class="alert alert-success">
            Les restrictions ont été enregistrées avec succès.
        </div>
    <?php endif; ?>
    <?php if(isset($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    <!-- DROPDOWN LISTE TABLE -->
    <form method="get" class="mb-4">    
        <label class="fw-bold">Choisir une catégorie :</label>
        <select name="table" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
            <?php foreach ($listTables as $key => $label): ?>
                <option value="<?= $key ?>" <?= ($table == $key) ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <div class="container-grid">

        <!-- LISTE DES MEALS -->
        <div class="card card-custom">
            <div class="card-header bg-dark text-white fw-bold">Meals (<?= $listTables[$table] ?>)</div>

            <ul class="list-group list-group-flush scroll-list">
                <?php foreach ($meals as $m): ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><?= htmlspecialchars($m['meal']) ?></span>
                        <a href="/restriction/edit?table=<?= $table ?>&id=<?= $m['id'] ?>" 
                           class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- FORMULAIRE DE RESTRICTIONS -->
        <div class="card card-custom p-4">

            <?php if (!$selectedMeal): ?>
                <h5 class="text-muted">Sélectionnez un meal dans la liste.</h5>

            <?php else: ?>

                <h3 class="fw-bold text-primary mb-3"><?= htmlspecialchars($selectedMeal['meal']) ?></h3>

                <form method="post">

                    <input type="hidden" name="meal_id" value="<?= $selectedMeal['id'] ?>">
                    <input type="hidden" name="table" value="<?= $table ?>">

                    <!-- ALLERGENES -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Allergènes</label><br>

                        <button type="button"
                                class="btn btn-outline-primary btn-sm"
                                data-toggle="modal"
                                data-target="#allergenModal">
                            Choisir les allergènes
                        </button>

                        <div id="allergen-tags" class="mt-2"></div>
                        <input type="hidden" name="allergen" id="allergen-final">
                    </div>

                    <!-- INTOLERANCES -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Intolérances</label><br>

                        <button type="button"
                                class="btn btn-outline-warning btn-sm"
                                data-toggle="modal"
                                data-target="#intoleranceModal">
                            Choisir les intolérances
                        </button>

                        <div id="intol-tags" class="mt-2"></div>
                        <input type="hidden" name="intolerance" id="intol-final">
                    </div>
<!------------------------------------------------------------------------------->
                    <button type="submit" class="btn btn-info">Enregistrer</button>  
                </form>
            <?php endif; ?>
        </div>
    </div>
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
                                id="allergen_<?= md5($a) ?>"
                                <?= in_array($a, $checkedAllergens) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="allergen_<?= md5($a) ?>">
                                <?= htmlspecialchars($a) ?>
                            </label>
                        </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="applySelection(
                        'allergen-check',
                        'allergen-tags',
                        'allergen-final'
                    )" data-dismiss="modal">
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
                                    <input
                                    class="form-check-input intolerance-check"
                                    type="checkbox"
                                    value="<?= htmlspecialchars($i) ?>"
                                    id="intol_<?= md5($i) ?>"
                                    <?= in_array($i, $checkedIntolerances) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="intol_<?= md5($i) ?>">
                                    <?= htmlspecialchars($i) ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="modal-footer">
                        <button
                        type="button"
                        class="btn btn-primary"
                        onclick="applySelection(
                            'intolerance-check',
                            'intol-tags',
                            'intol-final'
                        )"
                        data-dismiss="modal">
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
        <button class="btn btn-primary" onclick="saveAllergen()">Enregistrer</button>
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
        <button class="btn btn-primary" onclick="saveIntolerance()">Enregistrer</button>
      </div>

    </div>
  </div>
</div>
        </div>
    </div>
<!---------------------FIN DIV PRINCIPAL--------------------->
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>