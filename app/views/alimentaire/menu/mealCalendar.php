<?php $title = 'Meal Calendar'; ?>
<?php require __DIR__ . '/../../layout/header.php'; ?>

<div class="container mt-4">
    <div class="card-modern">
        <div class="card-header-pastel"><?= e($title) ?></div>
        <div class="card-body">

            <div class="mb-3">
                <strong>Meal:</strong> <?= e($meal) ?><br>
                <strong>Service:</strong> <?= e($allowedServices[$service] ?? $service) ?><br>
                <strong>Year:</strong> <?= e($year) ?><br>
                <strong>Season:</strong> <?= e($season) ?><br>
                <strong>Week:</strong> <?= e($week) ?><br>
                <strong>Day:</strong> <?= e($day) ?><br>

                <?php if (!empty($selectedSeason)): ?>
                    <strong>Season range:</strong>
                    <?= e($selectedSeason['Début']) ?> → <?= e($selectedSeason['Fin']) ?>
                <?php else: ?>
                    <strong>Season range:</strong> Not found
                <?php endif; ?>
            </div>

            <?php if (!empty($rows)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>Date</th>
                                <th>Meal</th>
                                <th>Service</th>
                                <th>Season</th>
                                <th>Week</th>
                                <th>Day</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row): ?>
                                <tr>
                                    <td>
                                        <a href="/menu/dailyMenu?date=<?= urlencode($row['date']) ?>">
                                            <?= e($row['date']) ?>
                                        </a>
                                    </td>
                                    <td><?= e($row['meal']) ?></td>
                                    <td><?= e($row['service']) ?></td>
                                    <td><?= e($row['season']) ?></td>
                                    <td><?= e($row['week']) ?></td>
                                    <td><?= e($row['day']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">No date found for this meal.</div>
            <?php endif; ?>

            <div class="mt-3">
                <a href="/menu/searchMeal" class="btn btn-secondary">Back</a>
            </div>

        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layout/footer.php'; ?>