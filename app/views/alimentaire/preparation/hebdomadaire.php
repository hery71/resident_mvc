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
        <button type="button" target="_blank" onclick="window.open('/preparation/printHebdomadaire?date=<?= urlencode($xdate) ?>', '_blank')" class="btn btn-info ms-3">🖨️ Imprimer</button>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Plat</th>
                <th>Ingrédient</th>
                <th>Action</th>
                <th>Quantité</th>
                <th>Unité</th>
                <th>Date du service</th>
            </tr>
        </thead>
        <tbody>
            <?php $dateEnCours = clone($startOfWeek);
            while($dateEnCours <= $endOfWeek): 
            $x=0;?>
                    <tr class="table-secondary">
                        <td colspan="7" class="fw-bold text-center">
                            <?= $dateEnCours->format('l d M Y');?>
                        </td>
                    </tr>
                <?php foreach ($weekData as $id => $items):
                    $itemDate = new DateTime($items['preparation_date']);
                    if ($itemDate->format('Y-m-d') == $dateEnCours->format('Y-m-d')): 
                        $x++;?>
                        <tr>
                            <td><?= htmlspecialchars($items['plat']) ?></td>
                            <td><?= htmlspecialchars($items['ingredient']) ?></td>
                            <td><?= htmlspecialchars($items['action']) ?></td>
                            <td><?= htmlspecialchars($items['nb']) ?></td>
                            <td><?= htmlspecialchars($items['unite']) ?></td>
                            <td><?= htmlspecialchars($items['date']) ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                    <?php if ($x === 0): ?>
                        <tr>
                            <td colspan="7" class="text-muted text-center">Aucune tâche de préparation ce jour.</td>
                        </tr>
                    <?php endif; ?>
                <?php $dateEnCours->modify('+1 day'); 
            endwhile; ?>
        </tbody>
    </table>    
<!---------------------FIN DIV PRINCIPAL--------------------->
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>