<?php 
    $title = 'Preference alimentaire'; 
    $inspection=  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
    $custom_js = <<<JS
    // Custom JavaScript can be added here
    JS;
    $custom_style = <<<CSS
    /* Custom CSS can be added here */
    .card { border-radius: 1rem; }
    .section-title { font-weight: 600; }
    .help { font-size:.85rem; color:#6c757d; }
    CSS;
//function
$parseList = function($s) {
    if (!$s) return [];
    return array_map('trim', explode(',', (string)$s));
};
$beuvragedejSel = $parseList($resident['Breuvage_dej'] ?? '');
$beuvragedinSel = $parseList($resident['Breuvage_din'] ?? '');
$beuvragesouSel = $parseList($resident['Breuvage_sou'] ?? '');
$allergieSel = $parseList($resident['Allergie'] ?? '');
$BreadSel = $parseList($resident['Bread'] ?? '');
?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container center">
    <h3> Preference alimentaire</h3>
<!-----------------------------DIV PRINCIPAL----------------->
<div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
    <h1 class="h4 mb-0">Préférences alimentaires — <?= e($resident['Prenom']) ?> <?= e($resident['Nom']) ?></h1>
    <a href="/resident/index/" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
  </div>

  <form method="post" action="/resident/savePreferenceAlimentaire/">
    <input type="hidden" name="idResident" value="<?= e($resident['id']) ?>">
    <div class="row g-3">
      <!-- Carte DIÉTÉTIQUE -->
      <div class="col-lg-6">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h2 class="h6 section-title mb-3">Diététique</h2>

            <div class="mb-3">
              <label for="Bread" class="form-label">Pain</label>
              <select name="Bread" id="Bread" class="form-select">
                <?php foreach ($options['Bread'] as $opt): ?>
                  <option value="<?= e($opt) ?>" <?= (($resident['Bread'] ?? '') === $opt) ? 'selected' : '' ?>><?= e($opt) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
             <div class="mb-4">
              <label for="Bread" class="form-label">Bread</label>
              <select class="form-select w-50" id="Bread" name="Bread[]" multiple size="6"  aria-describedby="helpBread">
                <?php foreach ($options['Bread'] as $opt): ?>
                  <option value="<?= e($opt) ?>" <?= in_array($opt, $BreadSel, true) ? 'selected' : '' ?>><?= e($opt) ?></option>
                <?php endforeach; ?>
              </select>
              <div id="helpDej" class="help">Maintiens Ctrl (ou ⌘ sur Mac) pour sélectionner plusieurs.</div>
            </div>

            <div class="mb-3">
              <label for="Tartinade" class="form-label">Tartinade</label>
              <select name="Tartinade" id="Tartinade" class="form-select">
                <?php foreach ($options['Tartinade'] as $opt): ?>
                  <option value="<?= e($opt) ?>" <?= (($resident['Tartinade'] ?? '') === $opt) ? 'selected' : '' ?>><?= e($opt) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="Cereale" class="form-label">Céréale</label>
              <select name="Cereale" id="Cereale" class="form-select">
                <?php foreach ($options['Cereale'] as $opt): ?>
                  <option value="<?= e($opt) ?>" <?= (($resident['Cereale'] ?? '') === $opt) ? 'selected' : '' ?>><?= e($opt) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="Proteine" class="form-label">Protéine</label>
              <select name="Proteine" id="Proteine" class="form-select">
                <?php foreach ($options['Proteine'] as $opt): ?>
                  <option value="<?= e($opt) ?>" <?= (($resident['Proteine'] ?? '') === $opt) ? 'selected' : '' ?>><?= e($opt) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="Fruit" class="form-label">Fruit</label>
              <select name="Fruit" id="Fruit" class="form-select">
                <?php foreach ($options['Fruit'] as $opt): ?>
                  <option value="<?= e($opt) ?>" <?= (($resident['Fruit'] ?? '') === $opt) ? 'selected' : '' ?>><?= e($opt) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-4">
              <label for="Regime" class="form-label">Regime</label>
              <input type="text" id="Regime" name="Regime" class="form-control" value="<?= e($resident['Regime'] ?? '') ?>" placeholder="Entrez, séparés par des virgules">
            </div>

            <div class="mb-4">
              <label for="ModeEating" class="form-label">Habilite a se nourrir</label>
              <select class="form-select w-50" id="ModeEating" name="ModeEating"  aria-describedby="helpModeEating">
                <?php foreach ($options['ModeEating'] as $opt): ?>
                  <option value="<?= e($opt) ?>" <?= ($opt === ($resident['ModeEating'] ?? '')) ? 'selected' : '' ?>><?= e($opt) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-4">
              <label for="Allergie" class="form-label">Allergies</label>
              <select class="form-select w-50" id="Allergie" name="Allergie[]" multiple size="6"  aria-describedby="helpAllergie">
                <?php foreach ($allergenes as $opt): ?>
                  <option value="<?= e($opt) ?>" <?= in_array($opt, $allergieSel, true) ? 'selected' : '' ?>><?= e($opt) ?></option>
                <?php endforeach; ?>
              </select>
              <div id="helpAllergie" class="help">Maintiens Ctrl (ou ⌘ sur Mac) pour sélectionner plusieurs.</div>
            </div>

          </div>
        </div>
      </div>

      <!-- Carte BREUVAGES & PRÉFÉRENCES -->
      <div class="col-lg-6">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h2 class="h6 section-title mb-3">Breuvages & préférences</h2>

            <div class="mb-4">
              <label for="Breuvage_dej" class="form-label">Breuvages – Déjeuner</label>
              <select class="form-select w-50" id="Breuvage_dej" name="Breuvage_dej[]" multiple size="6"  aria-describedby="helpDej">
                <?php foreach ($options['Breuvage'] as $opt): ?>
                  <option value="<?= e($opt) ?>" <?= in_array($opt, $beuvragedejSel, true) ? 'selected' : '' ?>><?= e($opt) ?></option>
                <?php endforeach; ?>
              </select>
              <div id="helpDej" class="help">Maintiens Ctrl (ou ⌘ sur Mac) pour sélectionner plusieurs.</div>
            </div>

            <div class="mb-4">
              <label for="Breuvage_din" class="form-label">Breuvages – Dîner</label>
              <select class="form-select w-50" id="Breuvage_din" name="Breuvage_din[]" multiple size="6" aria-describedby="helpDin">
                <?php foreach ($options['Breuvage'] as $opt): ?>
                  <option value="<?= e($opt) ?>" <?= in_array($opt, $beuvragedinSel, true) ? 'selected' : '' ?>><?= e($opt) ?></option>
                <?php endforeach; ?>
              </select>
              <div id="helpDin" class="help">Sélection multiple autorisée.</div>
            </div>

            <div class="mb-4">
              <label for="Breuvage_sou" class="form-label">Breuvages – Souper</label>
              <select class="form-select w-50" id="Breuvage_sou" name="Breuvage_sou[]" multiple size="6" aria-describedby="helpSou">
                <?php foreach ($options['Breuvage'] as $opt): ?>
                  <option value="<?= e($opt) ?>" <?= in_array($opt, $beuvragesouSel, true) ? 'selected' : '' ?>><?= e($opt) ?></option>
                <?php endforeach; ?>
              </select>
              <div id="helpSou" class="help">Sélection multiple autorisée.</div>
            </div>

            <div class="mb-4">
              <label for="moremeal" class="form-label">Aliments aimés</label>
              <input type="text" id="moremeal" name="moremeal" class="form-control" value="<?= e($resident['moremeal'] ?? '') ?>" placeholder="Entrez, séparés par des virgules">
            </div>

            <div class="mb-4">
              <label for="lessmeal" class="form-label">Aliments NON aimés</label>
              <input type="text" id="lessmeal" name="lessmeal" class="form-control" value="<?= e($resident['lessmeal'] ?? '') ?>" placeholder="Entrez, séparés par des virgules">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex gap-2 mt-3">
      <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Enregistrer</button>
      <a href="/resident/index/" class="btn btn-outline-secondary">Annuler</a>
    </div>
  </form>
<!---------------------FIN DIV PRINCIPAL--------------------->
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>