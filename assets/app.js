$(function () {
    const storageKey = 'lumbre-bag';
    const catalog = window.LUMBRE_PRODUCTS || [];
    let toastTimer;
    function readBag() {
        try { return JSON.parse(localStorage.getItem(storageKey) || '[]'); }
        catch (error) { return []; }
    }
    function updateBadge() {
        $('.bag-count').text(readBag().reduce((sum, item) => sum + (Number(item.quantity) || 0), 0));
    }
    function showToast(message) {
        const $toast = $('.toast');
        $toast.text(message).addClass('show');
        window.clearTimeout(toastTimer);
        toastTimer = window.setTimeout(() => $toast.removeClass('show'), 2300);
    }

    const $menu = $('.mobile-menu');
    const $menuButton = $('.menu-toggle');
    $menuButton.on('click', function () {
        const isOpen = $menu.hasClass('open');
        $menu.toggleClass('open', !isOpen);
        $menuButton.attr('aria-expanded', String(!isOpen));
        $menuButton.attr('aria-label', isOpen ? 'Abrir menú' : 'Cerrar menú');
    });
    $('.mobile-menu a').on('click', function () {
        $menu.removeClass('open');
        $menuButton.attr('aria-expanded', 'false').attr('aria-label', 'Abrir menú');
    });
    updateBadge();

    $('.quick-add').on('click', function (event) {
        event.preventDefault();
        event.stopPropagation();
        const $card = $(this).closest('.product-card');
        const product = catalog.find(item => item.id === String($card.data('id')));
        if (!product) return;
        const bag = readBag();
        const existing = bag.find(item => item.id === product.id);
        if (existing) existing.quantity += 1;
        else bag.push({ ...product, quantity: 1 });
        localStorage.setItem(storageKey, JSON.stringify(bag));
        updateBadge();
        showToast(product.name + ' añadido a tu bolsa');
    });

    $('.site-search').on('input', function () {
        const rawTerm = $(this).val().trim();
        const term = rawTerm.toLocaleLowerCase('es');
        const $cards = $('.product-grid .product-card');
        let visibleCount = 0;
        $cards.each(function () {
            const matches = !term || $(this).text().toLocaleLowerCase('es').includes(term);
            $(this).toggle(matches);
            if (matches) visibleCount += 1;
        });
        let $empty = $('.search-empty');
        if (!$empty.length && $('.product-grid').length) {
            $empty = $('<p class="search-empty" role="status"></p>').insertAfter($('.product-grid').first());
        }
        $empty.text(term && visibleCount === 0 ? 'No encontramos productos para “' + rawTerm + '”.' : '').toggle(Boolean(term && visibleCount === 0));
    }).on('keydown', function (event) {
        if (event.key === 'Enter') event.preventDefault();
    });
});
