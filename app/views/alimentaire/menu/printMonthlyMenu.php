<?php
$colonnes='
{
"Date": 1,
"Jour": 2,
"Saison": 3,
"Week": 4,
"Breakfast": 5,
"Lunch": 6,
"Lunch Dessert": 7,
"Dinner": 8,
"Dinner Dessert": 9
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
<H3 class="mb-4 text-center font-weight-bold">Menu du mois: <?= $monthName ?> <?= $year ?></H3> 
    <div class="table-responsive">
            <table class="table table-bordered table-striped">
                 <colgroup>
        <col style="width:9%">   <!-- Jour -->
        <col style="width:6%">  <!-- Date -->
        <col style="width:8%">  <!-- Saison -->
        <col style="width:8%">  <!-- Week -->
        <col style="width:15%">  <!-- Breakfast -->
        <col style="width:15%">  <!-- Lunch -->
        <col style="width:12%">  <!-- Lunch Dessert -->
        <col style="width:12%">  <!-- Dinner -->
        <col style="width:15%">  <!-- Dinner Dessert -->
    </colgroup>
                <thead>
                    <tr>
                        
                        <th class="col-1">Date</th>
                        <th class="col-2">Jour</th>
                        <th class="toggle-col-season-week hidden-col col-3">Saison</th>
                        <th class="toggle-col-season-week hidden-col col-4">Week</th>
                        <th class="toggle-col-breakfast cil-5">Breakfast</th>
                        <th class="col-6">Lunch</th>
                        <th class="toggle-col-desserts col-7">Lunch Dessert</th>
                        <th class="col-8">Dinner</th>
                        <th class="toggle-col-desserts col-9">Dinner Dessert</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($rows as $r): ?>
                        <tr class="<?= ($r['saison'] === 'Special') ? 'special-row' : '' ?>">
                            <td class="col-1"><?= date('d/m/Y', strtotime($r['date'])) ?></td>
                            <td class="col-2"><?= htmlspecialchars(ucfirst(strtolower($r['day']))) ?></td>
                            <td class="toggle-col-season-week hidden-col col-3"><?= htmlspecialchars($r['saison']) ?></td>
                            <td class="toggle-col-season-week hidden-col col-4"><?= htmlspecialchars($r['week']) ?></td>

                            <?php if ($r['menu']): ?>
                                <td class="toggle-col-breakfast col-5">
                                    <?= htmlspecialchars($r['menu']['breakfast'] ?? '') ?>
                                </td>
                                <td class="col-6"><?= htmlspecialchars($r['menu']['lunch'] ?? '') ?></td>
                                <td class="toggle-col-desserts">
                                    <?= htmlspecialchars($r['menu']['lunch_dessert'] ?? '') ?>
                                </td>
                                <td class="col-8"><?= htmlspecialchars($r['menu']['dinner'] ?? '') ?></td>
                                <td class="toggle-col-desserts col-9">
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
</div> <!-- container -->


    <footer class="bg-light text-center mt-5 py-3">
        <small class="text-muted">
            © 2026 – Resident MVC
        </small>
    </footer>
</body>
    </html>

