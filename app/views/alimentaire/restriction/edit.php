<?php $title = 'Editer les restrictions alimentaires';
    $inspection=  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
    $custom_js = <<<'JS'
    // Custom JavaScript can be added here
    function applySelection(checkClass, containerId, hiddenId) {

    const checks = document.querySelectorAll('.' + checkClass + ':checked');
    const container = document.getElementById(containerId);
    const hidden = document.getElementById(hiddenId);

    container.innerHTML = '';
    const values = [];

    checks.forEach(chk => {
        values.push(chk.value);

        const badge = document.createElement('span');
        badge.className = 'badge bg-primary me-1 mb-1';
        badge.textContent = chk.value;

        container.appendChild(badge);
    });

    hidden.value = values.join(',');
    }
    JS;
    $custom_style = <<<CSS
    /* Custom CSS can be added here */
    CSS;
?>
<?php require __DIR__ . '/../../layout/header.php'; ?>
<div class="container center">
    <h3> Editer les Restrictions Alimentatires</h3>
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
                    <button type="submit" class="btn btn-success">Enregistrer</button>  
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
                                    >
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
<!---------------------FIN DIV PRINCIPAL--------------------->
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>