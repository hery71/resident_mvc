<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression Menu Journalier</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://resident_mvc.test/assets/css/style.css">
<?php require __DIR__ . '/../../layout/printStyleScript.php'; ?>
</head>
<body>
<div class="container mt-4" id="printable-area">
<?php include __DIR__ . '/../../layout/printSizeOption.php'; ?>
<H3 class="mb-4 text-center font-weight-bold">MENU DU JOUR - <?= $date->format('d M Y') ?></H3>

    <?php if ($menu): ?>
    <div id="menuContent" style="margin:auto;max-width:700px;text-align:center;">
      <div class="section-title font-weight-bold">Breakfast</div>
      <p><?= htmlspecialchars($menu['breakfast']) ?: '-' ?></p>
      <div class="section-title font-weight-bold">Lunch</div>
      <p><?= htmlspecialchars($menu['lunch']) ?: '-' ?></p>
      <div class="section-title font-weight-bold">Lunch Dessert</div>
      <p><?= htmlspecialchars($menu['lunch_dessert']) ?: '-' ?></p>
      <div class="section-title">Dinner</div>
      <p><?= htmlspecialchars($menu['dinner']) ?: '-' ?></p>
      <div class="section-title font-weight-bold">Dinner Dessert</div>
      <p><?= htmlspecialchars($menu['dinner_dessert']) ?: '-' ?></p>
    </div>
  <?php else: ?>
    <div class="alert alert-warning mt-3">Aucun menu trouvé pour cette date.</div>
  <?php endif; ?>


</div> <!-- container -->


    <footer class="bg-light text-center mt-5 py-3">
        <small class="text-muted">
            © 2026 – Resident MVC
        </small>
    </footer>
</body>
    </html>

