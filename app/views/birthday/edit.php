<?php $title = 'Editer Anniversaire'; 
    $custom_js = <<<'JS'
    // Custom JavaScript can be added here
    function verifierDate() {
        const dateCake = document.getElementById("dateCake").value;
        const dateFete = document.getElementById("date").value;
        if (dateCake > dateFete) {
            alert("La date du cake est incorrecte");
            const errorDiv = document.getElementById("dateError");
            errorDiv.classList.remove("d-none");
            window.scrollTo(0,0);
            return;
        }
        // si tout est bon → envoyer formulaire
        document.getElementById("formFete").submit();
    }
    JS;
    $custom_style = <<<'CSS'
    /* Custom CSS can be added here */
    CSS;
require __DIR__ . '/../layout/header.php'; 
$messageCake = $cake['dateLivraison'] ?? 'Non Commande';
if ($messageCake != 'Non Commande') {
    //Comparer avec la date de la fete d'anniversaire avec $birthday['date'] 
    $dateBirthday = new DateTime($birthday['Anniversaire']);
    $dateFete = new DateTime($birthday['date']);    
    $dateCake = new DateTime($cake['dateLivraison']);
    $interval = $dateFete->diff($dateCake);
    if($interval->invert == 0) {
        echo '<div class="alert alert-danger">⚠️ La date de livraison du gâteau ('.$dateCake->format('d-m-Y').') N EST PAS antérieure à la date de la fete ('.$dateFete->format('d-m-Y').'). Veuillez vérifier les dates.</div>';
    } else {
        echo '<div class="alert alert-success">✅ La date de livraison du gâteau est antérieure à la date de la fete.</div>';
    }   
}
?>
<div id="dateError" class="alert alert-danger d-none">
    La date du cake ne peut pas être après la date de la fête.
</div>
<div class="container mt-4">
<div class="card-modern">
    <div class="card-header-pastel"><?= $title ?></div>
    <div class="card-body">
<form id="formFete" method="post" action="/birthday/update">

<!-- ================= INFOS TECHNIQUES ================= -->
<input type="hidden" name="token" value="<?= e($token) ?>">
<input type="hidden" name="mois" value="<?= $mois ?>">
<input type="hidden" name="annee" value="<?= $annee ?>">
<input type="hidden" name="idBirthday" value="<?= $idBirthday ?>">
<input type="hidden" name="id_resident" value="<?= $birthday['id_resident'] ?>">
<input type="hidden" name="motif" value="Birthday">
<input type="hidden" name="dateCake" id="dateCake" value="<?= $dateCake ? $dateCake->format('Y-m-d') : '' ?>">

<!-- ================= RESIDENT ================= -->
<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <h5 class="mb-2">🎂 Anniversaire</h5>
        <p class="mb-1">
            <strong>Résident :</strong>
            (<?= $birthday['id_resident'] ?>)
            <?= $birthday['Prenom'] ?> <?= $birthday['Nom'] ?> – <?= $birthday['Gender'] ?>
        </p>
        <p class="mb-0">
            <strong>Date Anniversaire:</strong>
            <?= sprintf('%02d-%02d-%d',
                $dateBirthday->format('d'),
                $mois,
                $annee
            ) ?>
        </p>
        <p class="mb-0">
            <strong>Date de la fete :</strong>
            <?= $dateFete ? $dateFete->format('d-m-Y') : 'Non commandé' ?>
        </p>
        <p class="mb-0">
            <strong>Commande de gateau :</strong>
            <?= $dateCake ? $dateCake->format('d-m-Y') : 'Non commandé' ?>
        </p>
    </div>
</div>

<!-- ================= INFOS FÊTE ================= -->
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <div class="form-row align-items-end">

            <div class="form-group col-md-2">
                <label>Pax</label>
                <input type="number" name="pax" class="form-control" value="<?= $birthday['pax'] ?>">
            </div>

            <div class="form-group col-md-3">
                <label>Date</label>
                <input type="date" id="date" name="date" class="form-control" value="<?= $birthday['date'] ?>">
            </div>

            <div class="form-group col-md-3">
                <label>Heure</label>
                <select name="heure" class="form-control">
                    <?php foreach ($options['Heure'] as $h): ?>
                        <option value="<?= e($h) ?>" <?= $birthday['heure']==$h?'selected':'' ?>>
                            <?= e($h) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label>Lieux</label>
                <select name="lieux" class="form-control">
                    <?php foreach ($options['Lieux'] as $l): ?>
                        <option value="<?= e($l) ?>" <?= $birthday['lieux']==$l?'selected':'' ?>>
                            <?= e($l) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>
    </div>
</div>

<!-- ================= BOISSONS ================= -->
<div class="card mb-3">
    <div class="card-header font-weight-bold">🥤 Boissons</div>
    <div class="card-body">
        <?php
        $boissons = ['tea'=>'Tea','coffee'=>'Coffee','pop'=>'Pop','juice'=>'Juice','milk'=>'Milk','water'=>'Water'];
        foreach ($boissons as $k=>$v): ?>
        <div class="form-check">
            <input type="hidden" name="<?= $k ?>" value="0">
            <input class="form-check-input" type="checkbox" name="<?= $k ?>" value="1" <?= $birthday[$k]?'checked':'' ?>>
            <label class="form-check-label"><?= $v ?></label>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ================= NOURRITURE ================= -->
