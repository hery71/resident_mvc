<?php $title = 'Liste des commandes'; require __DIR__ . '/../layout/header.php'; ?>
<main class="container-fluid mt-4"><div class="card-modern"><div class="card-header-pastel">Liste des commandes</div><div class="card-body">
<?php if ($message !== ''): ?><div class="alert alert-success" role="status"><?= e($message) ?></div><?php endif; ?>
<a href="/inventaireCommandes/form" class="btn btn-primary mb-3">Nouvelle demande de commande</a>
<div class="table-responsive"><table class="table table-bordered table-hover">
<thead><tr><th>Nom de la commande</th><th>Département</th><th>Demandeur</th><th>Dernier enregistrement</th><th>Statut</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($orders as $order): $draft = $order['statut'] === 'brouillon'; ?>
<tr><td><a href="/inventaireCommandes/<?= $draft ? 'form' : 'view' ?>?id=<?= (int)$order['id'] ?>"><?= e($order['nom']) ?></a></td>
<td><?= e($order['departement_nom']) ?></td><td><?= e($order['demandeur']) ?></td><td><?= e(date('d/m/Y H:i', strtotime($order['updated_at']))) ?></td>
<td><span class="badge badge-<?= $draft ? 'secondary' : 'success' ?>"><?= $draft ? 'Brouillon' : 'Envoyée' ?></span></td>
<td><a class="btn btn-outline-primary btn-sm" href="/inventaireCommandes/<?= $draft ? 'form' : 'view' ?>?id=<?= (int)$order['id'] ?>"><?= $draft ? 'Modifier' : 'Consulter' ?></a> <a class="btn btn-outline-secondary btn-sm" href="/inventaireCommandes/print?id=<?= (int)$order['id'] ?>" target="_blank" rel="noopener">Imprimer</a></td></tr>
<?php endforeach; ?>
<?php if (!$orders): ?><tr><td colspan="6" class="text-center text-muted">Aucune commande enregistrée.</td></tr><?php endif; ?>
</tbody></table></div></div></div></main>
<?php require __DIR__ . '/../layout/footer.php'; ?>
