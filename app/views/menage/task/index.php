<?php $title = 'Taches'; 
    $inspection =  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-4">
<h3>Taches </h3>


</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>