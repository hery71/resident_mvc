<?php 
    $title = 'Preference alimentaire'; 
    $inspection=  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
    $custom_js = <<<JS
    // Custom JavaScript can be added here
    JS;
   $custom_style = <<<CSS
.card { 
    border-radius: 1rem; 
    border: 1px solid #e9ecef;
}

.section-title { 
    font-weight: 600; 
    border-bottom: 1px solid #dee2e6;
    padding-bottom: .5rem;
}

.form-label {
    font-weight: 500;
    margin-bottom: .3rem;
}

.form-select[multiple] {
    height: 140px;
}

.help { 
    font-size:.80rem; 
    color:#6c757d; 
}

.card-body {
    padding: 1.5rem;
}

h3 {
    font-weight: 600;
}
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
$TartinadeSel = $parseList($resident['Tartinade'] ?? '');
$CerealeSel = $parseList($resident['Cereale'] ?? '');
$ProteineSel = $parseList($resident['Proteine'] ?? '');
$FruitSel = $parseList($resident['Fruit'] ?? '');

?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container center">
<div class="card-modern">
    <div class="card-header-pastel"><?= $title ?></div>
    <div class="card-body">
<!-----------------------------DIV PRINCIPAL----------------->
<div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
    <h1 class="h4 mb-0">Préférences alimentaires — <?= e($resident['Prenom']) ?> <?= e($resident['Nom']) ?></h1>
    <a href="/resident/index/" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
  </div>

  <form method="post" action="/resident/savePreferenceAlimentaire/">
    <input type="hidden" name="idResident" value="<?= e($resident['id']) ?>">
    <div class="row g-3">
      <!-- Carte DIÉTÉTIQUE -->
      <h2 class="h6 section-title mb-4">Diététique</h2>

<div class="row g-3">

  <div class="col-md-6">
    <label for="Bread" class="form-label">Pain</label>
    <select class="form-select w-100" id="Bread" name="Bread[]" multiple>
      <?php foreach ($options['Bread'] as $opt): ?>
        <option value="<?= e($opt) ?>" <?= in_array($opt, $BreadSel, true) ? 'selected' : '' ?>><?= e($opt) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-6">
    <label for="Tartinade" class="form-label">Tartinade</label>
    <select class="form-select w-100" id="Tartinade" name="Tartinade[]" multiple>
      <?php foreach ($options['Tartinade'] as $opt): ?>
        <option value="<?= e($opt) ?>" <?= in_array($opt, $TartinadeSel, true) ? 'selected' : '' ?>><?= e($opt) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-6">
    <label for="Cereale" class="form-label">Céréales</label>
    <select class="form-select w-100" id="Cereale" name="Cereale[]" multiple>
      <?php foreach ($options['Cereale'] as $opt): ?>
        <option value="<?= e($opt) ?>" <?= in_array($opt, $CerealeSel, true) ? 'selected' : '' ?>><?= e($opt) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-6">
    <label for="Proteine" class="form-label">Protéines</label>
    <select class="form-select w-100" id="Proteine" name="Proteine[]" multiple>
      <?php foreach ($options['Proteine'] as $opt): ?>
        <option value="<?= e($opt) ?>" <?= in_array($opt, $ProteineSel, true) ? 'selected' : '' ?>><?= e($opt) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-6">
    <label for="Fruit" class="form-label">Fruits</label>
    <select class="form-select w-100" id="Fruit" name="Fruit[]" multiple>
      <?php foreach ($options['Fruit'] as $opt): ?>
        <option value="<?= e($opt) ?>" <?= in_array($opt, $FruitSel, true) ? 'selected' : '' ?>><?= e($opt) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-6">
    <label for="ModeEating" class="form-label">Habilité à se nourrir</label>
    <select class="form-select w-100" id="ModeEating" name="ModeEating">
      <?php foreach ($options['ModeEating'] as $opt): ?>
        <option value="<?= e($opt) ?>" <?= ($opt === ($resident['ModeEating'] ?? '')) ? 'selected' : '' ?>><?= e($opt) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-6">
    <label for="Allergie" class="form-label">Allergies</label>
    <select class="form-select w-100" id="Allergie" name="Allergie[]" multiple>
      <?php foreach ($allergenes as $opt): ?>
        <option value="<?= e($opt) ?>" <?= in_array($opt, $allergieSel, true) ? 'selected' : '' ?>><?= e($opt) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-6">
    <label for="Regime" class="form-label">Régime particulier</label>
    <input type="text" id="Regime" name="Regime" class="form-control"
           value="<?= e($resident['Regime'] ?? '') ?>">
  </div>

</div>


      <!-- Carte BREUVAGES & PRÉFÉRENCES -->
      <div class="col-lg-6">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h2 class="h6 section-title mb-3">Breuvages & préférences</h2>

            <div class="mb-4">
              <label for="Breuvage_dej" class="form-label">Breuvages – Déjeuner</label>
              <select class="form-select w-100" id="Breuvage_dej" name="Breuvage_dej[]" multiple size="6"  aria-describedby="helpDej">
                <?php foreach ($options['Breuvage'] as $opt): ?>
                  <option value="<?= e($opt) ?>" <?= in_array($opt, $beuvragedejSel, true) ? 'selected' : '' ?>><?= e($opt) ?></option>
                <?php endforeach; ?>
              </select>
              <div id="helpDej" class="help">Maintiens Ctrl (ou ⌘ sur Mac) pour sélectionner plusieurs.</div>
            </div>

            <div class="mb-4">
              <label for="Breuvage_din" class="form-label">Breuvages – Dîner</label>
              <select class="form-select w-100" id="Breuvage_din" name="Breuvage_din[]" multiple size="6" aria-describedby="helpDin">
                <?php foreach ($options['Breuvage'] as $opt): ?>
                  <option value="<?= e($opt) ?>" <?= in_array($opt, $beuvragedinSel, true) ? 'selected' : '' ?>><?= e($opt) ?></option>
                <?php endforeach; ?>
              </select>
              <div id="helpDin" class="help">Sélection multiple autorisée.</div>
            </div>

            <div class="mb-4">
              <label for="Breuvage_sou" class="form-label">Breuvages – Souper</label>
              <select class="form-select w-100" id="Breuvage_sou" name="Breuvage_sou[]" multiple size="6" aria-describedby="helpSou">
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
      <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
      <a href="/resident/index/" class="btn btn-outline-secondary">Annuler</a>
    </div>
  </form>
<!---------------------FIN DIV PRINCIPAL--------------------->
    </div>
    </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>