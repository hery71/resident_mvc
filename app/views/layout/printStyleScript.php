<script>
function setPrintFontSize(size) {
    document
        .getElementById('printable-area')
        .style
        .setProperty('--print-font-size', size);
}
function setOrientation(value) {

    document.getElementById('orientation-style').innerHTML = `
        @media print {
            @page {
                size: ${value};
                margin: 0mm;
            }
        }
    `;
}
function setPrintSettings(valeur) {
    let paper, orientation;
    switch(valeur) {
        case '1':
            paper = 'letter';
            orientation = 'portrait';
            break;
        case '2':
            paper = 'letter';
            orientation = 'landscape';
            break;
        case '3':
            paper = 'legal';
            orientation = 'portrait';
            break;
        case '4':
            paper = 'legal';
            orientation = 'landscape';
            break;
        default:
            paper = 'letter';
            orientation = 'portrait';
    }
    document.getElementById('orientation-style').textContent = `
        @media print {
            @page {
                size: ${paper} ${orientation};
                margin: 10mm;
            }
        }
    `;
}
function toggleColumn(colClass) {
    document.querySelectorAll("." + colClass).forEach(el => {
        el.classList.toggle("hide-col");
    });
}
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  setPrintSettings(document.querySelector('select[onchange*="setPrintSettings"]').value);
});
</script>
<style>

/* =========================
   GLOBAL SCREEN + PRINT
========================= */

#printable-area {
    font-size: 14px; /* écran */
}

table {
    width: 100%;
    table-layout: fixed;
}

th {
    text-align: center;
}

.btn {
    display: inline-block;
    width: auto;
}

.hide-col {
    display: none;
}

/* =========================
   PRINT ONLY
========================= */

@media print {

    .no-print {
        display: none !important;
    }

    body {
        margin: 0;
    }

    .container {
        margin: 0;
        padding: 0;
        max-width: 100%;
    }

    #printable-area {
        margin: 0;
        padding: 0;
        font-size: var(--print-font-size, 14px) !important;
    }

    th, td {
        padding: 3px;
    }
}

</style>
<style id="orientation-style">
@media print {
    @page {
        size: letter portrait;
        margin: 5mm;
    }
}
</style>

