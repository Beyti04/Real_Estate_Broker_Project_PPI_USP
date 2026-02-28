<?php
session_start();

const VIEW_DIR = __DIR__ . '/../src/views/';

spl_autoload_register(function ($class) {
    $prefixes = [
        'App\\'    => __DIR__ . '/../src/',
        'Config\\' => __DIR__ . '/../config/'
    ];





    foreach ($prefixes as $prefix => $base_dir) {
        // Проверява дали класът използва този prefix
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }

        // Взима името на класа без prefix-а
        $relative_class = substr($class, $len);

        // Превръща namespace пътя във файлов път (напр. Controllers\AuthController -> Controllers/AuthController.php)
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

        // Ако файлът съществува, го зарежда
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

$action = $_GET['action'] ?? 'homepage';

switch ($action) {
    case 'homepage':
        require VIEW_DIR . 'homepage.php';
        break;
    case 'buy_rent':
        require VIEW_DIR . 'buy_rent.php';
        break;
    //Auth
    case 'login':
        require VIEW_DIR . 'login.php';
        break;
    case 'register':
        require VIEW_DIR . 'register.php';
        break;
    
    default:
        echo "404 Not Found";
        break;
}
