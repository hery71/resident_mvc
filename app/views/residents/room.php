<?php $title = 'Chambres des résidents'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>
<style>
@media print {
    @page { margin: 15mm; }
    body > :not(#roomPrintArea) { display: none !important; }
    #roomPrintArea { display: block !important; color: #000; font-size: 10pt; }
    #roomPrintArea h1 { font-size: 16pt; margin-bottom: 12pt; }
    #roomPrintArea table { width: 100%; border-collapse: collapse; }
    #roomPrintArea th, #roomPrintArea td { border: 1px solid #777; padding: 4pt 7pt; }
    #roomPrintArea thead { display: table-header-group; }
    #roomPrintArea tr { break-inside: avoid; }
}
</style>

<div class="container mt-4">

    <div class="card-modern">

        <div class="card-header-pastel">
            <?= $title ?>
        </div>

        <div class="card-body">

            <form method="post" action="/resident/update_rooms">

                <table class="table table-sm table-hover" id="residentRoomsTable">

                    <thead>
                        <tr>
                            <th scope="col" aria-sort="none"><button type="button" class="btn btn-link p-0 font-weight-bold text-body" data-room-sort="0">Prénom <span aria-hidden="true">↕</span></button></th>
                            <th scope="col" aria-sort="none"><button type="button" class="btn btn-link p-0 font-weight-bold text-body" data-room-sort="1">Nom <span aria-hidden="true">↕</span></button></th>
                            <th scope="col" aria-sort="none" style="width:250px;"><button type="button" class="btn btn-link p-0 font-weight-bold text-body" data-room-sort="2">Chambre <span aria-hidden="true">↕</span></button></th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($residents as $r): ?>

                        <tr>

                            <td>
                                <?= e($r['Prenom']) ?>
                            </td>

                            <td>
                                <?= e($r['Nom']) ?>
                            </td>

                            <td>
                                <input type="text"
                                       name="chambres[<?= (int)$r['id'] ?>]"
                                       value="<?= e($r['Chambre'] ?? '') ?>"
                                       class="form-control form-control-sm"
                                       style="width:100px;">
                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

                <div class="text-right mt-3">
                    <button type="button" class="btn btn-secondary mr-2" id="printResidentRooms">Imprimer</button>
                    <button type="submit"
                            class="btn btn-primary">
                        💾 Enregistrer
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const table = document.getElementById('residentRoomsTable');
    function preparePrint() {
        document.getElementById('roomPrintArea')?.remove();
        const area = document.createElement('section');
        area.id = 'roomPrintArea';
        area.style.display = 'none';
        const heading = document.createElement('h1');
        heading.textContent = 'Chambres des résidents';
        area.appendChild(heading);
        const copy = table.cloneNode(true);
        copy.removeAttribute('id');
        // Copier les valeurs actuelles, même si elles ne sont pas encore enregistrées.
        const inputs = table.querySelectorAll('input');
        copy.querySelectorAll('input').forEach((input, index) => {
            input.replaceWith(document.createTextNode(inputs[index].value));
        });
        copy.querySelectorAll('button').forEach(button => {
            button.querySelector('span')?.remove();
            button.replaceWith(document.createTextNode(button.textContent.trim()));
        });
        copy.querySelectorAll('[aria-sort]').forEach(cell => cell.removeAttribute('aria-sort'));
        area.appendChild(copy);
        document.body.appendChild(area);
    }
    window.addEventListener('beforeprint', preparePrint);
    window.addEventListener('afterprint', function () {
        document.getElementById('roomPrintArea')?.remove();
    });
    document.getElementById('printResidentRooms').addEventListener('click', function () {
        preparePrint();
        window.print();
    });
    const body = table.tBodies[0];
    const buttons = table.querySelectorAll('[data-room-sort]');
    const collator = new Intl.Collator('fr', { numeric: true, sensitivity: 'base' });
    let activeColumn = null;
    let ascending = true;
    function cellValue(row, column) {
        const cell = row.cells[column];
        const input = cell.querySelector('input');
        return (input ? input.value : cell.textContent).trim();
    }
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const column = Number(button.dataset.roomSort);
            ascending = activeColumn === column ? !ascending : true;
            activeColumn = column;
            const rows = Array.from(body.rows);
            rows.sort((a, b) => {
                const comparison = collator.compare(cellValue(a, column), cellValue(b, column));
                return ascending ? comparison : -comparison;
            });
            // Déplacer les lignes existantes conserve les chambres saisies et leurs IDs.
            rows.forEach(row => body.appendChild(row));
            buttons.forEach(item => {
                const selected = item === button;
                item.closest('th').setAttribute('aria-sort', selected ? (ascending ? 'ascending' : 'descending') : 'none');
                item.querySelector('span').textContent = selected ? (ascending ? '↑' : '↓') : '↕';
            });
        });
    });
});
</script>
<?php require __DIR__ . '/../layout/footer.php'; ?>
