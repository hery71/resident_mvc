<?php $title = 'Liste Fêtes du mois'; 
    $inspection =  Config::inspection(); 
?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-4">
<div class="card-modern">
    <div class="card-header-pastel"><?= $title ?></div>
    <div class="card-body">
<form method="POST" action="/menage/save">
        <input type="hidden" name="annee" value="<?= $annee ?>">
        <div class="card shadow-sm">
            <div class="card-body">

                <!-- Type inspection -->
                <div class="form-group">
                    <label>Type d’inspection :</label>
                    <select name="type_inspection" class="form-control" required>
                        <option value="">-- Sélectionner --</option>
                        <?php foreach ($inspection['TypeInspection'] as $r): ?>
                            <option value="<?= htmlspecialchars($r) ?>">
                                <?= htmlspecialchars($r) ?>
                            </option>
                        <?php endforeach; ?>
        </select>
                    </select>
                </div>

                <!-- Nom inspection -->
                <div class="form-group">
                    <label>Nom de l’inspection :</label>
                    <input type="text" name="nom" class="form-control" required
                           placeholder="Ex: Inspection Aile B – Matin">
                </div>

                <!-- Date -->
                <div class="form-group">
                    <label>Date :</label>
                    <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <!-- Staff responsable -->
                <div class="form-group">
                    <label>Staff responsable :</label>
                    <select name="id_staff" class="form-control" required>
                        <option value="">-- Sélectionner un employé --</option>
                        <?php foreach ($staffs as $s): ?>
                            <option value="<?= $s['id'] ?>">
                                <?= htmlspecialchars($s['nom'] . " " . $s['prenom']) ?>
                                (<?= htmlspecialchars($s['sous_departement'] ?? '') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Observation -->
                <div class="form-group">
                    <label>Observation :</label>
                    <textarea name="observation" class="form-control" rows="3"
                              placeholder="Notes générales..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Créer l’inspection</button>
                <a href="inspection_list.php" class="btn btn-secondary">Annuler</a>

            </div>
        </div>
    </form>
</div>
</div>
</div> <!-- container -->
<?php require __DIR__ . '/../layout/footer.php'; ?>