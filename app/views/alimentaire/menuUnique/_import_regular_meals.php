<?php foreach ($mealsByTable as $table => $data): ?>
    <h5><?= htmlspecialchars($data['label']) ?></h5>
    <div class="form-check">
        <?php foreach ($data['meals'] as $meal): ?>
            <div class="form-check">
                <input class="form-check-input"
                       type="checkbox"
                       name="<?= htmlspecialchars($table) ?>[]"
                       value="<?= htmlspecialchars($meal) ?>"
                       id="meal_<?= htmlspecialchars($table . '_' . $meal) ?>">
                <label class="form-check-label" for="meal_<?= htmlspecialchars($table . '_' . $meal) ?>">
                    <?= htmlspecialchars($meal) ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
