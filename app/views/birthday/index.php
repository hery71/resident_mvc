<?php
$title = 'Anniversaires du mois';
$previousMonth = (int)$mois === 1 ? 12 : (int)$mois - 1;
$previousYear = (int)$mois === 1 ? (int)$annee - 1 : (int)$annee;
$nextMonth = (int)$mois === 12 ? 1 : (int)$mois + 1;
$nextYear = (int)$mois === 12 ? (int)$annee + 1 : (int)$annee;
$previousUrl = '/birthday?' . http_build_query(['mois' => $previousMonth, 'annee' => $previousYear]);
$nextUrl = '/birthday?' . http_build_query(['mois' => $nextMonth, 'annee' => $nextYear]);
?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-4">
    <div class="card-modern">
    <div class="card-header-pastel"><?= $title ?> — <?= e($moisLabel[$mois]) ?> <?= e($annee) ?></div>
    <div class="card-body">

    <!-- FILTRES -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <a href="<?= e($previousUrl) ?>" class="btn btn-outline-primary mr-2" aria-label="Mois précédent" title="Mois précédent">&lt;</a>
    <form method="get" class="form-inline justify-content-center flex-wrap mx-2">
        <label class="mr-2 font-weight-bold">Mois</label>
        <select name="mois" class="form-control mr-3">
            <?php foreach ($moisLabel as $num => $label): ?>
                <option value="<?= $num ?>" <?= $num === $mois ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label class="mr-2 font-weight-bold">Année</label>
        <input type="number" name="annee"
               value="<?= $annee ?>"
               class="form-control mr-3"
               style="width:100px">

        <button class="btn btn-primary">
            Afficher
        </button>
    </form>
        <a href="<?= e($nextUrl) ?>" class="btn btn-outline-primary ml-2" aria-label="Mois suivant" title="Mois suivant">&gt;</a>
    </div>

    <!-- TABLEAU -->
    <table class="table table-bordered table-sm table-hover">
        <thead >
            <tr>
                <th>Jour</th>
                <th>Résident</th>
                <th>Date de naissance</th>
                <th>Date Fete</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

        <?php if (empty($anniversaires)): ?>
            <tr>
                <td colspan="5" class="text-center text-muted">
                    Aucun anniversaire ce mois-ci
                </td>
            </tr>
        <?php endif; ?>
        <?php foreach ($anniversaires as $a): ?>
            <tr>
                <td class="text-center"><?= $a['jour'] ?></td>
                <td><?= e($a['Nom']) ?> <?= e($a['Prenom']) ?></td>
                <td><?= e($a['date_naissance']) ?></td>
                <td>
                    <?= !empty($a['date_fete']) ? e($a['date_fete']) : '—' ?>
                </td>
                <td class="text-left">
                    <?php if ($a['fete_id']): ?>
                        <a href="/birthday/edit?idBirthday=<?= $a['fete_id'] ."&jour=" .$a['jour'] ."&mois=" .$mois ."&annee=" .$annee ?>"
                            class="btn btn-sm btn-info">
                            Voir/ Editer</a>
                         <a href="/birthday/printRequisition/<?= (int)$a['fete_id'] ?>" 
                            class="btn btn-sm btn-outline-danger" target="_blank">
                            Requisition</a>
                        <form method="post" action="/birthday/delete" class="d-inline">
                            <input type="hidden" name="token" value="<?= e($token) ?>">
                            <input type="hidden" name="id" value="<?= (int)$a['fete_id'] ?>">
                            <input type="hidden" name="mois" value="<?= (int)$mois ?>">
                            <input type="hidden" name="annee" value="<?= (int)$annee ?>">
                            <button type="submit" class="btn btn-sm" style="background-color: #f49a38; border-color: #f49a38; color: #212529;">Supprimer</button>
                        </form>
                    <?php else: ?>
                        <a href="/birthday/create?
                            id_resident=<?= $a['id'] ?>
                            &annee=<?= $annee ?>
                            &mois=<?= $mois ?>
                            &jour=<?= $a['jour'] ?>"
                        class="btn btn-sm btn-primary">
                            ➕ Ajouter anniversaire
                            </a>
                            <?php endif; ?>
                    <!-- si anniversaire enabled == 1 donc il y a un anniversaire enregistré -->
                    <?php if ($a['enabled'] == 1): ?>
                        <?php if ($a['cake_id']): ?>
                            <a href="/cake/edit/<?= $a['cake_id'] ?>"
                            class="btn btn-sm btn-info">Modifier commande cake</a>
                            <a href="/cake/cakeOrderPdf/<?= $a['cake_id'] ?>"
                             target="_blank"
                            class="btn btn-sm btn-info">Cake order</a>
                        <?php else: ?>    
                            <a href="/cake/create/<?= $a['id'] ?>/<?= e($a['annee']) ?>/<?= $a['fete_id'] ?>"
                            class="btn btn-sm btn-warning">Commander gâteau</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="text-muted">—</span>
                    <?php endif; ?>
                </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a href="/" class="btn btn-secondary">
        ⬅ Retour accueil
    </a>
    </div>
    </div>
</div> <!-- container -->
<?php require __DIR__ . '/../layout/footer.php'; ?>
