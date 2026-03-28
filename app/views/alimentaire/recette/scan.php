<?php 
$title = 'Scan des sections recettes';

// 🔹 même logique que ton controller
$dir = __DIR__ . '/../../../../storage/data/recepies/france/';

$sections = [];

$fichiers = glob($dir . '*.json');

foreach ($fichiers as $fichier) {

    $data = json_decode(file_get_contents($fichier), true);

    if (!is_array($data)) continue;

    foreach ($data as $key => $value) {

        if (in_array($key, [
            'titre','type','pax','page','fiche','bandeau','technique_de_realisation'
        ])) continue;

        if (is_array($value)) {
            $sections[$key] = true;
        }
    }
}

$sections = array_keys($sections);
sort($sections);

require __DIR__ . '/../../layout/header.php'; 
?>

<div class="container mt-4">
<div class="card-modern">
<div class="card-header-pastel"><?= $title ?></div>
<div class="card-body">

<h5>Sections détectées</h5>

<?php if (empty($sections)): ?>
    <div class="alert alert-danger">
        Aucune section trouvée<br>
        Chemin utilisé : <?= $dir ?>
    </div>
<?php else: ?>

<textarea id="result" class="form-control" rows="12">
<?php foreach ($sections as $s): ?>
<?= $s . "\n" ?>
<?php endforeach; ?>
</textarea>

<button class="btn btn-primary mt-2" onclick="copyText()">Copier</button>

<?php endif; ?>

</div>
</div>
</div>

<script>
function copyText() {
    let text = document.getElementById('result');
    text.select();
    document.execCommand('copy');
    alert('Copié');
}
</script>

<?php require __DIR__ . '/../../layout/footer.php'; ?>