<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Anniversaires des résidents</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="https://resident_mvc.test/assets/css/style.css">

    <?php require __DIR__ . '/../layout/printStyleScript.php'; ?>

    <style>
        .month-title {
            font-size: 16px;
            font-weight: bold;
            background: #eeeeee;
            padding: 5px 8px;
            margin-top: 15px;
            margin-bottom: 0;
            border: 1px solid #999;
        }

        .birthday-table {
            width: 100%;
            margin-bottom: 10px;
        }

        .birthday-table th,
        .birthday-table td {
            padding: 4px 8px;
            border: 1px solid #aaa;
        }

        .birthday-table th {
            font-weight: bold;
            background: #f5f5f5;
        }

        @media print {
            .birthday-month {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }
    </style>

</head>

<body>

<div class="container mt-4" id="printable-area">

    <?php include __DIR__ . '/../layout/printSizeOption.php'; ?>

    <h3 class="mb-4 text-center font-weight-bold">
        ANNIVERSAIRES DES RÉSIDENTS
    </h3>

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

            <table class="table table-sm birthday-table">

                <thead>
                    <tr>
                        <th style="width:40%;">Prénom</th>
                        <th style="width:40%;">Nom</th>
                        <th style="width:20%;">Anniversaire</th>
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
                            <?= (int)$resident['jour'] ?>
                            <?= htmlspecialchars($nomMois) ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>

<?php endforeach; ?>

</div><!-- container -->


<footer class="bg-light text-center mt-5 py-3">
    <small class="text-muted">
        © 2026 – Resident MVC
    </small>
</footer>

</body>
</html>