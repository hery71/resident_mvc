<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>IMPRESSION LISTE FETE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://resident_mvc.test/assets/css/style.css">
<?php require __DIR__ . '/../layout/printStyleScript.php'; ?>
</head>
<body>
<div class="container mt-4" id="printable-area">
<style id="orientation-style"></style>
<?php include __DIR__ . '/../layout/printSizeOption.php'; ?>
<div id="printable-area">
<h3>Liste des Fêtes de – <?= e($moisLabel[$mois]) ?> <?= e($annee) ?></h3>
    <table class="table table-bordered table-sm table-hover">
        <thead >
            <tr>
                <th style="width:50px;">N</th>
                <th>Motif</th>
                <th>Résident</th>
                <th>Date</th>
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
                <td class="text-center maxw-50"><?= $n ?></td>
                <td class="text-center"><?= e($a['motif']) ?></td>
                <td><?= e($a['Nom'])? e($a['Nom']):'--NO '; ?> <?= e($a['Prenom'])? e($a['Prenom']):'RESIDENT--' ?></td>
                <td class="text-center"><?= e($a['date']) ?></td>  
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div> <!-- container -->


    <footer class="bg-light text-center mt-5 py-3">
        <small class="text-muted">
            © 2026 – Resident MVC
        </small>
    </footer>
</body>
    </html>

