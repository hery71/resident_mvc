<style>
body.resident-nav-layout { padding-top: 64px; padding-left: 280px; }
body.resident-nav-layout.resident-nav-collapsed { padding-left: 76px; }
#residentNavigation {
    position: fixed; inset: 0 auto 0 0; width: 280px; z-index: 1040;
    padding: 20px 14px; overflow-y: auto; display: block;
    background: #172b40; color: #fff; box-shadow: 3px 0 18px rgba(15, 30, 45, .12);
}
#residentNavigation .container-fluid { padding: 0; display: flex; flex-direction: column; align-items: stretch; min-height: 100%; }
#residentNavigation .resident-nav-brand { display: flex; align-items: center; gap: 10px; padding: 4px 8px 22px; }
#residentNavigation .resident-nav-brand img { width: 36px; height: 40px; object-fit: contain; }
#residentNavigation .navbar-brand { font-size: 1.12rem; font-weight: 700; margin: 0; color: #fff; white-space: normal; line-height: 1.3; }
#residentNavigation .resident-nav-content { display: flex; flex-direction: column; flex: 1; }
#residentNavigation .navbar-nav { flex-direction: column; width: 100%; margin: 0 !important; }
#residentNavigation .nav-item { margin-bottom: 5px; }
#residentNavigation .nav-link {
    display: flex; align-items: center; gap: 12px; padding: 11px 12px;
    border-radius: 9px; color: #d8e3ed; font-weight: 600; font-size: .94rem;
}
#residentNavigation .nav-link > i { width: 20px; text-align: center; color: #7dd3ce; flex-shrink: 0; }
#residentNavigation .nav-link:hover, #residentNavigation .nav-link:focus,
#residentNavigation .is-open > .nav-link { background: #263e55; color: #fff; }
#residentNavigation .dropdown-toggle::after { margin-left: auto; flex-shrink: 0; }
#residentNavigation .is-open > .dropdown-toggle::after { transform: rotate(180deg); }
#residentNavigation .dropdown-menu {
    position: static; float: none; display: none; min-width: 0; width: auto;
    margin: 4px 0 10px 12px; padding: 4px 0 4px 12px;
    border: 0; border-left: 1px solid #486176; border-radius: 0;
    background: transparent; box-shadow: none;
}
#residentNavigation .is-open > .dropdown-menu { display: block; }
#residentNavigation .dropdown-item {
    display: block; padding: 8px 10px; color: #d0dde9; white-space: normal;
    border-radius: 6px; font-size: .88rem; line-height: 1.4;
}
#residentNavigation .dropdown-item:hover, #residentNavigation .dropdown-item:focus { color: #fff; background: #304b64; }
#residentNavigation .dropdown-item[aria-current="page"] { color: #fff; background: #146f76; font-weight: 700; }
#residentNavigation .resident-submenu > .dropdown-toggle { display: flex; align-items: center; font-weight: 600; }
#residentNavigation .dropdown-divider { border-top-color: #3a5066; margin: 8px 10px; }
#residentNavigation .resident-nav-account { margin-top: auto !important; padding: 18px 8px 4px; border-top: 1px solid #3a5066; }
#residentNavigation .navbar-text { display: block; margin-bottom: 8px; overflow-wrap: anywhere; }
#residentNavigation .resident-nav-close { display: none; }
#residentNavBar {
    position: fixed; top: 0; right: 0; left: 280px; height: 64px; z-index: 1030;
    display: flex; align-items: center; gap: 15px; padding: 10px 22px;
    background: #fff; border-bottom: 1px solid #e0e7ee; color: #243f56;
}
#residentNavBar .resident-page-title { font-weight: 600; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
#residentNavBar button, #residentNavigation .resident-nav-close {
    border: 1px solid #d4e0e8; border-radius: 8px; background: #f0f5f8;
    color: #243f56; min-width: 40px; min-height: 40px; cursor: pointer;
}
#residentNavBackdrop { display: none; }
#residentNavigation .resident-brand-icon { display: none; }
.resident-nav-collapsed #residentNavigation { width: 76px; padding: 20px 9px; }
.resident-nav-collapsed #residentNavBar { left: 76px; }
.resident-nav-collapsed #residentNavigation .resident-nav-brand { justify-content: center; padding: 4px 0 22px; }
.resident-nav-collapsed #residentNavigation .resident-nav-brand img,
.resident-nav-collapsed #residentNavigation .resident-brand-name,
.resident-nav-collapsed #residentNavigation .resident-nav-label,
.resident-nav-collapsed #residentNavigation .navbar-text,
.resident-nav-collapsed #residentNavigation .nav-link::after { display: none; }
.resident-nav-collapsed #residentNavigation .resident-brand-icon { display: inline; }
.resident-nav-collapsed #residentNavigation .nav-link { justify-content: center; padding: 13px 8px; }
.resident-nav-collapsed #residentNavigation .resident-nav-account { padding: 15px 0 4px; }
.resident-nav-collapsed #residentNavigation .resident-nav-account a { display: block; padding: 10px 5px; }
.resident-nav-collapsed #residentNavigation .navbar-nav.mr-auto > .nav-item > .dropdown-menu { display: none; }
.resident-nav-collapsed #residentNavigation .navbar-nav.mr-auto > .resident-flyout-open > .dropdown-menu {
    display: block; position: fixed; left: 76px; top: 74px;
    width: 300px; max-width: calc(100vw - 90px); max-height: calc(100vh - 90px);
    overflow-y: auto; margin: 0; padding: 12px; background: #172b40;
    border: 1px solid #486176; border-radius: 0 10px 10px 0;
    box-shadow: 6px 6px 20px rgba(15, 30, 45, .2);
}
.resident-nav-collapsed #residentNavigation .resident-flyout-open > .nav-link { background: #146f76; }
#residentNavigation a:focus-visible, #residentNavBar button:focus-visible,
#residentNavigation button:focus-visible { outline: 3px solid #f6c66d; outline-offset: 2px; }
@media (max-width: 991.98px) {
    body.resident-nav-layout { padding-left: 0; }
    #residentNavBar { left: 0; padding: 10px 14px; }
    #residentNavigation { display: none; width: min(310px, 88vw); z-index: 1051; }
    .resident-nav-open #residentNavigation { display: block; }
    .resident-nav-open #residentNavBackdrop { display: block; position: fixed; inset: 0; z-index: 1050; background: rgba(10, 24, 38, .5); }
    body.resident-nav-open { overflow: hidden; }
    #residentNavigation .resident-nav-close { display: inline-block; margin-left: auto; flex-shrink: 0; }
}
@media print {
    body.resident-nav-layout { padding: 0 !important; }
    #residentNavigation, #residentNavBar, #residentNavBackdrop { display: none !important; }
}
</style>
<header id="residentNavBar" class="no-print">
    <button type="button" id="residentNavToggle" aria-controls="residentNavigation" aria-expanded="true" aria-label="Réduire le menu">
        <i class="fas fa-chevron-left" aria-hidden="true"></i>
    </button>
    <span class="resident-page-title"><?= e($title ?? 'CFSM') ?></span>
    <div role="group" aria-label="Taille du texte" style="margin-left:auto;display:flex;gap:6px;flex-shrink:0">
        <button type="button" id="residentFontDecrease" aria-label="Réduire la taille du texte" title="Réduire la taille du texte">A−</button>
        <button type="button" id="residentFontIncrease" aria-label="Augmenter la taille du texte" title="Augmenter la taille du texte">A+</button>
        <span id="residentFontStatus" class="sr-only" role="status" aria-live="polite"></span>
    </div>
