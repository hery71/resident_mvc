<div class="row no-print mb-3 align-items-center">

    <!-- Taille police -->
    <div class="col-4 col-md-3">
        <label class="mb-0 mr-2">Taille police :</label>
        <select class="form-control form-control-sm"
                onchange="setPrintFontSize(this.value)">
            <option value="12px">12</option>
            <option value="13px">13</option>
            <option value="14px" selected>14</option>
            <option value="15px">15</option>
            <option value="16px">16</option>
            <option value="18px">18</option>
            <option value="20px">20</option>
            <option value="24px">24</option>
            <option value="36px">36</option>
        </select>
    </div>

    <!-- Orientation -->
    <div class="col-4 col-md-3">
        <label class="mb-0 mr-2">Orientation :</label>
        <select class="form-control form-control-sm"
                onchange="setOrientation(this.value)">
            <option value="portrait" selected>Portrait</option>
            <option value="landscape">Paysage</option>
        </select>
    </div>
    <!-- Afficher/ Masquer colonnes -->
    <div class="col-4 col-md-3">
        <label class="mb-0 mr-2">Afficher/ Masquer colonnes :</label>
        <select class="form-control form-control-sm"
                onchange="setOrientation(this.value)">
            <?php
            $colonnesArray = json_decode($colonnes, true);
            foreach ($colonnesArray as $colName => $colIndex) {
                echo '<option value="' . $colIndex . '" selected>' . $colName . '</option>';
            }    
            ?>
        </select>
    </div>
    <!-- Bouton imprimer -->
    <div class="col-auto">
        <button class="btn btn-primary mt-2 mt-md-0"
                onclick="window.print()">
            🖨 Imprimer
        </button>
    </div>

</div>
