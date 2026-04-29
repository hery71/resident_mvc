<?php $title = 'Recherche de menu'; ?>
<?php require __DIR__ . '/../../layout/header.php'; ?>

<div class="container mt-4">
    <div class="card-modern">
        <div class="card-header-pastel"><?= e($title) ?></div>
        <div class="card-body">

            <form method="get" action="/menu/searchMeal" class="mb-4">
                <div class="form-row align-items-end">
                    <div class="col-md-2">
                        <label><strong>Année</strong></label>
                        <select name="annee" class="form-control">
                            <?php foreach ($years as $y): ?>
                                <option value="<?= e($y) ?>" <?= ($y == $selectedYear) ? 'selected' : '' ?>>
                                    <?= e($y) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label><strong>Saison</strong></label>
                        <select name="saison" class="form-control">
                            <?php foreach ($seasons as $s): ?>
                                <option value="<?= e($s['Saison']) ?>"
                                    <?= ($selectedSeasonName === $s['Saison']) ? 'selected' : '' ?>>
                                    <?= e($s['Saison']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="service"><strong>Service</strong></label>
                        <select name="service" id="service" class="form-control">
                            <option value="all" <?= ($service === 'all') ? 'selected' : '' ?>>Tous les services</option>
                            <option value="menu_breakfast" <?= ($service === 'menu_breakfast') ? 'selected' : '' ?>>Breakfast</option>
                            <option value="menu_lunch" <?= ($service === 'menu_lunch') ? 'selected' : '' ?>>Lunch</option>
                            <option value="menu_lunch_dessert" <?= ($service === 'menu_lunch_dessert') ? 'selected' : '' ?>>Lunch Dessert</option>
                            <option value="menu_dinner" <?= ($service === 'menu_dinner') ? 'selected' : '' ?>>Dinner</option>
                            <option value="menu_dinner_dessert" <?= ($service === 'menu_dinner_dessert') ? 'selected' : '' ?>>Dinner Dessert</option>
                        </select>
                    </div>

                    <div class="col-md-7">
                        <label for="keywords"><strong>Mots-clés</strong>  (séparer plusieurs mots-clés avec le signe +)</label>
                        <input
                            type="text"
                            name="keywords"
                            id="keywords"
                            class="form-control"
                            value="<?= e($keywordsRaw ?? '') ?>"
                            placeholder="Ex: chicken + soup"
                        >
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">Chercher</button>
                    </div>
                </div>
            </form>

            <?php if (!empty($keywordsRaw)): ?>
                <h5 class="mb-3">Résultats : <?= count($results) ?></h5>

                <?php if (!empty($results)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Service</th>
                                    <th>ID ligne</th>
                                    <th>Meal trouvé</th>
                                    <th>ID menu</th>
                                    <th>ID spécial</th>
                                    <th>Semaine</th>
                                    <th>Jour</th>
                                    <th>Année</th>
                                    <th>Menu spécial</th>
                                    <th>Date spéciale</th>
                                    <th>Observation spécial</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($results as $row): ?>
                                <tr>
                                    <td><?= e($row['service_name'] ?? '') ?></td>
                                    <td><?= e($row['id']) ?></td>
                                    <td>
                                       <a href="/menu/mealCalendar?service=<?= urlencode($row['service_table'] ?? $service) ?>&meal=<?= urlencode(preg_replace('/\s+/', ' ', $row['meal'])) ?>&season=<?= urlencode($selectedSeasonName) ?>&year=<?= urlencode($selectedYear) ?>&week=<?= urlencode($row['week'] ?? 1) ?>&day=<?= urlencode($row['day'] ?? '') ?>">
                                            <?= e($row['meal']) ?>
                                        </a>
                                    </td>
                                    <td><?= e($row['id_menu']) ?></td>
                                    <td><?= e($row['ids']) ?></td>
                                    <td><?= e($row['week'] ?? '') ?></td>
                                    <td><?= e($row['day'] ?? '') ?></td>
                                    <td><?= e($row['annee'] ?? '') ?></td>
                                    <td><?= ((int)($row['ids'] ?? 0) > 0) ? e($row['unique_nom'] ?? '') : 'Aucun' ?></td>
                                    <td><?= ((int)($row['ids'] ?? 0) > 0) ? e($row['unique_date'] ?? '') : '' ?></td>
                                    <td><?= ((int)($row['ids'] ?? 0) > 0) ? e($row['unique_observation'] ?? '') : '' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">Aucun résultat trouvé.</div>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layout/footer.php'; ?>