<?php
// Script para reemplazar rutas relativas en require/include por __DIR__ . '/...'

function fix_requires_in_file($file) {
    $content = file_get_contents($file);
    // Reemplaza require_once __DIR__ . '/../algo.php';
    $content = preg_replace(
        "/require_once\\s*['\"](\\.\\.?\\/[^'\"]+)['\"];/",
        "require_once __DIR__ . '/\$1';",
        $content
    );
    // Reemplaza require __DIR__ . '/../algo.php';
    $content = preg_replace(
        "/require\\s*['\"](\\.\\.?\\/[^'\"]+)['\"];/",
        "require __DIR__ . '/\$1';",
        $content
    );
    // Reemplaza include_once __DIR__ . '/../algo.php';
    $content = preg_replace(
        "/include_once\\s*['\"](\\.\\.?\\/[^'\"]+)['\"];/",
        "include_once __DIR__ . '/\$1';",
        $content
    );
    // Reemplaza include __DIR__ . '/../algo.php';
    $content = preg_replace(
        "/include\\s*['\"](\\.\\.?\\/[^'\"]+)['\"];/",
        "include __DIR__ . '/\$1';",
        $content
    );
    file_put_contents($file, $content);
}

function scan_and_fix($dir) {
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($rii as $file) {
        if ($file->isDir()) continue;
        if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            fix_requires_in_file($file->getPathname());
        }
    }
}

scan_and_fix(__DIR__);
echo "¡Listo! Todas las rutas de require/include fueron actualizadas.\n";
?>