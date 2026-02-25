<?php $title = "DashBoard"; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<style>
.card-header-pastel {
    background-color: #5ebdef; /* gris pastel doux */
    font-weight: 600;
    text-align: center;
    border: 1px solid #E0E0E0;
    border-radius: 18px;
    padding: 5px;
    box-shadow: inset 0 -1px 0 rgba(0,0,0,0.05);
}
.pastel-tile {
    background-color: #A8D8EA;
    border-radius: 18px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    transition: all 0.25s ease;
    min-height: 350px;
    color: #2E2E2E;
    height: 350px;               /* fixe la grandeur */
    display: flex;
    flex-direction: column;      /* header en haut, contenu en bas */
    overflow: hidden;            /* garde le border-radius propre */
}
.pastel-tile .card-body {
    flex: 1 1 auto;              /* prend le reste de la hauteur */
    min-height: 0;               /* TRÈS IMPORTANT pour que overflow marche en flex */
    overflow-y: auto;            /* scrollbar si nécessaire */
    overflow-x: hidden;
    padding: 10px;             /* ton padding ici plutôt que sur la tile */
}

.pastel-tile:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 28px rgba(0,0,0,0.10);
}

.tile-content {
    font-size: 0.95rem;
}

.top-bar {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}
</style>

<div class="container-fluid mt-4">

    <!-- =============================== -->
    <!-- BARRE SUPERIEURE : DATE        -->
    <!-- =============================== -->

    <div class="top-bar mb-4 text-center font-weight-bold">

        <div class="mb-2">
            <?= $info ?>
        </div>

        <form method="post" action="/dashBoard/" class="form-inline justify-content-center">
            <input type="date"
                   name="xdate"
                   class="form-control mr-2"
                   value="<?= e($xdate) ?>">

            <button class="btn btn-outline-dark">
                Changer
            </button>
        </form>

    </div>

    <div class="row">

        <!-- ===================== -->
        <!-- TUILE L1 1 : MENU        -->
        <!-- ===================== -->
        <div class="col-md-4 mb-4">
            <div class="card pastel-tile">
                <div class="card-header card-header-pastel">
                    Menu du Jour
                </div>
                <div class="card-body">

                    <?php if ($menu): ?>

                        <div class="tile-content">

                            <strong>Breakfast</strong><br>
                            <?= htmlspecialchars($menu['breakfast'] ?? '-') ?><br><br>

                            <strong>Lunch</strong><br>
                            <?= htmlspecialchars($menu['lunch'] ?? '-') ?><br><br>

                            <strong>Lunch Dessert</strong><br>
                            <?= htmlspecialchars($menu['lunch_dessert'] ?? '-') ?><br><br>

                            <strong>Dinner</strong><br>
                            <?= htmlspecialchars($menu['dinner'] ?? '-') ?><br><br>

                            <strong>Dinner Dessert</strong><br>
                            <?= htmlspecialchars($menu['dinner_dessert'] ?? '-') ?>

                        </div>

                    <?php else: ?>

                        <div class="text-center mt-4">
                            Aucun menu trouvé
                        </div>

                    <?php endif; ?>
                <div class="d-flex justify-content-end mt-3">
                    <a href="/Menu/dailyMenu/" class="btn btn-secondary">Voir</a>
                </div>
                </div>
            </div>
        </div>

        <!-- ===================== -->
        <!-- TUILE L1 2 : RESTRICTIONS -->
        <!-- ===================== -->
        <div class="col-md-4 mb-4">
            <div class="card pastel-tile">
                <div class="card-header card-header-pastel">
                    Restrictions
                </div>
                <div class="card-body">

                    <?php if (!empty($restrictions)): ?>

                        <div class="tile-content">

                            <?php foreach ($restrictions as $r): ?>

                                <strong><?= htmlspecialchars($r['section']) ?></strong><br>
                                <?= htmlspecialchars($r['meal']) ?><br>

                                <?php if (!empty($r['allergene'])): ?>
                                    Allergène: <?= htmlspecialchars($r['allergene']) ?><br>
                                <?php endif; ?>

                                <?php if (!empty($r['intolerance'])): ?>
                                    Intolérance: <?= htmlspecialchars($r['intolerance']) ?><br>
                                <?php endif; ?>

                                <?php if (!empty($r['residents'])): ?>
                                    <em class="font-weight-bold">Résidents concernés :</em><br>
                                    <?= implode('<br>', array_map('htmlspecialchars', $r['residents'])) ?>
                                <?php else: ?>
                                    <em>Aucun résident concerné</em>
                                <?php endif; ?>

                                <hr>

                            <?php endforeach; ?>

                        </div>

                    <?php else: ?>

                        <div class="text-center mt-4">
                            ✅ Aucun allergène détecté
                        </div>

                    <?php endif; ?>
                    <div class="d-flex justify-content-end mt-3">
                    <a href="/restriction/edit/" class="btn btn-secondary">Voir</a>
                </div>
                </div>
            </div>
        </div>

        <!-- ===================== -->
        <!-- TUILE L1 3 : ANNIVERSAIRES -->
        <!-- ===================== -->
        <div class="col-md-4 mb-4">
            <div class="card pastel-tile">
                <div class="card-header card-header-pastel">
                    Anniversaires du Jour
                </div>
                <div class="card-body">

                    <?php if (!empty($birthdays)): ?>

                        <div class="tile-content">

                            <?php foreach ($birthdays as $b): ?>
                                <?= htmlspecialchars($b['Prenom']) ?>
                                <?= htmlspecialchars($b['Nom']) ?><br>
                            <?php endforeach; ?>

                        </div>

                    <?php else: ?>

                        <div class="text-center mt-4">
                            Aucun anniversaire aujourd'hui
                        </div>

                    <?php endif; ?>
                <div class="d-flex justify-content-end mt-3">
                    <a href="/birthday/" class="btn btn-secondary">Voir</a>
                </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
         <!-- ===================== -->
        <!-- TUILE L2 1: Vide -->
        <!-- ===================== -->
        <div class="col-md-4 mb-4">
            <div class="card pastel-tile">
                <div class="card-header card-header-pastel">
                   Fetes du Jour
                </div>
                <div class="card-body">
                        <?php if (!empty($fetes)): ?>
                            <div class="tile-content">
                                <?php foreach ($fetes as $f): ?>
                                    <?= e($f['Prenom']) ." " ?>
                                    <?= e($f['Nom']) ?>
                                    <?= "(" .e($f['motif']) .")" ?>
                                    <br>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center mt-4">
                                Aucune fête aujourd'hui
                            </div>
                        <?php endif; ?>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="/Fete/" class="btn btn-secondary">Voir</a>
                        </div>
                </div>
            </div>
        </div>
         <!-- ===================== -->
        <!-- TUILE L2 2: Gâteaux d'anniversaire -->
        <!-- ===================== -->
        <div class="col-md-4 mb-4">
            <div class="card pastel-tile">
                <div class="card-header card-header-pastel">
                    Commande gateau
                </div>
                <div class="card-body">
                        <?php if (!empty($cakes)): ?>
                            <div class="tile-content">
                                <?php foreach ($cakes as $c): ?>
                                    <?= e($c['Prenom']) ?>
                                    <?= e($c['Nom']) ?>
                                    <br>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center mt-4">
                                Aucune commande de gâteau aujourd'hui
                            </div>
                        <?php endif; ?>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="/Cake/cake_list_order/" class="btn btn-secondary">Voir</a>
                        </div>
                </div>
            </div>
        </div>
         <!-- ===================== -->
        <!-- TUILE L2 3: Next Periode -->
        <!-- ===================== -->
         <!-- ===================== array(4) { ["Saison"]=> string(6) "Winter" ["Début"]=> string(10) "2026-01-04" ["Fin"]=> string(10) "2026-03-21" ["Durée"]=> float(76.95833333333333) } -->
        <div class="col-md-4 mb-4">
            <div class="card pastel-tile">
                <div class="card-header card-header-pastel">
                    Periode en cours
                </div>
                <div class="card-body">
                        <?php if (!empty($currentPeriod)): ?>
                            <div class="tile-content">
                                    <?= e($currentPeriod['Saison']) ?> -
                                    <?= e($currentPeriod['Début']) ?> au
                                    <?= e($currentPeriod['Fin']) ?>
                                    <br>
                            </div>
                        <?php else: ?>
                            <div class="text-center mt-4">
                                Aucune période en cours
                            </div>
                        <?php endif; ?>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="/alimentaire/saison/" class="btn btn-secondary">Voir</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>