<?php

namespace Config;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    private const HOST = 'localhost';
    private const DBNAME = 'real_estate_db';
    private const USER = 'root';
    private const PASS = '';

    private function __construct() {}
    private function __clone() {}

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {

            try {
                // First attempt → try to connect normally
                $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::DBNAME . ';charset=utf8mb4';
                self::$instance = new PDO($dsn, self::USER, self::PASS);
            } catch (PDOException $e) {

                // If DB doesn't exist → errno 1049
                if ($e->getCode() === 1049) {
                    self::initializeDatabase();
                } else {
                    die('Database connection failed: ' . $e->getMessage());
                }
            }
        }

        return self::$instance;
    }

    /**
     * Run init.sql to create the database + all tables
     */
    private static function initializeDatabase(): void
    {
        try {
            // Connect without selecting DB
            $dsn = 'mysql:host=' . self::HOST . ';charset=utf8mb4';
            $pdo = new PDO($dsn, self::USER, self::PASS);

            // Load SQL file
            $sqlPath = __DIR__ . '/../init.sql';

            if (!file_exists($sqlPath)) {
                die("init.sql not found at: $sqlPath");
            }

            $sql = file_get_contents($sqlPath);

            // Execute SQL
            $pdo->exec($sql);

            // Now connect to the newly created DB
            $dsnDb = 'mysql:host=' . self::HOST . ';dbname=' . self::DBNAME . ';charset=utf8mb4';
            self::$instance = new PDO($dsnDb, self::USER, self::PASS);
        } catch (PDOException $e) {
            die("Database initialization failed: " . $e->getMessage());
        }
    }
}
