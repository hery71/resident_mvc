<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression Departement</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://resident_mvc.test/assets/css/style.css">
<?php require __DIR__ . '/../layout/printStyleScript.php'; ?>
</head>
<body>
<div class="container mt-4" id="printable-area">
<?php include __DIR__ . '/../layout/printSizeOption.php'; 
$endDate = date('Y-m-d', strtotime($startDate . ' +13 days'));
?>
<H3 class="mb-4 text-center font-weight-bold">Congés par departement</H3>
<H5  class="mb-4 text-left font-weight-bold">Congés de <?= e($departement) ?>  </H5>
<H5  class="mb-4 text-left font-weight-bold">Periode du <?= e($startDate) ?> Au <?= e($endDate) ?></H5>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>Type de congé</th>
        <th>Nb</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($sumOffDepartement as $off => $count): ?>
        <tr>
            <td><?= e($off) ?></td>
            <td><?= e($count) ?></td>
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