</header>
<div id="residentNavBackdrop" aria-hidden="true"></div>
<nav id="residentNavigation" aria-label="Menu principal" class="no-print">
    <div class="container-fluid">
        <div class="resident-nav-brand">
        <?php if (!empty($logoPathPublic)): ?>
        <img src="<?= e($logoPathPublic) ?>" alt="Logo">
        <?php endif; ?>
        <a class="navbar-brand" href="/" aria-label="CFSM — Accueil"><i class="fas fa-home resident-brand-icon" aria-hidden="true"></i><span class="resident-brand-name">CFSM</span></a>
        <button class="resident-nav-close" type="button" aria-label="Fermer le menu">
            <i class="fas fa-times" aria-hidden="true"></i>
        </button>
        </div>

        <div class="resident-nav-content" id="mainMenu">

            <!-- GAUCHE -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       id="dashboardDropdown"
                       role="button"
                       >
                        Dashboard
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/dashboard">Dashboard</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       id="residentDropdown"
                       role="button"
                       
                       aria-haspopup="true"
                       aria-expanded="false">
                        Résidents
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/resident">Liste des résidents</a>
                        <a class="dropdown-item" href="/resident/create">Ajouter un résident</a>
                        <a class="dropdown-item" href="/resident/room">Chambres</a>
                        <a class="dropdown-item" href="/resident/restriction">Restrictions alimentaires</a>
                        <a class="dropdown-item" href="/resident/drinks">Gestions des Boissons des residents</a>
                        <a class="dropdown-item" href="/resident/edit_drinks">Editer Boissons</a>
                        <a class="dropdown-item" href="/resident/unlike_meal">Gérer les plats non appréciés</a>
                        <a class="dropdown-item" href="/resident/resident_menu">Menu du jour par resident</a>
                        <a class="dropdown-item" href="/resident/print_menu">Imprimer menu par résident</a>
                        <a class="dropdown-item" href="/resident/printLabels">Imprimer étiquettes des résident</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                    href="#"
                    >
                        Événements
                    </a>
                    <div class="dropdown-menu">

                        <!-- Sous-menu Anniversaires -->
                        <div class="resident-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Anniversaires</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/birthday/birthdayList">Liste des anniversaires</a>
                                <a class="dropdown-item" href="/birthday">Anniversaires</a>
                                <a class="dropdown-item" href="/cake/cake_list_order?mois=<?= date('n') ?>&annee=<?= date('Y') ?>">Cake Order List</a>
                            </div>
                        </div>

                        <!-- Sous-menu Fêtes -->
                        <div class="resident-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Fêtes</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/Fete/?mois=<?= date('n') ?>&annee=<?= date('Y') ?>">Liste des fêtes</a>
                                <a class="dropdown-item" href="/Fete/create">Ajouter fête</a>
                            </div>
                        </div>

                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       >
                        Ménage
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/menage/">Liste Inspections</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       >
                        Service Alimentaire
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/alimentaire/index">Sommaire Alimentaire</a>
                        <a class="dropdown-item" href="/alimentaire/saison">Cycle saison</a>
                        <a class="dropdown-item" href="/menu/edit">Editer Menu </a>
                        <a class="dropdown-item" href="/menu/searchMeal">Rechercher un plat dans les menus</a>
                        <a class="dropdown-item" href="/menu/dailyMenu">Menu du jour</a>
                        <a class="dropdown-item" href="/menu/weeklyMenu">Menu de la semaine</a>
                        <a class="dropdown-item" href="/menu/menu2weeks">Menu aux 2 semaines</a>
                        <a class="dropdown-item" href="/menu/monthlyMenu">Menu du Mois</a>
                        <a class="dropdown-item" href="/menu/special">Menu Noel et Fin d année</a>
                        <a class="dropdown-item" href="/menuUnique/index">Menu Unique</a>                       
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/meal/mealManager">Gestion des plats</a>
                        <a class="dropdown-item" href="/meal/dayMealManagement">Gestion des plats du jour</a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/ingredient/edit">Éditer Ingrédients</a>
                        <a class="dropdown-item" href="/preparation/mealAddIngredient">Plats sans ingrédients</a>
                        <a class="dropdown-item" href="/preparation/edit">Éditer Preparations</a>
                        <a class="dropdown-item" href="/preparation/hebdomadaire">Préparations Hebdomadaires</a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/order/">Liste des commandes</a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/allergie/edit">Éditer Allergies</a>
                        <a class="dropdown-item" href="/intolerance/edit">Éditer Intolérances</a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/restriction/index">Liste des restrictions Alimentaires</a>
                        <a class="dropdown-item" href="/restriction/edit">Éditer Restrictions Alimentaires</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       >
                        Recettes
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/recette/indexca">Liste des recettes Canada</a>
                        <a class="dropdown-item" href="/recette/indexfr">Liste des recettes France</a>
                    </div>
                </li>
                 <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#" 
                       >
                        Staff
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/staff/liste">Liste des staffs</a>
                        <a class="dropdown-item" href="/staff/create">Ajouter un staff</a>
                        <a class="dropdown-item" href="/staff/editDayOff">Editer jour Congés</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#" 
                       >
                        Inventaire
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/inventaire/index">Inventaire par département</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#">
                        Paramètres
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/parametres/">Paramètres</a>
                        <a class="dropdown-item" href="/parametres/import">Importer les menus réguliers</a>
                        <a class="dropdown-item" href="/parametres/importSpecial">Importer les menus spéciaux</a>
                        <a class="dropdown-item" href="/parametres/seasonMenu">Menus par saison</a>
                        <a class="dropdown-item" href="/parametres/jsonProcess">Traitement des fichiers JSON</a>
                        <a class="dropdown-item" href="/parametres/editStartSeasonWeek">Editer semaine de début de saison</a>
                        <a class="dropdown-item" href="/parametres/seasonDuration">Durée des saisons</a>
                        <a class="dropdown-item" href="/parametres/secondChoice">2ème choix</a>
                    </div>
                </li>

            </ul>

            <!-- DROITE -->
            <ul class="navbar-nav resident-nav-account">

                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item mr-3">
                        <span class="navbar-text text-light">
                            👤 <?= e($_SESSION['user']['login']) ?>
                        </span>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm"
                           href="/auth/logout"
                           onclick="return confirm('Se déconnecter ?');">
                            🚪 Déconnexion
                        </a>
                    </li>
                <?php endif; ?>

            </ul>

        </div>
    </div>
