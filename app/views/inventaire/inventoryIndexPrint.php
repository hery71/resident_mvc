<?php $title = 'Inventaire — ' . $department['departement']; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <?php require __DIR__ . '/../layout/printStyleScript.php'; ?>
</head>
<body>
<main class="container-fluid mt-4" id="printable-area">
    <?php include __DIR__ . '/../layout/printSizeOption.php'; ?>
    <h1 class="h3 text-center">Inventaire — <?= e($department['departement']) ?></h1>
    <p class="text-center">Stock en cours au <?= e(date('d/m/Y')) ?></p>
    <?php if ($department['observations'] !== ''): ?><p><?= nl2br(e($department['observations'])) ?></p><?php endif; ?>
    <table class="table table-bordered">
        <thead><tr>
            <th data-print-weight="80">Article</th>
            <th data-print-weight="20" class="text-right">Stock en cours</th>
        </tr></thead>
        <tbody>
        <?php foreach ($articles as $article): ?>
            <tr>
                <td><?= e($article['nom']) ?></td>
                <td class="text-right"><strong><?= e($article['stock']) ?></strong></td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$articles): ?><tr><td colspan="2" class="text-center">Aucun article dans ce département.</td></tr><?php endif; ?>
        </tbody>
    </table>
</main>
</body>
</html>
