<?php
function getDbConnection() {
    $cfg = require __DIR__ . '/config.php';
    $dsn = "mysql:host={$cfg['host']};dbname={$cfg['dbname']};charset={$cfg['charset']}";

    try {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        return new PDO($dsn, $cfg['username'], $cfg['password'], $options);
    } catch (PDOException $e) {
        file_put_contents(__DIR__ . '/db_errors.log', date('c') . " - " . $e->getMessage() . PHP_EOL, FILE_APPEND);
        die("Connection failed. Please check configuration (see db_errors.log for details).");
    }
}