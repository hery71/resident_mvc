<?php $title = $id ? 'Modifier la commande' : 'Demande de commande';
$custom_js = <<<'JS'
const orderForm = document.getElementById('inventoryOrderForm');
if (orderForm) {
    let changed = false;
    orderForm.addEventListener('input', () => { changed = true; });
    window.addEventListener('beforeunload', event => { if (changed) { event.preventDefault(); event.returnValue = ''; } });
    orderForm.addEventListener('submit', event => {
        if (event.submitter && event.submitter.value === 'send') {
            const requester = document.getElementById('orderRequester');
            if (!requester.value.trim()) { event.preventDefault(); requester.setCustomValidity('Indiquez votre nom avant l’envoi.'); requester.reportValidity(); return; }
            const positive = [...orderForm.querySelectorAll('[data-order-quantity]')].some(input => Number(input.value) > 0);
            if (!positive) { event.preventDefault(); alert('Indiquez au moins une quantité supérieure à zéro.'); return; }
            if (!confirm('Envoyer cette commande ? Elle ne pourra plus être modifiée.')) { event.preventDefault(); return; }
        }
        changed = false;
    });
    document.getElementById('orderRequester').addEventListener('input', function () { this.setCustomValidity(''); });
}
JS;
require __DIR__ . '/../layout/header.php'; ?>
<main class="container-fluid mt-4"><div class="card-modern"><div class="card-header-pastel"><?= e($title) ?></div><div class="card-body">
<a href="/inventaireCommandes/index" class="btn btn-outline-secondary mb-3">Liste des commandes</a>
<?php if ($error !== ''): ?><div class="alert alert-danger" role="alert"><?= e($error) ?></div><?php endif; ?>
<?php if (!$id): ?>
<form method="get" action="/inventaireCommandes/form" class="mb-4"><label for="orderDepartment">Département</label>
<select id="orderDepartment" name="departement" class="form-control" required onchange="this.form.submit()"><option value="">Choisir un département</option>
<?php foreach ($departments as $dept): ?><option value="<?= (int)$dept['id'] ?>" <?= $department === (int)$dept['id'] ? 'selected' : '' ?>><?= e($dept['departement']) ?></option><?php endforeach; ?></select><noscript><button class="btn btn-secondary mt-2">Afficher les articles</button></noscript></form>
<?php else: ?><p><strong>Département :</strong> <?= e($order['departement_nom']) ?></p><?php endif; ?>
<?php if ($department): ?>
<form id="inventoryOrderForm" method="post" action="/inventaireCommandes/form<?= $id ? '?id=' . $id : '' ?>">
<input type="hidden" name="token" value="<?= e($token) ?>"><input type="hidden" name="departement" value="<?= $department ?>"><input type="hidden" name="version" value="<?= $version ?>">
<p>Indiquez les quantités souhaitées. Laissez 0 pour les articles à ne pas commander.</p>
<div class="table-responsive"><table class="table table-bordered"><thead><tr><th>Article</th><th>Item</th><th style="width:220px">Quantité demandée</th></tr></thead><tbody>
<?php foreach ($articles as $article): $value = $quantities[(int)$article['id']] ?? '0'; ?>
<tr><td><label for="orderQty<?= (int)$article['id'] ?>" class="mb-0"><?= e($article['nom']) ?></label></td><td><?= e($article['item']) ?></td><td><input data-order-quantity type="number" class="form-control" id="orderQty<?= (int)$article['id'] ?>" name="quantites[<?= (int)$article['id'] ?>]" min="0" max="2147483647" step="1" required value="<?= e(is_string($value) ? $value : '0') ?>"></td></tr>
<?php endforeach; ?>
<?php if (!$articles): ?><tr><td colspan="3" class="text-muted text-center">Aucun article actif dans ce département.</td></tr><?php endif; ?>
</tbody></table></div>
<?php if ($inactiveLines): ?><div class="alert alert-warning">Ces articles ne sont plus actifs. Leurs anciennes quantités seront retirées au prochain enregistrement : <?php foreach ($inactiveLines as $line): ?><?= e($line['nom_article']) ?> (<?= (int)$line['quantite'] ?>). <?php endforeach; ?></div><?php endif; ?>
<div class="form-group"><label for="orderName">Nom de la commande *</label><input id="orderName" name="nom" class="form-control" maxlength="200" required value="<?= e($name) ?>" placeholder="Ex. : Commande entretien — novembre"></div>
<div class="form-group"><label for="orderRequester">Nom du demandeur (obligatoire pour envoyer)</label><input id="orderRequester" name="demandeur" class="form-control" maxlength="200" value="<?= e($requester) ?>"></div>
<p class="text-muted">Enregistrer conserve un brouillon modifiable. Envoyer rend la commande définitive et la signale sur le dashboard.</p>
<button type="submit" name="action" value="save" class="btn btn-secondary">Enregistrer</button>
<button type="submit" name="action" value="send" class="btn btn-primary">Envoyer la commande</button>
</form><?php endif; ?>
</div></div></main><?php require __DIR__ . '/../layout/footer.php'; ?>
