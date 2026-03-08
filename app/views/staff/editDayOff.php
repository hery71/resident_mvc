<?php $title = 'Edit Day Off'; 
    $custom_js = <<<'JS'
    // Custom JavaScript can be added here
    document.addEventListener("DOMContentLoaded", function () {
        const staff = document.querySelector("select[name='IdStaff']");
        const start = document.querySelector("input[name='startDate']");

        if (!staff || !start) return;

        function getSunday(dateValue) {
            const d = new Date(dateValue + "T00:00:00");
            if (isNaN(d)) return "";
            const day = d.getDay();
            d.setDate(d.getDate() - day);
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, "0");
            const dayNum = String(d.getDate()).padStart(2, "0");
            return `${year}-${month}-${dayNum}`;
        }

        function reloadPage() {
            const IdStaff = staff.value;
            const sunday = getSunday(start.value);

            if (!IdStaff || !sunday) return;

            if (start.value !== sunday) {
                start.value = sunday;
            }

            const url = new URL(window.location.href);
            url.searchParams.set("IdStaff", IdStaff);
            url.searchParams.set("startDate", sunday);
            window.location.href = url.toString();
        }

        staff.addEventListener("change", function () {
            reloadPage();
        });

        start.addEventListener("change", function () {
            reloadPage();
        });
    });

    document.addEventListener("DOMContentLoaded",function(){
        const staff=document.querySelector("select[name='IdStaff']");
        const start=document.querySelector("input[name='startDate']");
        function reload(){
            const s=staff?staff.value:"";
            const d=start?start.value:"";
            if(!s||!d)return;
            const url=new URL(window.location.href);
            url.searchParams.set("IdStaff",s);
            url.searchParams.set("startDate",d);
            window.location=url.toString();
        }
        if(staff)staff.addEventListener("change",reload);
        if(start)start.addEventListener("change",reload);
    });
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
            <h3> Day Off</h3>
            <form method="POST" action='saveDayOff'>
            <!-- STAFF + WEEK -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Staff</label>
                    <select name="IdStaff" class="form-control">
                        <?php foreach($staffList as $s): ?>
                            <option value="<?= $s['id'] ?>"
                                <?= ($IdStaff==$s['id'])?'selected':'' ?>>
                                <?= e($s['prenom'].' '.$s['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Start Week (Sunday)</label>
                    <input
                        type="date"
                        name="startDate"
                        value="<?= $startDate ?>"
                        class="form-control">
                </div>
            </div>
            <!-- TABLE 14 DAYS -->
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Day</th>
                        <th>DayOff</th>
                        <th>Hour</th>
                        <th>Observation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $start = new DateTime($startDate);
                        for($i=0;$i<14;$i++):
                            $d = clone $start;
                            $d->modify("+$i day");
                            $dateStr = $d->format('Y-m-d');
                            $dayName = $d->format('l');
                            $offValue  = $existingOff[$dateStr]['off'] ?? '';
                            $hourValue = $existingOff[$dateStr]['hour'] ?? '';
                            $obsValue  = $existingOff[$dateStr]['observation'] ?? '';
                            $idrow    = $existingOff[$dateStr]['id'] ?? 0;      
                    ?>
                    <tr>
                        <td>
                            <?= $dateStr ?>
                            <input
                                type="hidden"
                                name="date[]"
                                value="<?= $dateStr ?>">
                        </td>
                        <td>
                            <?= $dayName ?>
                        </td>
                        <td>
                            <select
                                name="off[]"
                                class="form-control form-control-sm">
                                <option value=""></option>
                                <?php foreach($options['DayOff'] as $off): ?>
                                    <option
                                        value="<?= $off ?>"
                                        <?= ($offValue==$off)?'selected':'' ?>
                                        class="<?= in_array($off,['SM','WD'])?'text-danger fw-bold':'text-primary' ?>">
                                        <?= $off ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select
                                name="hour[]"
                                class="form-control form-control-sm">
                                <option value=""></option>
                                <?php foreach($options['Hour'] as $h): ?>
                                    <option
                                        value="<?= $h ?>"
                                        <?= ($hourValue==$h)?'selected':'' ?>>
                                        <?= $h ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input
                                type="text"
                                name="observation[]"
                                value="<?= e($obsValue) ?>"
                                class="form-control form-control-sm">
                        </td>
                        <td>
                            <a href="/staff/deleteDayOff?Id=<?= $idrow ?>&startDate=<?= $startDate ?>"
                               class="btn btn-sm btn-outline-secondary" onclick=" return confirm('Supprimer ce jour de congé ?');">
                                supprimer
                            </a>
                        </td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
            <button class="btn btn-primary mt-2">
                Save
            </button>
        </form>
        <hr>
        <h4 class="mt-4">Summary by Service</h4>
        <?php foreach ($summaryByStaff as $service => $departements): ?>
        <div class="card mb-3">
            <div class="card-header">
                <strong><?= $service ?></strong>
             </div>
            <div class="card-body">
                <?php foreach ($departements as $departement => $staffs): ?>
                <h4>Departement : <?= $departement ?></h4>
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>SM</th>
                            <th>WD</th>
                            <th>H</th>
                            <th>V</th>
                            <th>F</th>
                            <th>HA</th>
                            <th>CUPE</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $totalSM = 0;
                    $totalWD = 0;
                    $totalH  = 0;
                    $totalV  = 0;
                    $totalF  = 0;
                    $totalHA = 0;
                    $totalCupe = 0;
                    ?>
                    <?php foreach ($staffs as $parts => $offs): 
                    //Exploder id#prenom nom
                    $partsArray = explode('#', $parts);
                    $id_staff = $partsArray[0];
                    $name = $partsArray[1];
                    $sm   = $offs['SM'] ?? 0;
                    $wd   = $offs['WD'] ?? 0;
                    $h    = $offs['H'] ?? 0;
                    $v    = $offs['V'] ?? 0;
                    $f    = $offs['F'] ?? 0;
                    $ha   = $offs['HA'] ?? 0;
                    $cupe = $offs['CUPE'] ?? 0;

                    $totalSM += $sm;
                    $totalWD += $wd;
                    $totalH  += $h;
                    $totalV  += $v;
                    $totalF  += $f;
                    $totalHA += $ha;
                    $totalCupe += $cupe;
                    ?>
                    <tr>
                        <td><?= $name ?></td>
                        <td class="td-offred"><?= $sm ?: '' ?></td>
                        <td class="td-offred"><?= $wd ?: '' ?></td>
                        <td class="td-offblue"><?= $h ?: '' ?></td>
                        <td class="td-offblue"><?= $v ?: '' ?></td>
                        <td class="td-offblue"><?= $f ?: '' ?></td>
                        <td class="td-offblue"><?= $ha ?: '' ?></td>
                        <td><?= $cupe ?: '' ?></td>
                        <td>
                            <a href="/staff/editDayOff?IdStaff=<?= $id_staff ?>&startDate=<?= $startDate ?>"
                               class="btn btn-sm btn-outline-primary">
                                Edit
                            </a>
                            <a href="/staff/printSummaryStaff?IdStaff=<?= $id_staff ?>&startDate=<?= $startDate ?>"
                               class="btn btn-sm btn-outline-secondary" target="_blank">
                                Print
                            </a>
                        </td>
                     </tr>
                 <?php endforeach; ?>
                    <tr class="table-light">
                        <td>Total</td>
                        <td class="td-somme"><?= $totalSM ?></td>
                        <td class="td-somme"><?= $totalWD ?></td>
                        <td class="td-somme"><?= $totalH ?></td>
                        <td class="td-somme"><?= $totalV ?></td>
                        <td class="td-somme"><?= $totalF ?></td>
                        <td class="td-somme"><?= $totalHA ?></td>
                        <td class="td-somme"><?= $totalCupe ?></td>
                    </tr>

                    </tbody>
                </table>
            <?php endforeach; ?>
             </div>
        </div>
        <?php endforeach; ?>
<!---------------------FIN DIV PRINCIPAL--------------------->
        </div><!---------------------FIN CARD-BODY--------------------->
    </div><!---------------------FIN CARD-MODERN--------------------->
</div> <!---------------------FIN CONTAINER--------------------->
<?php require __DIR__ . '/../layout/footer.php'; ?>