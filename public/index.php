<?php
declare(strict_types=1);

use model\MyPDO;

session_start();
require_once __DIR__ . '/../config-dev.php';

// Autoload: model\manager\RecipeManager => /model/manager/RecipeManager.php
spl_autoload_register(function (string $class): void {
    $path = dirname(__DIR__) . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($path)) require_once $path;
});

try {
    $connectPDO = MyPDO::getInstance();
} catch (Throwable $e) {
    http_response_code(500);
    exit('Erreur de connexion à la base de données : ' . htmlspecialchars($e->getMessage()));
}

require_once __DIR__ . '/../controller/publicController.php';

// checking if connection is working
/* echo "Connection OK"; */