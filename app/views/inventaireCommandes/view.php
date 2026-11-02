<?php $title = 'Commande — ' . $order['nom'];
if (!$print) require __DIR__ . '/../layout/header.php';
else { ?>
<!DOCTYPE html><html lang="fr"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?= e($title) ?></title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"><link rel="stylesheet" href="/assets/css/style.css">
<?php require __DIR__ . '/../layout/printStyleScript.php'; ?></head><body>
<?php } ?>
<main class="container-fluid mt-4" id="printable-area">
<?php if ($print) include __DIR__ . '/../layout/printSizeOption.php'; ?>
<?php if (!$print): ?><div class="mb-3"><a class="btn btn-outline-secondary" href="/inventaireCommandes/index">Liste des commandes</a> <a class="btn btn-primary" target="_blank" rel="noopener" href="/inventaireCommandes/print?id=<?= (int)$order['id'] ?>">Imprimer</a></div><?php endif; ?>
<?php if ($message !== ''): ?><div class="alert alert-success" role="status"><?= e($message) ?></div><?php endif; ?>
<h1 class="h3"><?= e($order['nom']) ?></h1>
<p><strong>Commande nº <?= (int)$order['id'] ?></strong> — <?= $order['statut'] === 'brouillon' ? 'Brouillon — non envoyé' : 'Envoyée' ?></p>
<p><strong>Département :</strong> <?= e($order['departement_nom']) ?><br>
<strong>Création :</strong> <?= e(date('d/m/Y H:i', strtotime($order['created_at']))) ?>
<?php if ($order['sent_at']): ?><br><strong>Envoi :</strong> <?= e(date('d/m/Y H:i', strtotime($order['sent_at']))) ?><?php endif; ?></p>
<table class="table table-bordered"><thead><tr><th data-print-weight="55">Article</th><th data-print-weight="25">Item</th><th data-print-weight="20" class="text-right">Quantité demandée</th></tr></thead><tbody>
<?php foreach ($lines as $line): ?><tr><td><?= e($line['nom_article']) ?></td><td><?= e($line['item']) ?></td><td class="text-right"><?= (int)$line['quantite'] ?></td></tr><?php endforeach; ?>
<?php if (!$lines): ?><tr><td colspan="3" class="text-center">Aucun article demandé.</td></tr><?php endif; ?>
</tbody></table><p><strong>Demandeur :</strong> <?= e($order['demandeur']) ?></p></main>
<?php if (!$print) require __DIR__ . '/../layout/footer.php'; else echo '</body></html>'; ?>
