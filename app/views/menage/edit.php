<?php $title = 'Editer Inspection'; 
    $inspection =  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-4">
    <div class="card-modern">
    <div class="card-header-pastel"><?= $title ?></div>
    <div class="card-body">
<h3>Editer Inspection </h3>


</div>
</div>
</div> <!-- container -->
<?php require __DIR__ . '/../layout/footer.php'; ?>