<?php
/**
 * Конфигурация подключения к базе данных
 * 
 * Для использования:
 * require_once 'includes/db.php';
 * $db = Database::getInstance();
 */

class Database {
    private static $instance = null;
    private $connection;

    // Конфигурация БД (измените под ваши данные)
    private $host = 'localhost';
    private $dbname = 'akvamed_db';
    private $username = 'root';
    private $password = 'root';
    private $charset = 'utf8mb4';
    private $port = 3306;

    private function __construct() {
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw new Exception("Ошибка подключения к базе данных");
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    // Универсальный метод для выполнения запросов
    public function query($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // Получение одной строки
    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }

    // Получение всех строк
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    // Вставка данных (null-safe, без HY093)
    public function insert($table, $data) {
        $columns      = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($k) => ':' . $k, array_keys($data)));
        $sql          = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";

        $stmt = $this->connection->prepare($sql);
        foreach ($data as $key => $value) {
            $type = is_null($value)  ? PDO::PARAM_NULL
                  : (is_int($value) ? PDO::PARAM_INT
                  :                   PDO::PARAM_STR);
            $stmt->bindValue(':' . $key, $value, $type);
        }
        $stmt->execute();
        return $this->connection->lastInsertId();
    }

    // Обновление данных
    public function update($table, $data, $where, $whereParams) {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "{$key} = :{$key}";
        }
        $setStr = implode(', ', $set);
        $sql = "UPDATE {$table} SET {$setStr} WHERE {$where}";
        $params = array_merge($data, $whereParams);
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    // Удаление данных
    public function delete($table, $where, $params) {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }
}

// Пример использования:
// $db = Database::getInstance();
// $services = $db->fetchAll("SELECT * FROM services WHERE active = 1");
