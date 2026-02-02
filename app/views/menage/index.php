<?php $title = 'Liste Inspection'; 
    $inspection =  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-4">
<h3>Liste Inspection </h3>
 <!-- Sélecteur d'année -->
    <form method="GET" class="form-inline mb-3">
        <label class="mr-2">Année :</label>
        <select name="annee" class="form-control mr-3" onchange="this.form.submit()">
            <?php for ($y = 2023; $y <= 2030; $y++): ?>
                <option value="<?= $y ?>" <?= ($y == $annee ? 'selected' : '') ?>>
                    <?= $y ?>
                </option>
            <?php endfor; ?>
        </select>

        <a href="/menage/create?annee=<?= $annee ?>" class="btn btn-success">
            ➕ Créer une inspection
        </a>
    </form>

    <!-- Tableau des inspections -->
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Nom</th>
                <th>Staff</th>
                <th>Observation</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($inspections) == 0): ?>
                <tr><td colspan="4" class="text-center"><em>Aucune inspection trouvée</em></td></tr>
            <?php endif; ?>

            <?php foreach ($inspections as $i): ?>
                <tr style="cursor:pointer;"
                    onclick="window.location='/menage/detail?param=<?= $i['id'] .$annee ?>'">
                    <td><strong><?= htmlspecialchars($i['date']) ?></strong></td>
                    <td><?= htmlspecialchars($i['type']) ?></td>
                    <td><?= htmlspecialchars($i['nom']) ?></td>
                    <td><?= htmlspecialchars($i['staff']) ?></td>
                    <td><?= htmlspecialchars($i['observation']) ?></td>
                    <td>
                        </a>
                         <a href="/menage/edit?param=<?= $i['id'] .$annee ?>" class="btn btn-sm btn-info" >
                            Modifier
                            </a>
                             <a href="/menage/delete?param=<?= $i['id'] .$annee ?>" class="btn btn-sm btn-info"  onclick="return confirm('Confirmer la suppression ?');">
                            Supprimer
                            </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>