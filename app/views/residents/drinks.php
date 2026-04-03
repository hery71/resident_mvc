<?php $title = 'Boissons des residents';
$custom_js = <<<'JS'
function reloadDrinkSelect(type, selectId, selectedValue = null)
{
    return fetch('/resident/getDictionary?type=' + type)
    .then(r => r.json())
    .then(data => {
         const selects = [
            document.getElementById("drinkBreakfastSelect"),
            document.getElementById("drinkLunchSelect"),
            document.getElementById("drinkDinnerSelect")
        ];

        //let sel = document.getElementById(selectId);
        selects.forEach(sel => {

        if (!sel) return;
        //drinkBreakfastNew,drinkLunchNew,drinkDinnerNew
        sel.innerHTML = "";

        data.sort((a,b)=>a.localeCompare(b,'fr',{sensitivity:'base'}));

        let found = false;

        data.forEach(i => {
            let opt = document.createElement("option");
            opt.value = i;
            opt.textContent = i;

            if (selectedValue && i.toLowerCase() === selectedValue.toLowerCase()) {
                opt.selected = true;
                found = true;
            }

            sel.appendChild(opt);
        });

        if (!found && selectedValue) {
            sel.value = selectedValue;
        }
    })
    });
}

function addDrinkSelect(field, selectId)
{
    let sel = document.getElementById(selectId);
    let val = sel.value;
    let id  = document.getElementById('residentId').value;

    if (!val || !id) {
        alert('Valeur ou résident manquant');
        return;
    }

    fetch('/resident/updateDrink', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'id=' + encodeURIComponent(id)
            + '&field=' + encodeURIComponent(field)
            + '&value=' + encodeURIComponent(val)
            + '&action=add'
    })
    .then(r => r.text())
    .then(text => {
        console.log('updateDrink =>', text);
        location.reload();
    })
    .catch(err => {
        console.error(err);
        alert('Erreur enregistrement');
    });
}

function addDrinkNew(field, inputId, type, selectId)
{
    let input = document.getElementById(inputId);
    let val = input.value.trim();

    if (!val) return;

    let sel = document.getElementById(selectId);

    // 🔍 vérifier si existe
    let exists = false;

    for (let i = 0; i < sel.options.length; i++) {
        if (sel.options[i].value.toLowerCase() === val.toLowerCase()) {
            exists = true;

            // ✅ sélectionner directement
            sel.selectedIndex = i;
            break;
        }
    }

    // ✅ CAS 1 → existe → rien d'autre à faire
    if (exists) {
        input.value = "";
        return;
    }

    // 🔵 CAS 2 → n'existe pas → ajouter + reload
    fetch('/resident/addDictionary', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'type=' + encodeURIComponent(type)
            + '&value=' + encodeURIComponent(val)
    })
    .then(r => r.text())
    .then(() => {
        // reload + sélectionner le nouvel item
        reloadDrinkSelect(type, selectId, val);
        input.value = "";
    })
    .catch(err => {
        console.error(err);
        alert('Erreur ajout dictionnaire');
    });
}

