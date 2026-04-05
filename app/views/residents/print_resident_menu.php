<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression Base</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://resident_mvc.test/assets/css/style.css">
<?php require __DIR__ . '/../layout/printStyleScript.php'; ?>
<style>
    @media print {

    .label {
        width: 8cm;
        height: 10cm;
        border: 1px solid #000;
        float: left;
        margin: 0.2cm;
        padding: 5px;
        box-sizing: border-box;
        page-break-inside: avoid;
    }
}
</style>
</head>
<body>
<div class="container mt-4" id="printable-area">
<?php include __DIR__ . '/../layout/printSizeOption.php'; ?>
<H3 class="mb-4 text-center font-weight-bold"><?= e(ucfirst($_GET['service'] ?? '')) ?></H3>
<div>

<?php foreach ($residents as $r): ?>

    <div class="label">

        <strong>
        <?= (new DateTime())->format('d/m/Y') . ' - ' .e($r['LieuRepas']) .' - ' . e(mb_strtoupper($service, 'UTF-8') .' - '.$r['Prenom'].' '.$r['Nom']) . ' - ' . e($r['Chambre']) ?>
        </strong><br>
        
        <div>
            <strong>Diabet:</strong><?= e($r['Diabet']==1 ? 'YES' : 'NO') ?>
            |
            <strong>T:</strong> <?= e($r['Thickened'] ?? '-') ?>
            |
            <strong>C:</strong> <?= e($r['Consistance'] ?? '-') ?>
        </div>

        <br>

        <?php if ($service === 'breakfast'): ?>

            <?php if ($showDrinks): ?>
                <div>
                    <strong>Drinks:</strong><br>
                    <?= e($r['Drink_breakfast'] ?? '') ?>
                </div>
            <?php endif; ?>

            <?php if ($showMenu): ?>
                <div style="margin-top:5px;">
                    <strong>Menu:</strong><br>
                    <?= formatTxt($r['Breakfast_final'] ?? '') ?>
                </div>
            <?php endif; ?>

        <?php elseif ($service === 'lunch'): ?>

            <?php if ($showDrinks): ?>
                <div>
                    <strong>Drinks:</strong><br>
                    <?= e($r['Drink_lunch'] ?? '') ?>
                </div>
            <?php endif; ?>

            <?php if ($showMenu): ?>
                <div style="margin-top:5px;">
                    <strong>Menu:</strong><br>
                    <?= formatTxt($r['Lunch_final'] ?? '') ?>
                </div>
            <?php endif; ?>

        <?php elseif ($service === 'dinner'): ?>

            <?php if ($showDrinks): ?>
                <div>
                    <strong>Drinks:</strong><br>
                    <?= e($r['Drink_dinner'] ?? '') ?>
                </div>
            <?php endif; ?>

            <?php if ($showMenu): ?>
                <div style="margin-top:5px;">
                    <strong>Menu:</strong><br>
                    <?= formatTxt($r['Dinner_final'] ?? '') ?>
                </div>
            <?php endif; ?>

        <?php endif; ?>

    </div>

<?php endforeach; ?>

</div>
  



</div> <!-- container -->


    <footer class="bg-light text-center mt-5 py-3">
        <small class="text-muted">
            © 2026 – Resident MVC
        </small>
    </footer>
</body>
    </html>

