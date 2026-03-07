<?php $title = 'Edit Day Off'; 
    $custom_js = <<<'JS'
    // Custom JavaScript can be added here
    document.addEventListener("DOMContentLoaded", function(){
        const startInput = document.querySelector("input[name='startDate']");
        if(!startInput) return;
        startInput.addEventListener("change", function(){
            let d = new Date(this.value);
            if(isNaN(d)) return;
            let day = d.getDay(); // 0 = Sunday
            if(day !== 0){
                d.setDate(d.getDate() - day);
                let sunday = d.toISOString().split('T')[0];
                this.value = sunday;
                alert("Start week adjusted to Sunday: " + sunday);
            }
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

                    </tr>

                    <?php endfor; ?>

                </tbody>

            </table>


            <button class="btn btn-primary mt-2">

                Save

            </button>

        </form>


        <hr>


        <h4 class="mt-4">

            Summary by Service

        </h4>


        <?php foreach($summaryByService as $service => $data): ?>

            <div class="card mb-3">

                <div class="card-header">

                    <strong><?= $service ?></strong>

                </div>


                <div class="card-body">

                    <?php foreach($options['DayOff'] as $code):

                        $count = $data[$code]['count'] ?? 0;
                        $hours = $data[$code]['hours'] ?? 0;

                        $class = in_array($code,['SM','WD'])
                            ? 'text-danger fw-bold'
                            : 'text-primary';

                    ?>

                        <div class="<?= $class ?>">

                            <?= $code ?> <?= $count ?> (<?= $hours ?>)

                        </div>

                    <?php endforeach; ?>


                    <hr>

                    <strong>

                        Total DaysOff :

                        <?= $data['totalDays'] ?? 0 ?>

                        <br>

                        Total HoursOff :

                        <?= $data['totalHours'] ?? 0 ?>

                    </strong>

                </div>

            </div>

        <?php endforeach; ?>


    
<!---------------------FIN DIV PRINCIPAL--------------------->
        </div><!---------------------FIN CARD-BODY--------------------->
    </div><!---------------------FIN CARD-MODERN--------------------->
</div> <!---------------------FIN CONTAINER--------------------->
<?php require __DIR__ . '/../layout/footer.php'; ?>