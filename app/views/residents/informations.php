<?php $title = 'Informations du résident';
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
            <h3> Informations du résident</h3>
            <table class="table table-sm table-bordered">
            <tr><th>Gender</th><td><?= e($resident['Gender']) ?></td></tr>
            <tr><th>Prénom</th><td><?= e($resident['Prenom']) ?></td></tr>
            <tr><th>Nom</th><td><?= e($resident['Nom']) ?></td></tr>
            <tr><th>Chambre</th><td><?= e($resident['Chambre']) ?></td></tr>
            <tr><th>Tel1</th><td><?= e($resident['Tel1']) ?></td></tr>
            <tr><th>Tel2</th><td><?= e($resident['Tel2'] ?? '') ?></td></tr>
            <tr><th>Tel3</th><td><?= e($resident['Tel3'] ?? '') ?></td></tr>
            <tr><th>Famille</th><td><?= e($resident['Famille'] ?? '') ?></td></tr>
            <tr><th>Date anniversaire</th><td><?= e($resident['Anniversaire'] ?? '') ?></td></tr>
            <tr><th>Admission</th><td><?= e($resident['Admission'] ?? '') ?></td></tr>
            <tr><th>Lieu repas</th><td><?= e($resident['Lieu_repas'] ?? '') ?></td></tr>
            </table>
            
            <a href="/resident" class="btn btn-secondary mt-3">⬅️ Retour à la liste</a>  

    
<!---------------------FIN DIV PRINCIPAL--------------------->
        </div><!---------------------FIN CARD-BODY--------------------->
    </div><!---------------------FIN CARD-MODERN--------------------->
</div> <!---------------------FIN CONTAINER--------------------->
<?php require __DIR__ . '/../layout/footer.php'; ?>