<?php $title = 'IMPORTER MENUS'; 
    $inspection=  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
    $custom_js = <<<'JS'
    function confirmExport() {

        // 1️⃣ Récupérer le JSON hidden
        let raw = document.getElementById("yearSeason").value;
        let yearSeason = JSON.parse(raw);

        // 2️⃣ Récupérer les selects
        let saison = document.getElementById("saison").value;
        let annee  = document.getElementById("annee").value;

        if (!saison || !annee) {
            return true; // laisse le required HTML gérer
        }

        // 3️⃣ Construire la combinaison
        let selected = annee + " " + saison;

        // 4️⃣ Message par défaut
        let message = "Êtes-vous sûr de vouloir exporter vers la base ?";
        document.getElementById("overwrite").value = "0"; // par défaut pas d overwrite

        // 5️⃣ Si déjà existant → changer message
        if (yearSeason.includes(selected)) {
            message = "⚠️ La saison " + selected + 
                    " existe déjà.\n\nVoulez-vous vraiment écraser les données ?";
            document.getElementById("overwrite").value = "1"; // signaler l overwrite
        }

        // 6️⃣ Afficher confirmation
        return confirm(message);
    }
    // Custom JavaScript can be added here
    JS;
    $custom_style = <<<CSS
    /* Custom CSS can be added here */
    CSS;
?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container center">
<h3> IMPORTATION DES MENUS </h3>
<div class="alert alert-info">
    Séparateurs de chaque bloc:
    <strong>xxxxxxx;;;;;;;</strong> = Separateur de blocs week1 (Breakfast → Lunch → Lunch Dessert → Dinner → Dinner Dessert) en premier week2 et week3 ensuite...
</div>
<form method="post" action="/parametres/import/">

<ul class="nav nav-tabs" id="weekTabs" role="tablist">

    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#week0">Brut</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#week1">Week 1</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#week2">Week 2</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#week3">Week 3</a>
    </li>

</ul>

<div class="tab-content border p-3">

    <!-- TAB 0 : BRUT -->
    <div class="tab-pane fade show active" id="week0">
        <div class="form-group">
            <label><strong>Données brutes</strong></label>
            <textarea name="raw_data"
                      class="form-control"
                      rows="15"
                      placeholder="Collez les données brutes ici..."><?= htmlspecialchars($_POST['raw_data'] ?? '') ?></textarea>
        </div>

        <button type="submit" name="range" class="btn btn-warning">
            Ranger
        </button>
    </div>

<?php
$meals = [
    'breakfast' => 'Breakfast',
    'lunch' => 'Lunch',
    'lunch_dessert' => 'Lunch Dessert',
    'dinner' => 'Dinner',
    'dinner_dessert' => 'Dinner Dessert'
];
?>

<?php for ($w = 1; $w <= 3; $w++): ?>
    <div class="tab-pane fade" id="week<?= $w ?>">

        <?php foreach ($meals as $key => $label): ?>
            <div class="form-group mt-3">
                <label><strong><?= $label ?> (Week <?= $w ?>)</strong></label>
                <textarea name="week<?= $w ?>_<?= $key ?>"
                          class="form-control"
                          rows="6"
                          placeholder="Données séparées par ;"><?= 
                              htmlspecialchars($_POST["week{$w}_{$key}"] ?? '') 
                          ?></textarea>
            </div>
        <?php endforeach; ?>

    </div>
<?php endfor; ?>

</div>

<hr>

<button type="submit" name="preview" class="btn btn-primary mt-3">
    Aperçu
</button>

</form>  

<!---------------------Affichage ---------------------->
</form>
<?php if (!empty($rows)): ?>

    <div class="card mt-4">
        <div class="card-header">
            Aperçu du fichier CSV
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <?php foreach ($rows[0] as $header): ?>
                            <th><?= e($header) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 1; $i < count($rows); $i++): ?>
                        <tr>
                            <?php foreach ($rows[$i] as $cell): ?>
                                <td><?= e($cell) ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php endif; ?>  
<!------------------------EXPORT------------------------------>
<form method="post" action="/parametres/export/" class="mt-3">

    <input type="hidden" name="confirm_export" value="1">

    <div class="form-group w-25">
        <label for="saison">Saison</label>
        <select name="saison" id="saison" class="form-control" required>
            <option value="">-- Choisir --</option>
            <option value="Christmass">Christmass</option>
            <option value="New year">New year</option>
            <option value="Winter">Winter</option>
            <option value="Spring">Spring</option>
            <option value="Summer">Summer</option>
            <option value="Fall">Fall</option>
        </select>
    </div>
    <div class="form-group w-25">
        <label for="annee">Annee</label>
        <select name="annee" id="annee" class="form-control" required>
            <option value="">-- Choisir --</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
            <option value="2027">2027</option>
        </select>
    </div>
    <!----------------------------tetareas cachées pour export---------------------------->
    <?php for ($w = 1; $w <= 3; $w++): ?>
        <?php foreach ($meals as $key => $label): ?>
            <input type="hidden"
                name="week<?= $w ?>_<?= $key ?>"
                value="<?= htmlspecialchars($_POST["week{$w}_{$key}"] ?? '') ?>">
        <?php endforeach; ?>
    <?php endfor; ?>
<input type="hidden"
    name="overwrite" id="overwrite" value="0"> 
<!----------------------------Bouton d'export---------------------------->
<input type="hidden"
    name="yearSeason" id="yearSeason"
    value='<?= htmlspecialchars(json_encode($yearSeason), ENT_QUOTES, "UTF-8") ?>'>
    <button type="submit" 
        class="btn btn-success mt-2"
        onclick="return confirmExport();">
        Exporter vers la base
    </button>
</form>

<!---------------------FIN DIV PRINCIPAL--------------------->
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>