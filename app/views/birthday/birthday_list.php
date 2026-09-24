<?php
$title = 'Liste des anniversaires';

$custom_js = <<<'JS'
// Custom JavaScript can be added here
JS;

$custom_style = <<<'CSS'

.birthday-month {
    margin-bottom: 30px;
}

.month-title {
    font-size: 1.15rem;
    font-weight: 600;
    padding: 8px 12px;
    margin-bottom: 0;
    background-color: #f2f2f2;
    border-left: 4px solid #6c757d;
}

.birthday-table {
    margin-bottom: 0;
}

.birthday-table th {
    font-weight: 600;
}

.birthday-table td,
.birthday-table th {
    vertical-align: middle;
}

CSS;
?>

<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">

    <div class="card-modern">

        <div class="card-header-pastel">
            <?= htmlspecialchars($title) ?>
        </div>

        <div class="card-body">

            <h3>Anniversaires des résidents</h3>
            <div class="text-right mb-3">
                <a href="/birthday/birthdayListPrint"
                target="_blank"
                class="btn btn-primary">
                    🖨 Imprimer
                </a>
            </div>

            <?php

            $moisLabels = [
                1  => 'Janvier',
                2  => 'Février',
                3  => 'Mars',
                4  => 'Avril',
                5  => 'Mai',
                6  => 'Juin',
                7  => 'Juillet',
                8  => 'Août',
                9  => 'Septembre',
                10 => 'Octobre',
                11 => 'Novembre',
                12 => 'Décembre'
            ];

            // Regrouper les résidents par mois
            $residentsParMois = [];

            foreach ($residents as $resident) {

                $mois = (int)$resident['mois'];

                if (!isset($residentsParMois[$mois])) {
                    $residentsParMois[$mois] = [];
                }

                $residentsParMois[$mois][] = $resident;
            }

            ?>

            <?php foreach ($moisLabels as $numeroMois => $nomMois): ?>

                <?php if (!empty($residentsParMois[$numeroMois])): ?>

                    <div class="birthday-month">

                        <div class="month-title">
                            <?= htmlspecialchars($nomMois) ?>
                        </div>

                        <div class="table-responsive">

                            <table class="table table-striped table-hover birthday-table">

                                <thead>
                                    <tr>
                                        <th>Prénom</th>
                                        <th>Nom</th>
                                        <th>Anniversaire</th>
                                    </tr>
                                </thead>

                                <tbody>

                                <?php foreach ($residentsParMois[$numeroMois] as $resident): ?>

                                    <tr>

                                        <td>
                                            <?= htmlspecialchars($resident['Prenom']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($resident['Nom']) ?>
                                        </td>

                                        <td>
                                            <?php
                                            $jour = (int)$resident['jour'];
                                            echo $jour . ' ' . htmlspecialchars($nomMois);
                                            ?>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                <?php endif; ?>

            <?php endforeach; ?>


<!---------------------FIN DIV PRINCIPAL--------------------->
        </div><!---------------------FIN CARD-BODY--------------------->
    </div><!---------------------FIN CARD-MODERN--------------------->
</div><!---------------------FIN CONTAINER--------------------->

<?php require __DIR__ . '/../layout/footer.php'; ?>