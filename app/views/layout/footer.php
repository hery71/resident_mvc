    <footer class="bg-light text-center mt-5 py-3">
        <small class="text-muted">
            © <?= date('Y') ?> – Resident MVC
        </small>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <script>
    // Tailles de police
    const fontSizes = {
        's': { screen: '12px', print: '12px' },
        'm': { screen: '14px', print: '14px' },
        'l': { screen: '16px', print: '16px' },
        'xl': { screen: '18px', print: '18px' },
        'tg': { screen: '22px', print: '20px' }
    };

    let currentSize = 'm';

    function setFontSize(size) {
        currentSize = size;

        // Appliquer à l'écran
        document.getElementById('printable-area').style.fontSize = fontSizes[size].screen;

        // Mettre à jour le CSS d'impression
        const style = document.createElement('style');
        style.id = 'print-font-style';
        style.innerHTML = `
            @media print {
                #printable-area {
                    font-size: ${fontSizes[size].print} !important;
                }
            }
        `;

        // Supprimer l'ancien style si existe
        const oldStyle = document.getElementById('print-font-style');
        if (oldStyle) oldStyle.remove();

        // Ajouter le nouveau
        document.head.appendChild(style);

        // Sauvegarder la préférence
        localStorage.setItem('fontSize', size);
    }

    // Charger la taille sauvegardée
    document.addEventListener('DOMContentLoaded', () => {
        const savedSize = localStorage.getItem('fontSize');
        if (savedSize) setFontSize(savedSize);
    });
    <?= $custom_js ?>
    </script>


    </body>
    </html>
