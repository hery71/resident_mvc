<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression Staff List</title>
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
<H3 class="mb-4 text-center font-weight-bold">Liste du staff</H3>
<H5  class="mb-4 text-left font-weight-bold">Congés du departement <?= e($departement) ?>  </H5>
<H5  class="mb-4 text-left font-weight-bold">Periode du <?= e($startDate) ?> Au <?= e($endDate) ?></H5>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Nom</th>
                <th>SM</th>
                <th>WD</th>
                <th>H</th>
                <th>V</th>
                <th>F</th>
                <th>HA</th>
                <th>CUPE</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $totalSM = 0;
        $totalWD = 0;
        $totalH  = 0;
        $totalV  = 0;
        $totalF  = 0;
        $totalHA = 0;
        $totalCupe = 0;
        ?>
        <?php foreach ($summaryStaffList as $parts => $offs): 
        //Exploder id#prenom nom
        $partsArray = explode('#', $parts);
        $id_staff = $partsArray[0];
        $name = $partsArray[1];
        $sm   = $offs['SM'] ?? 0;
        $wd   = $offs['WD'] ?? 0;
        $h    = $offs['H'] ?? 0;
        $v    = $offs['V'] ?? 0;
        $f    = $offs['F'] ?? 0;
        $ha   = $offs['HA'] ?? 0;
        $cupe = $offs['CUPE'] ?? 0;

        $totalSM += $sm;
        $totalWD += $wd;
        $totalH  += $h;
        $totalV  += $v;
        $totalF  += $f;
        $totalHA += $ha;
        $totalCupe += $cupe;
        ?>
        <tr>
            <td><?= $name ?></td>
            <td class="td-offred"><?= $sm ?: '' ?></td>
            <td class="td-offred"><?= $wd ?: '' ?></td>
            <td class="td-offblue"><?= $h ?: '' ?></td>
            <td class="td-offblue"><?= $v ?: '' ?></td>
            <td class="td-offblue"><?= $f ?: '' ?></td>
            <td class="td-offblue"><?= $ha ?: '' ?></td>
            <td><?= $cupe ?: '' ?></td>
            </tr>
        <?php endforeach; ?>
        <tr class="table-light">
            <td>Total</td>
            <td class="td-somme"><?= $totalSM ?></td>
            <td class="td-somme"><?= $totalWD ?></td>
            <td class="td-somme"><?= $totalH ?></td>
            <td class="td-somme"><?= $totalV ?></td>
            <td class="td-somme"><?= $totalF ?></td>
            <td class="td-somme"><?= $totalHA ?></td>
            <td class="td-somme"><?= $totalCupe ?></td>
        </tr>

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

