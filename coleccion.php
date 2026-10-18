<?php
$products = require __DIR__ . '/data/products.php';
function e(string $value): string { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
$clientProducts = array_map(static fn($product) => array_intersect_key($product, array_flip(['id', 'name', 'category', 'price', 'image'])), $products);
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
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="assets/collection.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>window.LUMBRE_PRODUCTS = <?= json_encode($clientProducts, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;</script>
    <script defer src="assets/app.js"></script>
</head>
<body class="collection-page">
    <div class="announcement">Envío gratis a partir de 60 € <span>·</span> Hecho despacio, para durar</div>
    <header class="site-header">
        <button class="icon-button menu-toggle" aria-label="Abrir menú" aria-expanded="false"><span></span><span></span></button>
        <nav class="nav nav-left" aria-label="Navegación principal">
            <a href="index.php#novedades" aria-current="page">Tienda</a>
            <a href="index.php#historia">Nuestra historia</a>
        </nav>
        <a class="wordmark" href="index.php" aria-label="Lumbre, inicio">lumbre<span>.</span></a>
        <nav class="nav nav-right" aria-label="Acciones">
            <form class="search-box" role="search"><span class="search-icon" aria-hidden="true"></span><input class="site-search" type="search" placeholder="Buscar" aria-label="Buscar productos"></form>
            <a class="bag-button" href="bolsa.php" aria-label="Ir a la bolsa">Bolsa <span class="bag-count">0</span></a>
        </nav>
        <div class="mobile-menu">
            <a href="index.php#novedades">Tienda</a><a href="index.php#historia">Nuestra historia</a>
        </div>
    </header>
    <main class="collection-main">
        <div class="collection-intro">
            <p class="eyebrow"><span class="eyebrow-line"></span> Hecho para quedarse</p>
            <h1>Toda la <em>colección.</em></h1>
            <p class="collection-description">Objetos honestos, aromas que abrazan y pequeños rituales para volver a casa.</p>
            <div class="collection-rule"><span>Todos los objetos</span><span><?= count($products) ?> piezas</span></div>
        </div>
        <div class="product-grid collection-grid" id="productos">
            <?php foreach ($products as $index => $product): ?>
                <article class="product-card" data-id="<?= e($product['id']) ?>" style="--card-delay: <?= $index * 70 ?>ms">
                    <a class="product-image <?= e($product['tone']) ?>" href="#productos" aria-label="Ver <?= e($product['name']) ?>">
                        <img src="<?= e($product['image']) ?>" alt="<?= e($product['alt']) ?>" loading="lazy">
                        <?php if ($product['badge'] !== ''): ?><span class="product-badge"><?= e($product['badge']) ?></span><?php endif; ?>
                        <button class="quick-add" type="button" aria-label="Añadir <?= e($product['name']) ?> a la bolsa"><span>+</span> Añadir a la bolsa</button>
                    </a>
                    <div class="product-meta"><div><h2><?= e($product['name']) ?></h2><p><?= e($product['category']) ?></p></div><span class="price"><?= number_format($product['price'], 0, ',', '.') ?> €</span></div>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="collection-note"><span>✳</span> Piezas hechas con intención, para acompañarte mucho tiempo.</div>
    </main>
    <footer class="site-footer"><a class="wordmark" href="index.php">lumbre<span>.</span></a><p>Hecho con calma, en Madrid. © <?= date('Y') ?> Lumbre Estudio</p><a href="mailto:hola@lumbre.example">Hablemos <span>↗</span></a></footer>
    <div class="toast" role="status" aria-live="polite"></div>
</body>
</html>


