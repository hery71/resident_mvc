<?php $title = 'PREPARATIONS HEBDOMADAIRES'; 
    $inspection=  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
    $custom_js = <<<JS
    // Custom JavaScript can be added here
    JS;
    $custom_style = <<<CSS
    /* Custom CSS can be added here */
    CSS;
?>
<?php require __DIR__ . '/../../layout/header.php'; ?>
<div class="container center">
    <h2>📅 Fiche hebdomadaire de préparation</h2>
    <h5>
        Semaine du <strong><?= $startOfWeek->format('d M Y') ?></strong>  
        au <strong><?= $endOfWeek->format('d M Y') ?></strong>
    </h5>

    <!-- Sélecteur de date -->
    <form method="GET" class="no-print mt-4 mb-4 d-flex align-items-center gap-2">
        <label class="me-2">Choisir une date :</label>
        <input type="date" name="date" class="form-control me-2" style="width:200px" value="<?= $xdate ?>">
        <button class="btn btn-primary">Afficher</button>
        <button type="button" onclick="window.print()" class="btn btn-success ms-3">🖨️ Imprimer</button>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Date de préparation</th>
                <th>Plat</th>
                <th>Ingrédient</th>
                <th>Action</th>
                <th>Quantité</th>
                <th>Unité</th>
                <th>Date du service</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach ($weekData as $day => $items): ?>
            <tr class="table-secondary">
                <td colspan="7" class="fw-bold text-center">
                    <?= (new DateTime($day))->format('l d M Y') ?>
                </td>
            </tr>

            <?php if (empty($items)): ?>
                <tr>
                    <td colspan="7" class="text-muted text-center">Aucune tâche de préparation ce jour.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($items as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($day) ?></td>
                    <td><?= htmlspecialchars($p['plat']) ?></td>
                    <td><?= htmlspecialchars($p['ingredient']) ?></td>
                    <td><?= htmlspecialchars($p['action']) ?></td>
                    <td><?= htmlspecialchars($p['nb']) ?></td>
                    <td><?= htmlspecialchars($p['unite']) ?></td>
                    <td><?= htmlspecialchars($p['service_date']) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>

        <?php endforeach; ?>

        </tbody>
    </table>


    
<!---------------------FIN DIV PRINCIPAL--------------------->
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>