<?php $title = 'Menu du Jour'; 
    $inspection=  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
?>
<?php require __DIR__ . '/../../layout/header.php'; ?>
<div class="container center">
<h3>Menu du jour</h3>
<form class="form-inline mt-3 mb-4">
    <label for="date" class="mr-2">Choisissez une date :</label>
    <input type="date" id="date" name="date" class="form-control mr-2" value="<?= htmlspecialchars($xdate) ?>">
    <button type="button" class="btn btn-primary mr-2" onclick="selectDate()">Afficher</button>
    <button type="button" class="btn btn-outline-secondary mr-2" onclick="changeDate(-1)">⬅️ Jour précédent</button>
    <button type="button" class="btn btn-outline-secondary" onclick="changeDate(1)">➡️ Jour suivant</button>
    <?php if ($id_unique == 0): ?>
      <a href="edit_menu_jour_unique.php?date=<?= htmlspecialchars($xdate) ?>"
      class="btn btn-outline-secondary">
      Changer en menu unique
      </a>
    <?php else: ?>
      <a href="edit_menu_jour_unique.php?id=<?= $id_unique ?>"
      class="btn btn-outline-secondary">
      Changer le menu unique
      </a>
    <?php endif; ?>
    <?php if ($week !== null): ?>
    <a href="edit_menu.php?annee=<?= urlencode($cycleYear) ?>&saison=<?= urlencode($saison) ?>&week=<?= urlencode($week) ?>&day=<?= urlencode($day) ?>"
    class="btn btn-outline-primary ml-2">
    Changer le menu de base
    </a>
    <?php endif; ?>
  </form>

  <script>
  function selectDate() {
    const d = document.getElementById('date').value;
    if (d) window.location = "menu_jour.php?date=" + d;
  }
  function changeDate(offset) {
    const input = document.getElementById('date');
    if (!input.value) return;
    const current = new Date(input.value);
    current.setDate(current.getDate() + offset);
    const newDate = current.toISOString().split('T')[0];
    window.location = "menu_jour.php?date=" + newDate;
  }
  </script>

  <div class="alert alert-info"><?= $info ?></div>

  <?php if ($menu): ?>
  <div id="menuContent" style="margin:auto;max-width:700px;text-align:center;">
    <div class="section-title">Breakfast</div>
    <p><?= htmlspecialchars($menu['breakfast']) ?: '-' ?></p>
    <div class="section-title">Lunch</div>
    <p><?= htmlspecialchars($menu['lunch']) ?: '-' ?></p>
    <div class="section-title">Lunch Dessert</div>
    <p><?= htmlspecialchars($menu['lunch_dessert']) ?: '-' ?></p>
    <div class="section-title">Dinner</div>
    <p><?= htmlspecialchars($menu['dinner']) ?: '-' ?></p>
    <div class="section-title">Dinner Dessert</div>
    <p><?= htmlspecialchars($menu['dinner_dessert']) ?: '-' ?></p>
  </div>
  <?php else: ?>
    <div class="alert alert-warning mt-3">⚠️ Aucun menu trouvé pour cette date.</div>
  <?php endif; ?>

  <button class="btn btn-success mt-4" onclick="printMenu()">🖨️ Imprimer le menu du jour</button>
  <a href="index.php" class="btn btn-secondary mt-4 ml-2">⬅ Retour</a>
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>