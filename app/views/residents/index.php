<?php $title = 'Liste résidents'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-4">
    <a href="/resident/create" class="btn btn-primary mb-3">
    Ajouter un résident
    </a>
    <a href="/resident/printIndex?nom=<?= urlencode($nom) ?>&prenom=<?= urlencode($prenom) ?>&page=<?= $page ?>" class="NP btn btn-warning mb-3" target="_blank">
      🖨 Imprimer
    </a>
    <form method="get" class="mb-3">
        <div class="form-row align-items-end">
            <div class="col">
                <label>Prénom</label>
                <input type="text" name="prenom" class="form-control"
                    value="<?= e($prenom) ?>">
            </div>

            <div class="col">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control"
                    value="<?= e($nom) ?>">
            </div>

            <div class="col-auto">
                <button class="btn btn-primary">🔍 Rechercher</button>
            </div>

            <div class="col-auto">
                <a href="/resident" class="btn btn-secondary">
                    ♻️ Annuler filtre
                </a>
            </div>
        </div>
    </form>
    <table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Chambre</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($residents as $r): ?>
        <tr>
            <td><?= e($r['Prenom']) ?></td>
            <td><?= e($r['Nom']) ?></td>
            <td><?= e($r['Chambre'] ?? '') ?></td>
            <td>
                <button
                    class="btn btn-sm btn-info btn-info-resident"
                    data-toggle="modal"
                    data-target="#infoModal"
                    data-prenom="<?= e($r['Prenom']) ?>"
                    data-nom="<?= e($r['Nom']) ?>"
                    data-anniversaire="<?= e($r['Anniversaire']) ?>"
                    data-tel1="<?= e($r['Tel1'] ?? '') ?>"
                    data-tel2="<?= e($r['Tel2'] ?? '') ?>"
                    data-tel3="<?= e($r['Tel3'] ?? '') ?>"
                    data-famille="<?= e($r['Famille'] ?? '') ?>">
                    ℹ️ Informations
                </button>
                <a href="/resident/edit/<?= $r['id'] ?>"
                class="btn btn-sm btn-warning ml-1">
                    ✏️ Modifier
                </a>
                <a href="/resident/preferenceAlimentaire?id=<?= $r['id'] ?>"
                class="btn btn-sm btn-success ml-1">
                Preference Alimentaires
                </a>
                <a href="#"
                    class="btn btn-sm btn-danger btn-depart-resident"
                    data-toggle="modal"
                    data-target="#departModal"
                    data-id="<?= $r['id'] ?>"
                    data-prenom="<?= e($r['Prenom']) ?>"
                    data-nom="<?= e($r['Nom']) ?>">
                🚪 Départ
                </a>

            </td>
        </tr>
<?php endforeach; ?>
</tbody>
</table>
<nav>
    <ul class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link"
                   href="?page=<?= $i ?>&nom=<?= urlencode($nom) ?>&prenom=<?= urlencode($prenom) ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
</div>
 <!-- Modal resident informations -->
<div class="modal fade" id="infoModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Informations du résident</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tr>
            <th>Prénom</th>
            <td id="info-prenom"></td>
          </tr>
          <tr>
            <th>Nom</th>
            <td id="info-nom"></td>
          </tr>
          <tr>
            <th>Date anniversaire</th>
            <td id="info-anniversaire"></td>
          </tr>
          <tr>
            <th>Téléphone 1</th>
            <td id="info-tel1"></td>
          </tr>
          <tr>
            <th>Téléphone 2</th>
            <td id="info-tel2"></td>
          </tr>
          <tr>
            <th>Téléphone 3</th>
            <td id="info-tel3"></td>
          </tr>
          <tr>
            <th>Famille</th>
            <td id="info-famille"></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<!--  Modal départ résident -->
<div class="modal fade" id="departModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form method="post" action="/resident/depart">

        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Confirmer le départ</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id" id="depart-id">

          <p>
            Confirmer le départ de :
            <strong id="depart-prenom"></strong>
            <strong id="depart-nom"></strong>
          </p>

          <div class="form-group">
            <label>Motif du départ</label>
            <select name="CauseDepart" class="form-control" required>
                <?php foreach ($options['CauseDepart'] as $g): ?>
                    <option value="<?= e($g) ?>"><?= e($g) ?></option>
                <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Date de départ</label>
            <input type="date" name="leavedate"
                   class="form-control"
                   required>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-danger">Confirmer le départ</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Annuler
          </button>
        </div>

      </form>

    </div>
  </div>
</div>
</div> <!-- container -->
<script>
document.querySelectorAll('.btn-info-resident').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('info-prenom').textContent = this.dataset.prenom;
        document.getElementById('info-nom').textContent = this.dataset.nom;
        document.getElementById('info-anniversaire').textContent = this.dataset.anniversaire;
        document.getElementById('info-tel1').textContent = this.dataset.tel1;
        document.getElementById('info-tel2').textContent = this.dataset.tel2;
        document.getElementById('info-tel3').textContent = this.dataset.tel3;
        document.getElementById('info-famille').textContent = this.dataset.famille;
    });
});
</script>
<script>
document.querySelectorAll('.btn-depart-resident').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('depart-id').value = this.dataset.id;
        document.getElementById('depart-prenom').textContent = this.dataset.prenom;
        document.getElementById('depart-nom').textContent = this.dataset.nom;
    });
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>

