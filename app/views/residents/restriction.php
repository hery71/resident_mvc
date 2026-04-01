<?php $title = 'Restrictions Alimentaires'; 

$custom_js = <<<'JS'
function reloadRestrictionSelect(type, selectId, selectedValue = null)
{
    fetch('/resident/getDictionary?type=' + type)
    .then(r => r.json())
    .then(data => {

        let sel = document.getElementById(selectId);

        if (!sel) {
            console.log('Select introuvable:', selectId);
            return;
        }

        sel.innerHTML = "";

        data.sort((a,b)=>a.localeCompare(b,'fr',{sensitivity:'base'}));

        data.forEach(i => {
            let opt = document.createElement("option");
            opt.value = i;
            opt.textContent = i;

            if (selectedValue && i.toLowerCase() === selectedValue.toLowerCase()) {
                opt.selected = true;
            }

            sel.appendChild(opt);
        });
    })
    .catch(err => console.error(type, err));
}

function addRestrictionSelect(field, selectId)
{
    let sel = document.getElementById(selectId);
    let val = sel.value;
    let id  = document.getElementById('residentId').value;

    if (!val || !id) {
        alert('Valeur ou résident manquant');
        return;
    }

    fetch('/resident/updateRestriction', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'id=' + encodeURIComponent(id)
            + '&field=' + encodeURIComponent(field)
            + '&value=' + encodeURIComponent(val)
            + '&action=add'
    })
    .then(r => r.text())
    .then(text => {
        console.log('updateRestriction =>', text);
        location.reload();
    })
    .catch(err => {
        console.error(err);
        alert('Erreur enregistrement');
    });
}

function addRestrictionNew(field, inputId, type, selectId)
{
    let input = document.getElementById(inputId);
    let val = input.value.trim();

    if (!val) return;

    let sel = document.getElementById(selectId);
    let exists = false;

    for (let i = 0; i < sel.options.length; i++) {
        if (sel.options[i].value.toLowerCase() === val.toLowerCase()) {
            exists = true;
            break;
        }
    }

    if (exists) {
        reloadRestrictionSelect(type, selectId, val).then(() => {
            addRestrictionSelect(field, selectId);
        });
        input.value = "";
        return;
    }

    fetch('/resident/addDictionary', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'type=' + encodeURIComponent(type)
            + '&value=' + encodeURIComponent(val)
    })
    .then(r => r.text())
    .then(text => {
        console.log('addDictionary =>', text);
        return reloadRestrictionSelect(type, selectId, val);
    })
    .then(() => {
        addRestrictionSelect(field, selectId);
        input.value = "";
    })
    .catch(err => {
        console.error(err);
        alert('Erreur ajout dictionnaire');
    });
}

function suggestRestriction(term, datalistId, type)
{
    let list = document.getElementById(datalistId);

    if (!term) {
        list.innerHTML = '';
        return;
    }

    fetch('/resident/suggest?type=' + type + '&term=' + encodeURIComponent(term))
    .then(r => r.json())
    .then(data => {
        list.innerHTML = '';

        data.forEach(i => {
            list.innerHTML += `<option value="${i}"></option>`;
        });
    });
}

document.addEventListener('DOMContentLoaded', function () {
    reloadRestrictionSelect('allergies', 'allergySelect');
    reloadRestrictionSelect('intolerances', 'intoleranceSelect');
    reloadRestrictionSelect('ingredients', 'ingredientSelect');
});
JS;
?>

