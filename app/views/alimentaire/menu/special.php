<?php $title = 'Menu Spécial'; 
    $inspection=  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
    $custom_js = <<<JS
    // Custom JavaScript can be added here
    JS;
?>
<?php require __DIR__ . '/../../layout/header.php'; ?>
<div class="container mt-4 mb-5">
    <h2 class="text-center">🎉 Menus spéciaux</h2>
    <!-- Filtres -->
    <form method="get" class="form-inline justify-content-center mb-4">
        <label class="mr-2">Menu spécial :</label>
        <select name="special" id="specialSelect" class="form-control mr-3">
            <option value="4" <?= ($special==4)?'selected':'' ?>>🎄 Christmas</option>
            <option value="5" <?= ($special==5)?'selected':'' ?>>🎆 New Year</option>
        </select>
        <label class="mr-2">Année :</label>
        <select name="annee" id="anneeSelect" class="form-control mr-3">
            <?php for ($y=2025;$y<=2030;$y++): ?>
                <option value="<?= $y ?>" <?= ($y==$annee)?'selected':'' ?>><?= $y ?></option>
            <?php endfor; ?>
        </select>

        <button class="btn btn-primary">Afficher</button>
    </form>

    <h5 class="text-center mb-4">
        🎄 Menu spécial <strong><?= htmlspecialchars($specialLabel) ?></strong>
        – <strong><?= htmlspecialchars($annee) ?></strong>
    </h5>

    <?php if (empty($menus)): ?>
        <div class="alert alert-info text-center">
            Aucun menu spécial trouvé.
        </div>
    <?php else: ?>
    <div id="specialContent">
        <table class="table table-bordered table-hover">
            <thead class="bg-primary text-white text-center">
                <tr>
                    <th>Day</th>
                    <th>Date 1</th>
                    <th>Date 2</th>
                    <th>Breakfast</th>
                    <th>Lunch</th>
                    <th>Dessert Lunch</th>
                    <th>Dinner</th>
                    <th>Dessert Dinner</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($menus as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['day']) ?></td>
                    <td><?= $m['date1'] ? date('d/m/Y', strtotime($m['date1'])) : '' ?></td>
                    <td><?= $m['date2'] ? date('d/m/Y', strtotime($m['date2'])) : '' ?></td>
                    <td><?= htmlspecialchars($m['breakfast']) ?></td>
                    <td><?= htmlspecialchars($m['lunch']) ?></td>
                    <td><?= htmlspecialchars($m['lunch_dessert']) ?></td>
                    <td><?= htmlspecialchars($m['dinner']) ?></td>
                    <td><?= htmlspecialchars($m['dinner_dessert']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-3">
        <button class="btn btn-info" onclick="printSpecial()">🖨️ Imprimer</button>
    </div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="/menu" class="btn btn-secondary">⬅ Retour</a>
    </div>

</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>