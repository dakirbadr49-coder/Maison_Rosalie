<?php
declare(strict_types=1);
namespace model;
use PDO;

final class MyPDO extends PDO
{
    private static ?MyPDO $instance = null;
    private function __construct()
    {
        parent::__construct(
            DB_TYPE . ':host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
            DB_LOGIN,
            DB_PWD,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }

    public static function getInstance(): MyPDO
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone(): void
    {
    }
}
