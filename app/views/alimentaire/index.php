<?php
$title = 'Alimentaire – Accueil';
$custom_js = <<<JS
// JS spécifique si besoin plus tard
JS;
?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-5">

    <h2 class="mb-4 text-center">🍽️ Module Alimentaire</h2>
    <p class="text-center text-muted mb-5">
        Gestion des menus, saisons et menus spéciaux
    </p>

    <div class="row">

        <!-- Calendrier des saisons -->
        <div class="col-md-3 mb-4">
            <a href="/alimentaire/saison" class="text-decoration-none">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <h3 class="mb-3">🌿</h3>
                        <h5 class="card-title">Saisons</h5>
                        <p class="card-text text-muted">
                            Voir le calendrier des saisons alimentaires
                        </p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Menu du jour -->
        <div class="col-md-3 mb-4">
            <a href="/menu/dailyMenu" class="text-decoration-none">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <h3 class="mb-3">📅</h3>
                        <h5 class="card-title">Menu du jour</h5>
                        <p class="card-text text-muted">
                            Consulter les menus par jour
                        </p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Menu de la semaine -->
        <div class="col-md-3 mb-4">
            <a href="/menu/weeklyMenu" class="text-decoration-none">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <h3 class="mb-3">🗓️</h3>
                        <h5 class="card-title">Menu de la semaine</h5>
                        <p class="card-text text-muted">
                            Vue hebdomadaire des menus
                        </p>
                    </div>
                </div>
            </a>
        </div>
          <!-- Menu de la semaine -->
        <div class="col-md-3 mb-4">
            <a href="/menu/monthlyMenu" class="text-decoration-none">
                <div class="card h-100 shadow-sm text-center">
                    <div class="card-body">
                        <h3 class="mb-3">🗓️</h3>
                        <h5 class="card-title">Menu mensuel</h5>
                        <p class="card-text text-muted">
                            Vue mensuelle des menus
                        </p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Éditer menus réguliers -->
        <div class="col-md-6 mb-4">
            <a href="/menu/edit" class="text-decoration-none">
                <div class="card h-100 shadow-sm text-center border-primary">
                    <div class="card-body">
                        <h3 class="mb-3">✏️</h3>
                        <h5 class="card-title">Éditer les menus reguliers</h5>
                        <p class="card-text text-muted">
                            Modifier les menus réguliers (cycles)
                        </p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Menus uniques -->
        <div class="col-md-6 mb-4">
            <a href="/menuUnique/index" class="text-decoration-none">
                <div class="card h-100 shadow-sm text-center border-warning">
                    <div class="card-body">
                        <h3 class="mb-3">🎉</h3>
                        <h5 class="card-title">Menus uniques</h5>
                        <p class="card-text text-muted">
                            Créer et modifier les menus spéciaux
                        </p>
                    </div>
                </div>
            </a>
        </div>

    </div>

</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
