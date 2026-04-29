<?php $title = 'Impression étiquettes Thermopatch'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">

    <h3>Impression étiquettes Thermopatch</h3>

    <form method="post" action="/resident/printThermopatchLabels">

        <div class="form-group">
            <label>Résident actif</label>

            <select id="residentSelect" class="form-control">
                <option value="">-- Choisir un résident --</option>

                <?php foreach ($residents as $r): ?>
                    <option 
                        value="<?= (int)$r['id'] ?>"
                        data-nom="<?= e(strtoupper($r['Nom'])) ?>"
                        data-prenom="<?= e(strtoupper($r['Prenom'])) ?>"
                        data-chambre="<?= e($r['Chambre']) ?>"
                    >
                        <?= e($r['Prenom'] . ' ' . $r['Nom'] . ' - Chambre ' . $r['Chambre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="button" class="btn btn-primary" onclick="addLabel()">
            Ajouter
        </button>

        <hr>

        <h5>Étiquettes à imprimer</h5>

        <table class="table table-bordered mt-3" id="labelTable">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Chambre</th>
                    <th style="width:80px;">Copies</th>
                    <th style="width:80px;">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <button type="submit" class="btn btn-success">
            Imprimer Thermopatch
        </button>

    </form>

</div>

<script>
function addLabel() {
    const select = document.getElementById('residentSelect');
    const option = select.options[select.selectedIndex];

    if (!option.value) {
        alert('Choisir un résident.');
        return;
    }

    const id = option.value;
    const nom = option.dataset.nom;
    const prenom = option.dataset.prenom;
    const chambre = option.dataset.chambre;

    if (document.getElementById('resident_' + id)) {
        alert('Résident déjà ajouté.');
        return;
    }

    const tbody = document.querySelector('#labelTable tbody');

    const tr = document.createElement('tr');
    tr.id = 'resident_' + id;

    tr.innerHTML = `
        <td>
            ${prenom} ${nom}
            <input type="hidden" name="labels[${id}][id]" value="${id}">
            <input type="hidden" name="labels[${id}][prenom]" value="${prenom}">
            <input type="hidden" name="labels[${id}][nom]" value="${nom}">
        </td>
        <td>
            ${chambre}
            <input type="hidden" name="labels[${id}][chambre]" value="${chambre}">
        </td>
        <td>
            <input type="number" name="labels[${id}][copies]" value="1" min="1" class="form-control">
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">
                X
            </button>
        </td>
    `;

    tbody.appendChild(tr);
}
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>