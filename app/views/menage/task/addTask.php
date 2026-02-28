<?php $title = 'Ajouter Taches'; 
    $inspection=  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
?>
<?php require __DIR__ . '/../../layout/header.php'; ?>
<div class="container mt-4">
<div class="card-modern">
    <div class="card-header-pastel"><?= $title ?></div>
    <div class="card-body">
<hr>
<p><strong>Nom :</strong> <?= e($inspectionDetail['nom']) ."(" .$id_inspection  . ")"?></p>
<p><strong>Date :</strong> <?= e($inspectionDetail['date']) ?></p>
<p><strong>Staff :</strong> <?= e($inspectionDetail['staff']) ?></p>
<p><strong>Type d’inspection :</strong> <?= e($inspectionDetail['type']) ?></p>
<p><strong>Observation générale :</strong><br>
    <?= e($inspectionDetail['observation']) ?>
</p>
<h2>Liste des taches</h2>
<form method="POST" action="/task/saveTask">
    <input type="hidden" name="date" value="<?= e($inspectionDetail['date']) ?>">
    <input type="hidden" name="id_inspection" value="<?= e($inspectionDetail['id']) ?>">
    <input type="hidden" name="annee" value="<?= e($annee) ?>">
    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Sélection de l'aile -->
            <select id="aile" class="form-control" name="aile" required>
                <option value="">-- Choisir une aile --</option>
                <?php foreach (Config::inspection()['aile'] as $a): ?>
                    <option value="<?= e($a) ?>"><?= e($a) ?></option>
                <?php endforeach; ?>
            </select>
            <!-- Sélection chambre ou piece-->
            <select id="room" class="form-control mt-2" name="room" required>
                <option value="">-- Choisir une chambre --</option>
            </select>
        </div>
        <div class="card-body">
            <!-- Sélection type d'inspection -->
            <select id="typeInspection" class="form-control mt-2" name="typeInspection" required>
                <option value="">-- Type inspection --</option>
                <?php foreach (Config::inspection()['TypeInspection'] as $t): ?>
                    <option value="<?= e($t) ?>"><?= e($t) ?></option>
                <?php endforeach; ?>
            </select>
            <!-- Sélection tache -->
            <select id="task" class="form-control mt-2" name="task" required>
                <option value="">-- Choisir une tâche --</option>
            </select>
        </div>
        <input type="text" name="observation" class="form-control mt-2" placeholder="Observation" required>
        <button type="submit" class="btn btn-primary mt-2">Ajouter Tâche</button>
        <?php
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
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $r): ?>
                                    <tr>
                                        <td><?= e($r['task']) ?></td>
                                        <td><?= $r['value'] == '1' ? '✔️' : '❌' ?></td>
                                        <td><?= e($r['observation']) ?></td>
                                        <td>
                                            <form method="POST" action="/task/deleteTask" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?');">
                                                <input type="hidden" name="id_task" value="<?= e($r['id']) ?>">
                                                <input type="hidden" name="id_inspection" value="<?= e($inspectionDetail['id']) ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                            </form>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </form>
    </div>
    </div></div> <!-- container -->
<script>
document.getElementById('aile').addEventListener('change', function () {
    fetch('/ajax/getRooms.php?aile=' + this.value)
        .then(res => res.json())
        .then(data => {
            const room = document.getElementById('room');
            room.innerHTML = '<option value="">-- Choisir une chambre --</option>';
            data.forEach(r => {
                room.innerHTML += `<option value="${r}">${r}</option>`;
            });
        });
});
document.getElementById('typeInspection').addEventListener('change', function () {
    fetch('/ajax/getTasks.php?type=' + this.value)
        .then(res => res.json())
        .then(data => {
            const task = document.getElementById('task');
            task.innerHTML = '<option value="">-- Choisir une tâche --</option>';
            data.forEach(t => {
                task.innerHTML += `<option value="${t}">${t}</option>`;
            });
        });
});
</script>


<?php require __DIR__ . '/../../layout/footer.php'; ?>