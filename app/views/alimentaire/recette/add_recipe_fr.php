<?php 
$title = 'Ajouter recette'; 

$options = require __DIR__ . '/../../../config/options.php';

$custom_style = <<<'CSS'
.table td, .table th {
    vertical-align: middle;
}
textarea.form-control {
    resize: vertical;
}
.section-block {
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 15px;
    background: #f8f9fa;
}
.section-title {
    font-weight: 600;
    margin-bottom: 10px;
}
CSS;
$Sections = $options['Sections'] ?? [];
sort($Sections);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $type = $_POST['type'] ?? 'general';
    $titre = trim($_POST['titre'] ?? '');

    if ($titre !== '') {

        $data = [
            'titre' => $titre,
            'type' => $_POST['type_recette'] ?? ''
        ];

        // 🔹 GENERAL
        if ($type === 'general') {


            $data['pax'] = $_POST['pax'] ?? '';

            $sectionsSelect = $_POST['section_select'] ?? [];
            $sectionsInput  = $_POST['section_input'] ?? [];
            $noms = $_POST['nom'] ?? [];
            $unites = $_POST['unite'] ?? [];
            $quantites = $_POST['quantite'] ?? [];

            foreach ($sectionsSelect as $index => $sectionName) {

                if (!empty($sectionName) && $sectionName !== 'custom') {
                    $finalSection = $sectionName;
                } else {
                    $finalSection = trim($sectionsInput[$index] ?? '');
                }

                if ($finalSection === '') continue;

                $data[$finalSection] = [];

                if (!isset($noms[$index])) continue;

                foreach ($noms[$index] as $i => $nom) {

                    $nom = trim($nom);
                    if ($nom === '') continue;

                    $item = ['nom' => $nom];

                    if (!empty($unites[$index][$i])) {
                        $item['unite'] = trim($unites[$index][$i]);
                    }

                    if (!empty($quantites[$index][$i])) {
                        $item['quantite'] = trim($quantites[$index][$i]);
                    }

                    $data[$finalSection][] = $item;
                }
            }

            $data['technique_de_realisation'] = array_filter($_POST['technique'] ?? []);
        }

        // 🔹 BEURRE
        if ($type === 'beurre') {
            $data['genre'] = $_POST['genre'] ?? '';
            $data['ingredients'] = array_filter($_POST['ingredients'] ?? []);
            $data['technique_de_realisation'] = array_filter($_POST['technique'] ?? []);
            $data['utilisation'] = array_filter($_POST['utilisation'] ?? []);
        }

        // 🔹 MARINADE
        if ($type === 'marinade') {
            $data['base'] = $_POST['base'] ?? '';
            $data['type_de_viande'] = $_POST['type_viande'] ?? '';
            $data['ingredients'] = array_filter($_POST['ingredients'] ?? []);
            $data['technique_de_realisation'] = array_filter($_POST['technique'] ?? []);
        }

        $filename = strtolower(str_replace(' ', '_', $titre)) . '.json';
        $path = __DIR__ . '/../../../storage/data/recipies/france/' . $filename;

        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

require __DIR__ . '/../../layout/header.php'; 
if(isset($error)) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($error) . '</div>';
}
?>
<div class="container mt-4">
    <div class="card-modern">
        <div class="card-header-pastel"><?= $title ?></div>
        <div class="card-body">

            <form method="post" action="/recette/save_recipe_fr">
                <label>Type de recette</label>
                <select name="type" class="form-control" onchange="toggleType(this.value)">
                    <option value="general">Recette générale</option>
                    <option value="beurre">Beurre composé</option>
                    <option value="marinade">Marinade</option>
                </select>
                <label class="mt-2">Titre</label>
                <input type="text" name="titre" class="form-control">
                <label class="mt-2">Type</label>
                <input type="text" name="type_recette" class="form-control">
                <!-- GENERAL -->
                <div id="general_block" class="mt-3">
                    <label>Pax</label>
                    <input type="number" name="pax" class="form-control">
                    <label class="mt-2">Sections</label>
                    <div id="sections_container">
                        <div class="section-block mb-3">
                            <select name="section_select[]" class="form-control mb-2">
                                <option value="">-- Section --</option>
                                <?php foreach ($Sections as $s): ?>
                                <option value="<?= htmlspecialchars($s) ?>"><?= htmlspecialchars($s) ?></option>
                                <?php endforeach; ?>
                                <option value="custom">Autre</option>
                            </select>
                            <input type="text" name="section_input[]" class="form-control mb-2" placeholder="Nouvelle section" style="display:none;">
                            <div class="ingredients_container">    
                                <div class="row mb-2">
                                    <div class="col"><input type="text" name="nom[0][]" class="form-control" placeholder="Nom"></div>
                                    <div class="col"><input type="text" name="unite[0][]" class="form-control" placeholder="Unité"></div>
                                    <div class="col"><input type="text" name="quantite[0][]" class="form-control" placeholder="Quantité"></div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="removeIngredient(this)">X</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-secondary" onclick="addIngredient(this,0)">+ ingrédient</button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeSection(this)">Supprimer section</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addSection()">+ section</button>

                    <label class="mt-2">Technique</label>
                    <textarea name="technique[]" class="form-control"></textarea>
                </div>
                <!-- BEURRE -->
                <div id="beurre_block" style="display:none" class="mt-3">
                    <label>Genre</label>
                    <input type="text" name="genre" class="form-control">
                    <label class="mt-2">Ingredients</label>
                    <textarea name="ingredients[]" class="form-control"></textarea>
                    <label class="mt-2">Technique</label>
                    <textarea name="technique[]" class="form-control"></textarea>
                    <label class="mt-2">Utilisation</label>
                    <textarea name="utilisation[]" class="form-control"></textarea>
                </div>
                <!-- MARINADE -->
                <div id="marinade_block" style="display:none" class="mt-3">
                    <label>Base</label>
                    <input type="text" name="base" class="form-control">
                    <label class="mt-2">Type viande</label>
                    <input type="text" name="type_viande" class="form-control">
                    <label class="mt-2">Ingredients</label>
                    <textarea name="ingredients[]" class="form-control"></textarea>
                    <label class="mt-2">Technique</label>
                    <textarea name="technique[]" class="form-control"></textarea>
                </div>
                <button class="btn btn-success">Enregistrer</button>
                <a href="/recette/indexfr" class="btn btn-outline-secondary">Annuler</a>
            </form>

        </div>
    </div>
