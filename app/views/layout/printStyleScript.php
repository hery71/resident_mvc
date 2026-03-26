<script>
function updateColgroup() {
    const cols = [
        { cls: 'col-1', weight: 8 },
        { cls: 'col-2', weight: 10 },
        { cls: 'col-3', weight: 5 },
        { cls: 'col-4', weight: 4 },
        { cls: 'col-5', weight: 15 },
        { cls: 'col-6', weight: 20 },
        { cls: 'col-7', weight: 10 },
        { cls: 'col-8', weight: 20 },
        { cls: 'col-9', weight: 10 }
    ];

    const visibleCols = cols.filter(col => {
        const th = document.querySelector('th.' + col.cls);
        return th && !th.classList.contains('hide-col');
    });

    const total = visibleCols.reduce((sum, col) => sum + col.weight, 0);

    const colgroup = document.getElementById('dynamic-colgroup');
    if (!colgroup) return;

    colgroup.innerHTML = '';

    visibleCols.forEach(colData => {
        const col = document.createElement('col');
        col.style.width = ((colData.weight / total) * 100) + '%';
        colgroup.appendChild(col);
    });
}
function setPrintFontSize(size) {
    document
        .getElementById('printable-area')
        .style
        .setProperty('--print-font-size', size);
}
function applyPrintStyle(paper, orientation) {
    const style = document.getElementById('orientation-style');
    style.innerHTML = `
        @media print {
            @page {
                size: ${paper} ${orientation};
                margin: 10mm;
            }
        }
    `;
}
function setPrintSettings(valeur) {
    let paper = 'letter';
    let orientation = 'portrait';

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
    }

    applyPrintStyle(paper, orientation);
}
function toggleColumn(colClass) {
    document.querySelectorAll("." + colClass).forEach(el => {
        el.classList.toggle("hide-col");
    });

    updateColgroup(); // ← AJOUT IMPORTANT
}
document.addEventListener('DOMContentLoaded', () => {
  const select = document.querySelector('select[onchange*="setPrintSettings"]');
  if (select) {
      setPrintSettings(select.value);
  }
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

    @page {
        margin: 10mm;
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
        width: 100%;
    }

    th, td {
        padding: 3px;
    }

    .no-print {
        display: none !important;
    }
}
</style>

