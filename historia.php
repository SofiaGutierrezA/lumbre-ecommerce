<?php
require_once __DIR__ . '/includes/store.php';
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f6f3ed">
    <meta name="description" content="La inspiración detrás de Lumbre: objetos cotidianos, materiales honestos y una vida un poco más lenta.">
    <title>La inspiración de Lumbre — Lumbre</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="assets/story.css">
</head>
<body class="story-page">
    <div class="announcement">Envío gratis a partir de 60 € <span>·</span> Hecho despacio, para durar</div>
    <header class="site-header">
        <details class="mobile-nav">
            <summary class="menu-toggle" aria-label="Abrir menú"><span></span><span></span></summary>
            <div class="mobile-menu"><a href="coleccion.php">Tienda</a><a href="historia.php">Nuestra historia</a></div>
        </details>
        <nav class="nav nav-left" aria-label="Navegación principal">
            <a href="coleccion.php">Tienda</a>
            <a href="historia.php" aria-current="page">Nuestra historia</a>
        </nav>
        <a class="wordmark" href="index.php" aria-label="Lumbre, inicio">lumbre<span>.</span></a>
        <nav class="nav nav-right" aria-label="Acciones">
            <a class="bag-button" href="bolsa.php" aria-label="Ir a la bolsa">Bolsa <span class="bag-count"><?= lumbre_bag_count() ?></span></a>
        </nav>
    </header>
    <main>
        <section class="story-hero">
            <div class="story-hero-copy">
                <p class="eyebrow"><span class="eyebrow-line"></span> La inspiración de Lumbre</p>
                <h1>Una casa no se llena.<br><em>Se siente.</em></h1>
                <p>Empezamos con una pregunta sencilla: ¿y si lo que nos rodea nos ayudara a vivir un poco más despacio?</p>
                <a class="story-scroll" href="#inspiracion">Nuestra inspiración <span>↓</span></a>
            </div>
            <div class="story-hero-image">
                <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=1600&q=90" alt="Un hogar sereno con luz natural y materiales cálidos">
                <span class="story-image-label">Un lugar para volver a ti</span>
            </div>
        </section>
        <section class="inspiration-section" id="inspiracion">
            <div class="inspiration-aside"><span>01 — La idea</span><span class="aside-star">✳</span></div>
            <div class="inspiration-copy">
                <p class="eyebrow">Volver a lo esencial</p>
                <h2>El hogar también<br>puede ser un <em>ritual.</em></h2>
                <p>Lumbre nace de esos momentos pequeños que cambian el tono del día: encender una vela al llegar, poner flores en un jarrón, dejar el teléfono lejos mientras el café se enfría un poco.</p>
                <p>Nos inspiró la idea de que los objetos cotidianos no tienen que ser extraordinarios. Solo tienen que estar hechos con cuidado, gustarnos de verdad y acompañarnos durante mucho tiempo.</p>
            </div>
        </section>
        <section class="story-values">
            <div class="values-photo"><img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1200&q=85" alt="Texturas y objetos naturales en un interior" loading="lazy"></div>
            <div class="values-copy">
                <p class="eyebrow">Lo que nos guía</p>
                <h2>Menos ruido.<br><em>Más sentido.</em></h2>
                <div class="value-item"><span>01</span><div><h3>Materiales que se sienten</h3><p>Nos gustan las superficies honestas, las formas imperfectas y las piezas que ganan carácter con el tiempo.</p></div></div>
                <div class="value-item"><span>02</span><div><h3>Elegir con intención</h3><p>Preferimos una selección pequeña y pensada: cosas útiles, bonitas y fáciles de hacer tuyas.</p></div></div>
                <div class="value-item"><span>03</span><div><h3>El placer de lo cotidiano</h3><p>Creemos que una casa se construye con gestos. Queremos que cada objeto invite a disfrutar uno más.</p></div></div>
            </div>
        </section>
        <section class="story-ending">
            <span class="ending-star">✳</span><p class="eyebrow">Bienvenida a casa</p>
            <h2>Que lo que te rodea<br>te recuerde <em>cómo quieres sentirte.</em></h2>
            <a class="button button-dark" href="coleccion.php">Explorar la colección <span>↗</span></a>
        </section>
    </main>
    <footer class="site-footer"><a class="wordmark" href="index.php">lumbre<span>.</span></a><p>Hecho con calma, en Madrid. © <?= date('Y') ?> Lumbre Estudio</p><a href="mailto:hola@lumbre.example">Hablemos <span>↗</span></a></footer>
</body>
</html>
