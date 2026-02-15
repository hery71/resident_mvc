<?php $title = 'Menu par saison'; 
    $inspection=  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
    $custom_js = <<<JS
    // Custom JavaScript can be added here
    JS;
    $custom_style = <<<CSS
    /* Custom CSS can be added here */
    CSS;
?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container center">
    <h3> Menu par saison</h3>
    <form method="post" action="/parametres/seasonMenu/" class="mb-4">

    <div class="row align-items-end">

        <div class="col-md-3">
            <label>Année</label>
            <select name="annee" class="form-control">
                <?php for ($y = 2023; $y <= 2027; $y++): ?>
                    <option value="<?= $y ?>" <?= ($annee ?? '') == $y ? 'selected' : '' ?>>
                        <?= $y ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label>Saison</label>
            <select name="saison" class="form-control" required>
                <option value="">-- Choisir --</option>
                <?php 
                $seasons = ['Winter','Spring','Summer','Falls','Christmass','New year'];
                foreach ($seasons as $s): ?>
                    <option value="<?= $s ?>" <?= ($saison ?? '') == $s ? 'selected' : '' ?>>
                        <?= $s ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">
                Afficher
            </button>
        </div>

    </div>

    </form>

    <?php
        $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        $meals = [
            'breakfast' => 'Breakfast',
            'lunch' => 'Lunch',
            'lunch_dessert' => 'Lunch Dessert',
            'dinner' => 'Dinner',
            'dinner_dessert' => 'Dinner Dessert'
        ];
        ?>

        <ul class="nav nav-tabs">
        <?php for ($w = 1; $w <= 3; $w++): ?>
            <li class="nav-item">
                <a class="nav-link <?= $w===1?'active':'' ?>"
                data-toggle="tab"
                href="#week<?= $w ?>">
                Week <?= $w ?>
                </a>
            </li>
        <?php endfor; ?>
        </ul>

        <div class="tab-content border p-3">

        <?php for ($w = 1; $w <= 3; $w++): ?>
        <div class="tab-pane fade <?= $w===1?'show active':'' ?>" id="week<?= $w ?>">

            <table class="table table-bordered table-sm">
                <thead>
                <tr>
                    <th></th>
                    <?php foreach ($days as $day): ?>
                        <th><?= $day ?></th>
                    <?php endforeach; ?>
                </tr>
                </thead>
                    <tbody>

                    <?php foreach ($meals as $key => $label): ?>
                    <tr>
                        <th><?= $label ?></th>

                        <?php foreach ($days as $day): ?>
                            <td>
                                <?php if (!empty($menus[$w][$day][$key])): ?>
                                <?php foreach ($menus[$w][$day][$key] as $item): ?>
                                    <?= e($item) ?><br>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
            <?php endfor; ?>
        </div>

<!---------------------FIN DIV PRINCIPAL--------------------->
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>