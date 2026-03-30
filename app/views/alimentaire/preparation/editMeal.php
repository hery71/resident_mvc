<?php $title = "Ajouter ingrédients"; ?>
<?php require __DIR__ . '/../../layout/header.php'; ?>

<div class="container mt-4">
    <div class="card-modern">
        <div class="card-header-pastel">
            <?= $title ?> : <?= htmlspecialchars($meal['meal']) ?>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <label>Nouvel ingrédient</label>
                <input type="text" id="ingredient_input" class="form-control">
            </div>

            <button class="btn btn-primary" onclick="addIngredient()">
                Ajouter
            </button>

            <hr>

            <h5>Ingrédients existants</h5>

            <ul id="ingredient_list">
                <?php
                $items = !empty($meal['ingredients'])
                    ? explode(',', $meal['ingredients'])
                    : [];

                foreach ($items as $i):
                ?>
                    <li><?= htmlspecialchars(trim($i)) ?></li>
                <?php endforeach; ?>
            </ul>

        </div>
    </div>
</div>

<script>
function addIngredient()
{
    let ingredient = document.getElementById("ingredient_input").value.trim();
    let plat = "<?= htmlspecialchars($meal['meal'], ENT_QUOTES) ?>";

    if (!ingredient) {
        alert("Entrer un ingrédient");
        return;
    }

    fetch("index.php?url=preparation/addMealIngredient", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body:
            "plat=" + encodeURIComponent(plat) +
            "&ingredient=" + encodeURIComponent(ingredient)
    })
    .then(r => r.json())
    .then(res => {

        if (res.success) {
            location.reload(); // refresh page
        } else {
            alert(res.message || "Erreur");
        }

    });
}
</script>

<?php require __DIR__ . '/../../layout/footer.php'; ?>