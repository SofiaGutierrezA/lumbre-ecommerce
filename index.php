<?php
require_once __DIR__ . '/includes/store.php';
$search = trim((string) ($_GET['q'] ?? ''));
$visibleProducts = array_values(array_filter($products, static function (array $product) use ($search): bool {
    return $search === '' || stripos($product['name'] . ' ' . $product['category'], $search) !== false;
}));
$redirect = 'index.php' . ($search !== '' ? '?q=' . rawurlencode($search) : '') . '#novedades';
lumbre_handle_add_post($redirect);
$flash = lumbre_take_flash();
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
</head>

<body>
    <div class="announcement">Envío gratis a partir de 60 € <span>·</span> Hecho despacio, para durar</div>
    <header class="site-header">
        <details class="mobile-nav">
            <summary class="menu-toggle" aria-label="Abrir menú"><span></span><span></span></summary>
            <div class="mobile-menu"><a href="#novedades">Tienda</a><a href="#historia">Nuestra historia</a></div>
        </details>
        <nav class="nav nav-left" aria-label="Navegación principal">
            <a href="#novedades">Tienda</a>
            <a href="#historia">Nuestra historia</a>
        </nav>
        <a class="wordmark" href="index.php" aria-label="Lumbre, inicio">lumbre<span>.</span></a>
        <nav class="nav nav-right" aria-label="Acciones">
            <form class="search-box" role="search" method="get" action="index.php#novedades">
                <span class="search-icon" aria-hidden="true"></span>
                <input class="site-search" type="search" name="q" placeholder="Buscar" aria-label="Buscar productos" value="<?= e($search) ?>">
            </form>
            <a class="bag-button" href="bolsa.php" aria-label="Ir a la bolsa">Bolsa <span class="bag-count"><?= lumbre_bag_count() ?></span></a>
        </nav>
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
            <p>Menos, pero mejor <span>✳</span></p>
            <p>Materiales naturales <span>✳</span></p>
            <p>Pequeños talleres <span>✳</span></p>
            <p>Hecho para durar <span>✳</span></p>
        </section>

        <section class="new-arrivals section-wrap" id="novedades">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Recién llegados</p>
                    <h2>Novedades <em>con alma.</em></h2>
                </div>
                <a class="text-link" href="coleccion.php">Ver toda la colección <span>↗</span></a>
            </div>
            <?php if ($flash !== ''): ?><p class="form-notice" role="status"><?= e($flash) ?></p><?php endif; ?>
            <?php if ($search !== ''): ?><p class="search-summary">Resultados para “<?= e($search) ?>”</p><?php endif; ?>
            <div class="product-grid" id="productos">
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
                        <div class="product-meta">
                            <div>
                                <h3><?= e($product['name']) ?></h3>
                                <p><?= e($product['category']) ?></p>
                            </div><span class="price"><?= lumbre_money($product['price']) ?></span>
                        </div>
                    </article>
                <?php endforeach; ?>
                <?php if ($search !== '' && $visibleProducts === []): ?><p class="search-empty">No encontramos productos para “<?= e($search) ?>”.</p><?php endif; ?>
            </div>
        </section>

        <section class="story" id="historia">
            <div class="story-image"><img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1200&q=85" alt="Detalle de un espacio natural con objetos artesanales" loading="lazy"></div>
            <div class="story-copy">
                <p class="eyebrow">Una forma de estar</p>
                <h2>Lo cotidiano<br>también merece<br><em>magia.</em></h2>
                <p>Creemos en los objetos que cuentan historias, en los materiales que envejecen bonito y en el placer de hacer las cosas sin prisa.</p><a class="text-link" href="historia.php">Conoce Lumbre <span>↗</span></a>
            </div>
        </section>
    </main>

    <footer class="site-footer"><a class="wordmark" href="#inicio">lumbre<span>.</span></a>
        <p>Hecho con calma, en Madrid. © <?= date('Y') ?> Lumbre Estudio</p><a href="mailto:hola@lumbre.example">Hablemos <span>↗</span></a>
    </footer>
</body>

</html>