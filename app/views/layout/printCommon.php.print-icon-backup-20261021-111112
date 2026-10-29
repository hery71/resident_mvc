<script>
function updateColgroup() {
    document.querySelectorAll('#printable-area table').forEach(table => {
        const headers = Array.from(table.querySelectorAll('thead tr:first-child > th'));
        if (!headers.length || headers.some(header => header.colSpan !== 1 || header.rowSpan !== 1)) return;
        let group = table.querySelector('colgroup');
        if (!group) {
            group = document.createElement('colgroup');
            table.insertBefore(group, table.querySelector('thead'));
        }
        if (!table.residentPrintWeights) {
            const cols = Array.from(group.children);
            table.residentPrintWeights = headers.map((header, index) => {
                const specified = Number(header.dataset.printWeight);
                const width = (cols[index] && cols[index].style.width) || header.style.width;
                const percentage = width && width.endsWith('%') ? parseFloat(width) : 0;
                return specified > 0 ? specified : percentage > 0 ? percentage : 1;
            });
        }
        const visible = headers.map((header, index) => ({header, weight: table.residentPrintWeights[index]}))
            .filter(column => getComputedStyle(column.header).display !== 'none');
        const total = visible.reduce((sum, column) => sum + column.weight, 0);
        group.replaceChildren(...visible.map(column => {
            const col = document.createElement('col');
            col.style.width = (100 * column.weight / total) + '%';
            return col;
        }));
    });
}
function setPrintFontSize(size) {
    if (!/^(11|12|13|14|15|16|18|20|24|36)px$/.test(size)) return;
    const area = document.getElementById('printable-area');
    if (!area) return;
    area.style.setProperty('--print-font-size', size);
    area.style.setProperty('--print-fit-scale', '1');
}
function applyPrintStyle(paper, orientation) {
    const landscape = orientation === 'landscape';
    const longEdge = paper === 'legal' ? 355.6 : 279.4;
    const width = landscape ? longEdge : 215.9;
    const height = landscape ? 215.9 : longEdge;
    let orientationStyle = document.getElementById('orientation-style');
    if (!orientationStyle) {
        orientationStyle = document.createElement('style');
        orientationStyle.id = 'orientation-style';
        document.head.appendChild(orientationStyle);
    }
    orientationStyle.textContent =
        '@page { size: ' + width + 'mm ' + height + 'mm; margin: 10mm; }';
    document.documentElement.style.setProperty('--print-paper-width', (width - 20) + 'mm');
    document.documentElement.style.setProperty('--print-paper-height', (height - 20) + 'mm');
}
window.addEventListener('beforeprint', function () {
    const area = document.getElementById('printable-area');
    if (!area) return;
    updateColgroup();
    area.style.setProperty('--print-fit-scale', '1');
    const fit = document.getElementById('fitPrintPage');
    if (!fit || !fit.checked) return;
    const rootStyle = getComputedStyle(document.documentElement);
    const width = parseFloat(rootStyle.getPropertyValue('--print-paper-width')) * 96 / 25.4;
    const height = parseFloat(rootStyle.getPropertyValue('--print-paper-height')) * 96 / 25.4;
    if (!(width > 0 && height > 0)) return;
    const probe = area.cloneNode(true);
    probe.querySelectorAll('.no-print').forEach(element => element.remove());
    probe.style.cssText = 'position:absolute;left:-100000px;top:0;visibility:hidden;margin:0!important;padding:0!important;max-width:none!important';
    document.body.appendChild(probe);
    let scale = 1;
    const fontSize = parseFloat(getComputedStyle(area).fontSize);
    const minimumScale = Math.min(1, 11 / fontSize);
    probe.style.setProperty('width', width + 'px', 'important');
    for (let i = 0; i < 10; i++) {
        probe.style.setProperty('font-size', (fontSize * scale) + 'px', 'important');
        const usedHeight = probe.getBoundingClientRect().height;
        if (usedHeight <= height * 0.98) break;
        const nextScale = Math.max(minimumScale, scale * height * 0.98 / usedHeight);
        if (nextScale === scale) break;
        scale = nextScale;
    }
    probe.remove();
    area.style.setProperty('--print-fit-scale', String(scale));
});
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
  setPrintSettings(select ? select.value : '1');
  const font = document.querySelector('select[onchange*="setPrintFontSize"]');
  setPrintFontSize(font ? font.value : '14px');
  updateColgroup();
});
window.addEventListener('afterprint', function () {
    const area = document.getElementById('printable-area');
    if (area) area.style.setProperty('--print-fit-scale', '1');
});
</script>
<style>
#printable-area { font-size: var(--print-font-size, 14px); transition: none !important; }
#printable-area table { width: 100% !important; table-layout: fixed; }
#printable-area table th, #printable-area table td {
    font-size: inherit !important; overflow-wrap: anywhere; white-space: normal;
    min-width: 0; line-height: 1.15; padding: 3px;
}
.hide-col { display: none !important; }
.maxw-50 { width: 5px; max-width: 5px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
@media print {
    @page { margin: 10mm; }
    .no-print { display: none !important; }
    footer { width: 100%; text-align: center; margin-top: 20px; }
    html, body { width: 100% !important; max-width: none !important; margin: 0 !important; padding: 0 !important; }
    #printable-area {
        box-sizing: border-box; width: 100% !important; max-width: none !important;
        margin: 0 !important; padding: 0 !important;
        font-size: calc(var(--print-font-size, 14px) * var(--print-fit-scale, 1)) !important;
    }
    #printable-area table { max-width: none !important; }
    #printable-area table th, #printable-area table td { font-size: inherit !important; }
    #printable-area thead { display: table-header-group; }
    #printable-area tr { break-inside: avoid; page-break-inside: avoid; }
}
</style>
