<?php
require_once __DIR__ . '/includes/store.php';
$search = trim((string) ($_GET['q'] ?? ''));
$visibleProducts = array_values(array_filter($products, static function (array $product) use ($search): bool {
    return $search === '' || stripos($product['name'] . ' ' . $product['category'], $search) !== false;
}));
$redirect = 'coleccion.php' . ($search !== '' ? '?q=' . rawurlencode($search) : '');
lumbre_handle_add_post($redirect);
$flash = lumbre_take_flash();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f6f3ed">
    <meta name="description" content="Descubre todos los objetos y aromas de Lumbre, hechos con calma para tu hogar.">
    <title>Toda la colección — Lumbre</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="assets/collection.css">
</head>
<body class="collection-page">
    <div class="announcement">Envío gratis a partir de 60 € <span>·</span> Hecho despacio, para durar</div>
    <header class="site-header">
        <details class="mobile-nav">
            <summary class="menu-toggle" aria-label="Abrir menú"><span></span><span></span></summary>
            <div class="mobile-menu"><a href="index.php#novedades">Tienda</a><a href="historia.php">Nuestra historia</a></div>
        </details>
        <nav class="nav nav-left" aria-label="Navegación principal">
            <a href="index.php#novedades" aria-current="page">Tienda</a>
            <a href="historia.php">Nuestra historia</a>
        </nav>
        <a class="wordmark" href="index.php" aria-label="Lumbre, inicio">lumbre<span>.</span></a>
        <nav class="nav nav-right" aria-label="Acciones">
            <form class="search-box" role="search" method="get" action="coleccion.php#productos">
                <span class="search-icon" aria-hidden="true"></span>
                <input class="site-search" type="search" name="q" placeholder="Buscar" aria-label="Buscar productos" value="<?= e($search) ?>">
            </form>
            <a class="bag-button" href="bolsa.php" aria-label="Ir a la bolsa">Bolsa <span class="bag-count"><?= lumbre_bag_count() ?></span></a>
        </nav>
    </header>
    <main class="collection-main">
        <div class="collection-intro">
            <p class="eyebrow"><span class="eyebrow-line"></span> Hecho para quedarse</p>
            <h1>Toda la <em>colección.</em></h1>
            <p class="collection-description">Objetos honestos, aromas que abrazan y pequeños rituales para volver a casa.</p>
            <div class="collection-rule"><span><?= $search !== '' ? 'Resultados de búsqueda' : 'Todos los objetos' ?></span><span><?= count($visibleProducts) ?> piezas</span></div>
        </div>
        <?php if ($flash !== ''): ?><p class="form-notice" role="status"><?= e($flash) ?></p><?php endif; ?>
        <?php if ($search !== ''): ?><p class="search-summary">Resultados para “<?= e($search) ?>”</p><?php endif; ?>
        <div class="product-grid collection-grid" id="productos">
            <?php foreach ($visibleProducts as $product): ?>
                <article class="product-card">
                    <div class="product-image <?= e($product['tone']) ?>">
                        <img src="<?= e($product['image']) ?>" alt="<?= e($product['alt']) ?>" loading="lazy">
                        <?php if ($product['badge'] !== ''): ?><span class="product-badge"><?= e($product['badge']) ?></span><?php endif; ?>
                        <form class="add-form" method="post" action="<?= e($redirect) ?>">
                            <input type="hidden" name="csrf_token" value="<?= e(lumbre_csrf_token()) ?>">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="product_id" value="<?= e($product['id']) ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button class="quick-add" type="submit"><span>+</span> Añadir a la bolsa</button>
                        </form>
                    </div>
                    <div class="product-meta"><div><h2><?= e($product['name']) ?></h2><p><?= e($product['category']) ?></p></div><span class="price"><?= lumbre_money($product['price']) ?></span></div>
                </article>
            <?php endforeach; ?>
            <?php if ($search !== '' && $visibleProducts === []): ?><p class="search-empty">No encontramos productos para “<?= e($search) ?>”.</p><?php endif; ?>
        </div>
        <div class="collection-note"><span>✳</span> Piezas hechas con intención, para acompañarte mucho tiempo.</div>
    </main>
    <footer class="site-footer"><a class="wordmark" href="index.php">lumbre<span>.</span></a><p>Hecho con calma, en Madrid. © <?= date('Y') ?> Lumbre Estudio</p><a href="mailto:hola@lumbre.example">Hablemos <span>↗</span></a></footer>
</body>
</html>
