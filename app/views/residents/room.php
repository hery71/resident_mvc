<?php $title = 'Chambres des résidents'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">

    <div class="card-modern">

        <div class="card-header-pastel">
            <?= $title ?>
        </div>

        <div class="card-body">

            <form method="post" action="/resident/update_rooms">

                <table class="table table-sm table-hover">

                    <thead>
                        <tr>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th style="width:250px;">Chambre</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($residents as $r): ?>

                        <tr>

                            <td>
                                <?= e($r['Prenom']) ?>
                            </td>

                            <td>
                                <?= e($r['Nom']) ?>
                            </td>

                            <td>
                                <input type="text"
                                       name="chambres[<?= (int)$r['id'] ?>]"
                                       value="<?= e($r['Chambre'] ?? '') ?>"
                                       class="form-control form-control-sm"
                                       style="width:100px;">
                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

                <div class="text-right mt-3">
                    <button type="submit"
                            class="btn btn-primary">
                        💾 Enregistrer
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>