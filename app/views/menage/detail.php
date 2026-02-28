<?php $title = 'Detail Inspection'; 
    //$inspection =  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-4">
<div class="card-modern">
    <div class="card-header-pastel"><?= $title ?></div>
    <div class="card-body">
<a href="/task/addTask?id=<?= $id_inspection  .'&type=' .$inspection['type'] ?>" class="btn btn-primary mb-3">
    Ajouter des tâches
</a>

<hr>
<p><strong>Nom :</strong> <?= e($inspection['nom']) ?></p>
<p><strong>Date :</strong> <?= e($inspection['date']) ?></p>
<p><strong>Staff :</strong> <?= e($inspection['staff']) ?></p>
<p><strong>Type d’inspection :</strong> <?= e($inspection['type']) ?></p>
<p><strong>Observation générale :</strong><br>
    <?= e($inspection['observation']) ?>
</p>
<hr>
<h4>Résultat par chambre</h4>
<?php
// Groupement par room
$grouped = [];
foreach ($taskS as $t) {
     $grouped[$t['aile']][$t['room']][] = $t;
}
?>
<?php foreach ($grouped as $aile => $rooms): ?>
    <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            Aile <?= e($aile) ?>
        </div>
        <div class="card-body">
            <?php foreach ($rooms as $room => $rows): ?>
                <h6 class="mt-3">Chambre <?= e($room) ?></h6>

                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Tâche</th>
                            <th>Valeur</th>
                            <th>Observation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $r): ?>
                            <tr>
                                <td><?= e($r['task']) ?></td>
                                <td><?= $r['value'] == '1' ? '✔️' : '❌' ?></td>
                                <td><?= e($r['observation']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>
<a href="/menage/index?annee=<?= $annee ?>" class="btn btn-secondary">Retour</a>
</div>
</div>
</div> <!-- container -->
<?php require __DIR__ . '/../layout/footer.php'; ?>