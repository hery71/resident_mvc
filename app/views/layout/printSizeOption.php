<div class="row no-print mb-3 align-items-center">
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
    <div class="col-auto">
        <button class="btn btn-primary mt-2 mt-md-0"
                onclick="window.print()">
            🖨 Imprimer
        </button>
    </div>
</div>