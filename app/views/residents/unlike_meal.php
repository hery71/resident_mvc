<?php $title = 'Meals non aimés des résidents';

$custom_js = <<<'JS'

function reloadMealSelect(selectId, selectedValue = null)
{
    return fetch('/resident/getMeals')
    .then(r => r.json())
    .then(data => {

        const selects = [
            document.getElementById("mealSelect")
        ];

        selects.forEach(sel => {

            if (!sel) return;

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
        });
    });
}

function addUnlikeMeal(field, selectId)
{
    let sel = document.getElementById(selectId);
    let val = sel.value;
    let id  = document.getElementById('residentId').value;

    if (!val || !id) {
        alert('Valeur ou résident manquant');
        return;
    }

    fetch('/resident/updateUnlikeMeal', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'id=' + encodeURIComponent(id)
            + '&field=' + encodeURIComponent(field)
            + '&value=' + encodeURIComponent(val)
            + '&action=add'
    })
    .then(() => location.reload())
    .catch(() => alert('Erreur enregistrement'));
}

function removeUnlikeMeal(field, value)
{
    let id = document.getElementById('residentId').value;

    if (!id || !value) return;

    if (!confirm("Supprimer : " + value + " ?")) return;

    fetch('/resident/updateUnlikeMeal', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'id=' + encodeURIComponent(id)
            + '&field=' + encodeURIComponent(field)
            + '&value=' + encodeURIComponent(value)
            + '&action=remove'
    })
    .then(() => location.reload())
    .catch(() => alert('Erreur suppression'));
}

document.addEventListener('DOMContentLoaded', function () {
    reloadMealSelect('mealSelect');
});
function suggestMeal(term, datalistId)
{
    let list = document.getElementById(datalistId);

    if (!term) {
        list.innerHTML = '';
        return;
    }

    fetch('/resident/suggestMeal?term=' + encodeURIComponent(term))
    .then(r => r.json())
    .then(data => {
        list.innerHTML = '';

        data.forEach(i => {
            list.innerHTML += `<option value="${i}"></option>`;
        });
    });
}

function selectMealFromInput(inputId, selectId)
{
    let input = document.getElementById(inputId);
    let val = input.value.trim();
    let sel = document.getElementById(selectId);

    if (!val) return;

    for (let i = 0; i < sel.options.length; i++) {
        if (sel.options[i].value.toLowerCase() === val.toLowerCase()) {
            sel.selectedIndex = i;
            return;
        }
    }

    alert("Non trouvé dans la liste");
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
                    <strong><?= e($resident['Prenom'] . ' ' . $resident['Nom']) ?></strong>
                </div>

                <h5>plats ou boissons  non apréciés par le resident</h5>

                <div class="mb-2">
                    <?php foreach (array_filter(array_map('trim', explode(',', $resident['Unlike_meal'] ?? ''))) as $m): ?>
                        <span class="badge badge-danger mr-1"
                            style="cursor:pointer"
                            onclick="removeUnlikeMeal('Unlike_meal','<?= addslashes($m) ?>')">
                            <?= e($m) ?>
                        </span>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex mb-3">
                    <select id="mealSelect" class="form-control mr-2"></select>

                    <button type="button" class="btn btn-primary"
                        onclick="addUnlikeMeal('Unlike_meal','mealSelect')">
                        Ajouter
                    </button>
                </div>
                <div class="d-flex mb-3">
                    <input id="mealSearch" class="form-control mr-2"
                        list="mealSuggestions"
                        onkeyup="suggestMeal(this.value,'mealSuggestions')"
                        placeholder="Rechercher meal">

                    <button type="button" class="btn btn-info"
                        onclick="selectMealFromInput('mealSearch','mealSelect')">
                        Selectionner
                    </button>
                </div>

<datalist id="mealSuggestions"></datalist>

            <?php endif; ?>

        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>