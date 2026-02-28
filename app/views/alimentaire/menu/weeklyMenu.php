<?php $title = 'Menu de la semaine'; 
    $annee = $_GET['annee'] ?? date("Y");
    $custom_js = <<<JS
    // Custom JavaScript can be added here
    function selectDate() {
    const date = document.getElementById('date').value;
    if (date) window.location = "/menu/weeklyMenu?date=" + date;
    }
    JS;
?>
<?php require __DIR__ . '/../../layout/header.php'; ?>
<div class="text-center mt-4">
    <div class="container center">
        <div class="card-modern">
        <div class="card-header-pastel"><?= $title ?></div>
        <div class="card-body">
        <form class="form-inline mb-4">
                <label for="date" class="mr-2">Date de début :</label>
                <input type="date" id="date" name="date"
                    class="form-control mr-2"
                    value="<?= e($startDate) ?>">
                <button type="button" class="btn btn-primary mr-2" onclick="selectDate()">Afficher</button>
                <a target="_blank" href="/menu/printWeeklyMenu?date=<?= e($startDate) ?>" class="btn btn-secondary">Imprimer</a>
        </form>
        <H3 class="mb-4 text-center font-weight-bold">Menu de la semaine du <?= $weekStartStr ?> au <?= $weekEndStr ?></H3> 
        <table class="table table-bordered table-hover">
            <colgroup>
                <col style="width:6%">   <!-- Jour -->
                <col style="width:10%">  <!-- Date -->
                <col style="width:10%">  <!-- Saison -->
                <col style="width:5%">  <!-- Week -->
                <col style="width:15%">  <!-- Breakfast -->
                <col style="width:15%">  <!-- Lunch -->
                <col style="width:12%">  <!-- Lunch Dessert -->
                <col style="width:15%">  <!-- Dinner -->
                <col style="width:12%">  <!-- Dinner Dessert -->
            </colgroup>
                <thead>
                    <tr>
                        <th>Jour</th>
                        <th>Date</th>
                        <th>Saison</th>
                        <th>Wk</th>
                        <th>Breakfast</th>
                        <th>Lunch</th>
                        <th>Lunch Dessert</th>
                        <th>Dinner</th>
                        <th>Dinner Dessert</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menus as $item): ?>
                        <tr class="<?= ($item['saison'] === 'Special') ? 'table-warning' : '' ?>">
                        <td class="col-1">
                            <strong>
                                <?= (new DateTime($item['day']))->format('D') ?>
                            </strong>
                        </td>
                        <td><?= date('d/m/Y', strtotime($item['date'])) ?></td>
                        <td><?= e($item['saison']) ?></td>
                        <td><?= e($item['week']) ?></td>

                        <?php if ($item['menu']): ?>
                            <td><?= e($item['menu']['breakfast']) ?></td>
                            <td><?= e($item['menu']['lunch']) ?></td>
                            <td><?= e($item['menu']['lunch_dessert']) ?></td>
                            <td><?= e($item['menu']['dinner']) ?></td>
                            <td><?= e($item['menu']['dinner_dessert']) ?></td>
                        <?php else: ?>
                            <td colspan="5" class="cell-empty"><em>Aucun menu trouvé</em></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
        </table>
    </div>
        </div>
    </div>

    <a href="/alimentaire/index" class="btn btn-secondary">⬅ Accueil</a>
<?php require __DIR__ . '/../../layout/footer.php'; ?> 