<?php $title = 'Editer les restrictions alimentaires';
    $inspection=  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
    $custom_js = <<<'JS'
    // Custom JavaScript can be added here
    /**********************************************
     *  SYSTEME D'AUTO-COMPLETION
     **********************************************/
    function setupAuto(inputId, boxId, containerId, hiddenId, sourceList) {

        const input = document.getElementById(inputId);
        const suggest = document.getElementById(boxId);
        const container = document.getElementById(containerId);
        const hiddenField = document.getElementById(hiddenId);

        if (!input) {
            console.warn("❌ Input introuvable:", inputId);
            return;
        }

        function refreshHidden() {
            const values = [...container.querySelectorAll(".tag")].map(t => t.dataset.value);
            hiddenField.value = values.join(",");
        }

        function addTag(value) {
            value = value.trim();
            if (!value) return;

            if ([...container.querySelectorAll(".tag")].some(t => t.dataset.value === value)) return;

            const span = document.createElement("span");
            span.className = "tag bg-primary text-white";
            span.dataset.value = value;
            span.innerHTML = value + ` <i class="bi bi-x remove-tag"></i>`;
            container.appendChild(span);

            suggest.style.display = "none";
            input.value = "";
            refreshHidden();
        }

        input.addEventListener("input", () => {
            let q = input.value.trim().toLowerCase();
            suggest.innerHTML = "";
            suggest.style.display = "none";

            if (q.length === 0) return;

            let filtered = sourceList.filter(item => item.toLowerCase().includes(q));

            filtered.forEach(item => {
                const div = document.createElement("div");
                div.className = "autocomplete-item";
                div.textContent = item;
                div.onclick = () => addTag(item);
                suggest.appendChild(div);
            });

            if (filtered.length > 0) suggest.style.display = "block";
        });

        container.addEventListener("click", e => {
            if (e.target.classList.contains("remove-tag")) {
                e.target.closest(".tag").remove();
                refreshHidden();
            }
        });

        document.addEventListener("click", e => {
            if (!suggest.contains(e.target) && e.target !== input) {
                suggest.style.display = "none";
            }
        });

        refreshHidden();
    }

    /**********************************************
     *  ACTIVATION (avec délai pour HTML prêt)
     **********************************************/
    setTimeout(() => {

        setupAuto(
            "allergen-input",
            "allergen-suggest",
            "allergen-tags",
            "allergen-final",
            <?= json_encode($allergenList) ?>
        );

        setupAuto(
            "intol-input",
            "intol-suggest",
            "intol-tags",
            "intol-final",
            <?= json_encode($intoleranceList) ?>
        );

    }, 200);
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
                        <a href="edit_meal_restriction.php?table=<?= $table ?>&id=<?= $m['id'] ?>" 
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
                    <h5 class="fw-bold">Allergènes</h5>

                    <div id="allergen-tags" class="mb-2">
                        <?php foreach ($checkedAllergens as $a): ?>
                            <span class="tag bg-danger text-white" data-value="<?= htmlspecialchars($a) ?>">
                                <?= htmlspecialchars($a) ?> 
                                <i class="bi bi-x remove-tag"></i>
                            </span>
                        <?php endforeach; ?>
                    </div>

                    <div class="position-relative">
                        <input type="text" id="allergen-input" class="form-control" placeholder="Ajouter un allergène...">
                        <div id="allergen-suggest" class="autocomplete-box"></div>
                    </div>

                    <input type="hidden" name="allergen_final" id="allergen-final">

                    <!-- INTOLERANCES -->
                    <h5 class="fw-bold mt-4">Intolérances</h5>

                    <div id="intol-tags" class="mb-2">
                        <?php foreach ($checkedIntolerances as $i): ?>
                            <span class="tag bg-warning text-dark" data-value="<?= htmlspecialchars($i) ?>">
                                <?= htmlspecialchars($i) ?> 
                                <i class="bi bi-x remove-tag"></i>
                            </span>
                        <?php endforeach; ?>
                    </div>

                    <div class="position-relative">
                        <input type="text" id="intol-input" class="form-control" placeholder="Ajouter une intolérance...">
                        <div id="intol-suggest" class="autocomplete-box"></div>
                    </div>

                    <input type="hidden" name="intol_final" id="intol-final">

                    <div class="text-center mt-4">
                        <button class="btn btn-success btn-lg px-5">
                            <i class="bi bi-check-circle"></i> Enregistrer
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>

    </div>
    
<!---------------------FIN DIV PRINCIPAL--------------------->
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>