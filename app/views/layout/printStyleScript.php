<script>
function setPrintFontSize(size) {
    document
        .getElementById('printable-area')
        .style
        .setProperty('--print-font-size', size);
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
</style>