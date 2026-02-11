<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression Liste préparation Hebdomadaire</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://resident_mvc.test/assets/css/style.css">
<?php require __DIR__ . '/../../layout/printStyleScript.php'; ?>
</head>
<body>
<div class="container mt-4" id="printable-area">
    <?php include __DIR__ . '/../../layout/printSizeOption.php'; ?>
    <h4 class="mb-4 text-center font-weight-bold">LISTE DES PREPARATIONS HEBDOMADAIRES</h4>
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
                        
</div> <!-- container -->


    <footer class="bg-light text-center mt-5 py-3">
        <small class="text-muted">
            © 2026 – Resident MVC
        </small>
    </footer>
</body>
    </html>

