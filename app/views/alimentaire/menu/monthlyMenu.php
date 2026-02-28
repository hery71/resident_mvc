<?php $title = 'Base'; 
    $inspection=  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
    $custom_js = <<<JS
    // Custom JavaScript can be added here
    // Changement de mois/année
    function selectMonth() {
        const mois = document.getElementById('mois').value;
        const annee = document.getElementById('annee').value;
        window.location = "monthlyMenu?annee=" + annee + "&mois=" + mois;
    }

    // Toggle Saison / Week
    document.getElementById("toggleSeasonWeekBtn").addEventListener("click", function() {
        const cols = document.querySelectorAll('.toggle-col-season-week');
        let showNow = false;

        cols.forEach(col => {
            if (col.classList.contains("hidden-col")) {
                col.classList.remove("hidden-col");
                col.classList.add("shown-col");
                showNow = true;
            } else {
                col.classList.remove("shown-col");
                col.classList.add("hidden-col");
            }
        });

        const icon = this.querySelector('i');
        if (showNow) {
            this.innerHTML = '<i class="bi bi-eye"></i> Masquer Saison / Week';
        } else {
            this.innerHTML = '<i class="bi bi-eye-slash"></i> Afficher Saison / Week';
        }
    });

    // Toggle Breakfast
    document.getElementById("toggleBreakfastBtn").addEventListener("click", function() {
        const cols = document.querySelectorAll('.toggle-col-breakfast');
        let showNow = false;

        cols.forEach(col => {
            if (col.classList.contains("hidden-col")) {
                col.classList.remove("hidden-col");
                col.classList.add("shown-col");
                showNow = true;
            } else {
                if (!col.classList.contains("hidden-col")) {
                    col.classList.add("hidden-col");
                    col.classList.remove("shown-col");
                }
            }
        });

        const icon = this.querySelector('i');
        if (showNow) {
            this.innerHTML = '<i class="bi bi-eye-slash"></i> Masquer Breakfast';
        } else {
            this.innerHTML = '<i class="bi bi-eye"></i> Afficher Breakfast';
        }
    });

    // Toggle Desserts
    document.getElementById("toggleDessertsBtn").addEventListener("click", function() {
        const cols = document.querySelectorAll('.toggle-col-desserts');
        let showNow = false;

        cols.forEach(col => {
            if (col.classList.contains("hidden-col")) {
                col.classList.remove("hidden-col");
                col.classList.add("shown-col");
                showNow = true;
            } else {
                if (!col.classList.contains("hidden-col")) {
                    col.classList.add("hidden-col");
                    col.classList.remove("shown-col");
                }
            }
        });

        const icon = this.querySelector('i');
        if (showNow) {
            this.innerHTML = '<i class="bi bi-eye-slash"></i> Masquer Desserts';
        } else {
            this.innerHTML = '<i class="bi bi-eye"></i> Afficher Desserts';
        }
    });
    JS;
    $custom_style = <<<CSS
    .hidden-col { display: none; }
        .shown-col  { display: table-cell; }

        /* Impression = reproduire EXACTEMENT l'état affiché */
        @media print {
            .no-print { display: none !important; }
            .hidden-col { display: none !important; }
            .shown-col  { display: table-cell !important; }
        }

        

        .table tbody td {
            vertical-align: middle;
            font-size: 14px;
        }

        .special-row { background: #fff3cd; }

        /* Style pour les boutons de toggle */
        .toggle-btn {
            margin-right: 5px;
            margin-bottom: 5px;
        }
    CSS;
?>
<?php require __DIR__ . '/../../layout/header.php'; ?>
<div class="container mt-4">
<div class="card-modern">
  <div class="card-header-pastel"><?= $title ?> : <?= $monthName ?> <?= $year ?></div>
    <div class="card-body">   
        <div class="container center">       
 <!-- Filtre mois/année -->
        <form class="form-inline mb-4 no-print">
            <label class="mr-2">Mois :</label>
            <select id="mois" class="form-control mr-2">
                <?php for($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= $i ?>" <?= ($i == $month) ? 'selected' : '' ?>>
                        <?= $monthsFr[$i - 1] ?>
                    </option>
                <?php endfor; ?>
            </select>

            <label class="mr-2">Année :</label>
            <select id="annee" class="form-control mr-2">
                <?php for($y = 2023; $y <= 2030; $y++): ?>
                    <option value="<?= $y ?>" <?= ($y == $year) ? 'selected' : '' ?>>
                        <?= $y ?>
                    </option>
                <?php endfor; ?>
            </select>

            <button type="button" class="btn btn-primary" onclick="selectMonth()">Afficher</button>
        </form>

        <!-- Boutons de toggle -->
        <div class="mb-3 no-print">
            <button id="toggleSeasonWeekBtn" class="btn btn-warning toggle-btn">
                <i class="bi bi-eye-slash"></i> Afficher Saison / Week
            </button>

            <button id="toggleBreakfastBtn" class="btn btn-info toggle-btn">
                <i class="bi bi-eye"></i> Masquer Breakfast
            </button>

            <button id="toggleDessertsBtn" class="btn btn-info toggle-btn">
                <i class="bi bi-eye"></i> Masquer Desserts
            </button>
            <a href="printMonthlyMenu?annee=<?= $year ?>&mois=<?= $month ?>" target="_blank" class="btn btn-secondary toggle-btn">
                <i class="bi bi-printer"></i> Imprimer
            </a>
        </div>

        <!-- TABLEAU -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Jour</th>
                        <th class="toggle-col-season-week hidden-col">Saison</th>
                        <th class="toggle-col-season-week hidden-col">Week</th>
                        <th class="toggle-col-breakfast">Breakfast</th>
                        <th>Lunch</th>
                        <th class="toggle-col-desserts">Lunch Dessert</th>
                        <th>Dinner</th>
                        <th class="toggle-col-desserts">Dinner Dessert</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($rows as $r): ?>
                        <tr class="<?= ($r['saison'] === 'Special') ? 'special-row' : '' ?>">
                            <td><?= date('d/m/Y', strtotime($r['date'])) ?></td>
                            <td><?= htmlspecialchars(ucfirst(strtolower($r['day']))) ?></td>
                            <td class="toggle-col-season-week hidden-col"><?= htmlspecialchars($r['saison']) ?></td>
                            <td class="toggle-col-season-week hidden-col"><?= htmlspecialchars($r['week']) ?></td>

                            <?php if ($r['menu']): ?>
                                <td class="toggle-col-breakfast">
                                    <?= htmlspecialchars($r['menu']['breakfast'] ?? '') ?>
                                </td>
                                <td><?= htmlspecialchars($r['menu']['lunch'] ?? '') ?></td>
                                <td class="toggle-col-desserts">
                                    <?= htmlspecialchars($r['menu']['lunch_dessert'] ?? '') ?>
                                </td>
                                <td><?= htmlspecialchars($r['menu']['dinner'] ?? '') ?></td>
                                <td class="toggle-col-desserts">
                                    <?= htmlspecialchars($r['menu']['dinner_dessert'] ?? '') ?>
                                </td>
                            <?php else: ?>
                                <td class="toggle-col-breakfast" colspan="5" class="text-muted text-center">
                                    Aucun menu
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>