</nav>
<script>
(function () {
    const sidebar = document.getElementById('residentNavigation');
    const toggle = document.getElementById('residentNavToggle');
    const backdrop = document.getElementById('residentNavBackdrop');
    const close = sidebar.querySelector('.resident-nav-close');
    const mobile = window.matchMedia('(max-width: 991.98px)');
    document.body.classList.add('resident-nav-layout');
    let desktopCollapsed = false;
    try { desktopCollapsed = localStorage.getItem('residentMenuCollapsed') === '1'; } catch (error) {}
    const topLinks = Array.from(sidebar.querySelectorAll('.navbar-nav.mr-auto > .nav-item > .nav-link'));
    function closeFlyouts() {
        topLinks.forEach(link => {
            link.parentElement.classList.remove('resident-flyout-open');
            link.setAttribute('aria-expanded', String(!desktopCollapsed || mobile.matches ? link.parentElement.classList.contains('is-open') : false));
            const panel = link.nextElementSibling;
            if (panel) panel.style.top = '';
        });
    }
    function applyLayout() {
        document.body.classList.toggle('resident-nav-collapsed', !mobile.matches && desktopCollapsed);
        const visible = mobile.matches ? document.body.classList.contains('resident-nav-open') : !desktopCollapsed;
        toggle.setAttribute('aria-expanded', String(visible));
        const label = mobile.matches ? (visible ? 'Masquer le menu' : 'Afficher le menu') : (desktopCollapsed ? 'Agrandir le menu' : 'Réduire le menu');
        toggle.setAttribute('aria-label', label);
        toggle.title = label;
        toggle.querySelector('i').className = 'fas ' + (mobile.matches ? 'fa-bars' : (desktopCollapsed ? 'fa-chevron-right' : 'fa-chevron-left'));
        closeFlyouts();
    }
    function closeMobile() {
        document.body.classList.remove('resident-nav-open');
        applyLayout();
    }
    toggle.addEventListener('click', function () {
        if (mobile.matches) {
            document.body.classList.toggle('resident-nav-open');
            applyLayout();
            if (document.body.classList.contains('resident-nav-open')) close.focus();
        } else {
            desktopCollapsed = !desktopCollapsed;
            try { localStorage.setItem('residentMenuCollapsed', desktopCollapsed ? '1' : '0'); } catch (error) {}
            applyLayout();
        }
    });
    [close, backdrop].forEach(element => element.addEventListener('click', function () {
        closeMobile();
        toggle.focus();
    }));
    mobile.addEventListener('change', function () { closeMobile(); });
    const icons = ['fa-chart-line', 'fa-users', 'fa-calendar-alt', 'fa-broom', 'fa-utensils', 'fa-book-open', 'fa-user-tie', 'fa-boxes', 'fa-cog'];
    topLinks.forEach((link, index) => {
        const text = link.textContent.trim();
        const label = document.createElement('span');
        label.className = 'resident-nav-label';
        label.textContent = text;
        link.textContent = '';
        link.appendChild(label);
        link.setAttribute('aria-label', text);
        link.title = text;
        const icon = document.createElement('i');
        icon.className = 'fas ' + (icons[index] || 'fa-folder');
        icon.setAttribute('aria-hidden', 'true');
        link.prepend(icon);
    });
    const logout = sidebar.querySelector('a[href="/auth/logout"]');
    if (logout) {
        logout.textContent = '';
        const icon = document.createElement('i');
        icon.className = 'fas fa-sign-out-alt';
        icon.setAttribute('aria-hidden', 'true');
        const label = document.createElement('span');
        label.className = 'resident-nav-label';
        label.textContent = ' Déconnexion';
        logout.append(icon, label);
        logout.setAttribute('aria-label', 'Déconnexion');
        logout.title = 'Déconnexion';
    }
    sidebar.querySelectorAll('.dropdown-toggle').forEach((link, index) => {
        const panel = link.nextElementSibling;
        if (!panel || !panel.classList.contains('dropdown-menu')) return;
        panel.id = 'residentNavGroup' + index;
        link.setAttribute('role', 'button');
        link.setAttribute('aria-controls', panel.id);
        link.setAttribute('aria-expanded', 'false');
        link.removeAttribute('aria-haspopup');
        link.addEventListener('click', function (event) {
            event.preventDefault();
            if (!mobile.matches && desktopCollapsed && topLinks.includes(link)) {
                const open = !link.parentElement.classList.contains('resident-flyout-open');
                closeFlyouts();
                if (open) {
                    link.parentElement.classList.add('resident-flyout-open');
                    link.setAttribute('aria-expanded', 'true');
                    const desiredTop = link.getBoundingClientRect().top;
                    panel.style.top = Math.max(10, Math.min(desiredTop, window.innerHeight - panel.offsetHeight - 10)) + 'px';
                }
                return;
            }
            const open = link.parentElement.classList.toggle('is-open');
            link.setAttribute('aria-expanded', String(open));
        });
        link.addEventListener('keydown', function (event) {
            if (event.key === ' ') { event.preventDefault(); link.click(); }
        });
    });
    document.addEventListener('click', function (event) {
        if (!sidebar.contains(event.target) && !toggle.contains(event.target)) closeFlyouts();
    });
    window.addEventListener('resize', closeFlyouts);
    sidebar.addEventListener('scroll', closeFlyouts);
    function normalize(path) { return path.replace(/\/+$/, '').toLowerCase() || '/'; }
    const current = normalize(window.location.pathname);
    let selected = null;
    let longest = -1;
    sidebar.querySelectorAll('a.dropdown-item[href]').forEach(link => {
        const href = link.getAttribute('href');
        if (!href.startsWith('/')) return;
        const path = normalize(new URL(href, window.location.origin).pathname);
        const aliases = (current === '/' && path === '/dashboard') || current === path + '/index';
        if ((aliases || current === path || (path !== '/' && current.startsWith(path + '/'))) && path.length > longest) {
            selected = link;
            longest = path.length;
        }
    });
    if (selected) {
        selected.setAttribute('aria-current', 'page');
        let parent = selected.parentElement;
        while (parent && parent !== sidebar) {
            if (parent.classList.contains('dropdown') || parent.classList.contains('resident-submenu')) {
                parent.classList.add('is-open');
                const link = parent.querySelector(':scope > .dropdown-toggle');
                if (link) link.setAttribute('aria-expanded', 'true');
            }
            parent = parent.parentElement;
        }
    }
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && desktopCollapsed && !mobile.matches) {
            const openLink = topLinks.find(link => link.parentElement.classList.contains('resident-flyout-open'));
            closeFlyouts();
            if (openLink) openLink.focus();
        }
        if (!mobile.matches || !document.body.classList.contains('resident-nav-open')) return;
        if (event.key === 'Escape') { closeMobile(); toggle.focus(); }
        if (event.key === 'Tab') {
            const focusable = Array.from(sidebar.querySelectorAll('a[href], button')).filter(element => element.getClientRects().length);
            const first = focusable[0];
            const last = focusable[focusable.length - 1];
            if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
            else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
        }
    });
    applyLayout();
})();
</script>


