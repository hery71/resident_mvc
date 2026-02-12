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
 <H3 class="mb-4 text-center font-weight-bold">Menu de la semaine du <?= $weekStartStr ?> au <?= $weekEndStr ?></H3> 
  <table class="table table-bordered">
     <colgroup>
        <col style="width:6%">   <!-- Jour -->
        <col style="width:10%">  <!-- Date -->
        <col style="width:20%">  <!-- Breakfast -->
        <col style="width:20%">  <!-- Lunch -->
        <col style="width:12%">  <!-- Lunch Dessert -->
        <col style="width:20%">  <!-- Dinner -->
        <col style="width:12%">  <!-- Dinner Dessert -->
    </colgroup>
        <thead>
            <tr>
                <th class="col-1">Jour</th>
                <th class="col-2">Date</th>
                <th class="col-3">Breakfast</th>
                <th class="col-4">Lunch</th>
                <th class="col-5">Lunch Dessert</th>
                <th class="col-6">Dinner</th>
                <th class="col-7">Dinner Dessert</th>
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
                <td class="col-2"><?= date('d/m/Y', strtotime($item['date'])) ?></td>
                <?php if ($item['menu']): ?>
                    <td class="col-3"><?= e($item['menu']['breakfast']) ?></td>
                    <td class="col-4"><?= e($item['menu']['lunch']) ?></td>
                    <td class="col-5"><?= e($item['menu']['lunch_dessert']) ?></td>
                    <td class="col-6"><?= e($item['menu']['dinner']) ?></td>
                    <td class="col-7"><?= e($item['menu']['dinner_dessert']) ?></td>
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

