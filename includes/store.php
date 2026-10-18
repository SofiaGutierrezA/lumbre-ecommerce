<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    $sessionDirectory = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'work' . DIRECTORY_SEPARATOR . 'lumbre-sessions';
    if (!is_dir($sessionDirectory) && !mkdir($sessionDirectory, 0700, true) && !is_dir($sessionDirectory)) {
        throw new RuntimeException('No se pudo crear el directorio de sesiones de Lumbre.');
    }
    if (!is_writable($sessionDirectory)) {
        throw new RuntimeException('El directorio de sesiones de Lumbre no permite escritura.');
    }
    ini_set('session.save_path', $sessionDirectory);
    session_start();
}

$products = require __DIR__ . '/../data/products.php';
$productsById = array_column($products, null, 'id');

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function lumbre_money(int|float $amount): string
{
    return number_format($amount, 0, ',', '.') . ' €';
}

function lumbre_bag_count(): int
{
    return array_sum($_SESSION['lumbre_bag'] ?? []);
}

function lumbre_bag_items(array $productsById): array
{
    $items = [];
    foreach ($_SESSION['lumbre_bag'] ?? [] as $id => $quantity) {
        if (isset($productsById[$id]) && $quantity > 0) {
            $items[] = $productsById[$id] + ['quantity' => (int) $quantity];
        }
    }
    return $items;
}

function lumbre_bag_subtotal(array $items): int
{
    return array_sum(array_map(static fn(array $item): int => $item['price'] * $item['quantity'], $items));
}

function lumbre_csrf_token(): string
{
    if (empty($_SESSION['lumbre_csrf'])) {
        $_SESSION['lumbre_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['lumbre_csrf'];
}

function lumbre_verify_csrf(): void
{
    $token = (string) ($_POST['csrf_token'] ?? '');
    if (!hash_equals(lumbre_csrf_token(), $token)) {
        http_response_code(400);
        exit('La sesión del formulario ha caducado. Vuelve a cargar la página e inténtalo de nuevo.');
    }
}

function lumbre_handle_add_post(string $redirect): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ($_POST['action'] ?? '') !== 'add') {
        return;
    }

    lumbre_verify_csrf();
    $id = (string) ($_POST['product_id'] ?? '');
    global $productsById;
    if (isset($productsById[$id])) {
        $quantity = min(99, max(1, (int) ($_POST['quantity'] ?? 1)));
        $_SESSION['lumbre_bag'][$id] = min(99, ($_SESSION['lumbre_bag'][$id] ?? 0) + $quantity);
        $_SESSION['lumbre_flash'] = $productsById[$id]['name'] . ' se ha añadido a tu bolsa.';
    }

    header('Location: ' . $redirect, true, 303);
    exit;
}

function lumbre_take_flash(): string
{
    $message = (string) ($_SESSION['lumbre_flash'] ?? '');
    unset($_SESSION['lumbre_flash']);
    return $message;
}
