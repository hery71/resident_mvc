<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression Résidents</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://resident_mvc.test/assets/css/style.css">
<?php require __DIR__ . '/../layout/printStyleScript.php'; ?>
</head>
<body>
<div class="container mt-4" id="printable-area">
    <?php include __DIR__ . '/../layout/printSizeOption.php'; ?>
    <h4 class="mb-4 text-center font-weight-bold">Liste des résidents</h4>
    <table class="table table-bordered table-striped">
        <thead class="thead-light text-center">
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Chambre</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($residents as $r): ?>
            <tr>
                <td><?= e($r['Prenom']) ?></td>
                <td><?= e($r['Nom']) ?></td>
                <td class="text-center"><?= e($r['Chambre'] ?? '') ?></td>
            </tr>
        <?php endforeach; ?>
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

