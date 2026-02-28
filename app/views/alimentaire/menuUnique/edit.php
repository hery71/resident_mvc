<?php $title = 'Menu Unique';
$custom_js = <<<'JS'
// Custom JavaScript can be added here
function removeMeal(btn) {
    btn.closest('li').remove()
}
//****************************************************** */
// Confirm Import Function
//*******************************************************/
function confirmImport(idUnique) {

    const data = new FormData();

    // hidden inputs (si tu en as)
    document.querySelectorAll('#importModal input[type="hidden"]').forEach(input => {
        data.append(input.name, input.value);
    });

    // ✅ CHECKBOXES COCHÉES
    document.querySelectorAll('#importModal input[type="checkbox"]:checked').forEach(input => {
        data.append(input.name, input.value);
    });

    data.append('id_unique', idUnique);
    data.append('import_confirm', 1);

    fetch('/menuUnique/importMeals', {
        method: 'POST',
        body: data
    })
    .then(r => r.text())
    .then(() => location.reload());
}
//****************************************************** */
// Event on nmodal #importModal open
//*******************************************************/
$('#importModal').on('show.bs.modal', function (e) {
    const button   = e.relatedTarget;          // bouton cliqué
    const idUnique = button.dataset.id_unique; // variable récupérée
    const body = document.getElementById('importModalBody');
    body.innerHTML = 'Chargement des plats…';

    fetch('/menuUnique/ajaxImportMenuRegular?id_unique=' + idUnique)
        .then(r => r.text())
        .then(html => body.innerHTML = html)
        .catch(() => body.innerHTML = 'Erreur de chargement');
});
//****************************************************** */
// Add text box
//*******************************************************/
function addTextbox(section) {
    const c = document.getElementById(section+'_container');
    const i = document.createElement('input');
    i.type='text'; i.name=section+'[]';
    i.className='form-control mt-1';
    i.placeholder='Nouveau plat';
    c.appendChild(i);
}
//****************************************************** */
// DELETE MEAL CONFIRMATION
//*******************************************************/
function confirmDelete(id, table, menuId) {
    if(confirm('Supprimer ce plat ?')) {
        location = `/menuUnique/deleteMeal?delete=${id}&table=${table}&idUnique=${menuId}`;
    }
}
JS;
require __DIR__ . '/../../layout/header.php'; ?>
<div class="container mt-4">
<div class="card-modern">
  <div class="card-header-pastel"><?= e($menu_unique['date'] ?? $currentDate) ?></div>
    <div class="card-body">
<a href="/menuUnique/index/" class="btn btn-secondary mb-3">Liste</a>

<?php if (!empty($message)): ?>
<div class="alert alert-success"><?= e($message) ?></div>
<?php endif; ?>

<?php if (!$menu_unique): ?>

       <form method="POST">
              <input name="nom" class="form-control mb-2" placeholder="Nom du menu" required>
              <input type="date" name="date" class="form-control mb-2" value="<?= $forcedDate ?? $currentDate ?>" required>
              <input name="observation" class="form-control mb-2" placeholder="Observation">
              <button name="save_menu" class="btn btn-primary">Créer</button>
       </form>

<?php else: ?>

       <form method="POST" class="mb-4">
              <input type="hidden" name="id_unique" value="<?= $menu_unique['id'] ?>">
              <input name="nom" class="form-control mb-2" value="<?= e($menu_unique['nom']) ?>" required>
              <input type="date" name="date" class="form-control mb-2" value="<?= e($menu_unique['date']) ?>" required>
              <input name="observation" class="form-control mb-2" value="<?= e($menu_unique['observation']) ?>">
              <button name="update_menu" class="btn btn-primary">💾 Mettre à jour</button>
       </form>
       <!-------------------------------------------------------------------------------------->
       <!-------------------------------------------------------------------------------------->
       <!-------------------------------------------------------------------------------------->
       <hr>
       <button class="btn btn-outline-info mb-3"
              data-toggle="modal"
              data-target="#importModal"
              data-id_unique="<?= (int)$id_unique ?>">
       Importer les plats du menu régulier
       </button>


<form method="POST">
    <input type="hidden" name="id_unique" value="<?= $menu_unique['id'] ?>">

    <?php
    $labels = [
        'breakfast'       => 'Petit-déjeuner',
        'lunch'           => '🍽️ Dîner',
        'lunch_dessert'   => 'Dessert dîner',
        'dinner'          => 'Souper',
        'dinner_dessert'  => 'Dessert souper'
    ];
    ?>

    <?php foreach ($labels as $table => $label): ?>

        <h5 class="mt-4 mb-2"><?= $label ?></h5>

        <?php
        $mealsToShow = $existingMeals[$table] ?? [];

        if (empty($mealsToShow) && !empty($importMeals[$table])) {
            foreach ($importMeals[$table] as $meal) {
                $mealsToShow[] = ['id' => null, 'meal' => $meal];
            }
        }

        ?>
        <?php foreach ($mealsToShow as $row): ?>
            <div class="row align-items-center mb-2">

                <?php if (!empty($row['id'])): ?>
                    <input type="hidden" name="<?= $table ?>_id[]" value="<?= $row['id'] ?>">
                <?php endif; ?>

                <!-- INPUT -->
                <div class="col-md-5">
                    <input name="<?= $table ?>_meal[]"
                           class="form-control"
                           value="<?= htmlspecialchars((string)$row['meal']) ?>">
                </div>

                <!-- DELETE -->
                <?php if (!empty($row['id'])): ?>
                    <div class="col-auto">
                        <button type="button"
                                class="btn btn-secondary btn-sm"
                                onclick="confirmDelete(<?= $row['id'] ?>,'<?= $table ?>',<?= $menu_unique['id'] ?>)">
                            X
                        </button>
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>

        <!-- AJOUT -->
        <div id="<?= $table ?>_container" class="ml-md-0"></div>
        <button type="button"
                class="btn btn-outline-secondary btn-sm mt-1"
                onclick="addTextbox('<?= $table ?>')">
       Ajouter
        </button>

        <hr>

    <?php endforeach; ?>

    <button name="update_meals" class="btn btn-secondary mt-3">
        Enregistrer les plats
    </button>
</form>


<?php endif; ?>
    </div>
</div>
</div>
<!---------------------------- Import Modal -------------------------------------------------->
<!-- MODAL IMPORT MENU RÉGULIER -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Importer les plats du menu régulier</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body" id="importModalBody">
        <div class="text-center text-muted">
          Chargement des plats…
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-info" onclick="confirmImport(<?= (int)$id_unique ?>)">Confirmer</button>
      </div>

    </div>
  </div>
</div>
<!--------------------------------------------------- End Modal ------------------>
<div class="text-center mt-4">
    <a href="/alimentaire/index" class="btn btn-secondary">⬅ Accueil</a>
  </div>
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>
