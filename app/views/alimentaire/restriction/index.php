<?php $title = 'Liste des restrictions alimentaires';
    $inspection=  Config::inspection(); 
    $annee = $_GET['annee'] ?? date("Y");
    $listTables = [
            'list_breakfast' => 'Breakfast',
            'list_lunch' => 'Lunch',
            'list_lunch_dessert' => 'Lunch Dessert',
            'list_dinner' => 'Dinner',
            'list_dinner_dessert' => 'Dinner Dessert'
        ];
    $custom_js = <<<JS
    // Custom JavaScript can be added here
    JS;
    $custom_style = <<<CSS
    /* Custom CSS can be added here */
    CSS;
?>
<?php require __DIR__ . '/../../layout/header.php'; ?>
<div class="container center">
    <h3> Liste des Restrictions Alimentatires</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Repas</th>
                <th>Allergène</th>
                <th>Intolérance</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $table => $info): ?>
                <?php foreach ($info['restrictions'] as $restriction): ?>
                    <tr>
                        <td><?= htmlspecialchars($info['label'] . ' - ' . $restriction['meal']) ?></td>
                        <td><?= htmlspecialchars($restriction['allergene']) ?></td>
                        <td><?= htmlspecialchars($restriction['intolerance']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<!---------------------FIN DIV PRINCIPAL--------------------->
</div>
<?php require __DIR__ . '/../../layout/footer.php'; ?>