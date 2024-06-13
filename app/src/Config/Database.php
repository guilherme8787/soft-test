<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private static $pdo = null;

    public static function getConnection()
    {
        if (self::$pdo === null) {
            $host = getenv('DB_HOST');
            $db = getenv('DB_NAME');
            $user = getenv('POSTGRES_USER');
            $pass = getenv('POSTGRES_PASSWORD');
            $port = "5432";

            try {
                self::$pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }

        return self::$pdo;
    }

    public static function select(string $sql, array $params = [])
    {
        $stmt = self::getConnection()->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindParam($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insert(string $sql, array $params = [])
    {
        return self::execute($sql, $params);
    }

    public static function update(string $sql, array $params = [])
    {
        $stmt = self::getConnection()->prepare($sql);

        foreach ($params as $index => $param) {
            $stmt->bindValue($index, $param);
        }

        return $stmt->execute();
    }

    public static function delete(string $sql, array $params = [])
    {
        return self::execute($sql, $params);
    }

    private static function execute(string $sql, array $params = [])
    {
        $stmt = self::getConnection()->prepare($sql);

        foreach ($params as $index => $param) {
            $stmt->bindValue($index + 1, $param);
        }

        return $stmt->execute();
    }
}
?>
