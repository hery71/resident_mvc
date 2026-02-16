<?php $title = 'Importer les menus speciaux'; 
    $annee = $_GET['annee'] ?? date("Y");
    $meals = [
    'breakfast'      => 'Breakfast',
    'lunch'          => 'Lunch',
    'lunch_dessert'  => 'Lunch Dessert',
    'dinner'         => 'Dinner',
    'dinner_dessert' => 'Dinner Dessert',
    ];
    $type = $_POST['special_type'] ?? '';
    $custom_js = <<<JS
    // Custom JavaScript can be added here
    JS;
    $custom_style = <<<CSS
    /* Custom CSS can be added here */
    CSS;
?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container center">
    <h3> Importer les menus speciaux</h3>
   <div class="container center mt-4">
    <h3>IMPORT SPECIAL — Christmas / New Year</h3>

    <form method="post" action="/parametres/importSpecial">

        <ul class="nav nav-tabs" id="weekTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab0">Brut</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab1">Semaine (1)</a>
            </li>
        </ul>

        <div class="tab-content border p-3">

            <!-- TAB 0 : BRUT -->
            <div class="tab-pane fade show active" id="tab0">
                <div class="alert alert-info">
                    Séparateurs :
                    <strong>CCCCCCC</strong> = Christmas |
                    <strong>NNNNNNN</strong> = New Year
                    <br>
                    ⚠ Un brut ne doit pas contenir les deux.
                    <br>
                    Chaque séparateur sépare les blocs : Breakfast → Lunch → Lunch Dessert → Dinner → Dinner Dessert
                </div>

                <div class="form-group">
                    <label><strong>Données brutes (1 semaine)</strong></label>
                    <textarea name="raw_data"
                              class="form-control"
                              rows="15"
                              placeholder="Collez le brut ici..."><?= htmlspecialchars($_POST['raw_data'] ?? '') ?></textarea>
                </div>

                <button type="submit" name="range" class="btn btn-warning">
                    Ranger
                </button>
            </div>

            <!-- TAB 1 : WEEK 1 -->
            <div class="tab-pane fade" id="tab1">

                <div class="form-group">
                    <label><strong>Type détecté</strong></label>
                    <input type="text" class="form-control w-25"
                           value="<?= htmlspecialchars($type ?: 'Non détecté') ?>" readonly>
                    <input type="hidden" name="special_type" value="<?= htmlspecialchars($type) ?>">
                </div>

                <?php foreach ($meals as $key => $label): ?>
                    <div class="form-group mt-3">
                        <label><strong><?= $label ?> (Week 1)</strong></label>
                        <textarea name="week1_<?= e($key) ?>"
                                  class="form-control"
                                  rows="6"
                                  placeholder="Données séparées par ;"><?= htmlspecialchars($_POST["week1_{$key}"] ?? '') ?></textarea>
                    </div>
                <?php endforeach; ?>

            </div>

        </div>

        <hr>

        <button type="submit" name="preview" class="btn btn-primary mt-2">
            Aperçu
        </button>

    </form>

    <!-- ===================== PREVIEW ===================== -->
    <?php if (!empty($rows)): ?>
        <div class="card mt-4">
            <div class="card-header">
                Aperçu Special
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

    <!-- ===================== EXPORT ===================== -->
    <form method="post" action="/parametres/exportSpecial" class="mt-3">

        <input type="hidden" name="confirm_export" value="1">
        <input type="hidden" name="special_type" value="<?= htmlspecialchars($_POST['special_type'] ?? '') ?>">

        <div class="form-group w-25">
            <label for="annee">Année</label>
            <select name="annee" id="annee" class="form-control" required>
                <option value="">-- Choisir --</option>
                <?php for ($y = 2023; $y <= 2028; $y++): ?>
                    <option value="<?= $y ?>"><?= $y ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <!-- hidden fields Week 1 -->
        <?php foreach ($meals as $key => $label): ?>
            <input type="hidden"
                   name="week1_<?= e($key) ?>"
                   value="<?= htmlspecialchars($_POST["week1_{$key}"] ?? '') ?>">
        <?php endforeach; ?>

        <button type="submit" class="btn btn-success mt-2">
            Exporter vers la base
        </button>

    </form>
<!---------------------FIN DIV PRINCIPAL--------------------->
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>