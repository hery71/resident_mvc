<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <img src="<?= $logoPathPublic ?>" alt="Logo" class="mr-2" style="height: 40px;">
        <a class="navbar-brand" href="/">Resident MVC</a>

        <button class="navbar-toggler" type="button"
                data-toggle="collapse"
                data-target="#mainMenu"
                aria-controls="mainMenu"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainMenu">

            <!-- GAUCHE -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       id="dashboardDropdown"
                       role="button"
                       data-toggle="dropdown">
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
                       data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">
                        Résidents
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/resident">Liste des résidents</a>
                        <a class="dropdown-item" href="/resident/create">Ajouter un résident</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       id="birthdayDropdown"
                       role="button"
                       data-toggle="dropdown">
                        Anniversaires
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/birthday">Anniversaires</a>
                        <a class="dropdown-item" href="/cake/cake_list_order?mois=<?= date('n') ?>&annee=<?= date('Y') ?>">Cake Order List</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        Fêtes
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/Fete/?mois=<?= date('n') ?>&annee=<?= date('Y') ?>"> Liste des fêtes </a>
                        <a class="dropdown-item" href="/Fete/create"> Ajouter fête</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       data-toggle="dropdown">
                        Ménage
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/menage/">Liste Inspections</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       data-toggle="dropdown">
                        Service Alimentaire
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/alimentaire/index">Sommaire Alimentaire</a>
                        <a class="dropdown-item" href="/alimentaire/saison">Cycle saison</a>
                        <a class="dropdown-item" href="/menu/edit">Editer Menu </a>
                        <a class="dropdown-item" href="/menu/dailyMenu">Menu du jour</a>
                        <a class="dropdown-item" href="/menu/weeklyMenu">Menu de la semaine</a>
                        <a class="dropdown-item" href="/menu/monthlyMenu">Menu du Mois</a>
                        <a class="dropdown-item" href="/menu/special">Menu Noel et Fin d année</a>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/menuUnique/index">Menu Unique</a>                       
                        <hr class="dropdown-divider">
                        <a class="dropdown-item" href="/ingredient/edit">Éditer Ingrédients</a>
                        <a class="dropdown-item" href="/preparation/edit">Éditer Preparations</a>
                        <a class="dropdown-item" href="/preparation/hebdomadaire">Préparations Hebdomadaires</a>
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
                       data-toggle="dropdown">
                        Staff
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/staff/liste">Liste des staffs</a>
                        <a class="dropdown-item" href="/staff/create">Ajouter un staff</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#" 
                       data-toggle="dropdown">
                        Paramètres
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/parametres/">Paramètres</a>
                        <a class="dropdown-item" href="/parametres/import">Importer les menus réguliers</a>
                        <a class="dropdown-item" href="/parametres/importSpecial">Importer les menus spéciaux</a>
                        <a class="dropdown-item" href="/parametres/seasonMenu">Menus par saison</a>
                        <a class="dropdown-item" href="/parametres/jsonProcess">Traitement des fichiers JSON</a>
                    </div>
                </li>

            </ul>

            <!-- DROITE -->
            <ul class="navbar-nav ml-auto">

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
