<?php $title = 'Menu aux 2 Semaines — Impression'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <?php require __DIR__ . '/../../layout/printStyleScript.php'; ?>
    <style id="orientation-style"></style>
    <style>
        .special-row { background: #fff3cd; }
        .second-choice-row { background: #eef6ff; }
        .hidden-col, .second-choice-row[hidden] { display: none !important; }
        @media print {
            #printable-area tbody { break-inside: avoid; page-break-inside: avoid; }
            #printable-area thead { display: table-header-group; }
        }
    </style>
</head>
<body>
<main class="container-fluid mt-4" id="printable-area">
    <?php include __DIR__ . '/../../layout/printSizeOption.php'; ?>
    <div class="no-print mb-3" role="group" aria-label="Contenu du menu">
        <label class="mr-3"><input type="checkbox" id="printSeason"> Saison / Week</label>
        <label class="mr-3"><input type="checkbox" id="printBreakfast" checked> Breakfast</label>
        <label class="mr-3"><input type="checkbox" id="printDesserts" checked> Desserts</label>
        <label class="mr-3"><input type="checkbox" id="printSecond"> 2ème choix</label>
    </div>
    <h3 class="text-center mb-3">Menu aux 2 Semaines</h3>
    <p class="text-center">Du <?= e(date('d/m/Y', strtotime($startDate))) ?> au <?= e(date('d/m/Y', strtotime($endDate))) ?></p>
<table class="table table-bordered table-hover">
                        <colgroup id="menu-print-columns"></colgroup>
                        <thead>
                            <tr>
                                <th data-print-weight="9">Date</th>
                                <th data-print-weight="8">Jour</th>
                                <th data-print-weight="6" class="toggle-col-season-week">Saison</th>
                                <th data-print-weight="4" class="toggle-col-season-week">Week</th>
                                <th data-print-weight="16" class="toggle-col-breakfast">Breakfast</th>
                                <th data-print-weight="24">Lunch</th>
                                <th data-print-weight="12" class="toggle-col-desserts">Lunch Dessert</th>
                                <th data-print-weight="24">Dinner</th>
                                <th data-print-weight="12" class="toggle-col-desserts">Dinner Dessert</th>
                            </tr>
                        </thead>
                        
                            <?php foreach($rows as $r): ?><tbody>
                                <tr class="<?= ($r['saison'] === 'Special') ? 'special-row' : '' ?>">
                                    <td><?= date('d/m/Y', strtotime($r['date'])) ?></td>
                                    <td><?= htmlspecialchars(ucfirst(strtolower($r['day']))) ?></td>
                                    <td class="toggle-col-season-week"><?= htmlspecialchars($r['saison']) ?></td>
                                    <td class="toggle-col-season-week"><?= htmlspecialchars($r['week']) ?></td>

                                    <?php if ($r['menu']): ?>
                                        <td class="toggle-col-breakfast"><?= htmlspecialchars($r['menu']['breakfast'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($r['menu']['lunch'] ?? '') ?></td>
                                        <td class="toggle-col-desserts"><?= htmlspecialchars($r['menu']['lunch_dessert'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($r['menu']['dinner'] ?? '') ?></td>
                                        <td class="toggle-col-desserts"><?= htmlspecialchars($r['menu']['dinner_dessert'] ?? '') ?></td>
                                    <?php else: ?>
                                        <td class="toggle-col-breakfast"></td>
                                        <td></td>
                                        <td class="toggle-col-desserts"></td>
                                        <td></td>
                                        <td class="toggle-col-desserts"></td>
                                    <?php endif; ?>
                                </tr>
                                <tr class="second-choice-row">
                                    <th scope="row" colspan="2">2ème Choix</th>
                                    <td class="toggle-col-season-week"></td>
                                    <td class="toggle-col-season-week"></td>
                                    <td class="toggle-col-breakfast"><?= e($secondChoice['Breakfast'] ?? '') ?></td>
                                    <td><?= e($secondChoice['lunch'] ?? '') ?></td>
                                    <td class="toggle-col-desserts"></td>
                                    <td><?= e($secondChoice['diner'] ?? '') ?></td>
                                    <td class="toggle-col-desserts"></td>
                                </tr>
                            </tbody><?php endforeach; ?>
                        
                    </table>
</main>
<script>
(function () {
    const params = new URLSearchParams(window.location.search);
    const settings = [
        ['printSeason', 'season', '.toggle-col-season-week', false],
        ['printBreakfast', 'breakfast', '.toggle-col-breakfast', true],
        ['printDesserts', 'desserts', '.toggle-col-desserts', true],
        ['printSecond', 'second', '.second-choice-row', false]
    ];
    settings.forEach(([id, key, selector, defaultValue]) => {
        const input = document.getElementById(id);
        input.checked = params.has(key) ? params.get(key) === '1' : defaultValue;
        function update() {
            document.querySelectorAll(selector).forEach(element => {
                element.classList.toggle('hidden-col', !input.checked);
            });
            updateColgroup();
        }
        input.addEventListener('change', update);
        update();
    });
})();
</script>
</body>
</html>
