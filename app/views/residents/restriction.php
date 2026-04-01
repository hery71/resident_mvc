<?php $title = 'Restrictions Alimentaires'; 

$custom_js = <<<'JS'

function loadRestrictionSelect(type, selectId)
{
    fetch('/resident/getDictionary?type=' + type)
    .then(r => r.json())
    .then(data => {

        let sel = document.getElementById(selectId);
        sel.innerHTML = '';

        data.sort((a,b)=>a.localeCompare(b,'fr',{sensitivity:'base'}));

        data.forEach(i => {
            let opt = document.createElement('option');
            opt.value = i;
            opt.textContent = i;
            sel.appendChild(opt);
        });
    });
}

function addRestrictionSelect(field, selectId)
{
    let val = document.getElementById(selectId).value;
    let id  = document.getElementById('residentId').value;

    if(!val) return;

    fetch('/resident/updateRestriction', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'id='+id+'&field='+field+'&value='+encodeURIComponent(val)+'&action=add'
    })
    .then(()=> location.reload());
}

function addRestrictionNew(field, inputId, type, selectId)
{
    let val = document.getElementById(inputId).value.trim();
    let id  = document.getElementById('residentId').value;

    if(!val) return;

    let sel = document.getElementById(selectId);

    // 🔥 1. vérifier si existe déjà dans le select
    let found = false;

    for(let i=0;i<sel.options.length;i++){
        if(sel.options[i].value.toLowerCase() === val.toLowerCase()){
            sel.selectedIndex = i;
            found = true;
            break;
        }
    }

    // 🔥 si trouvé → ajouter direct
    if(found){
        addRestrictionSelect(field, selectId);
        document.getElementById(inputId).value = '';
        return;
    }

    // 🔥 sinon → ajouter au JSON
    fetch('/resident/addDictionary', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'type='+type+'&value='+encodeURIComponent(val)
    })
    .then(r=>r.json())
    .then(res => {

        // 🔥 reload dropdown
        loadRestrictionSelect(type, selectId);

        // 🔥 attendre reload puis sélectionner le nouvel item
        setTimeout(()=>{

            let sel = document.getElementById(selectId);

            for(let i=0;i<sel.options.length;i++){
                if(sel.options[i].value.toLowerCase() === val.toLowerCase()){
                    sel.selectedIndex = i;
                    break;
                }
            }

            // 🔥 ajouter au résident
            addRestrictionSelect(field, selectId);

        },200);

        document.getElementById(inputId).value = '';
    });
}

function suggestRestriction(term, datalistId, type)
{
    if(!term){
        document.getElementById(datalistId).innerHTML='';
        return;
    }

    fetch('/resident/suggest?type='+type+'&term='+encodeURIComponent(term))
    .then(r=>r.json())
    .then(data => {

        let list = document.getElementById(datalistId);
        list.innerHTML='';

        data.forEach(i=>{
            list.innerHTML += `<option value="${i}"></option>`;
        });

    });
}

document.addEventListener('DOMContentLoaded', function(){

    loadRestrictionSelect('allergies','allergySelect');
    loadRestrictionSelect('intolerances','intoleranceSelect');
    loadRestrictionSelect('ingredients','ingredientSelect');

});
function suggestRestriction(term, datalistId, type)
{
    if(!term){
        document.getElementById(datalistId).innerHTML = '';
        return;
    }

    fetch('/resident/suggest?type=' + type + '&term=' + encodeURIComponent(term))
    .then(r => r.json())
    .then(data => {

        let list = document.getElementById(datalistId);
        list.innerHTML = '';

        data.forEach(i => {
            list.innerHTML += `<option value="${i}"></option>`;
        });

    });
}

JS;
?>

<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">
<div class="card-modern">
<div class="card-header-pastel"><?= $title ?></div>

<div class="card-body">

