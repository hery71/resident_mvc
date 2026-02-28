<?php $title = 'Modifier fete'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-4">
<div class="card-modern">
    <div class="card-header-pastel"><?= $title ?></div>
    <div class="card-body">
<form method="post" action="/fete/update">
    <input type="hidden" name="token" value="<?= e($token) ?>">
    <input type="hidden" name="mois" value="<?= $mois ?>">
    <input type="hidden" name="annee" value="<?= $annee ?>">
    <input type="hidden" name="id_fete" value="<?= $id_fete ?>">
    <!--Motif de la fete-->
    <div class="form-group">
        <label>Motif</label>
        <select name="motif" class="form-control w-auto">
        <?php foreach ($options['Motif'] as $h): ?>
                    <option value="<?= e($h)?>" <?= ($fete['motif'] == $h) ? 'selected':'';?>><?= e($h) ?></option>
                <?php endforeach; ?>
        </select>
    </div>
    <!--Liste des resident-->
    <div class="form-group">
        <label>Resident</label>
        <select name="id_resident" class="form-control w-auto">
            <option value="0">-----Sans Resident-----</option>
            <?php 
                foreach ($resident as $a):
                $n++;
            ?>
                    <option value="<?= e($a['id'])?>" <?= ($fete['id_resident'] == $a['id']) ? 'selected':'';?>><?= e($a['Prenom'] ." " .$a['Nom']) ?></option>
                <?php endforeach; ?>
        </select>
    </div>
    <!--Date pax heure lieux-->
   <div class="row align-items-end g-2">
    <div class="col-auto">
        <label class="form-label">Pax</label>
        <input type="input" name="pax" class="form-control" value ="<?=  $fete['pax'] ?>">
    </div>
    <div class="col-auto">
        <label class="form-label">Date</label>
        <input type="date" name="date" class="form-control" value ="<?=  $fete['date'] ?>">
    </div>

    <div class="col-auto">
        <label class="form-label">Heure</label>
        <select name="heure" class="form-control w-auto">
        <?php foreach ($options['Heure'] as $h): ?>
                    <option value="<?= e($h)?>" <?= ($fete['heure'] == $h) ? 'selected':'';?>> <?= e($h) ?></option>
                <?php endforeach; ?>
        </select>
    </div>
    
    <div class="col-auto">
        <label class="form-label">Lieux</label>
        <select name="lieux" class="form-control w-auto">
        <?php foreach ($options['Lieux'] as $h): ?>
                    <option value="<?= e($h)?>" <?= ($fete['lieux'] == $h) ? 'selected':'';?>><?= e($h) ?></option>
                <?php endforeach; ?>
        </select>
    </div>
            <!-- BOISSONS -->
    <div class="card rounded-4 shadow-sm mb-3">
        <div class="card-header fw-bold">Boissons</div>
        <div class="card-body d-flex flex-wrap gap-3">

            <div class="form-check">
                <input type="hidden" name="tea" value="0">
                <input class="form-check-input" type="checkbox" name="tea" value="1" id="tea" <?= $fete['tea'] ? 'checked':'';?>>
                <label class="form-check-label" for="tea">Tea</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="coffee" value="0">
                <input class="form-check-input" type="checkbox" name="coffee" value="1" id="coffee" <?= $fete['coffee'] ? 'checked':'';?>>
                <label class="form-check-label" for="coffee">Coffee</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="pop" value="0">
                <input class="form-check-input" type="checkbox" name="pop" value="1" id="pop" <?= $fete['pop'] ? 'checked':'';?>>
                <label class="form-check-label" for="pop">Pop</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="juice" value="0">
                <input class="form-check-input" type="checkbox" name="juice" value="1" id="juice" <?= $fete['juice'] ? 'checked':'';?>>
                <label class="form-check-label" for="juice">Juice</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="milk" value="0">
                <input class="form-check-input" type="checkbox" name="milk" value="1" id="milk" <?= $fete['milk'] ? 'checked':'';?>>
                <label class="form-check-label" for="milk">Milk</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="water" value="0">
                <input class="form-check-input" type="checkbox" name="water" value="1" id="water" <?= $fete['water'] ? 'checked':'';?>>
                <label class="form-check-label" for="water">Water</label>
            </div>

        </div>
    </div>

    <!-- NOURRITURE / CONDIMENTS -->
    <div class="card rounded-4 shadow-sm mb-3">
        <div class="card-header fw-bold">Nourriture & condiments</div>
        <div class="card-body d-flex flex-wrap gap-3">

            <div class="form-check">
                <input type="hidden" name="cake" value="0">
                <input class="form-check-input" type="checkbox" name="cake" value="1" id="cake" <?= $fete['cake'] ? 'checked':'';?>>
                <label class="form-check-label" for="cake">Cake</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="sugar" value="0">
                <input class="form-check-input" type="checkbox" name="sugar" value="1" id="sugar" <?= $fete['sugar'] ? 'checked':'';?>>
                <label class="form-check-label" for="sugar">Sugar</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="saltpepper" value="0">
                <input class="form-check-input" type="checkbox" name="saltpepper" value="1" id="saltpepper" <?= $fete['saltpepper'] ? 'checked':'';?>>
                <label class="form-check-label" for="saltpepper">Salt &amp; Pepper</label>
            </div>

        </div>
    </div>
     <!-- All Disposable -->
    <div class="card rounded-4 shadow-sm mb-3">
        <div class="card-header fw-bold">All Disposable</div>
        <div class="card-body d-flex flex-wrap gap-3">

            <div class="form-check">
                <input type="hidden" name="disposable" value="0">
                <input class="form-check-input" type="checkbox" id="disposable" name="disposable" value="1" <?= $fete['disposable'] ? 'checked':'';?>>
                <label class="form-check-label" for="disposable">All Disposable</label>
            </div>
        </div>
    </div>

    <!-- VAISSELLE -->
    <div class="card rounded-4 shadow-sm mb-3" id="vaisselles">
        <div class="card-header fw-bold">Vaisselle</div>
        <div class="card-body d-flex flex-wrap gap-3">

            <div class="form-check">
                <input type="hidden" name="cups" value="0">
                <input class="form-check-input" type="checkbox" name="cups" value="1" id="cups" <?= $fete['cups'] ? 'checked':'';?>>
                <label class="form-check-label" for="cups">Cups</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="juiceglass" value="0">
                <input class="form-check-input" type="checkbox" name="juiceglass" value="1" id="juiceglass" <?= $fete['juiceglass'] ? 'checked':'';?>>
                <label class="form-check-label" for="juiceglass">Juice glass</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="foamglass" value="0">
                <input class="form-check-input" type="checkbox" name="foamglass" value="1" id="foamglass" <?= $fete['foamglass'] ? 'checked':'';?>>
                <label class="form-check-label" for="foamglass">Foam glass</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="plasticdish6" value="0">
                <input class="form-check-input" type="checkbox" name="plasticdish6" value="1" id="plasticdish6" <?= $fete['plasticdish6'] ? 'checked':'';?>>
                <label class="form-check-label" for="plasticdish6">Plastic dish 6"</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="plasticdish9" value="0">
                <input class="form-check-input" type="checkbox" name="plasticdish9" value="1" id="plasticdish9" <?= $fete['plasticdish9'] ? 'checked':'';?>>
                <label class="form-check-label" for="plasticdish9">Plastic dish 9"</label>
            </div>

        </div>
    </div>

    <!-- USTENSILES -->
    <div class="card rounded-4 shadow-sm mb-3" id="ustensiles">
        <div class="card-header fw-bold">Ustensiles</div>
        <div class="card-body d-flex flex-wrap gap-3">

            <div class="form-check">
                <input type="hidden" name="knife" value="0">
                <input class="form-check-input" type="checkbox" name="knife" value="1" id="knife" <?= $fete['knife'] ? 'checked':'';?>>
                <label class="form-check-label" for="knife">Knife</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="fork" value="0">
                <input class="form-check-input" type="checkbox" name="fork" value="1" id="fork" <?= $fete['fork'] ? 'checked':'';?>>
                <label class="form-check-label" for="fork">Fork</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="teaspoon" value="0">
                <input class="form-check-input" type="checkbox" name="teaspoon" value="1" id="teaspoon" <?= $fete['teaspoon'] ? 'checked':'';?>>
                <label class="form-check-label" for="teaspoon">Teaspoon</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="cakeknife" value="0">
                <input class="form-check-input" type="checkbox" name="cakeknife" value="1" id="cakeknife" <?= $fete['cakeknife'] ? 'checked':'';?>>
                <label class="form-check-label" for="cakeknife">Cake knife</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="napkin" value="0">
                <input class="form-check-input" type="checkbox" name="napkin" value="1" id="napkin" <?= $fete['napkin'] ? 'checked':'';?>>
                <label class="form-check-label" for="napkin">Napkin</label>
            </div>

        </div>
    </div>

    <!-- LINGE & DIVERS -->
    <div class="card rounded-4 shadow-sm mb-3" id="lingeDivers">
        <div class="card-header fw-bold">Linge & divers</div>
        <div class="card-body d-flex flex-wrap gap-3">

            <div class="form-check">
                <input type="hidden" name="tablecloth" value="0">
                <input class="form-check-input" type="checkbox" name="tablecloth" value="1" id="tablecloth" <?= $fete['tablecloth'] ? 'checked':'';?>>
                <label class="form-check-label" for="tablecloth">Tablecloth</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="greycenter" value="0">
                <input class="form-check-input" type="checkbox" name="greycenter" value="1" id="greycenter" <?= $fete['greycenter'] ? 'checked':'';?>>
                <label class="form-check-label" for="greycenter">Grey center</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="trashbag" value="0">
                <input class="form-check-input" type="checkbox" name="trashbag" value="1" id="trashbag" <?= $fete['trashbag'] ? 'checked':'';?>>
                <label class="form-check-label" for="trashbag">Trash bag</label>
            </div>

            <div class="form-check">
                <input type="hidden" name="kitchencloth" value="0">
                <input class="form-check-input" type="checkbox" name="kitchencloth" value="1" id="kitchencloth" <?= $fete['kitchencloth'] ? 'checked':'';?>>
                <label class="form-check-label" for="kitchencloth">Kitchen cloth</label>
            </div>

        </div>
    </div>
    <div class="form-group mb-6">
        <label class="form-label">Informations<input type="input" name="informations" class="form-control" value ="<?=  $fete['informations'] ?>"></label>
    </div>
    <div class="mt-3">
        <button class="btn btn-info">
            Enregistrer Fête
        </button>   
</div>

</form>
</div>
</div>
</div>
</div> <!-- container -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const disposable = document.getElementById('disposable');

    const sections = [
        document.getElementById('lingeDivers'),
        document.getElementById('vaisselles'),
        document.getElementById('ustensiles')
    ];

    if (!disposable) return;

    disposable.addEventListener('change', function () {

        sections.forEach(section => {
            if (!section) return;

            if (this.checked) {
                section.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                    cb.checked = false;
                });
            }

            section.classList.toggle('d-none', this.checked);
        });

    });
});
document.addEventListener('DOMContentLoaded', function () {
     const disposable = document.getElementById('disposable');
     const sections = [
        document.getElementById('lingeDivers'),
        document.getElementById('vaisselles'),
        document.getElementById('ustensiles')
    ];
     if (document.getElementById('disposable').checked) {
            sections.forEach(section => {
            if (!section) return;

            if (this.checked) {
                section.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                    cb.checked = false;
                });
            }

            section.classList.toggle('d-none', this.checked);
        });
    } 
});
</script>
<?php require __DIR__ . '/../layout/footer.php'; ?>