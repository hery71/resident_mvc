<?php $title = 'Liste Fêtes du mois'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-4">
    <div class="card-modern">
    <div class="card-header-pastel"><?= $title ?></div>
    <div class="card-body">

    <!-- FILTRES -->
    <form method="get" class="form-inline mb-4">
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
    <!-- TABLEAU -->
    <div id="printable-area">
        <h3>Liste des Fêtes de – <?= e($moisLabel[$mois]) ?> <?= e($annee) ?></h3>
        <a href="/fete/create" class="btn btn-secondary no-print">
           Créer fête
        </a>
        <button type="button"
                onclick="window.open('/fete/printListFete?mois=<?= (int)$mois ?>&annee=<?= (int)$annee ?>', '_blank')"
                class="btn btn-info no-print">
            Imprimer programme
        </button>
        <button type="button"
                onclick="window.open('/fete/printListFete?mois=<?= (int)$mois ?>&annee=<?= (int)$annee ?>', '_blank')"
                class="btn btn-info no-print">
            Imprimer le tableau
        </button>
            <table class="table table-bordered table-sm table-hover">
                <thead >
                    <tr>
                        <th>N</th>
                        <th>Motif</th>
                        <th>Résident</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $n= 0;    
                if (empty($fete)): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Aucune Fete ce mois-ci
                        </td>
                    </tr>
                <?php endif; ?>
                <?php 
                foreach ($fete as $a):
                $n++;
                ?>
                    <tr>
                        <td class="text-center"><?= $n ?></td>
                        <td><?= e($a['motif']) ?></td>
                        <td><?= e($a['Nom'])? e($a['Nom']):'--NO '; ?> <?= e($a['Prenom'])? e($a['Prenom']):'RESIDENT--' ?></td>
                        <td><?= e($a['date']) ?></td>  
                        <td><?= e($a['heure'] ?? '') ?></td>
                        <td>
                            <a href="/birthday/printRequisition/<?= (int)$a['id'] ?>" 
                            class="btn btn-sm btn-outline-danger" target="_blank">
                            Requisition</a>
                            <a href="/fete/edit?id_fete=<?=  $a['id'] ?>&param=<?= $annee .$mois ?>" class="btn btn-sm btn-info">
                            Modifier
                            </a>
                             <a href="/fete/delete?id_fete=<?= e($a['id']) ."&mois=" .$mois ."&annee=" .$annee ?>" class="btn btn-sm btn-info"  onclick="return confirm('Confirmer la suppression ?');">
                            Supprimer
                            </a>
                        </td>           
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="no-print mt-3 d-flex gap-2">
            <button class="btn btn-secondary" onclick="window.location.href='/'">
                Retour accueil
                </button>
            </div>
    </div>
</div>
</div> <!-- container -->
<?php require __DIR__ . '/../layout/footer.php'; ?>
