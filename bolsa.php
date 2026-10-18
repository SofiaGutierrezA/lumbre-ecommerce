<?php
$products = require __DIR__ . '/data/products.php';
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f6f3ed">
    <meta name="description" content="Revisa tu bolsa de Lumbre y prepara tu pedido.">
    <title>Tu bolsa — Lumbre</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="assets/cart.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        window.LUMBRE_PRODUCTS = <?= json_encode(array_map(static fn($product) => array_intersect_key($product, array_flip(['id', 'name', 'category', 'price', 'image'])), $products), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
    </script>
    <script defer src="assets/cart.js"></script>
</head>

<body class="cart-page">
    <div class="announcement">Envío gratis a partir de 60 € <span>·</span> Hecho despacio, para durar</div>
    <header class="site-header cart-header">
        <a class="back-link" href="index.php">← <span>Seguir comprando</span></a>
        <a class="wordmark" href="index.php" aria-label="Lumbre, inicio">lumbre<span>.</span></a>
        <a class="bag-button" href="bolsa.php" aria-label="Bolsa de compra">Bolsa <span class="bag-count">0</span></a>
    </header>
    <main class="cart-main">
        <div class="cart-title">
            <p class="eyebrow">Tu selección Lumbre</p>
            <h1>Tu bolsa<span class="cart-title-count"></span></h1>
        </div>
        <div class="cart-layout">
            <section class="cart-items" aria-label="Productos de la bolsa">
                <div class="cart-items-heading"><span>Producto</span><span>Cantidad</span><span>Total</span></div>
                <div class="cart-list"></div>
                <div class="cart-empty" hidden>
                    <span class="empty-flower">✳</span>
                    <h2>Tu bolsa está en calma.</h2>
                    <p>Añade una pieza bonita y aparecerá aquí.</p><a class="button button-dark" href="index.php#novedades">Descubrir novedades <span>↗</span></a>
                </div>
                <a class="continue-link" href="index.php#novedades">← Seguir descubriendo</a>
            </section>
            <aside class="order-summary">
                <h2>Resumen del pedido</h2>
                <div class="summary-row"><span>Subtotal</span><span class="subtotal">0 €</span></div>
                <div class="summary-row shipping-row"><span>Envío</span><span class="shipping">Calculado al finalizar</span></div>
                <p class="shipping-note">Envío gratis a partir de 60 €</p>
                <div class="summary-total"><span>Total</span><strong class="total">0 €</strong></div>
                <button class="button button-dark checkout-button" type="button">Continuar con el pedido <span>↗</span></button>
                <p class="secure-note">Pago seguro</p>
            </aside>
        </div>
    </main>
    <footer class="site-footer"><a class="wordmark" href="index.php">lumbre<span>.</span></a>
        <p>Hecho con calma, en Madrid. © <?= date('Y') ?> Lumbre Estudio</p><a href="mailto:hola@lumbre.example">Hablemos <span>↗</span></a>
    </footer>
    <div class="toast" role="status" aria-live="polite"></div>
</body>

</html>