<?php $title = 'Anniversaires du mois'; ?>
<?php 
    require __DIR__ . '/../layout/header.php'; 
    $countryData=  Config::country(); 
    $message = $message ?? '';
    $logoPath = logo_disk_path(); // ← depuis helpers + logo.json
?>
<div class="container mt-4">
    <div class="card-modern">
    <div class="card-header-pastel"><?= $title ?></div>
    <div class="card-body">
    <div class="box">

        <h3>Informations de l'entreprise</h3>
        <hr>

        <?php if ($message): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Nom de l'entreprise</label>
                    <input type="text" name="nom" class="form-control"
                           value="<?= htmlspecialchars($company['nom']) ?>">
                </div>

                <div class="col-md-6">
                    <label>Adresse</label>
                    <input type="text" name="adresse" class="form-control"
                           value="<?= htmlspecialchars($company['adresse']) ?>">
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-md-3">
                    <label>Ville</label>
                    <input type="text" name="ville" class="form-control"
                           value="<?= htmlspecialchars($company['ville']) ?>">
                </div>

                <div class="col-md-3">
                    <label>Code Postal</label>
                    <input type="text" name="code_postale" class="form-control"
                           value="<?= htmlspecialchars($company['code_postale']) ?>">
                </div>

                <div class="col-md-3">
                    <label>Pays</label>
                    <select id="pays" name="pays" class="form-control" onchange="updateRegions()">
                        <?php foreach ($countryData as $country => $regions): ?>
                            <option value="<?= $country ?>"
                                <?= ($company['pays'] === $country ? 'selected' : '') ?>>
                                <?= $country ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Région / Province / Département</label>
                    <select id="region" name="region" class="form-control">
                        <!-- Rempli automatiquement -->
                    </select>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Téléphone</label>
                    <input type="text" name="telephone" class="form-control"
                           value="<?= htmlspecialchars($company['telephone']) ?>">
                </div>

                <div class="col-md-4">
                    <label>Fax</label>
                    <input type="text" name="fax" class="form-control"
                           value="<?= htmlspecialchars($company['fax']) ?>">
                </div>

                <div class="col-md-4">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                           value="<?= htmlspecialchars($company['email']) ?>">
                </div>
            </div>

            <div class="mb-3">
                <label>Site web</label>
                <input type="text" name="web" class="form-control"
                       value="<?= htmlspecialchars($company['web']) ?>">
            </div>

            <div class="mb-3">
                <label>Logo (PNG uniquement)</label>
                <input type="file" name="logo" accept="image/png" class="form-control">
            </div>

            <?php if (file_exists($logoPath)): ?>
                <div class="mb-3">
                    <label>Logo actuel :</label><br>
                    <img src="<?= $logoPath ?>?v=<?= time() ?>" 
                         style="max-height:120px;border:1px solid #ccc;padding:5px;background:white;">
                </div>
            <?php endif; ?>

            <button class="btn btn-primary">💾 Enregistrer</button>
        </form>
    </div>
    </div>

    </div>




</div>
 <script>
        function updateRegions() {
            let data = <?= json_encode($countryData) ?>;
            let selectedCountry = document.getElementById("pays").value;
            let regionSelect = document.getElementById("region");

            regionSelect.innerHTML = "";

            if (data[selectedCountry]) {
                data[selectedCountry].forEach(function(reg) {
                    let opt = document.createElement("option");
                    opt.value = reg;
                    opt.textContent = reg;
                    regionSelect.appendChild(opt);
                });
            }
        }

        function selectSavedRegion() {
            let savedRegion = "<?= htmlspecialchars($company['region']) ?>";
            let regionSelect = document.getElementById("region");

            for (let i = 0; i < regionSelect.options.length; i++) {
                if (regionSelect.options[i].value === savedRegion) {
                    regionSelect.selectedIndex = i;
                    break;
                }
            }
        }
    </script>
<?php require __DIR__ . '/../layout/footer.php'; ?>