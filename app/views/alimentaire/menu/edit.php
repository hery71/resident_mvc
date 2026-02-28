<?php $title = 'Modifier menu'; 
    $annee = $_GET['annee'] ?? date("Y");
    // =========================
    // 🔧 Variables
    // =========================
    $id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $saison  = $_GET['saison'] ?? 'Winter';
    $annee   = $_GET['annee'] ?? date('Y');
    $week    = isset($_GET['week']) ? (int)$_GET['week'] : 1;
    $day     = $_GET['day'] ?? 'Sunday';
    $currentMenu = getMenuRotation($annee, $saison, $week);
    // =========================
    // 📅 Dropdowns
    // =========================
    $seasons = ['Winter', 'Spring', 'Summer', 'Fall'];
    $years = range((int)$annee -5 , (int)$annee+10);
    $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    $weeksMap = [
        1 => 'Week 1',
        2 => 'Week 2',
        3 => 'Week 3',
        4 => '🎄 Special Christmas',
        5 => '🎆 Special New Year'
    ];
    // =========================JS
    $custom_js = <<<JS
    // Custom JavaScript can be added here
    JS;
require __DIR__ . '/../../layout/header.php'; ?>
<div class="container center">
    <div class="card-modern">
    <div class="card-header-pastel"><?= $title ?> - Cycle : <?= $currentMenu ?></div>
    <div class="card-body">
    <div class="container mt-4 mb-5">

        <!-- ====================== -->
        <!--       FILTRES         -->
        <!-- ====================== -->

        <form method="get" action="/menu/edit" class="mb-4">
            <input type="hidden" name="id" value="<?= $menu['id'] ?>">
            <div class="row g-3 bg-white p-3 rounded shadow-sm">

                <div class="col-md-3">
                    <label class="form-label fw-bold">Année</label>
                    <select name="annee" class="form-select" onchange="this.form.submit()">
                    <?php foreach ($years as $y): ?>
                        <option value="<?= $y ?>" <?= ($annee==$y)?'selected':'' ?>><?= $y ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Saison</label>
                    <select name="saison" class="form-select" onchange="this.form.submit()">
                    <?php foreach ($seasons as $s): ?>
                        <option value="<?= $s ?>" <?= ($saison==$s)?'selected':'' ?>><?= $s ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">week</label>
                    <select name="week" class="form-select" onchange="this.form.submit()">
                    <?php foreach ($weeksMap as $num=>$label): ?>
                        <option value="<?= $num ?>" <?= ($week==$num)?'selected':'' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Jour</label>
                    <select name="day" class="form-select" onchange="this.form.submit()">
                    <?php foreach ($days as $d): ?>
                        <option value="<?= $d ?>" <?= ($day==$d)?'selected':'' ?>><?= $d ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>

            </div>
        </form>

        <!-- ====================== -->
        <!--      FORMULAIRE        -->
        <!-- ====================== -->

        <form method="post" id="mainForm" action="/menu/save" class="mb-5">

            <input type="hidden" name="id_menu" value="<?= $menu['id'] ?>">
            <input type="hidden" name="annee" value="<?= $annee ?>">
            <input type="hidden" name="saison" value="<?= $saison ?>">
            <input type="hidden" name="week" value="<?= $week ?>">
            <input type="hidden" name="day" value="<?= $day ?>">

        <div class="row">
            <div class="col-md-4">
                <?php createMealSection('Breakfast', 'breakfast', $breakfastItems); ?>
            </div>

            <div class="col-md-4">
                <?php createMealSection(
                    'Lunch',
                    'lunch',
                    $lunchItems,
                    'Dessert',
                    'lunch_dessert',
                    $lunchDessertItems
                ); ?>
            </div>

            <div class="col-md-4">
                <?php createMealSection(
                    'Dinner',
                    'dinner',
                    $dinnerItems,
                    'Dessert',
                    'dinner_dessert',
                    $dinnerDessertItems
                ); ?>
            </div>
        </div>

        </form>
    </div>
    </div>
</div>
<!-- ====================== -->
<!--   BARRE DE SAUVEGARDE  -->
<!-- ====================== -->

<div class="save-bar text-center">
    <button type="submit" form="mainForm" class="btn btn-light btn-lg btn-modern text-info fw-bold ">
        <i class="bi bi-check-circle-fill"></i> Enregistrer
    </button>
</div>
<div class="text-center mt-4">
    <a href="/alimentaire/index" class="btn btn-secondary">⬅ Accueil</a>
    <a href="/menu/dailyMenu" class="btn btn-secondary">⬅ Menu du jour</a>
  </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// === AUTO-COMPLETE MODERNISÉ ===
document.addEventListener("input", function (e) {
    if (!e.target.matches("input[name*='[meal]'], input[name*='new_meal']")) return;

    const input = e.target;
    const group = input.closest(".input-group");
    const table = input.name.split("[")[0];

    let oldBox = group.querySelector(".autocomplete-box");
    if (oldBox) oldBox.remove();

    const q = input.value.trim();
    if (q.length < 1) return;

    fetch("get_meals.php?table=" + table + "&q=" + encodeURIComponent(q))
        .then(r => r.json())
        .then(list => {
            if (list.length === 0) return;

            let box = document.createElement("div");
            box.className = "autocomplete-box list-group";

            list.forEach(meal => {
                let item = document.createElement("button");
                item.type = "button";
                item.className = "list-group-item list-group-item-action py-1";
                item.textContent = meal;
                item.onclick = () => {
                    input.value = meal;
                    box.remove();
                };
                box.appendChild(item);
            });
            group.appendChild(box);
        });
});

// Supprimer dropdown si clic ailleurs
document.addEventListener("click", function (e) {
    document.querySelectorAll(".autocomplete-box").forEach(box => {
        if (!box.contains(e.target)) box.remove();
    });
});

// ============= SUPPRESSION MEAL =============
document.addEventListener("click", e => {

  if (e.target.closest(".remove-btn")) {
    const btn = e.target.closest(".remove-btn");
    const id = btn.dataset.id;
    const table = btn.dataset.table;
    const meal = btn.dataset.meal;

    if (!id) { btn.closest(".input-group").remove(); return; }

    if (confirm(`Supprimer "${meal}" ?`)) {
      fetch("/menu/deleteMeal/", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ table, id })
      })
      .then(r => r.text())
      .then(t => {
        if (t.trim() === "OK") {
          btn.closest(".input-group").remove();
        } else { alert("Erreur : " + t); }
      })
      .catch(err => alert("Erreur serveur : " + err));
    }
  }
});

// ████ AJOUT DE CHAMPS ████
document.addEventListener("click", e => {
  if (e.target.closest(".add-btn")) {
    const btn = e.target.closest(".add-btn");
    const table = btn.dataset.table;
    const container = document.getElementById(table + "-list");

    const div = document.createElement("div");
    div.classList.add("input-group", "mb-2", "position-relative");
    div.innerHTML = `
      <input type="hidden" name="${table}[id][]" value="0">
      <input type="text" name="${table}[meal][]" class="form-control" placeholder="Nouveau meal...">
      <button type="button" class="btn btn-light remove-btn ms-2 text-warning"><i class="bi bi-trash">X</i></button>
    `;
    container.appendChild(div);
  }
});
</script>
<?php require __DIR__ . '/../../layout/footer.php'; ?>