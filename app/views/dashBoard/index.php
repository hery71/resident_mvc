<?php $title = "DashBoard";
    $custom_js = <<<'JS'
    // Custom JavaScript can be added here
        const colors = [
        { name: 'Bleu',    val: '#A8D8EA' },
        { name: 'Vert',    val: '#B8E0C8' },
        { name: 'Rose',    val: '#F2C4CE' },
        { name: 'Lavande', val: '#D4B8E0' },
        { name: 'Pêche',   val: '#F9D5A7' },
        { name: 'Menthe',  val: '#A8EDD4' },
        { name: 'Gris',    val: '#DDE1E7' },
        { name: 'Jaune',   val: '#FFF0A0' },
    ];

    document.addEventListener('DOMContentLoaded', () => {

        const container = document.getElementById('color-swatches');

        const savedCols = document.getElementById('init-cols').value || '3';
        const savedColor = document.getElementById('init-color').value || '#A8D8EA';

        document.getElementById('active-color').value = savedColor;
        document.getElementById('col-slider').value = savedCols;

        function applySettings() {
            const cols = parseInt(document.getElementById('col-slider').value);
            document.getElementById('col-display').textContent = cols + ' par ligne';

            const fontSizes = { 2:'1.05rem', 3:'0.95rem', 4:'0.82rem', 5:'0.72rem', 6:'0.65rem' };
            const cardHeight = { 2:'420px', 3:'350px', 4:'300px', 5:'270px', 6:'240px' };

            document.getElementById('dashboard-grid').style.gridTemplateColumns = `repeat(${cols}, 1fr)`;

            document.querySelectorAll('.pastel-tile').forEach(el => {
                el.style.height = cardHeight[cols];
                el.style.minHeight = cardHeight[cols];
                el.style.fontSize = fontSizes[cols];
            });

            const color = document.getElementById('active-color').value;
            document.querySelectorAll('.pastel-tile').forEach(el => {
                el.style.backgroundColor = color;
            });

            fetch('/dashBoard/saveSettings', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `cols=${cols}&color=${color}`
            });
        }

        colors.forEach(c => {
            const s = document.createElement('div');
            s.className = 'swatch' + (c.val === savedColor ? ' active' : '');
            s.style.backgroundColor = c.val;

            s.addEventListener('click', () => {
                document.querySelectorAll('.swatch').forEach(x => x.classList.remove('active'));
                s.classList.add('active');
                document.getElementById('active-color').value = c.val;
                applySettings();
            });

            container.appendChild(s);
        });

        applySettings();

        document.getElementById('col-slider').addEventListener('input', applySettings);

        document.getElementById('config-toggle').addEventListener('click', () => {
            document.getElementById('config-panel').classList.toggle('open');
        });

    });
    JS;
    $custom_style = <<<'CSS'
    /* Custom CSS can be added here */
    .card-header-pastel {
    background-color: #6e7071; /* gris pastel doux */
    font-weight: 600;
    text-align: center;
    color: #fffbfb;
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
    /* Panneau config */
    #config-panel {
        position: fixed;
        top: 80px;
        right: -260px;
        width: 250px;
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 12px 0 0 12px;
        box-shadow: -4px 0 15px rgba(0,0,0,0.1);
        z-index: 9999;
        transition: right 0.3s ease;
        padding: 15px;
    }
    #config-panel.open { right: 0; }
    #config-toggle {
        position: fixed;
        top: 80px;
        right: 0;
        background: #5ebdef;
        color: white;
        border: none;
        border-radius: 8px 0 0 8px;
        padding: 10px 8px;
        cursor: pointer;
        z-index: 10000;
        writing-mode: vertical-rl;
        font-size: 0.8rem;
        font-weight: 600;
    }
    #config-panel label { font-size: 0.85rem; font-weight: 600; display: block; margin-top: 10px; }
    #config-panel input[type=range] { width: 100%; }
    #col-display { font-size: 0.8rem; color: #555; }
    .color-swatches { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 5px; }
    .swatch {
        width: 28px; height: 28px; border-radius: 6px;
        cursor: pointer; border: 2px solid transparent;
        transition: transform 0.15s;
    }
    .swatch:hover, .swatch.active { border-color: #333; transform: scale(1.15); }
    #dashboard-grid {
    display: grid;
    gap: 20px;
    }
