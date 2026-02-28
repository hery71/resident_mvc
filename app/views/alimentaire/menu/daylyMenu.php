<?php $title = 'Menu du jour'; 

$custom_js = <<<JS
    // Custom JavaScript can be added here?>
     function selectDate() 
  {
    const d = document.getElementById('date').value;
    if (d) window.location = "?date=" + d;
  }
  function changeDate(offset) 
  {
    const input = document.getElementById('date');
    if (!input.value) return;
    const current = new Date(input.value);
    current.setDate(current.getDate() + offset);
    const newDate = current.toISOString().split('T')[0];
    window.location = "?date=" + newDate;
  }
  JS;
require __DIR__ . '/../../layout/header.php'; ?>

<div class="container mt-4">
  <div class="card-modern">
  <div class="card-header-pastel"><?= $title ?></div>
  <div class="card-body">

  <form class="form-inline mt-3 mb-4">
    <label class="mr-2">Choisissez une date :</label>
    <button type="button" class="btn btn-outline-secondary mr-2" onclick="changeDate(-1)">⬅️</button>
    <input type="date" id="date" class="form-control mr-2"value="<?= htmlspecialchars($xdate) ?>">
    <button type="button" class="btn btn-outline-secondary" onclick="changeDate(1)">➡️</button>
    <button type="button" class="btn btn-primary mr-2" onclick="selectDate()">Afficher</button>

    <?php if ($id_unique == 0): ?>
      <a href="/menuUnique/edit?date=<?= htmlspecialchars($xdate) ?>"
         class="btn btn-outline-secondary">
         Changer en menu unique
      </a>
    <?php else: ?>
      <a href="/menuUnique/edit?id=<?= $id_unique ?>"
         class="btn btn-outline-secondary">
         Changer le menu unique
      </a>
    <?php endif; ?>

    <?php if ($week !== null): ?>
      <a href="/menu/edit?annee=<?= $cycleYear ?>&saison=<?= urlencode($saison) ?>&week=<?= $week ?>&day=<?= urlencode($day) ?>"
         class="btn btn-outline-primary ml-2">
         Changer le menu de base
      </a>
    <?php endif; ?>
     <a target="_blank" href="/menu/printDailyMenu?date=<?= htmlspecialchars($xdate) ?>"
         class="btn btn-outline-secondary">
         Imprimer
      </a>
  </form>

  <div class="alert alert-info"><?= $info ?></div>

  <?php if ($menu): ?>
    <div id="menuContent" style="margin:auto;max-width:700px;text-align:center;">
      <div class="section-title font-weight-bold">Breakfast</div>
      <p><?= htmlspecialchars($menu['breakfast']) ?: '-' ?></p>
      <div class="section-title font-weight-bold">Lunch</div>
      <p><?= htmlspecialchars($menu['lunch']) ?: '-' ?></p>
      <div class="section-title font-weight-bold">Lunch Dessert</div>
      <p><?= htmlspecialchars($menu['lunch_dessert']) ?: '-' ?></p>
      <div class="section-title">Dinner</div>
      <p><?= htmlspecialchars($menu['dinner']) ?: '-' ?></p>
      <div class="section-title font-weight-bold">Dinner Dessert</div>
      <p><?= htmlspecialchars($menu['dinner_dessert']) ?: '-' ?></p>
    </div>
  <?php else: ?>
    <div class="alert alert-warning mt-3">Aucun menu trouvé pour cette date.</div>
  <?php endif; ?>
   <div class="text-center mt-4">
    <a href="/alimentaire/index" class="btn btn-secondary">⬅ Accueil</a>
  </div>
  </div>
  </div>
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>
