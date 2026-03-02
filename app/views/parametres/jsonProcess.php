<?php $title = 'Json Processing'; 
    $custom_js = <<<'JS'
    // Custom JavaScript can be added here
    JS;
    $custom_style = <<<'CSS'
    /* Custom CSS can be added here */
    CSS;
?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-4">
    <div class="card-modern">
        <div class="card-header-pastel"><?= $title ?></div>
        <div class="card-body">
            <h3> Json Processing </h3>
            <!-- ===================== CARD 1 ===================== -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <strong>1. Test conformité JSON</strong>
                </div>
                <div class="card-body">

                    <form method="post" action="/parametres/jsonCheck">
                        <div class="form-group mb-3">
                            <textarea 
                                name="json_input" 
                                class="form-control" 
                                rows="10"
                                placeholder="Collez ici votre JSON..."
                            ><?= isset($_POST['json_input']) ? htmlspecialchars($_POST['json_input']) : '' ?></textarea>
                        </div>

                        <button type="submit" name="check_json" class="btn btn-primary">
                            Vérifier JSON
                        </button>
                    </form>
                    <?php   $checkResultMessage = isset($checkResultMessage) ? $checkResultMessage : '';
                            $checkResultClass   = isset($checkResultClass) ? $checkResultClass : 'info'; ?>
                    <?php if ($checkResultMessage): ?>
                        <div class="alert alert-<?= $checkResultClass ?> mt-3">
                            <?= $checkResultMessage ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
            <!-- ===================== FIN CARD 1 ===================== -->

    
<!---------------------FIN DIV PRINCIPAL--------------------->
        </div><!---------------------FIN CARD-BODY--------------------->
    </div><!---------------------FIN CARD-MODERN--------------------->
</div> <!---------------------FIN CONTAINER--------------------->
<?php require __DIR__ . '/../layout/footer.php'; ?>