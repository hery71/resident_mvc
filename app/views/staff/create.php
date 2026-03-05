<?php $title = 'Ajouter nouva Staff'; 
    $custom_js = <<<'JS'
    // Custom JavaScript can be added here
    document.getElementById("service").addEventListener("change", function () {
        let service = this.value;
        fetch("/ajax/get_departements.php?service=" + encodeURIComponent(service))
        .then(response => response.json())
        .then(data => {
            let select = document.getElementById("departement");
            select.innerHTML = '<option value="">Select Departement</option>';
            data.forEach(function(dep) {
                let option = document.createElement("option");
                option.value = dep;
                option.textContent = dep;
                select.appendChild(option);
            });
        });
    });
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
            <h3>Ajouter Nouveau Staff</h3>
                    
            <form method="POST" action="<?= BASE_URL ?>/staff/store">

                <div class="row">

                <div class="col-md-4 mb-3">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                <label>Prénom</label>
                <input type="text" name="prenom" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                <label>Middle Name</label>
                <input type="text" name="middle_name" class="form-control">
                </div>

                </div>

                <div class="row">

                <div class="col-md-3 mb-3">
                <label>Gender</label>
                <select name="gender" class="form-control">
                    <option value="">Select Gender</option>
                    <?php foreach ($options['Gender'] as $key => $value): ?>
                        <option value="<?= e($value) ?>"><?= e($value) ?></option>
                    <?php endforeach; ?>
                </select>
                </div>

                <div class="col-md-3 mb-3">
                <label>Date of Birth</label>
                <input type="date" name="dob" class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                <label>Status</label>
                 <select name="status" class="form-control">
                    <option value="">Select Status</option>
                    <?php foreach ($options['status'] as $key => $value): ?>
                        <option value="<?= e($value) ?>"><?= e($value) ?></option>
                    <?php endforeach; ?>
                </select>
                </div>

                </div>

                <div class="row">

                <div class="col-md-4 mb-3">
                <label>Service</label>
                <select name="service"  id="service" class="form-control">
                    <option value="">Select Service</option>
                    <?php foreach ($options['Sevice'] as $key => $value): ?>
                        <option value="<?= e($value) ?>"><?= e($value) ?></option>
                    <?php endforeach; ?>
                </select>
                </div>

               <div class="col-md-4 mb-3">
                    <label>Departement</label>
                    <select name="departement" id="departement" class="form-control">
                        <option value="">Select Departement</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                <label>Poste</label>
                <select name="poste"  id="poste" class="form-control">
                    <option value="">Select Poste</option>
                    <?php foreach ($options['Poste'] as $key => $value): ?>
                        <option value="<?= e($value) ?>"><?= e($value) ?></option>
                    <?php endforeach; ?>
                </select>
                </div>

                </div>

                <div class="row">

                <div class="col-md-3 mb-3">
                <label>Téléphone 1</label>
                <input type="text" name="tel1" class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                <label>Téléphone 2</label>
                <input type="text" name="tel2" class="form-control">
                </div>

                </div>

                <div class="row">

                <div class="col-md-4 mb-3">
                <label>Adresse ligne 1</label>
                <input type="text" name="adresse_l1" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                <label>Adresse ligne 2</label>
                <input type="text" name="adresse_l2" class="form-control">
                </div>

                </div>

                <div class="row">

                <div class="col-md-3 mb-3">
                <label>Code Postal</label>
                <input type="text" name="code_postal" class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                <label>Ville</label>
                <input type="text" name="ville" class="form-control">
                </div>

                </div>

                <div class="mt-4">

                <button type="submit" class="btn btn-primary">
                Save
                </button>

                <a href="<?= BASE_URL ?>/staff" class="btn btn-secondary">
                Cancel
                </a>

                </div>

            </form>
<!---------------------FIN DIV PRINCIPAL--------------------->
        </div><!---------------------FIN CARD-BODY--------------------->
    </div><!---------------------FIN CARD-MODERN--------------------->
</div> <!---------------------FIN CONTAINER--------------------->
<?php require __DIR__ . '/../layout/footer.php'; ?>