<?php

/**
 * PortalNilai-SMP3
 * Automatic forwarder to Laravel's public directory
 * Memastikan website langsung terbuka saat diakses melalui http://localhost/portalnilai-smp3
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH)
);

// Jika public/index.php ada, muat langsung
if (file_exists(__DIR__ . '/public/index.php')) {
    require_once __DIR__ . '/public/index.php';
} else {
    header('Location: public/');
    exit;
}
