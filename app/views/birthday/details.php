<?php $title = 'Détails Anniversaire'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-4">

    <h3>🎂 Détails de l’anniversaire</h3>

    <table class="table table-bordered table-sm">
        <tr>
            <th>Résident</th>
            <td><?= e($birthday['Nom']) ?>
                <?= e($birthday['Prenom']) ?></td>
        </tr>
        <tr>
            <th>Date fêtée</th>
            <td><?= e($birthday['date']) ?></td>
        </tr>
        <tr>
            <th>Heure</th>
            <td><?= e($birthday['heure']) ?></td>
        </tr>
        <tr>
            <th>Motif</th>
            <td><?= e($birthday['motif']) ?></td>
        </tr>
        <tr>
            <th>Pax</th>
            <td><?= (int)$birthday['pax'] ?></td>
        </tr>
        <tr>
            <th>Lieux</th>
            <td><?= e($birthday['lieux']) ?></td>
        </tr>
        <tr>
            <th>Commentaires</th>
            <td><?= e($birthday['commentaires']) ?></td>
        </tr>
    </table>
    <a href="/editBirthday?id=<?= $birthday['id'] ?>"
        class="btn btn-warning">
        ✏️ Modifier anniversaire
    </a>
    <form method="post"
        action="/birthday/delete"
         onsubmit="return confirm('Confirmer la suppression de cet anniversaire ?');"
        style="display:inline-block">
        <input type="hidden" name="id" value="<?= e($birthday['id']) ?>">
        <button class="btn btn-danger">
            🗑 Supprimer anniversaire
        </button>
    </form>

    <a href="/birthday?mois=<?= e($birthday['mois']) ?>&annee=<?= e($birthday['annee']) ?>"
       class="btn btn-secondary">
        ⬅ Retour à la liste
    </a>
</div> <!-- container -->
<?php require __DIR__ . '/../layout/footer.php'; ?>
