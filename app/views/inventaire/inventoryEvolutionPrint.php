<?php $title = 'Historique — ' . $article['nom']; ?>
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
 <h1 class="h3 text-center">Historique — <?= e($article['nom']) ?></h1>
 <p class="text-center"><?= e($department['departement']) ?> — Édité le <?= e(date('d/m/Y')) ?></p>
 <table class="table table-bordered">
  <thead><tr>
   <th data-print-weight="16">Date</th><th data-print-weight="12" class="text-right">Entrée</th><th data-print-weight="12" class="text-right">Sortie</th><th data-print-weight="20" class="text-right">Stock après mouvement</th><th data-print-weight="40">Observation</th>
  </tr></thead>
  <tbody>
  <?php foreach ($evolution as $movement): ?><tr>
   <td><?= e(date('d/m/Y', strtotime($movement['date']))) ?></td>
   <td class="text-right"><?= (int)$movement['nb'] > 0 ? '+' . e($movement['nb']) : '—' ?></td>
   <td class="text-right"><?= (int)$movement['nb'] < 0 ? e($movement['nb']) : '—' ?></td>
   <td class="text-right"><strong><?= e($movement['stock']) ?></strong></td>
   <td><?= nl2br(e($movement['observation'])) ?></td>
  </tr><?php endforeach; ?>
  <?php if (!$evolution): ?><tr><td colspan="5" class="text-center">Aucun mouvement enregistré.</td></tr><?php endif; ?>
  </tbody>
  <tfoot><tr><th scope="row" colspan="3">Stock final</th><td class="text-right"><strong><?= e($stock) ?></strong></td><td></td></tr></tfoot>
 </table>
</main>
</body>
</html>
