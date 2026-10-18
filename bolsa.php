<?php
require_once __DIR__ . '/includes/store.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    lumbre_verify_csrf();
    $action = (string) ($_POST['action'] ?? '');
    $id = (string) ($_POST['product_id'] ?? '');
    if ($action === 'checkout') {
        $_SESSION['lumbre_flash'] = 'El pago estará disponible pronto.';
    } elseif (isset($productsById[$id])) {
        if ($action === 'remove') {
            unset($_SESSION['lumbre_bag'][$id]);
        } else {
            $quantity = min(99, max(1, (int) ($_POST['quantity'] ?? 1)));
            if ($action === 'increase') $quantity = min(99, $quantity + 1);
            if ($action === 'decrease') $quantity = max(1, $quantity - 1);
            if (in_array($action, ['update', 'increase', 'decrease'], true)) {
                $_SESSION['lumbre_bag'][$id] = $quantity;
            }
        }
    }
    header('Location: bolsa.php', true, 303);
    exit;
}

$items = lumbre_bag_items($productsById);
$subtotal = lumbre_bag_subtotal($items);
$flash = lumbre_take_flash();
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
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="assets/cart.css">
</head>
<body class="cart-page">
    <div class="announcement">Envío gratis a partir de 60 € <span>·</span> Hecho despacio, para durar</div>
    <header class="site-header cart-header">
        <a class="back-link" href="index.php">← <span>Seguir comprando</span></a>
        <a class="wordmark" href="index.php" aria-label="Lumbre, inicio">lumbre<span>.</span></a>
        <a class="bag-button" href="bolsa.php" aria-label="Bolsa de compra">Bolsa <span class="bag-count"><?= lumbre_bag_count() ?></span></a>
    </header>
    <main class="cart-main">
        <div class="cart-title"><p class="eyebrow">Tu selección Lumbre</p><h1>Tu bolsa<span class="cart-title-count"><?= lumbre_bag_count() > 0 ? '(' . lumbre_bag_count() . ')' : '' ?></span></h1></div>
        <div class="cart-layout">
            <section class="cart-items" aria-label="Productos de la bolsa">
                <?php if ($flash !== ''): ?><p class="form-notice" role="status"><?= e($flash) ?></p><?php endif; ?>
                <?php if ($items !== []): ?>
                    <div class="cart-items-heading"><span>Producto</span><span>Acciones</span><span>Total</span></div>
                    <div class="cart-list">
                        <?php foreach ($items as $item): ?>
                            <article class="cart-row">
                                <div class="cart-product">
                                    <img src="<?= e($item['image']) ?>" alt="<?= e($item['name']) ?>">
                                    <div class="cart-product-info">
                                        <h2><?= e($item['name']) ?></h2>
                                        <p><?= e($item['category']) ?></p>
                                        <span class="cart-unit-price"><?= lumbre_money($item['price']) ?> / unidad</span>
                                    </div>
                                </div>
                                <div class="cart-actions">
                                    <form class="quantity-form" method="post" action="bolsa.php">
                                        <input type="hidden" name="csrf_token" value="<?= e(lumbre_csrf_token()) ?>">
                                        <input type="hidden" name="product_id" value="<?= e($item['id']) ?>">
                                        <div class="quantity-control">
                                            <button type="submit" name="action" value="decrease" aria-label="Reducir cantidad de <?= e($item['name']) ?>">−</button>
                                            <input type="number" name="quantity" min="1" max="99" value="<?= $item['quantity'] ?>" aria-label="Cantidad de <?= e($item['name']) ?>">
                                            <button type="submit" name="action" value="increase" aria-label="Aumentar cantidad de <?= e($item['name']) ?>">+</button>
                                        </div>
                                        
                                    </form>
                                    <form class="remove-form" method="post" action="bolsa.php">
                                        <input type="hidden" name="csrf_token" value="<?= e(lumbre_csrf_token()) ?>">
                                        <input type="hidden" name="product_id" value="<?= e($item['id']) ?>">
                                        <button class="remove-item" type="submit" name="action" value="remove">Eliminar</button>
                                    </form>
                                </div>
                                <strong class="line-total"><?= lumbre_money($item['price'] * $item['quantity']) ?></strong>
                            </article>
                        <?php endforeach; ?>
                    </div>
                    <a class="continue-link" href="coleccion.php">← Seguir descubriendo</a>
                <?php else: ?>
                    <div class="cart-empty">
                        <span class="empty-flower">✳</span><h2>Tu bolsa está en calma.</h2><p>Añade una pieza bonita y aparecerá aquí.</p><a class="button button-dark" href="coleccion.php">Descubrir novedades <span>↗</span></a>
                    </div>
                <?php endif; ?>
            </section>
            <aside class="order-summary">
                <h2>Resumen del pedido</h2>
                <div class="summary-row"><span>Subtotal</span><span><?= lumbre_money($subtotal) ?></span></div>
                <div class="summary-row shipping-row"><span>Envío</span><span><?= $subtotal >= 60 && $subtotal > 0 ? 'Gratis' : 'Calculado al finalizar' ?></span></div>
                <p class="shipping-note">Envío gratis a partir de 60 €</p>
                <div class="summary-total"><span>Total</span><strong><?= lumbre_money($subtotal) ?></strong></div>
                <form method="post" action="bolsa.php">
                    <input type="hidden" name="csrf_token" value="<?= e(lumbre_csrf_token()) ?>">
                    <button class="button button-dark checkout-button" type="submit" name="action" value="checkout" <?= $items === [] ? 'disabled' : '' ?>>Continuar con el pedido <span>↗</span></button>
                </form>
                <p class="secure-note">Pago seguro · Hecho con calma</p>
            </aside>
        </div>
    </main>
    <footer class="site-footer"><a class="wordmark" href="index.php">lumbre<span>.</span></a><p>Hecho con calma, en Madrid. © <?= date('Y') ?> Lumbre Estudio</p><a href="mailto:hola@lumbre.example">Hablemos <span>↗</span></a></footer>
</body>
</html>
