<?php
$colonnes='
{
"Jour": 1,
"Date": 2,
"Breakfast": 3,
"Lunch": 4,
"Lunch Dessert": 5,
"Dinner": 6,
"Dinner Dessert": 7
}';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression Menu de la Semaine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://resident_mvc.test/assets/css/style.css">
<?php require __DIR__ . '/../../layout/printStyleScript.php'; ?>
</head>
<body>
<div class="container mt-4" id="printable-area">
<?php include __DIR__ . '/../../layout/printSizeOption.php'; ?>
<H3 class="mb-4 text-center font-weight-bold">MENU DE LA SEMAINE</H3>
 <H3 class="mb-4 text-center font-weight-bold">Menu de la semaine du <?= $weekStartStr ?> au <?= $weekEndStr ?></H3> 
  <table class="table table-bordered">
        <thead>
            <tr>
                <th>Jour</th>
                <th>Date</th>
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

</div> <!-- container -->


    <footer class="bg-light text-center mt-5 py-3">
        <small class="text-muted">
            © 2026 – Resident MVC
        </small>
    </footer>
</body>
    </html>

