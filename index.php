<?php
$products = require __DIR__ . '/data/products.php';
function e(string $value): string { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f6f3ed">
    <meta name="description" content="Lumbre: objetos cotidianos para hacer de casa tu lugar favorito.">
    <title>Lumbre — Habita lo que te hace bien</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>window.LUMBRE_PRODUCTS = <?= json_encode(array_map(static fn($product) => array_intersect_key($product, array_flip(['id', 'name', 'category', 'price', 'image'])), $products), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;</script>
    <script defer src="assets/app.js"></script>
</head>
<body>
    <div class="announcement">Envío gratis a partir de 60 € <span>·</span> Hecho despacio, para durar</div>
    <header class="site-header">
        <button class="icon-button menu-toggle" aria-label="Abrir menú" aria-expanded="false"><span></span><span></span></button>
        <nav class="nav nav-left" aria-label="Navegación principal">
            <a href="#novedades">Tienda</a>
            <a href="#historia">Nuestra historia</a>
        </nav>
        <a class="wordmark" href="index.php" aria-label="Lumbre, inicio">lumbre<span>.</span></a>
        <nav class="nav nav-right" aria-label="Acciones">
            <form class="search-box" role="search"><span class="search-icon" aria-hidden="true"></span><input class="site-search" type="search" placeholder="Buscar" aria-label="Buscar productos"></form>
            <a class="bag-button" href="bolsa.php" aria-label="Ir a la bolsa">Bolsa <span class="bag-count">0</span></a>
        </nav>
        <div class="mobile-menu">
            <a href="#novedades">Tienda</a><a href="#historia">Nuestra historia</a>
        </div>
    </header>

    <main id="inicio">
        <section class="hero" aria-labelledby="hero-title">
            <div class="hero-copy">
                <p class="eyebrow"><span class="eyebrow-line"></span> Objetos para vivir más lento</p>
                <h1 id="hero-title">Habita lo que<br>te hace <em>bien.</em></h1>
                <p class="hero-description">Piezas honestas, aromas que abrazan y pequeños rituales para volver a casa.</p>
                <a class="button button-dark" href="#novedades">Descubre la colección <span aria-hidden="true">↗</span></a>
                <div class="hero-note"></div>
            </div>
            <div class="hero-visual">
                <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=1600&q=90" alt="Salón sereno con materiales naturales y luz de tarde">
                <div class="image-caption"><span>La calma empieza en casa</span></div>
                <div class="hero-stamp"><span>objetos<br>con alma</span><i>✳</i></div>
            </div>
            <div class="hero-index">MADRID · DESDE 2021</div>
        </section>

        <section class="values-strip" aria-label="Nuestros valores">
            <p>Menos, pero mejor <span>✳</span></p><p>Materiales naturales <span>✳</span></p><p>Pequeños talleres <span>✳</span></p><p>Hecho para durar <span>✳</span></p>
        </section>

        <section class="new-arrivals section-wrap" id="novedades">
            <div class="section-heading">
                <div><p class="eyebrow">Recién llegados</p><h2>Novedades <em>con alma.</em></h2></div>
                <a class="text-link" href="coleccion.php">Ver toda la colección <span>↗</span></a>
            </div>
            <div class="product-grid" id="productos">
                <?php foreach ($products as $index => $product): ?>
                    <article class="product-card" data-id="<?= e($product['id']) ?>" style="--card-delay: <?= $index * 90 ?>ms">
                        <a class="product-image <?= e($product['tone']) ?>" href="#" aria-label="Ver <?= e($product['name']) ?>">
                            <img src="<?= e($product['image']) ?>" alt="<?= e($product['alt']) ?>" loading="lazy">
                            <?php if ($product['badge'] !== ''): ?><span class="product-badge"><?= e($product['badge']) ?></span><?php endif; ?>
                            <button class="quick-add" type="button" aria-label="Añadir <?= e($product['name']) ?> a la bolsa"><span>+</span> Añadir a la bolsa</button>
                        </a>
                        <div class="product-meta"><div><h3><?= e($product['name']) ?></h3><p><?= e($product['category']) ?></p></div><span class="price"><?= number_format($product['price'], 0, ',', '.') ?> €</span></div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="story" id="historia">
            <div class="story-image"><img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1200&q=85" alt="Detalle de un espacio natural con objetos artesanales" loading="lazy"></div>
            <div class="story-copy"><p class="eyebrow">Una forma de estar</p><h2>Lo cotidiano<br>también merece<br><em>magia.</em></h2><p>Creemos en los objetos que cuentan historias, en los materiales que envejecen bonito y en el placer de hacer las cosas sin prisa.</p><a class="text-link" href="historia.php">Conoce Lumbre <span>↗</span></a></div>
        </section>
    </main>

    <footer class="site-footer"><a class="wordmark" href="#inicio">lumbre<span>.</span></a><p>Hecho con calma, en Madrid. © <?= date('Y') ?> Lumbre Estudio</p><a href="mailto:hola@lumbre.example">Hablemos <span>↗</span></a></footer>
    <div class="toast" role="status" aria-live="polite"></div>
</body>
</html>








