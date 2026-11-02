<?php $title = "Tableau de bord";
    $custom_js = <<<'JS'
    const colors = [
        { name: 'Bleu', val: '#A8D8EA' }, { name: 'Vert', val: '#B8E0C8' },
        { name: 'Rose', val: '#F2C4CE' }, { name: 'Lavande', val: '#D4B8E0' },
        { name: 'Pêche', val: '#F9D5A7' }, { name: 'Menthe', val: '#A8EDD4' },
        { name: 'Gris', val: '#DDE1E7' }, { name: 'Jaune', val: '#FFF0A0' }
    ];
    document.addEventListener('DOMContentLoaded', () => {
        const grid = document.getElementById('dashboard-grid');
        const slider = document.getElementById('col-slider');
        const activeColor = document.getElementById('active-color');
        const panel = document.getElementById('config-panel');
        const toggle = document.getElementById('config-toggle');
        const savedCols = Math.max(2, Math.min(6, parseInt(document.getElementById('init-cols').value, 10) || 3));
        const rawColor = document.getElementById('init-color').value;
        const savedColor = /^#[0-9a-f]{6}$/i.test(rawColor) ? rawColor : '#A8D8EA';
        slider.value = savedCols;
        activeColor.value = savedColor;
        const icons = ['fa-shopping-cart', 'fa-utensils', 'fa-shield-alt', 'fa-birthday-cake', 'fa-glass-cheers', 'fa-birthday-cake', 'fa-leaf', 'fa-users'];
        grid.querySelectorAll('.card-header-pastel').forEach((header, index) => {
            const title = document.createElement('span');
            title.textContent = header.textContent.trim();
            const icon = document.createElement('i');
            icon.className = 'fas ' + (icons[index] || 'fa-th-large');
            icon.setAttribute('aria-hidden', 'true');
            header.replaceChildren(icon, title);
        });
        function applySettings() {
            const desired = Number(slider.value);
            const available = Math.max(1, Math.floor((grid.clientWidth + 20) / 290));
            const columns = Math.min(desired, available);
            grid.style.gridTemplateColumns = `repeat(${columns}, minmax(0, 1fr))`;
            grid.style.setProperty('--dashboard-accent', activeColor.value);
            document.getElementById('col-display').textContent = desired + ' par ligne' + (columns < desired ? ' (adapté à l’écran)' : '');
        }
        let saveTimer;
        function saveSettings() {
            clearTimeout(saveTimer);
            saveTimer = setTimeout(() => {
                fetch('/dashBoard/saveSettings', {
                    method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ cols: slider.value, color: activeColor.value }).toString()
                }).catch(() => {});
            }, 350);
        }
        colors.forEach(color => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'swatch' + (color.val.toLowerCase() === savedColor.toLowerCase() ? ' active' : '');
            button.style.backgroundColor = color.val;
            button.title = color.name;
            button.setAttribute('aria-label', color.name);
            button.setAttribute('aria-pressed', String(color.val.toLowerCase() === savedColor.toLowerCase()));
            button.addEventListener('click', () => {
                document.querySelectorAll('#color-swatches .swatch').forEach(item => {
                    item.classList.remove('active'); item.setAttribute('aria-pressed', 'false');
                });
                button.classList.add('active'); button.setAttribute('aria-pressed', 'true');
                activeColor.value = color.val; applySettings(); saveSettings();
            });
            document.getElementById('color-swatches').appendChild(button);
        });
        slider.addEventListener('input', () => { applySettings(); saveSettings(); });
        toggle.addEventListener('click', () => {
            const open = panel.classList.toggle('open');
            panel.setAttribute('aria-hidden', String(!open));
            panel.inert = !open;
            toggle.setAttribute('aria-expanded', String(open));
        });
        document.getElementById('config-close').addEventListener('click', () => {
            panel.classList.remove('open');
            panel.setAttribute('aria-hidden', 'true');
            panel.inert = true;
            toggle.setAttribute('aria-expanded', 'false');
            toggle.focus();
        });
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape' && panel.classList.contains('open')) {
                panel.classList.remove('open'); panel.setAttribute('aria-hidden', 'true'); panel.inert = true;
                toggle.setAttribute('aria-expanded', 'false'); toggle.focus();
            }
        });
        if (window.ResizeObserver) new ResizeObserver(applySettings).observe(grid);
        else window.addEventListener('resize', applySettings);
        applySettings();
    });
    JS;
    $custom_style = <<<'CSS'
    #cfsm-dashboard { padding: 0 24px 28px; color: #243f56; }
    #cfsm-dashboard .dashboard-heading { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 20px; }
    #cfsm-dashboard .dashboard-heading h1 { font-size: 1.65rem; font-weight: 700; letter-spacing: -.5px; margin-bottom: 4px; }
    #cfsm-dashboard .dashboard-heading p { margin: 0; color: #718096; font-size: .93rem; }
    #cfsm-dashboard .top-bar { background: #fff; border: 1px solid #e3eaf0; padding: 18px; border-radius: 14px; box-shadow: 0 3px 12px rgba(24,43,64,.025); font-size: .91rem; color: #506578; }
    #cfsm-dashboard .top-bar .form-control { border-radius: 8px; border-color: #d5e0e8; }
    #dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%,280px),1fr)); gap: 20px; --dashboard-accent: #A8D8EA; }
    #dashboard-grid > .mb-4 { margin-bottom: 0 !important; min-width: 0; }
    #dashboard-grid .pastel-tile { background: #fff; border: 1px solid #e1e8ef; border-top: 3px solid var(--dashboard-accent); border-radius: 15px; height: 365px; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 4px 16px rgba(24,43,64,.04); transition: box-shadow .2s, border-color .2s; }
    #dashboard-grid .pastel-tile:hover { box-shadow: 0 8px 24px rgba(24,43,64,.09); border-color: #c6d6df; border-top-color: var(--dashboard-accent); }
    #dashboard-grid .card-header-pastel { display: flex; align-items: center; gap: 12px; background: #fff; border: 0; border-bottom: 1px solid #edf1f5; border-radius: 0; box-shadow: none; text-align: left; padding: 17px 18px; color: #243f56; font-size: 1rem; font-weight: 700; min-height: 72px; }
    #dashboard-grid .card-header-pastel > i { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; flex-shrink: 0; border-radius: 11px; background: var(--dashboard-accent); color: #243f56; font-size: 1rem; }
    #dashboard-grid .card-body { display: flex; flex-direction: column; flex: 1; min-height: 0; padding: 18px; overflow-y: auto; overflow-wrap: anywhere; scrollbar-width: thin; }
    #dashboard-grid .tile-content { font-size: .92rem; line-height: 1.65; color: #526578; }
    #dashboard-grid .tile-content strong { color: #243f56; font-size: .9rem; }
    #dashboard-grid .card-body > p { font-size: .9rem; color: #526578; }
    #dashboard-grid .card-body > .d-flex:last-child { margin-top: auto !important; padding-top: 16px; }
    #dashboard-grid .card-body .btn-secondary { background: #edf5f6; color: #176c73; border: 1px solid #d6e8ea; border-radius: 8px; font-size: .82rem; font-weight: 600; padding: 6px 14px; }
    #dashboard-grid .card-body .btn-secondary:hover { background: #176c73; color: #fff; border-color: #176c73; }
    #dashboard-grid .text-left.mt-4, #dashboard-grid .text-center.mt-4 { margin-top: 6px !important; color: #778596; font-size: .91rem; line-height: 1.6; }
    #dashboard-grid hr { border-color: #edf1f5; }
    #config-toggle { border: 1px solid #dce5ec; background: #fff; color: #3c566c; border-radius: 10px; padding: 9px 14px; font-size: .86rem; font-weight: 600; white-space: nowrap; cursor: pointer; }
    #config-toggle:hover { background: #edf5f6; }
    #config-panel { position: fixed; top: 80px; right: -300px; width: 280px; max-width: calc(100vw - 24px); max-height: calc(100vh - 100px); overflow-y: auto; padding: 22px; background: #fff; border: 1px solid #dce5ec; border-radius: 14px 0 0 14px; box-shadow: -6px 8px 28px rgba(24,43,64,.12); z-index: 1042; visibility: hidden; transition: right .2s, visibility .2s; }
    #config-panel.open { right: 0; visibility: visible; }
    #config-panel .config-heading { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    #config-close { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; flex-shrink: 0; padding: 0; border: 0; border-radius: 7px; background: #edf2f6; color: #3c566c; font-size: 1.35rem; cursor: pointer; }
    #config-close:hover { background: #dce5ec; }
    #config-close:focus-visible { outline: 3px solid #176c73; outline-offset: 2px; }
    #config-panel label { display: block; font-size: .85rem; font-weight: 600; margin-top: 20px; }
    #config-panel input[type=range] { width: 100%; accent-color: #176c73; }
    #col-display { font-size: .78rem; color: #718096; }
    #color-swatches { display: flex; flex-wrap: wrap; gap: 9px; margin-top: 10px; }
    #color-swatches .swatch { width: 30px; height: 30px; border-radius: 50%; border: 2px solid #fff; outline: 1px solid #e1e8ef; cursor: pointer; }
    #color-swatches .swatch.active { outline: 2px solid #243f56; }
    #config-toggle:focus-visible, #color-swatches .swatch:focus-visible { outline: 3px solid #176c73; outline-offset: 3px; }
    @media (max-width: 575.98px) { #cfsm-dashboard { padding: 0 12px 20px; } #cfsm-dashboard .dashboard-heading { align-items: flex-start; } #cfsm-dashboard .dashboard-heading h1 { font-size: 1.3rem; } #cfsm-dashboard .dashboard-heading p { font-size: .83rem; } #dashboard-grid { gap: 14px; } }
    @media (prefers-reduced-motion: reduce) { #dashboard-grid .pastel-tile, #config-panel { transition: none; } }
    @media print { #config-panel, #config-toggle { display: none !important; } #dashboard-grid { grid-template-columns: repeat(2,minmax(0,1fr)) !important; } #dashboard-grid .pastel-tile { height: auto; break-inside: avoid; box-shadow: none; } #dashboard-grid .card-body { overflow: visible; } }
CSS;
?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<input type="hidden" id="init-cols" value="<?= $settings['dash_cols'] ?? 3 ?>">
<input type="hidden" id="init-color" value="<?= $settings['dash_color'] ?? '#A8D8EA' ?>">
<div class="container-fluid mt-4" id="cfsm-dashboard">
<div class="dashboard-heading"><div><h1>Vue d’ensemble</h1><p>Les informations utiles pour organiser votre journée.</p></div><button type="button" id="config-toggle" aria-controls="config-panel" aria-expanded="false"><i class="fas fa-sliders-h mr-2" aria-hidden="true"></i>Affichage</button></div>

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
        <div class="mb-4">
            <div class="card pastel-tile">
                <div class="card-header card-header-pastel">Commandes</div>
                <div class="card-body">
                    <?php if (!$newInventoryOrders): ?><p class="text-muted">Aucune nouvelle commande.</p><?php endif; ?>
                    <?php foreach ($newInventoryOrders as $newOrder): ?>
                    <p><a href="/inventaireCommandes/view?id=<?= (int)$newOrder['id'] ?>&amp;dashboard=1"><strong>Nouvelle commande : <?= e($newOrder['nom']) ?></strong></a><br>
                    <?= e($newOrder['departement_nom']) ?> — <?= e($newOrder['demandeur']) ?><br><small><?= e(date('d/m/Y H:i', strtotime($newOrder['sent_at']))) ?></small></p>
                    <?php endforeach; ?>
                    <div class="d-flex justify-content-end mt-3"><a class="btn btn-secondary" href="/inventaireCommandes/index">Toutes les commandes</a></div>
                </div>
            </div>
        </div>

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



<div id="config-panel" aria-hidden="true" inert>
    <div class="config-heading">
        <strong>Paramètres affichage</strong>
        <button type="button" id="config-close" aria-label="Fermer les paramètres d’affichage"><span aria-hidden="true">&times;</span></button>
    </div>

    <label>Colonnes par ligne : <span id="col-display">3 par ligne</span></label>
    <input type="range" id="col-slider" min="2" max="6" step="1" value="3">
    <div style="display:flex;justify-content:space-between;font-size:0.75rem;color:#888">
        <span>2</span><span>3</span><span>4</span><span>5</span><span>6</span>
    </div>

    <label>Couleur d’accent :</label>
    <div class="color-swatches" id="color-swatches"></div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
