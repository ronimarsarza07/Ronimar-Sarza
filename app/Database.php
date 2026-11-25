<?php
namespace App;
use PDO;
use PDOException;
final class Database {
    public static function connect(): PDO {
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $name = getenv('DB_NAME') ?: 'finals_crud_db';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: '';
        try { return new PDO("mysql:host={$host};dbname={$name};charset=utf8mb4", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES=>false]); }
        catch (PDOException $e) { http_response_code(500); exit('Hindi makakonekta sa database. Tiyaking tumatakbo ang MySQL at na-import ang database/schema.sql.'); }
    }
}
