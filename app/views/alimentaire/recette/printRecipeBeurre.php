<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression Base</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://resident_mvc.test/assets/css/style.css">
<?php require __DIR__ . '/../../layout/printStyleScript.php'; ?>
</head>

<body>

<div class="container mt-4" id="printable-area">

<?php include __DIR__ . '/../../layout/printSizeOption.php'; ?>

<h3 class="mb-4 text-center font-weight-bold"><?= htmlspecialchars($r['titre']) ?></h3>

<h5>Ingrédients</h5>

<?php if (isset($r['ingredients'])): ?>

    <!-- CAS BEURRE / MARINADE (liste simple) -->
    <ul>
        <?php foreach ($r['ingredients'] as $ing): ?>
            <li><?= htmlspecialchars(is_array($ing) ? ($ing['nom'] ?? '') : $ing) ?></li>
        <?php endforeach; ?>
    </ul>

<?php else: ?>

    <!-- CAS RECETTE FR AVEC SECTIONS -->
    <?php foreach ($r as $section => $items): ?>

        <?php
        if (in_array($section, ['titre', 'pax', 'type', 'genre', 'technique_de_realisation', 'utilisation'])) {
            continue;
        }

        if (!is_array($items)) continue;
        ?>

        <h6 class="mt-3 font-weight-bold"><?= htmlspecialchars($section) ?></h6>

        <ul>
            <?php foreach ($items as $ing): ?>
                <li>
                    <?= htmlspecialchars($ing['quantite'] ?? '') ?>
                    <?= htmlspecialchars($ing['unite'] ?? '') ?>
                    — <?= htmlspecialchars($ing['nom'] ?? '') ?>
                </li>
            <?php endforeach; ?>
        </ul>

    <?php endforeach; ?>

<?php endif; ?>


<h5>Technique de réalisation</h5>

<ol>
    <?php foreach ($r['technique_de_realisation'] as $etape): ?>
        <li><?= htmlspecialchars($etape) ?></li>
    <?php endforeach; ?>
</ol>


<?php if (!empty($r['utilisation'])): ?>
<h5>Utilisation</h5>
<ul>
    <?php foreach ($r['utilisation'] as $u): ?>
        <li><?= htmlspecialchars($u) ?></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>


</div>

<footer class="bg-light text-center mt-5 py-3">
    <small class="text-muted">
        © 2026 – Resident MVC
    </small>
</footer>

</body>
</html>