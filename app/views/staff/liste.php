<?php $title = 'Liste des staffs'; 
    $custom_js = <<<'JS'
    // Custom JavaScript can be added here
    JS;
    $custom_style = <<<'CSS'
    /* Custom CSS can be added here */
    CSS;
?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-4">
    <div class="card-modern">
        <div class="card-header-pastel"><?= $title ?></div>
        <div class="card-body">
            <h3> Sous titre</h3>
            <table class="table table-striped table-hover table-sm">

            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Genre</th>
                    <th>Service</th>
                    <th>Département</th>
                    <th>Poste</th>
                    <th>status</th>
                    <th>Téléphone</th>
                    <th>Ville</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

            <?php if (!empty($staffs)): ?>

                <?php foreach ($staffs as $staff): ?>

                <tr>

                    <td><?= e($staff['nom']) ?> <?= e($staff['middle_name']) ?> <?= e($staff['prenom']) ?></td>
                    <td><?= e($staff['gender']) ?></td>
                    
                    <td><?= e($staff['service']) ?></td>
                    <td><?= e($staff['departement']) ?></td>

                    <td><?= e($staff['poste']) ?></td>
                    <td><?= e($staff['status']) ?></td>

                    <td><?= e($staff['tel1']) ?></td>

                    <td><?= e($staff['ville']) ?></td>

                    <td>
                        <a href="<?= BASE_URL ?>/staff/edit?id=<?= $staff['id'] ?>"
                        class="btn btn-sm btn-primary">Edit</a>

                        <a href="<?= BASE_URL ?>/staff/disable?id=<?= $staff['id'] ?>"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Disable this staff?')">Disable</a>
                    </td>
                </tr>
                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="11" class="text-center text-muted">
                        Aucun staff trouvé
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>

        </table>


    
<!---------------------FIN DIV PRINCIPAL--------------------->
        </div><!---------------------FIN CARD-BODY--------------------->
    </div><!---------------------FIN CARD-MODERN--------------------->
</div> <!---------------------FIN CONTAINER--------------------->
<?php require __DIR__ . '/../layout/footer.php'; ?>