<!-- 🔹 SELECT RESIDENT -->
<form method="get" class="mb-3">
    <label><strong>Choisir un résident</strong></label>
    <select name="id" class="form-control" onchange="this.form.submit()">
        <?php foreach($residents as $r): ?>
            <option value="<?= $r['Id'] ?>"
                <?= ($resident && $resident['id']==$r['Id']) ? 'selected' : '' ?>>
                <?= e($r['Prenom'].' '.$r['Nom']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if(!empty($resident)): ?>

<input type="hidden" id="residentId" value="<?= $resident['id'] ?>">

<!-- 🔹 INFOS -->
<div class="mb-3 p-3 border rounded bg-light">
    <strong><?= e($resident['Prenom'].' '.$resident['Nom']) ?></strong><br>
    Civilité: <?= e($resident['Gender'] ?? '') ?> |
    Age: <?= date('Y') - date('Y', strtotime($resident['Anniversaire'] ?? '')) ?><br>
    Lieu repas: <?= e($resident['LieuRepas'] ?? '') ?> |
    Consistance: <?= e($resident['Consistance'] ?? '') ?> |
    Autonomie: <?= e($resident['ModeEating'] ?? '') ?>
</div>

<!-- ================= ALLERGIES ================= -->
<h5>Allergies</h5>

<div class="mb-2">
<?php foreach(array_filter(array_map('trim', explode(',', $resident['Allergie'] ?? ''))) as $a): ?>
    <span class="badge badge-secondary mr-1"><?= e($a) ?></span>
<?php endforeach; ?>
</div>

<div class="d-flex mb-2">
    <select id="allergySelect" class="form-control mr-2"></select>
    <button class="btn btn-primary"
        onclick="addRestrictionSelect('Allergie','allergySelect')">
        Ajouter
    </button>
</div>

<div class="d-flex mb-3">
    <input id="allergyNew" class="form-control mr-2"
        list="allergySuggestions"
        onkeyup="suggestRestriction(this.value,'allergySuggestions','allergies')"
        placeholder="Rechercher / Ajouter">
    <button class="btn btn-success"
        onclick="addRestrictionNew('Allergie','allergyNew','allergies','allergySelect')">
        Rechercher Ajouter
    </button>
</div>

<datalist id="allergySuggestions"></datalist>

<!-- ================= INTOLERANCES ================= -->
<h5>Intolérances</h5>

<div class="mb-2">
<?php foreach(array_filter(array_map('trim', explode(',', $resident['Intolerance'] ?? ''))) as $i): ?>
    <span class="badge badge-secondary mr-1"><?= e($i) ?></span>
<?php endforeach; ?>
</div>

<div class="d-flex mb-2">
    <select id="intoleranceSelect" class="form-control mr-2"></select>
    <button class="btn btn-primary"
        onclick="addRestrictionSelect('Intolerance','intoleranceSelect')">
        Ajouter
    </button>
</div>

<div class="d-flex mb-3">
    <input id="intoleranceNew" class="form-control mr-2"
        list="intoleranceSuggestions"
        onkeyup="suggestRestriction(this.value,'intoleranceSuggestions','intolerances')"
        placeholder="Rechercher / Ajouter">
    <button class="btn btn-success"
        onclick="addRestrictionNew('Intolerance','intoleranceNew','intolerances','intoleranceSelect')">
        Rechercher Ajouter
    </button>
</div>

<datalist id="intoleranceSuggestions"></datalist>

<!-- ================= INGREDIENTS ================= -->
<h5>Ingrédients non autorisés</h5>

<div class="mb-2">
<?php foreach(array_filter(array_map('trim', explode(',', $resident['ingredients'] ?? ''))) as $i): ?>
    <span class="badge badge-danger mr-1"><?= e($i) ?></span>
<?php endforeach; ?>
</div>

<div class="d-flex mb-2">
    <select id="ingredientSelect" class="form-control mr-2"></select>
    <button class="btn btn-danger"
        onclick="addRestrictionSelect('ingredients','ingredientSelect')">
        Ajouter
    </button>
</div>

<div class="d-flex mb-3">
    <input id="ingredientNew" class="form-control mr-2"
        list="ingredientSuggestions"
        onkeyup="suggestRestriction(this.value,'ingredientSuggestions','ingredients')"
        placeholder="Rechercher / Ajouter">
    <button class="btn btn-danger"
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