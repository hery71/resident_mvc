<?php $title = 'Créer Fêtes'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">
<div class="card-modern">
<div class="card-header-pastel"><?= $title ?></div>
<div class="card-body">

<form method="post" action="/fete/store">
<input type="hidden" name="token" value="<?= e($token) ?>">

<!-- ================= INFOS PRINCIPALES ================= -->
<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <h5 class="mb-3">Informations générales</h5>

        <div class="form-row align-items-end">

            <div class="form-group col-md-3">
                <label>Motif</label>
                <select name="motif" class="form-control">
                    <?php foreach ($options['Motif'] as $h): ?>
                        <option value="<?= e($h)?>"><?= e($h) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label>Resident</label>
                <select name="id_resident" class="form-control">
                    <option value="0">-----Sans Resident-----</option>
                    <?php foreach ($resident as $a): ?>
                        <option value="<?= e($a['id'])?>">
                            <?= e($a['Prenom'] ." " .$a['Nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>
    </div>
</div>

<!-- ================= DATE / PAX / HEURE / LIEUX ================= -->
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <div class="form-row align-items-end">

            <div class="form-group col-md-2">
                <label>Pax</label>
                <input type="input" name="pax" class="form-control">
            </div>

            <div class="form-group col-md-3">
                <label>Date</label>
                <input type="date" name="date" class="form-control">
            </div>

            <div class="form-group col-md-3">
                <label>Heure</label>
                <select name="heure" class="form-control">
                    <?php foreach ($options['Heure'] as $h): ?>
                        <option value="<?= e($h)?>"><?= e($h) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label>Lieux</label>
                <select name="lieux" class="form-control">
                    <?php foreach ($options['Lieux'] as $h): ?>
                        <option value="<?= e($h)?>"><?= e($h) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>
    </div>
</div>

<!-- ================= BOISSONS ================= -->
<div class="card mb-3">
    <div class="card-header font-weight-bold">Boissons</div>
    <div class="card-body">
        <?php $boissons = ['tea'=>'Tea','coffee'=>'Coffee','pop'=>'Pop','juice'=>'Juice','milk'=>'Milk','water'=>'Water']; ?>
        <?php foreach ($boissons as $k=>$v): ?>
        <div class="form-check">
            <input type="hidden" name="<?= $k ?>" value="0">
            <input class="form-check-input" type="checkbox" name="<?= $k ?>" value="1">
            <label class="form-check-label"><?= $v ?></label>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ================= NOURRITURE ================= -->
<div class="card mb-3">
    <div class="card-header font-weight-bold">Nourriture & condiments</div>
    <div class="card-body">
        <?php $food = ['cake'=>'Cake','sugar'=>'Sugar','saltpepper'=>'Salt & Pepper']; ?>
        <?php foreach ($food as $k=>$v): ?>
        <div class="form-check">
            <input type="hidden" name="<?= $k ?>" value="0">
            <input class="form-check-input" type="checkbox" name="<?= $k ?>" value="1">
            <label class="form-check-label"><?= $v ?></label>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ================= DISPOSABLE ================= -->
<div class="card mb-3">
    <div class="card-header font-weight-bold">All Disposable</div>
    <div class="card-body">
        <div class="form-check">
            <input type="hidden" name="disposable" value="0">
            <input class="form-check-input" type="checkbox" id="disposable" name="disposable" value="1">
            <label class="form-check-label">All Disposable</label>
        </div>
    </div>
</div>

<!-- ================= VAISSELLE ================= -->
<div class="card mb-3" id="vaisselles">
    <div class="card-header font-weight-bold">Vaisselle</div>
    <div class="card-body">
        <?php $vaisselle = [
            'cups'=>'Cups','juiceglass'=>'Juice glass','foamglass'=>'Foam glass',
            'plasticdish6'=>'Plastic dish 6"','plasticdish9'=>'Plastic dish 9"'
        ]; ?>
        <?php foreach ($vaisselle as $k=>$v): ?>
        <div class="form-check">
            <input type="hidden" name="<?= $k ?>" value="0">
            <input class="form-check-input" type="checkbox" name="<?= $k ?>" value="1">
            <label class="form-check-label"><?= $v ?></label>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ================= USTENSILES ================= -->
<div class="card mb-3" id="ustensiles">
    <div class="card-header font-weight-bold">Ustensiles</div>
    <div class="card-body">
        <?php $ust = ['knife'=>'Knife','fork'=>'Fork','teaspoon'=>'Teaspoon','cakeknife'=>'Cake knife','napkin'=>'Napkin']; ?>
        <?php foreach ($ust as $k=>$v): ?>
        <div class="form-check">
            <input type="hidden" name="<?= $k ?>" value="0">
            <input class="form-check-input" type="checkbox" name="<?= $k ?>" value="1">
            <label class="form-check-label"><?= $v ?></label>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ================= LINGE ================= -->
<div class="card mb-3" id="lingeDivers">
    <div class="card-header font-weight-bold">Linge & divers</div>
    <div class="card-body">
        <?php $linge = ['tablecloth'=>'Tablecloth','greycenter'=>'Grey center','trashbag'=>'Trash bag','kitchencloth'=>'Kitchen cloth']; ?>
        <?php foreach ($linge as $k=>$v): ?>
        <div class="form-check">
            <input type="hidden" name="<?= $k ?>" value="0">
            <input class="form-check-input" type="checkbox" name="<?= $k ?>" value="1">
            <label class="form-check-label"><?= $v ?></label>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ================= INFOS ================= -->
<div class="card mb-4">
    <div class="card-body">
        <label>Informations</label>
        <input type="input" name="informations" class="form-control">
    </div>
</div>

<div class="text-right mb-5">
    <button class="btn btn-info btn-lg">💾 Enregistrer</button>
</div>

</form>
</div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const disposable = document.getElementById('disposable');
    const sections = ['lingeDivers','vaisselles','ustensiles'];

    function toggleSections() {
        sections.forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;

            el.classList.toggle('d-none', disposable.checked);

            if (disposable.checked) {
                el.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            }
        });
    }

    if (disposable) {
        disposable.addEventListener('change', toggleSections);
        toggleSections();
    }
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>