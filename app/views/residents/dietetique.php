<?php $title = 'Dietetique'; 
$custom_js = <<<'JS'
    // Custom JavaScript can be added here
    document.getElementById('residentSelect').addEventListener('change', function() {
    window.location.href = '/resident/dietetique/' + this.value;
    });
    JS;
    $custom_style = <<<CSS
    /* Custom CSS can be added here */
    CSS;
$selectedIntolerances = [];
$selectedAllergies = [];

if (!empty($resident['Intolerance'])) {
    $selectedIntolerances = array_map('trim', explode(',', $resident['Intolerance']));
}
if (!empty($resident['Allergie'])) {
    $selectedAllergies = array_map('trim', explode(',', $resident['Allergie']));
}
?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">

    <h3>Régime diététique</h3>
    <!----------------------------Identité---------------->
    <div class="alert alert-info">
        <Form method="post" action="/resident/dietetique/">
            <label for="idResident">Sélectionner un résident :</label>
            <select name="idResident" id="residentSelect" class="form-control w-50 d-inline-block">
                <?php foreach ($residentList as $res): ?>
                    <option value="<?= e($res['id']) ?>" <?= $res['id'] == $resident['id'] ? 'selected' : '' ?>>
                        <?= e($res['Prenom']) ?> <?= e($res['Nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </Form>
        Chambre : <?= e($resident['Chambre']) ?>
    </div>
    <!-----------------------------DIV PRINCIPAL + Form Principal----------------->
    <form method="post" action="/resident/updateDietetique">

        <input type="hidden" name="id" value="<?= (int)$resident['id'] ?>">

        <!-- ==================== ETAT MEDICAL ==================== -->
        <h5 class="mt-4">État médical</h5>

        <div class="row">

            <div class="col-md-4">
                <label>Diabétique</label>
                <select class="form-control" name="Diabet">
                    <?php foreach ($options['Diabet'] as $opt): ?>
                        <option value="<?= e($opt) ?>"
                            <?= $resident['Diabet'] == $opt ? 'selected' : '' ?>>
                            <?= e($opt) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>


            <div class="col-md-4">
                <label>Lieu repas</label>
                <select class="form-control" name="LieuRepas">
                    <?php foreach ($options['LieuRepas'] as $opt): ?>
                        <option value="<?= e($opt) ?>"
                            <?= $resident['LieuRepas'] == $opt ? 'selected' : '' ?>>
                            <?= e($opt) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>

        <!-- ==================== TEXTURE ==================== -->
        <h5 class="mt-4">Texture & Consistance</h5>

        <div class="row">

            <div class="col-md-4">
                <label>Thickened</label>
                <select class="form-control" name="Thickened">
                    <?php foreach ($options['Thickened'] as $opt): ?>
                        <option value="<?= e($opt) ?>"
                            <?= $resident['Thickened'] == $opt ? 'selected' : '' ?>>
                            <?= e($opt) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>


           <div class="col-md-4">
                <label>Consistance</label>
                <select class="form-control" name="Consistance">
                    <?php foreach ($options['Consistance'] as $opt): ?>
                        <option value="<?= e($opt) ?>"
                            <?= $resident['Consistance'] == $opt ? 'selected' : '' ?>>
                            <?= e($opt) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>


        </div>

        <!-- ==================== PETIT DEJEUNER ==================== -->
        <h5 class="mt-4">Petit déjeuner</h5>

        <div class="row">

          <div class="col-md-3">
                <label>Juice</label>
                <select class="form-control" name="Juice">
                    <?php foreach ($options['Juice'] as $opt): ?>
                        <option value="<?= e($opt) ?>"
                            <?= $resident['Juice'] == $opt ? 'selected' : '' ?>>
                            <?= e($opt) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>


            <div class="col-md-3">
                <label>Prune</label>
                <select class="form-control" name="Prune">
                    <?php foreach ($options['Prune'] as $opt): ?>
                        <option value="<?= e($opt) ?>"
                            <?= $resident['Prune'] == $opt ? 'selected' : '' ?>>
                            <?= e($opt) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>


            <div class="col-md-3">
                <label>Milk</label>
                <select class="form-control" name="Milk">
                    <?php foreach ($options['Milk'] as $opt): ?>
                        <option value="<?= e($opt) ?>"
                            <?= $resident['Milk'] == $opt ? 'selected' : '' ?>>
                            <?= e($opt) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>


            <div class="col-md-3">
                <label>Lactose</label>
                <select class="form-control" name="Lactose">
                    <?php foreach ($options['Lactose'] as $opt): ?>
                        <option value="<?= e($opt) ?>"
                            <?= $resident['Lactose'] == $opt ? 'selected' : '' ?>>
                            <?= e($opt) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>


        </div>

        <!-- ==================== INTOLERANCE ==================== -->
        <div class="mt-4">
            <label><strong>🚫 Intolérances alimentaires</strong></label>
            <select class=" form-select w-100"
                    name="Intolerance[]"
                    multiple
                    size="12">

                <?php foreach ($intolerances['Intolerances_Alimentaires_Canada'] as $category => $items): ?>

                    <optgroup label="<?= e(str_replace('_', ' ', $category)) ?>">

                        <?php foreach ($items as $item): ?>

                            <option value="<?= e($item) ?>"
                                <?= in_array($item, $selectedIntolerances, true) ? 'selected' : '' ?>>
                                <?= e($item) ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>
                <?php endforeach; ?>
            </select>
            <small class="text-muted">
                Maintenir Ctrl (Windows) ou ⌘ (Mac) pour sélection multiple.
            </small>
        </div>
        <!-- ==================== ALLERGIES ==================== -->
         <div class="mt-4">
             <label><strong>🚫 Allergies alimentaires</strong></label>
              <select class="form-select w-100" 
                        id="Allergie" 
                        name="Allergie[]" 
                        multiple 
                        size="12"  
                        aria-describedby="helpAllergie">
                    <?php foreach ($allergies as $opt): ?>
                        <option value="<?= e($opt) ?>" 
                            <?= in_array($opt, $selectedAllergies, true) ? 'selected' : '' ?>>
                            <?= e($opt) ?>
                        </option>
                    <?php endforeach; ?>
              </select>
                <div id="helpAllergie" class="help">
                    Maintiens Ctrl (ou ⌘ sur Mac) pour sélectionner plusieurs.
                </div>
            </div>




        <button type="submit" class="btn btn-primary mt-4">
        Update
        </button>
        <a href="/resident/" class="btn btn-secondary mt-4">
        Retour
        </a>
        <a href="/resident/printFicheDietetique/<?= (int)$resident['id'] ?>"
            class="btn btn-success mt-4">
        Imprimer la fiche Dietetique
        </a>
    </form>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
