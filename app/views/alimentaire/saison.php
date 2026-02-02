<?php $title = 'Calendrier saison'; 
    $inspection=  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
    $selectedYear = (int)$annee;
    $years = range($selectedYear-5, $selectedYear+10);
?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container center">
<h2 class="mb-4 text-center">Cycle des saisons – Année <?= $annee ?></h2>

  <form method="get" class="form-inline justify-content-center mb-4">
    <label for="annee" class="mr-2">Choisir une année :</label>
    <select name="annee" id="annee" class="form-control mr-2" onchange="this.form.submit()">
      <?php foreach ($years as $y): ?>
        <option value="<?= $y ?>" <?= ($y == $selectedYear) ? 'selected' : '' ?>><?= $y ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-primary">Afficher</button>
  </form>
  <table class="table table-bordered table-hover text-center">
    <thead class="thead-dark">
      <tr>
        <th>Saison / Semaine spéciale</th>
        <th>Début (dimanche)</th>
        <th>Fin (samedi)</th>
        <th>Durée (jours)</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $totalDays = 0;
      foreach ($seasons as $s): 
        $class = match($s['Saison']) {
          'Winter' => 'winter',
          'Spring' => 'spring',
          'Summer' => 'summer',
          'Fall' => 'fall',
          default => 'special',
        };
        $totalDays += $s['Durée'];
      ?>
        <tr class="<?= $class ?>">
          <td><strong><?= htmlspecialchars($s['Saison']) ?></strong></td>
          <td><?= htmlspecialchars($s['Début']) ?></td>
          <td><?= htmlspecialchars($s['Fin']) ?></td>
          <td><?= htmlspecialchars($s['Durée']) ?></td>
        </tr>
      <?php endforeach; ?>
      <tr class="table-secondary font-weight-bold">
        <td colspan="3" class="text-right">Total annuel</td>
        <td><?= $totalDays ?></td>
      </tr>
    </tbody>
  </table>

  <p class="text-muted text-center">
    💡 Le cycle débute toujours par la saison <strong>Winter</strong> (dimanche suivant la semaine du 1er janvier).  
    Les deux semaines spéciales (<em>Noël</em> et <em>Nouvel An</em>) appartiennent à la même année de cycle.
  </p>

<div class="text-center mt-4">
    <a href="/alimentaire/index" class="btn btn-secondary">⬅ Accueil</a>
</div>



</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>