</div>

<script>
let sectionIndex = 1;

function toggleType2(type) {
    document.getElementById('general_block').style.display = (type === 'general') ? 'block' : 'none';
    document.getElementById('beurre_block').style.display = (type === 'beurre') ? 'block' : 'none';
    document.getElementById('marinade_block').style.display = (type === 'marinade') ? 'block' : 'none';
}
function toggleType(type) {

    let typeInput = document.getElementsByName('type_recette')[0];

    if(type === 'general') {
        document.getElementById('general_block').style.display = 'block';
        document.getElementById('beurre_block').style.display = 'none';
        document.getElementById('marinade_block').style.display = 'none';
        typeInput.value = '';
    } 
    else if(type === 'beurre') {
        document.getElementById('general_block').style.display = 'none';
        document.getElementById('beurre_block').style.display = 'block';
        document.getElementById('marinade_block').style.display = 'none';
        typeInput.value = 'beurre compose';
    } 
    else if(type === 'marinade') {
        document.getElementById('general_block').style.display = 'none';
        document.getElementById('beurre_block').style.display = 'none';
        document.getElementById('marinade_block').style.display = 'block';
        typeInput.value = 'marinade';
    }
}

function getSectionOptions() {
    return `
<option value="">-- Section --</option>
<?php foreach ($Sections as $s): ?>
<option value="<?= htmlspecialchars($s) ?>"><?= htmlspecialchars($s) ?></option>
<?php endforeach; ?>
<option value="custom">Autre</option>
`;
}

function addSection() {

    let index = sectionIndex++;

    let html = `
    <div class="section-block mb-3">

        <select name="section_select[]" class="form-control mb-2">
            ${getSectionOptions()}
        </select>
        <input type="text" name="section_input[]" class="form-control mb-2" placeholder="Nouvelle section" style="display:none;">
        <div class="ingredients_container">
            <div class="row mb-2">
                <div class="col"><input type="text" name="nom[${index}][]" class="form-control" placeholder="Nom"></div>
                <div class="col"><input type="text" name="unite[${index}][]" class="form-control" placeholder="Unité"></div>
                <div class="col"><input type="text" name="quantite[${index}][]" class="form-control" placeholder="Quantité"></div>
                 <div class="col-2">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeIngredient(this)">X</button>
                </div>
                </div>
        </div>
        <button type="button" class="btn btn-sm btn-secondary" onclick="addIngredient(this,${index})">+ ingrédient</button>
        <button type="button" class="btn btn-sm btn-danger" onclick="removeSection(this)">Supprimer section</button>
        </div>`;
    document.getElementById('sections_container').insertAdjacentHTML('beforeend', html);
}

function addIngredient(btn, index) {

    let container = btn.parentElement.querySelector('.ingredients_container');

    let html = `
<div class="row mb-2">
    <div class="col"><input type="text" name="nom[${index}][]" class="form-control" placeholder="Nom"></div>
    <div class="col"><input type="text" name="unite[${index}][]" class="form-control" placeholder="Unité"></div>
    <div class="col"><input type="text" name="quantite[${index}][]" class="form-control" placeholder="Quantité"></div>
    <div class="col-2">
        <button type="button" class="btn btn-sm btn-danger" onclick="removeIngredient(this)">X</button>
    </div>
</div>`;

    container.insertAdjacentHTML('beforeend', html);
}

document.addEventListener('change', function(e) {
    if (e.target.name === 'section_select[]') {
        let input = e.target.parentElement.querySelector('input[name="section_input[]"]');

        if (!input) return;

        if (e.target.value === 'Autres') {
            input.style.display = 'block';
        } else {
            input.style.display = 'none';
            input.value = '';
        }
    }
});
function removeSection(btn) {
    let section = btn.closest('.section-block');
    if (section) {
        section.remove();
    }
}
function removeIngredient(btn) {
    let row = btn.closest('.row');
    if (row) {
        row.remove();
    }
}
</script>

<?php require __DIR__ . '/../../layout/footer.php'; ?>