function suggestDrink(term, datalistId, type)
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
    reloadDrinkSelect('drink', 'drinkBreakfastSelect');
    reloadDrinkSelect('drink', 'drinkLunchSelect');
    reloadDrinkSelect('drink', 'drinkDinnerSelect');
});
function removeDrink(field, value)
{
    let id = document.getElementById('residentId').value;

    if (!id || !value) return;

    if (!confirm("Supprimer cet élément : " + value + " ?")) {
        return;
    }

    fetch('/resident/updateDrink', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'id=' + encodeURIComponent(id)
            + '&field=' + encodeURIComponent(field)
            + '&value=' + encodeURIComponent(value)
            + '&action=remove'
    })
    .then(r => r.text())
    .then(text => {
        console.log('removeDrink =>', text);
        location.reload();
    })
    .catch(err => {
        console.error(err);
        alert('Erreur suppression');
    });
}
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

                <h5>Petit Déjeuner</h5>
                <div class="mb-2">
                    <?php foreach (array_filter(array_map('trim', explode(',', $resident['Drink_breakfast'] ?? ''))) as $a): ?>
                        <span class="badge badge-danger mr-1"
                            style="cursor:pointer"
                            onclick="removeDrink('Drink_breakfast','<?= addslashes($a) ?>')">
                            <?= e($a) ?>
                        </span>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex mb-2">
                    <select id="drinkBreakfastSelect" class="form-control mr-2"></select>
                    <button type="button" class="btn btn-primary"
                        onclick="addDrinkSelect('Drink_breakfast','drinkBreakfastSelect')">
                        Ajouter
                    </button>
                </div>

                <div class="d-flex mb-3">
                    <input id="drinkBreakfastNew" class="form-control mr-2"
                        list="drinkBreakfastSuggestions"
                        onkeyup="suggestDrink(this.value,'drinkBreakfastSuggestions','drink')"
                        placeholder="Rechercher / Ajouter">
                    <button type="button" class="btn btn-success"
                        onclick="addDrinkNew('Drink_breakfast','drinkBreakfastNew','drink','drinkBreakfastSelect')">
                        Rechercher Ajouter
                    </button>
                </div>

                <datalist id="drinkBreakfastSuggestions"></datalist>

                <h5>Dejeuner</h5>
                <div class="mb-2">
                    <?php foreach (array_filter(array_map('trim', explode(',', $resident['Drink_lunch'] ?? ''))) as $i): ?>
                        <span class="badge badge-danger mr-1"
                            style="cursor:pointer"
                            onclick="removeDrink('Drink_lunch','<?= addslashes($i) ?>')">
                            <?= e($i) ?>
                        </span>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex mb-2">
                    <select id="drinkLunchSelect" class="form-control mr-2"></select>
                    <button type="button" class="btn btn-primary"
                        onclick="addDrinkSelect('Drink_lunch','drinkLunchSelect')">
                        Ajouter
                    </button>
                </div>

                <div class="d-flex mb-3">
                    <input id="drinkLunchNew" class="form-control mr-2"
                        list="drinkLunchSuggestions"
                        onkeyup="suggestDrink(this.value,'drinkLunchSuggestions','drink')"
                        placeholder="Rechercher / Ajouter">
                    <button type="button" class="btn btn-success"
                        onclick="addDrinkNew('Drink_lunch','drinkLunchNew','drink','drinkLunchSelect')">
                                            
                        Rechercher Ajouter
                    </button>
                </div>

                <datalist id="drinkLunchSuggestions"></datalist>

                <h5>Dîner</h5>
                <div class="mb-2">
                    <?php foreach (array_filter(array_map('trim', explode(',', $resident['Drink_dinner'] ?? ''))) as $i): ?>
                        <span class="badge badge-danger mr-1"
                            style="cursor:pointer"
                            onclick="removeDrink('Drink_dinner','<?= addslashes($i) ?>')">
                            <?= e($i) ?>
                        </span>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex mb-2">
                    <select id="drinkDinnerSelect" class="form-control mr-2"></select>
                    <button type="button" class="btn btn-danger"
                        onclick="addDrinkSelect('Drink_dinner','drinkDinnerSelect')">
                        Ajouter
                    </button>
                </div>

                <div class="d-flex mb-3">
                    <input id="drinkDinnerNew" class="form-control mr-2"
                        list="drinkDinnerSuggestions"
                        onkeyup="suggestDrink(this.value,'drinkDinnerSuggestions','drink')"
                        placeholder="Rechercher / Ajouter">
                    <button type="button" class="btn btn-danger"
                        onclick="addDrinkNew('Drink_dinner','drinkDinnerNew','drink','drinkDinnerSelect')">
                        Rechercher Ajouter
                    </button>
                </div>
                <datalist id="drinkDinnerSuggestions"></datalist>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>