<div class="card mb-3">
    <div class="card-header font-weight-bold">🍰 Nourriture & condiments</div>
    <div class="card-body">
        <?php
        $food = ['cake'=>'Cake','sugar'=>'Sugar','saltpepper'=>'Salt & Pepper'];
        foreach ($food as $k=>$v): ?>
        <div class="form-check">
            <input type="hidden" name="<?= $k ?>" value="0">
            <input class="form-check-input" type="checkbox" name="<?= $k ?>" value="1" <?= $birthday[$k]?'checked':'' ?>>
            <label class="form-check-label"><?= $v ?></label>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ================= DISPOSABLE ================= -->
<div class="card mb-3">
    <div class="card-header font-weight-bold">🧃 Disposable</div>
    <div class="card-body">
        <div class="form-check">
            <input type="hidden" name="disposable" value="0">
            <input class="form-check-input" type="checkbox" id="disposable" name="disposable" value="1" <?= $birthday['disposable']?'checked':'' ?>>
            <label class="form-check-label">All Disposable</label>
        </div>
    </div>
</div>

<!-- ================= VAISSELLE ================= -->
<div class="card mb-3" id="vaisselles">
    <div class="card-header font-weight-bold">🍽️ Vaisselle</div>
    <div class="card-body">
        <?php
        $vaisselle = [
            'cups'=>'Cups','juiceglass'=>'Juice glass','foamglass'=>'Foam glass',
            'plasticdish6'=>'Plastic dish 6"','plasticdish9'=>'Plastic dish 9"'
        ];
        foreach ($vaisselle as $k=>$v): ?>
        <div class="form-check">
            <input type="hidden" name="<?= $k ?>" value="0">
            <input class="form-check-input" type="checkbox" name="<?= $k ?>" value="1" <?= $birthday[$k]?'checked':'' ?>>
            <label class="form-check-label"><?= $v ?></label>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ================= USTENSILES ================= -->
<div class="card mb-3" id="ustensiles">
    <div class="card-header font-weight-bold">🍴 Ustensiles</div>
    <div class="card-body">
        <?php
        $ust = ['knife'=>'Knife','fork'=>'Fork','teaspoon'=>'Teaspoon','cakeknife'=>'Cake knife','napkin'=>'Napkin'];
        foreach ($ust as $k=>$v): ?>
        <div class="form-check">
            <input type="hidden" name="<?= $k ?>" value="0">
            <input class="form-check-input" type="checkbox" name="<?= $k ?>" value="1" <?= $birthday[$k]?'checked':'' ?>>
            <label class="form-check-label"><?= $v ?></label>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ================= LINGE ================= -->
<div class="card mb-3" id="lingeDivers">
    <div class="card-header font-weight-bold">🧺 Linge & divers</div>
    <div class="card-body">
        <?php
        $linge = ['tablecloth'=>'Tablecloth','greycenter'=>'Grey center','trashbag'=>'Trash bag','kitchencloth'=>'Kitchen cloth'];
        foreach ($linge as $k=>$v): ?>
        <div class="form-check">
            <input type="hidden" name="<?= $k ?>" value="0">
            <input class="form-check-input" type="checkbox" name="<?= $k ?>" value="1" <?= $birthday[$k]?'checked':'' ?>>
            <label class="form-check-label"><?= $v ?></label>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ================= INFO ================= -->
<div class="card mb-4">
    <div class="card-body">
        <label>Informations complémentaires</label>
        <input type="text" name="informations" class="form-control" value="<?= e($birthday['informations']) ?>">
    </div>
</div>
<!-- ================= OBSERVATIONS ================= -->
<div class="card mb-3">
    <div class="card-body">
        <label class="font-weight-bold">Observations</label>
        <select name="observation" class="form-control">
            <option value="">-- Choisir --</option>
            <?php foreach ($options['Observations'] as $o): ?>
                <option value="<?= e($o) ?>"
                    <?= (isset($birthday['observation']) && $birthday['observation'] === $o) ? 'selected' : '' ?>>
                    <?= e($o) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<!-- ================= COMMENTAIRES ================= -->
<div class="card mb-4">
    <div class="card-body">
        <label class="font-weight-bold">Commentaires</label>
        <select name="commentaires" class="form-control">
            <option value="">-- Choisir --</option>
            <?php foreach ($options['Commentaires'] as $c): ?>
                <option value="<?= e($c) ?>"
                    <?= (isset($birthday['commentaires']) && $birthday['commentaires'] === $c) ? 'selected' : '' ?>>
                    <?= e($c) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="text-right mb-5">
    <button type="button" class="btn btn-info btn-lg" onclick="verifierDate()">Enregistrer la fête</button>
</div>
</form>
</div>
</div>
</div>

<!-- ================= JS DISPOSABLE ================= -->
<script>
/*
document.addEventListener('DOMContentLoaded', function () {

    const disposable = document.getElementById('disposable');
    const sections = ['vaisselles','ustensiles','lingeDivers'];

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
*/
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
