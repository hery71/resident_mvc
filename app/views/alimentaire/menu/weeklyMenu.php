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
<div class="container center">
<h3> Menu de la semaine</h3>
  <form class="form-inline mb-4">
        <label for="date" class="mr-2">Date de début :</label>
        <input type="date" id="date" name="date"
            class="form-control mr-2"
            value="<?= e($startDate) ?>">
        <button type="button" class="btn btn-primary mr-2" onclick="selectDate()">Afficher</button>
  </form>

  <table class="table table-bordered">
        <thead>
            <tr>
                <th>Jour</th>
                <th>Date</th>
                <th>Saison</th>
                <th>Week</th>
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
                <td><strong><?= e($item['day']) ?></strong></td>
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

  <div class="form-group mt-3">
        <label for="fontSizeSelect"><strong>Taille du texte :</strong></label>
        <select id="fontSizeSelect" class="form-control d-inline-block ml-2" style="width:150px;">
            <option value="10">S</option>
            <option value="12">M</option>
            <option value="14" selected>Normal</option>
            <option value="16">XL</option>
            <option value="18">XXL</option>
            <option value="20">XXXL</option>
        </select>
  </div>

  <button class="btn btn-success mt-3" onclick="printWeek()">🖨️ Imprimer la semaine</button>
   <div class="text-center mt-4">
    <a href="/alimentaire/index" class="btn btn-secondary">⬅ Accueil</a>
<?php require __DIR__ . '/../../layout/footer.php'; ?> 