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
                margin: 10mm;
            }
        }
    `;
}
</script>
<style>
    @media print {
        .no-print {
            display: none;
        }

        #printable-area {
            font-size: var(--print-font-size, 14px) !important;
        }
    }
    /* écran */
    #printable-area {
        font-size: 14px;
    }

    .btn {
        display: inline-block;
        width: auto;
    }
    th {
    text-align: center;
}
    
</style>
<style id="orientation-style">
@media print {
    @page {
        size: portrait;
        margin: 10mm;
    }
}
</style>
