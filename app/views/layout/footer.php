    <footer class="bg-light text-center mt-5 py-3">
        <small class="text-muted">
            © <?= date('Y') ?> – CFSM v1.7.<?= APP_VERSION_DATE ."(" .APP_VERSION .")" ?>
        </small>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script>
    //Dropdown Menu
    document.querySelectorAll('.dropdown-submenu .dropdown-toggle').forEach(el => {
        el.addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            let menu = this.nextElementSibling;
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        });
    });


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

    // Charger la taille sauvegardée des anciennes pages imprimables.
    document.addEventListener('DOMContentLoaded', () => {
        const savedSize = localStorage.getItem('fontSize');
        if (savedSize && fontSizes[savedSize] && document.getElementById('printable-area')) setFontSize(savedSize);
    });
    <?= $custom_js ?>
    </script>
    <script>
    (function () {
        const decrease = document.getElementById('residentFontDecrease');
        const increase = document.getElementById('residentFontIncrease');
        if (!decrease || !increase) return;
        const levels = [80, 90, 100, 110, 120, 130, 140, 150];
        let percent = 100;
        try {
            const saved = Number(localStorage.getItem('residentTextPercent'));
            if (levels.includes(saved)) percent = saved;
        } catch (error) {}
        const sheet = document.createElement('style');
        document.head.appendChild(sheet);
        const sizes = new Map();
        let index = 0;
        function capture() {
            // Measure with our override disabled, so inherited sizes never compound.
            sheet.disabled = true;
            const measurements = [];
            document.body.querySelectorAll('*').forEach(element => {
                if (element.hasAttribute('data-resident-font') ||
                    element.closest('#residentNavBar') ||
                    ['SCRIPT', 'STYLE', 'LINK', 'SVG', 'PATH'].includes(element.tagName)) return;
                const size = parseFloat(getComputedStyle(element).fontSize);
                if (Number.isFinite(size)) measurements.push([element, size]);
            });
            measurements.forEach(([element, size]) => {
                if (!sizes.has(size)) sizes.set(size, String(index++));
                element.setAttribute('data-resident-font', sizes.get(size));
            });
            sheet.disabled = false;
        }
        function apply() {
            sheet.textContent = percent === 100 ? '' : '@media screen {' +
                Array.from(sizes, ([size, id]) =>
                    '[data-resident-font="' + id + '"]{font-size:' + (size * percent / 100) + 'px !important;}'
                ).join('') + '}';
            decrease.disabled = percent === levels[0];
            increase.disabled = percent === levels[levels.length - 1];
            document.getElementById('residentFontStatus').textContent = 'Taille du texte : ' + percent + ' %';
        }
        function change(direction) {
            percent = levels[Math.max(0, Math.min(levels.length - 1, levels.indexOf(percent) + direction))];
            apply();
            try { localStorage.setItem('residentTextPercent', String(percent)); } catch (error) {}
        }
        decrease.addEventListener('click', () => change(-1));
        increase.addEventListener('click', () => change(1));
        document.addEventListener('DOMContentLoaded', function () {
            capture();
            apply();
            new MutationObserver(records => {
                if (!records.some(record => Array.from(record.addedNodes).some(node => node.nodeType === 1))) return;
                capture();
                apply();
            }).observe(document.body, { childList: true, subtree: true });
        });
    })();
    </script>
    </body>
    </html>


