<?php $title = 'Menu Unique'; 
    $annee = $_GET['annee'] ?? date("Y");
    $custom_js = <<<'JS'
    // Custom JavaScript can be added here
        function confirmDelete(id, annee) {
        if (confirm("Voulez-vous vraiment supprimer ce menu unique ? Cette action est irréversible.")) {
            window.location = "/menuUnique/index?delete=" + id + "&annee=" + annee;
        }
    }
    JS;
    $custom_style = <<<CSS
    /* Custom CSS can be added here */
    CSS;
?>
<?php require __DIR__ . '/../../layout/header.php'; ?>
<div class="container center">
  <div class="card-modern">
  <div class="card-header-pastel"><?= $title ?> - Année <?= e($annee) ?></div>
    <div class="card-body">


    <form class="form-inline mb-4" method="get" action="/menuUnique/index">
    <label for="annee" class="mr-2"><strong>Année :</strong></label>
    <select id="annee" name="annee" class="form-control mr-3" onchange="this.form.submit()">
      <?php foreach ($years as $y): ?>
        <option value="<?= $y ?>" <?= ($y == $annee) ? 'selected' : '' ?>><?= $y ?></option>
      <?php endforeach; ?>
    </select>
    <noscript><button type="submit" class="btn btn-primary">Afficher</button></noscript>
  </form>

  <?php if (empty($menus)): ?>
    <div class="alert alert-warning">Aucun menu unique trouvé pour <?= e($annee) ?>.</div>
  <?php else: ?>
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Date</th>
          <th>Nom du menu</th>
          <th>Observation</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($menus as $menu): ?>
          <tr>
            <td><?= e(date('d/m/Y', strtotime($menu['date']))) ?></td>
            <td><?= e($menu['nom']) ?></td>
            <td><?= e($menu['observation']) ?></td>
            <td>
              <a href="/menuUnique/edit?id=<?= (int)$menu['id'] ?>" class="btn btn-sm btn-primary btn-action">✏️ Modifier</a>
              <button type="button" class="btn btn-sm btn-danger btn-action" onclick="confirmDelete(<?= (int)$menu['id'] ?>, <?= (int)$annee ?>)">🗑️ Supprimer</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <div class="mt-3">
    <a href="/menuUnique/edit" class="btn btn-info">➕ Créer un nouveau menu unique</a>
    <a href="/alimentaire/index.php" class="btn btn-secondary ml-2">⬅ Retour</a>
  </div>
    </div>
  </div>
<!---------------------FIN DIV PRINCIPAL--------------------->
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>