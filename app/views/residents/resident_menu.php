<?php $title = 'Menu des résidents'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">
    <div class="card-modern">
        <div class="card-header-pastel"><?= $title ?></div>

        <div class="card-body">

            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Résident</th>
                        <th>Drink Breakfast</th>
                        <th>Breakfast</th>
                        <th>Drink Lunch</th>
                        <th>Lunch</th>
                        <th>Drink Dinner</th>
                        <th>Dinner</th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach ($residents as $r): ?>

                    <tr>
                        <td><?= e($r['Prenom'] . ' ' . $r['Nom']) ?></td>

                        <td><?= e($r['Drink_breakfast'] ?? '') ?></td>
                        <td><?= formatTxt(e($r['Breakfast_final'] ?? '')) ?></td>

                        <td><?= e($r['Drink_lunch'] ?? '') ?></td>
                        <td><?= formatTxt(e($r['Lunch_final'] ?? '')) ?></td>

                        <td><?= e($r['Drink_dinner'] ?? '') ?></td>
                        <td><?= formatTxt(e($r['Dinner_final'] ?? '')) ?></td>
                    </tr>

                <?php endforeach; ?>

                </tbody>
            </table>

        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>