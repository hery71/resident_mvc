<?php $title = "DashBoard Cuisine"; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<style>
.card-header-pastel {
    background-color: #F2F4F6; /* gris pastel doux */
    font-weight: 600;
    text-align: center;
    border: 1px solid #E0E0E0;
    border-radius: 0px 0px 0 0;
    padding: 0px;
    box-shadow: inset 0 -1px 0 rgba(0,0,0,0.05);
}
.pastel-tile {
    background-color: #A8D8EA;
    border-radius: 18px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    transition: all 0.25s ease;
    min-height: 350px;
    color: #2E2E2E;
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
                                    <?= htmlspecialchars($f['Prenom']) ?>
                                    <?= htmlspecialchars($f['Nom']) ?><br>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center mt-4">
                                Aucune fête aujourd'hui
                            </div>
                        <?php endif; ?>
                </div>
            </div>
        </div>
         <!-- ===================== -->
        <!-- TUILE L2 2: AJOUER TUILE -->
        <!-- ===================== -->
        <div class="col-md-4 mb-4">
            <div class="card pastel-tile">
                <div class="card-header card-header-pastel">
                    Commande gateau
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>