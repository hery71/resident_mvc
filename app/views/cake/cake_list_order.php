<?php $title = 'Liste commande Gateau'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-4">
    <div class="card-modern">
    <div class="card-header-pastel"><?= $title ?> — <?= e($moisLabel[$mois]) ?> <?= e($annee) ?></div>
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
        <div id="printable-area">
            <h3>Commande de gateaux - <?= e($moisLabel[$mois]) ?> <?= e($annee) ?></h3>
        <!-- TABLEAU -->
            <table class="table table-bordered table-sm table-hover">
                <thead >
                    <tr>
                        <th>N</th>
                        <th>Résident</th>
                        <th>Pick Up Date</th>
                    </tr>
                </thead>
                <tbody>

                <?php 
                $n= 0;    
                if (empty($cake)): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Aucun Pick up ce mois-ci
                        </td>
                    </tr>
                <?php endif; ?>
                <?php 
                foreach ($cake as $a):
                $n++;
                ?>
                    <tr>
                        <td class="text-center"><?= $n ?></td>
                        <td><?= htmlspecialchars($a['Nom']) ?> <?= htmlspecialchars($a['Prenom']) ?></td>
                        <td><?= htmlspecialchars($a['dateLivraison']) ?></td>          
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="no-print mt-3 d-flex gap-2">
            <button class="btn btn-secondary" onclick="window.location.href='/'">
                Retour accueil
                </button>
                <button onclick="window.print()" class="btn btn-info">
                Imprimer le tableau
                </button>
                <button class="btn btn-outline-secondary btn-sm" onclick="setFontSize('s')">S</button>
                <button class="btn btn-outline-secondary btn-sm" onclick="setFontSize('m')">M</button>
                <button class="btn btn-outline-secondary btn-sm" onclick="setFontSize('l')">L</button>
                <button class="btn btn-outline-secondary btn-sm" onclick="setFontSize('xl')">XL</button>
                <button class="btn btn-outline-secondary btn-sm" onclick="setFontSize('tg')">TG</button>
            </div>
</div> <!-- container -->
<?php require __DIR__ . '/../layout/footer.php'; ?>
