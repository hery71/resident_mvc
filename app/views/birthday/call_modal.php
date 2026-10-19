<!-- Formulaire séparé du formulaire anniversaire. -->
<div class="modal fade" id="birthdayCallModal" tabindex="-1" aria-labelledby="birthdayCallTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="birthdayCallForm" method="post" action="/birthday/saveCall">
                <div class="modal-header">
                    <h5 class="modal-title" id="birthdayCallTitle">Appels à la famille — événement n° <?= e($idBirthday) ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><?= e($resident['Prenom'] ?? '') ?> <?= e($resident['Nom'] ?? '') ?></p>
                    <input type="hidden" name="token" value="<?= e($token) ?>">
                    <input type="hidden" name="id_anniversaire" value="<?= e($idBirthday) ?>">
                    <?php if (!$callNumbers): ?>
                        <p class="alert alert-warning">Aucun numéro enregistré pour ce résident. Ajoutez un numéro à sa fiche pour enregistrer un appel.</p>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="callNumber">Numéro appelé</label>
                        <select class="form-control" id="callNumber" name="numero" required>
                            <option value="">-- Choisir --</option>
                            <?php foreach ($callNumbers as $field => $number): ?>
                                <option value="<?= e($number) ?>" <?= $field === 'Tel' . (int)($resident['Tel_default'] ?? 0) ? 'selected' : '' ?>><?= e($number) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="callState">État de l’appel</label>
                        <select class="form-control" id="callState" name="etat" required>
                            <option value="">-- Choisir --</option>
                            <?php foreach (Config::options()['EtatAppel'] as $state): ?>
                                <option value="<?= e($state) ?>"><?= e($state) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" id="callReminderGroup" hidden>
                        <label for="callReminder">Date et heure du rappel</label>
                        <input type="datetime-local" class="form-control" id="callReminder" name="date_rappel" disabled>
                        <small class="text-muted">Heure locale (Atlantique).</small>
                    </div>
                    <div id="callError" class="alert alert-danger" role="alert" hidden></div>
                    <div id="callSaved" class="alert alert-success" role="status" hidden></div>
                    <hr>
                    <h6>Historique des appels de cet événement</h6>
                    <div id="callHistoryError" class="text-danger" role="status"></div>
                    <p id="callHistoryEmpty" <?= !empty($callLogs) ? 'hidden' : '' ?>>Aucun appel enregistré.</p>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <thead><tr><th>Date et heure</th><th>Utilisateur</th><th>Numéro</th><th>État</th><th>Rappel</th></tr></thead>
                            <tbody id="callHistoryRows">
                                <?php foreach ($callLogs as $log): ?>
                                    <tr>
                                        <td><?= e($log['date_appel']) ?></td>
                                        <td><?= e($log['user_name'] ?? (string)$log['id_user']) ?></td>
                                        <td><?= e($log['numero']) ?></td>
                                        <td><?= e($log['Etat']) ?></td>
                                        <td><?= e($log['date_rappel'] ?? '—') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-info" id="callSubmit" <?= !$callNumbers ? 'disabled' : '' ?>>Enregistrer l’appel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('birthdayCallForm');
    const state = document.getElementById('callState');
    const reminder = document.getElementById('callReminder');
    const group = document.getElementById('callReminderGroup');
    const error = document.getElementById('callError');
    const submit = document.getElementById('callSubmit');
    const saved = document.getElementById('callSaved');
    const history = document.getElementById('callHistoryRows');
    const historyEmpty = document.getElementById('callHistoryEmpty');
    const historyError = document.getElementById('callHistoryError');
    const hasNumbers = <?= $callNumbers ? 'true' : 'false' ?>;
    let saving = false;
    let loadingHistory = false;
    function addLog(log, prepend) {
        const row = document.createElement('tr');
        [log.date_appel, log.user_name || String(log.id_user), log.numero, log.Etat, log.date_rappel || '—'].forEach(value => {
            const cell = document.createElement('td');
            cell.textContent = value;
            row.appendChild(cell);
        });
        if (prepend) history.prepend(row); else history.appendChild(row);
        historyEmpty.hidden = true;
    }
    async function refreshHistory() {
        loadingHistory = true;
        submit.disabled = true;
        historyError.textContent = '';
        try {
            const response = await fetch('/birthday/callHistory?id_anniversaire=' + encodeURIComponent(form.elements.id_anniversaire.value), {
                credentials: 'same-origin', headers: { 'Accept': 'application/json' }
            });
            if (response.redirected) throw new Error('Veuillez vous reconnecter.');
            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Historique indisponible.');
            history.replaceChildren();
            historyEmpty.hidden = data.logs.length > 0;
            data.logs.forEach(log => addLog(log, false));
        } catch (exception) {
            historyError.textContent = 'Impossible d’actualiser l’historique. Les appels déjà affichés sont conservés.';
        } finally {
            loadingHistory = false;
            submit.disabled = saving || !hasNumbers;
        }
    }
    function toggleReminder() {
        const required = state.value === 'À rappeler';
        group.hidden = !required;
        reminder.disabled = !required;
        reminder.required = required;
        if (!required) reminder.value = '';
    }
    state.addEventListener('change', toggleReminder);
    toggleReminder();
    $('#birthdayCallModal').on('show.bs.modal', function () {
        error.hidden = true;
        saved.hidden = true;
        document.getElementById('birthdayCallSuccess').textContent = '';
        refreshHistory();
    }).on('hide.bs.modal', function (event) {
        if (saving) event.preventDefault();
    });
    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        if (saving || loadingHistory || !hasNumbers || !form.reportValidity()) return;
        saving = true;
        submit.disabled = true;
        error.hidden = true;
        saved.hidden = true;
        try {
            const response = await fetch(form.action, {
                method: 'POST', body: new FormData(form), credentials: 'same-origin',
                headers: { 'Accept': 'application/json' }
            });
            if (response.redirected) throw new Error('Veuillez vous reconnecter avant d’enregistrer l’appel.');
            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Impossible d’enregistrer l’appel.');
            document.getElementById('birthdayCallSuccess').textContent = data.message;
            saved.textContent = data.message;
            saved.hidden = false;
            addLog(data.log, true);
            form.reset();
            toggleReminder();
        } catch (exception) {
            error.textContent = exception instanceof SyntaxError || exception instanceof TypeError
                ? 'La réponse du serveur est indisponible. Vérifiez votre connexion avant de réessayer.'
                : exception.message;
            error.hidden = false;
        } finally {
            saving = false;
            submit.disabled = !hasNumbers || loadingHistory;
        }
    });
    <?php if ($openCallModal): ?>
    $('#birthdayCallModal').modal('show');
    <?php endif; ?>
});
</script>