<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">
    <div class="card-modern">
        <div class="card-header-pastel"><?= $title ?></div>

        <div class="card-body">

            <form method="get" class="mb-3">
                <label><strong>Choisir un résident</strong></label>
                <select name="id" class="form-control" onchange="this.form.submit()">
                    <?php foreach ($residents as $r): ?>
                        <option value="<?= (int)$r['Id'] ?>"
                            <?= (!empty($resident) && (int)$resident['id'] === (int)$r['Id']) ? 'selected' : '' ?>>
                            <?= e($r['Prenom'] . ' ' . $r['Nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <?php if (!empty($resident)): ?>

                <input type="hidden" id="residentId" value="<?= (int)$resident['id'] ?>">

                <div class="mb-3 p-3 border rounded bg-light">
                    <strong><?= e($resident['Prenom'] . ' ' . $resident['Nom']) ?></strong><br>
                    Civilité: <?= e($resident['Gender'] ?? '') ?> |
                    Age: <?= !empty($resident['Anniversaire']) ? (date('Y') - date('Y', strtotime($resident['Anniversaire']))) : '' ?><br>
                    Lieu repas: <?= e($resident['LieuRepas'] ?? '') ?> |
                    Consistance: <?= e($resident['Consistance'] ?? '') ?> |
                    Autonomie: <?= e($resident['ModeEating'] ?? '') ?>
                </div>

                <h5>Allergies</h5>
                <div class="mb-2">
                    <?php foreach (array_filter(array_map('trim', explode(',', $resident['Allergie'] ?? ''))) as $a): ?>
                        <span class="badge badge-secondary mr-1"><?= e($a) ?></span>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex mb-2">
                    <select id="allergySelect" class="form-control mr-2"></select>
                    <button type="button" class="btn btn-primary"
                        onclick="addRestrictionSelect('Allergie','allergySelect')">
                        Ajouter
                    </button>
                </div>

                <div class="d-flex mb-3">
                    <input id="allergyNew" class="form-control mr-2"
                        list="allergySuggestions"
                        onkeyup="suggestRestriction(this.value,'allergySuggestions','allergies')"
                        placeholder="Rechercher / Ajouter">
                    <button type="button" class="btn btn-success"
                        onclick="addRestrictionNew('Allergie','allergyNew','allergies','allergySelect')">
                        Rechercher Ajouter
                    </button>
                </div>

                <datalist id="allergySuggestions"></datalist>

                <h5>Intolérances</h5>
                <div class="mb-2">
                    <?php foreach (array_filter(array_map('trim', explode(',', $resident['Intolerance'] ?? ''))) as $i): ?>
                        <span class="badge badge-secondary mr-1"><?= e($i) ?></span>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex mb-2">
                    <select id="intoleranceSelect" class="form-control mr-2"></select>
                    <button type="button" class="btn btn-primary"
                        onclick="addRestrictionSelect('Intolerance','intoleranceSelect')">
                        Ajouter
                    </button>
                </div>

                <div class="d-flex mb-3">
                    <input id="intoleranceNew" class="form-control mr-2"
                        list="intoleranceSuggestions"
                        onkeyup="suggestRestriction(this.value,'intoleranceSuggestions','intolerances')"
                        placeholder="Rechercher / Ajouter">
                    <button type="button" class="btn btn-success"
                        onclick="addRestrictionNew('Intolerance','intoleranceNew','intolerances','intoleranceSelect')">
                        Rechercher Ajouter
                    </button>
                </div>

                <datalist id="intoleranceSuggestions"></datalist>

                <h5>Ingrédients non autorisés</h5>
                <div class="mb-2">
                    <?php foreach (array_filter(array_map('trim', explode(',', $resident['ingredients'] ?? ''))) as $i): ?>
                        <span class="badge badge-danger mr-1"><?= e($i) ?></span>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex mb-2">
                    <select id="ingredientSelect" class="form-control mr-2"></select>
                    <button type="button" class="btn btn-danger"
                        onclick="addRestrictionSelect('ingredients','ingredientSelect')">
                        Ajouter
                    </button>
                </div>

                <div class="d-flex mb-3">
                    <input id="ingredientNew" class="form-control mr-2"
                        list="ingredientSuggestions"
                        onkeyup="suggestRestriction(this.value,'ingredientSuggestions','ingredients')"
                        placeholder="Rechercher / Ajouter">
                    <button type="button" class="btn btn-danger"
                        onclick="addRestrictionNew('ingredients','ingredientNew','ingredients','ingredientSelect')">
                        Rechercher Ajouter
                    </button>
                </div>

                <datalist id="ingredientSuggestions"></datalist>

            <?php endif; ?>

        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>