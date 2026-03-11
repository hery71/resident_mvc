<?php $title = 'BaseEdit Start Season Week'; 
    $custom_js = <<<'JS'
    // Custom JavaScript can be added here
    JS;
    $custom_style = <<<'CSS'
    /* Custom CSS can be added here */
    CSS;
?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<?php if (!empty($message_error)) : ?>
    <div class="alert alert-danger" role="alert">
        <?= $message_error ?>
    </div>
<?php endif; ?>
<?php if (!empty($message_success)) : ?>
    <div class="alert alert-success" role="alert">
        <?= $message_success ?>
    </div>
<?php endif; ?>
<div class="container mt-4">
    <div class="card-modern">
        <div class="card-header-pastel"><?= $title ?></div>
        <div class="card-body">
            <h3>Edit Start Season Week</h3>
            <!-- ====================== FORM ADD ====================== -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <strong>Add Season Start Week</strong>
                </div>
                <div class="card-body">
              <form method="post" action="/parametres/saveStartSeasonWeek">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Year</label>
                        <select name="annee" class="form-control" required>
                            <option value="">Select</option>
                            <?php
                            $currentYear = date('Y');
                            for ($year = $currentYear - 2; $year <= $currentYear + 5; $year++) {
                                echo "<option value=\"$year\">$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Season</label>
                        <select name="saison" class="form-control" required>
                            <option value="">Select</option>
                            <option value="Winter">Winter</option>
                            <option value="Spring">Spring</option>
                            <option value="Summer">Summer</option>
                            <option value="Fall">Fall</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Start Week</label>
                        <select name="week" class="form-control" required>
                            <option value="1">Week 1</option>
                            <option value="2">Week 2</option>
                            <option value="3">Week 3</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
        </form>
    </div>
</div>
<!-- ====================== END FORM ====================== -->
<!-- ====================== TABLE ====================== -->
<div class="card">
    <div class="card-header bg-light">
        <strong>Registered Season Start Weeks</strong>
    </div>
    <div class="card-body">

        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Season</th>
                    <th>Start Week</th>
                    <th style="width:120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($startWeeks)): ?>
                    <?php foreach ($startWeeks as $row): ?>
                        <tr>
                            <td><?= $row['annee'] ?></td>
                            <td><?= $row['saison'] ?></td>
                            <td>Week <?= $row['week'] ?></td>
                            <td>
                                <a href="/parametres/deleteStartSeasonWeek?id=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this entry?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- ====================== END TABLE ====================== -->
        <form method="post" action="/parametres/saveStartSeasonWeek">

            <div class="row mb-3">
                <div class="col-md-4">
<!---------------------FIN DIV PRINCIPAL--------------------->
        </div><!---------------------FIN CARD-BODY--------------------->
    </div><!---------------------FIN CARD-MODERN--------------------->
</div> <!---------------------FIN CONTAINER--------------------->
<?php require __DIR__ . '/../layout/footer.php'; ?>