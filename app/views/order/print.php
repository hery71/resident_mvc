<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression Commandes</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="https://resident_mvc.test/assets/css/style.css">

    <?php require __DIR__ . '/../layout/printStyleScript.php'; ?>
</head>

<body>

<div class="container mt-4" id="printable-area">

<?php include __DIR__ . '/../layout/printSizeOption.php'; ?>

<h3 class="mb-4 text-center font-weight-bold">
    Liste des achats - <?= e($debutperiode) ?> au <?= e($finperiode) ?>
</h3>

<?php
$labels = [
    'breakfast' => 'Breakfast',
    'lunch' => 'Lunch + Dessert',
    'dinner' => 'Dinner + Dessert'
];
?>
,
<div class="row">

<?php foreach ($orderList as $group => $items): ?>
    <?php if ($group === 'mealsWithoutIngredients') continue; ?>

    <div class="col-md-4">

        <div class="card mb-4">

            <div class="card-header bg-dark text-white text-center">
                <?= e($labels[$group] ?? $group) ?>
            </div>

            <div class="card-body p-0">

                <table class="table table-bordered table-sm mb-0">

                    <thead>
                        <tr>
                            <th style="width:70px;">Nb</th>
                            <th>Ingredient</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($items as $ingredient => $count): ?>

                        <tr>
                            <td><?= $count ?></td>
                            <td><?= e($ingredient) ?></td>
                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

<?php endforeach; ?>

</div>

</div>

<footer class="bg-light text-center mt-5 py-3">
    <small class="text-muted">
        © 2026 – Resident MVC
    </small>
</footer>

</body>
</html>