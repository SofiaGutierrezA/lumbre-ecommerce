$(function () {
    const storageKey = 'lumbre-bag';
    const catalog = window.LUMBRE_PRODUCTS || [];
    const euro = amount => new Intl.NumberFormat('es-ES', { style: 'currency', currency: 'EUR', maximumFractionDigits: 0 }).format(amount);
    function readBag() {
        try { return JSON.parse(localStorage.getItem(storageKey) || '[]'); }
        catch (error) { return []; }
    }
    function saveBag(bag) { localStorage.setItem(storageKey, JSON.stringify(bag)); }
    function updateBadge(bag) {
        const count = bag.reduce((sum, item) => sum + item.quantity, 0);
        $('.bag-count').text(count);
    }

    if ($('.product-card').length) {
        const bag = readBag();
        updateBadge(bag);
        $('.quick-add').on('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            const $card = $(this).closest('.product-card');
            const id = String($card.data('id'));
            const product = catalog.find(item => item.id === id);
            if (!product) return;
            const existing = bag.find(item => item.id === id);
            if (existing) existing.quantity += 1;
            else bag.push({ ...product, quantity: 1 });
            saveBag(bag);
            updateBadge(bag);
            const $toast = $('.toast');
            $toast.text(product.name + ' añadido a tu bolsa').addClass('show');
            window.setTimeout(() => $toast.removeClass('show'), 2200);
        });
    }

    if ($('.cart-list').length) {
        let bag = readBag().filter(item => catalog.some(product => product.id === item.id) && Number(item.quantity) > 0);
        function render() {
            bag = bag.map(item => ({ ...item, quantity: Math.max(1, Math.floor(Number(item.quantity) || 1)) }));
            saveBag(bag);
            updateBadge(bag);
            const $list = $('.cart-list').empty();
            let subtotal = 0;
            bag.forEach(item => {
                const product = catalog.find(product => product.id === item.id);
                if (!product) return;
                const lineTotal = product.price * item.quantity;
                subtotal += lineTotal;
                const $row = $('<article class="cart-row"></article>').attr('data-id', item.id);
                const $product = $('<div class="cart-product"></div>');
                $('<img>').attr({ src: product.image, alt: product.name }).appendTo($product);
                const $info = $('<div class="cart-product-info"></div>');
                $('<h2></h2>').text(product.name).appendTo($info);
                $('<p></p>').text(product.category).appendTo($info);
                $('<span class="cart-unit-price"></span>').text(euro(product.price) + ' / unidad').appendTo($info);
                $product.append($info).appendTo($row);
                const $actions = $('<div class="cart-actions"></div>');
                const $quantity = $('<div class="quantity-control"></div>');
                $('<button type="button" class="quantity-minus" aria-label="Reducir cantidad">−</button>').appendTo($quantity);
                $('<input type="number" min="1" max="99" inputmode="numeric" aria-label="Cantidad">').val(item.quantity).appendTo($quantity);
                $('<button type="button" class="quantity-plus" aria-label="Aumentar cantidad">+</button>').appendTo($quantity);
                $actions.append($quantity).append('<button class="remove-item" type="button">Eliminar</button>').appendTo($row);
                $('<strong class="line-total"></strong>').text(euro(lineTotal)).appendTo($row);
                $list.append($row);
            });
            $('.subtotal, .total').text(euro(subtotal));
            $('.cart-title-count').text(bag.length ? '(' + bag.reduce((sum, item) => sum + item.quantity, 0) + ')' : '');
            $('.cart-empty').prop('hidden', bag.length > 0);
            $('.checkout-button').prop('disabled', bag.length === 0);
        }
        function changeQuantity(id, quantity) {
            const item = bag.find(entry => entry.id === id);
            if (!item) return;
            item.quantity = Math.max(1, Math.min(99, Math.floor(Number(quantity) || 1)));
            render();
        }
        $('.cart-list').on('click', '.quantity-minus', function () {
            const $row = $(this).closest('.cart-row');
            const item = bag.find(entry => entry.id === String($row.data('id')));
            if (item) changeQuantity(item.id, item.quantity - 1);
        }).on('click', '.quantity-plus', function () {
            const id = String($(this).closest('.cart-row').data('id'));
            const item = bag.find(entry => entry.id === id);
            if (item) changeQuantity(id, item.quantity + 1);
        }).on('change', 'input[type="number"]', function () {
            changeQuantity(String($(this).closest('.cart-row').data('id')), $(this).val());
        }).on('click', '.remove-item', function () {
            const id = String($(this).closest('.cart-row').data('id'));
            bag = bag.filter(item => item.id !== id);
            render();
        });
        $('.checkout-button').on('click', function () {
            if (bag.length) {
                $('.toast').text('¡Gracias! El proceso de pago estará disponible pronto.').addClass('show');
                window.setTimeout(() => $('.toast').removeClass('show'), 2600);
            }
        });
        render();
    }
});