CSS;
?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<input type="hidden" id="init-cols" value="<?= $settings['dash_cols'] ?? 3 ?>">
<input type="hidden" id="init-color" value="<?= $settings['dash_color'] ?? '#A8D8EA' ?>">
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

    <div id="dashboard-grid">

        <!-- ===================== -->
        <!-- TUILE L1 1 : MENU du jour      -->
        <!-- ===================== -->
        <div class="mb-4">
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
        <div class="mb-4">
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

                        <div class="text-left mt-4">
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
        <div class="mb-4">
            <div class="card pastel-tile">
                <div class="card-header card-header-pastel">
                    Anniversaires
                </div>
                <div class="card-body">
                    <p class="font-weight-bold">Résidents avec anniversaire aujourd'hui :</P>
                        <?php if (!empty($birthdays)): ?>
                            <div class="tile-content">
                                <?php foreach ($birthdays as $b): ?>
                                    <?= htmlspecialchars($b['Prenom']) ?>
                                    <?= htmlspecialchars($b['Nom']) ?><br>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-left mt-4"> 
                                Aucun anniversaire aujourd'hui
                            </div>
                        <?php endif; ?>
                    <div class="d-flex justify-content-end mt-3">
                        <a href="/birthday/" class="btn btn-secondary">Voir</a>
                    </div>
                    <p class="font-weight-bold">Anniversaire du mois de <?=  e(frenchMonthName((int)$month)) ?> NON edite:</p>
                    <?php if (!empty($anniversaires)): ?>
                        <div class="tile-content">
                            <?php foreach ($anniversaires as $a): ?>
                                 <?php if (!$a['fete_id']): ?>
                                    <?= e($a['Prenom']) ?>
                                    <?= e($a['Nom']) ?>
                                    (<?= e($a['date_naissance']) ?>)<br>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-left mt-4">
                            Aucun anniversaire non édité ce mois-ci
                        </div>
                    <?php endif; ?>
                    <?php $nextMonth = (new DateTime($xdate))->modify('+1 month')->format('F Y'); ?>
                    <p class="font-weight-bold">Anniversaire au debut du mois prochain(<?= e($nextMonth) ?>):</p>
                    <?php if (!empty($upcomingBirthdays)): ?>
                            <div class="tile-content">
                                <?php foreach ($upcomingBirthdays as $b): ?>
                                    <?= e($b['Prenom']) ?>
                                    <?= e($b['Nom']) ?>
                                    (<?= e($b['Anniversaire']) ?>)<br>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-left mt-4">
                                Aucun anniversaire à venir dans les 7 prochains jours
                            </div>
                        <?php endif; ?>
                    <div class="d-flex justify-content-end mt-3">
                        <a href="/birthday?mois=<?= (int)date('m')+1 ?>" class="btn btn-secondary">Voir</a>
                    </div>
                </div>
            </div>
        </div>
         <!-- ===================== -->
        <!-- TUILE L2 1: Fetes du jour-->
        <!-- ===================== -->
        <div class="mb-4">
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
                            <div class="text-left mt-4">
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
        <div class="mb-4">
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
                            <div class="text-left mt-4">
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
        <div class="mb-4">
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
         <!-- ===================== -->
        <!-- TUILE L3 1: Info residents -->
        <!-- ===================== -->
         <!-- ===================== array(4) { ["Saison"]=> string(6) "Winter" ["Début"]=> string(10) "2026-01-04" ["Fin"]=> string(10) "2026-03-21" ["Durée"]=> float(76.95833333333333) } -->
        <div class="mb-4">
            <div class="card pastel-tile">
                <div class="card-header card-header-pastel">
                    Info Residents
                </div>
                <div class="card-body">
                    <p class="font-weight-bold">5 Derniers résidents ajoutés :</p>
                        <?php if (!empty($lastResidents)): ?>
                            <?php foreach ($lastResidents as $lastResident): ?>
                                <div class="tile-content">
                                        (<?= e($lastResident['Admission']) ?>)
                                        <?= e($lastResident['Prenom']) ?>
                                        <?= e($lastResident['Nom']) ?>
                                        <?= "<a href='/resident/informations/{$lastResident['id']}' class='btn btn-primary btn-sm rounded-0 py-0 px-2'>Voir</a>" ?>
                                        <br>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class V="text-center mt-4">
                                Aucun résident ajouté récemment
                            </div>
                        <?php endif; ?>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="/resident/" class="btn btn-secondary">Voir</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-------------------PANNEAUX DE CONFIGURATION------------------->
<input type="hidden" id="active-color" value="#A8D8EA">

<button id="config-toggle">⚙ Config</button>

<div id="config-panel">
    <strong>Paramètres affichage</strong>

    <label>Colonnes par ligne : <span id="col-display">3 par ligne</span></label>
    <input type="range" id="col-slider" min="2" max="6" step="1" value="3">
    <div style="display:flex;justify-content:space-between;font-size:0.75rem;color:#888">
        <span>2</span><span>3</span><span>4</span><span>5</span><span>6</span>
    </div>

    <label>Couleur des tuiles :</label>
    <div class="color-swatches" id="color-swatches"></div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>