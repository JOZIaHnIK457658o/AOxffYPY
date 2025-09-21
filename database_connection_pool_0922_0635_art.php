<?php
// 代码生成时间: 2025-09-22 06:35:38
class DatabaseConnectionPool {

    private $connections = [];
    private $config;
    private $poolSize;

    /**
     * Constructor
     * @param array $config Database configuration array
     * @param int $poolSize The size of the connection pool
     */
    public function __construct(array $config, int $poolSize) {
        $this->config = $config;
        $this->poolSize = $poolSize;
        $this->initializePool();
    }

    /**
     * Initialize the connection pool
     */
    private function initializePool() {
        for ($i = 0; $i < $this->poolSize; $i++) {
            $this->connections[$i] = $this->createConnection();
        }
    }

    /**
     * Create a new database connection
     * @return PDO The new database connection
     */
    private function createConnection() {
        try {
            $dsn = "mysql:host=" . $this->config['host'] . ";dbname=" . $this->config['dbname'];
            $pdo = new PDO($dsn, $this->config['username'], $this->config['password']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            throw new Exception("Failed to create database connection: " . $e->getMessage());
        }
    }

    /**
     * Get a connection from the pool
     * @return PDO The connection from the pool
     */
    public function getConnection() {
        if (empty($this->connections)) {
            throw new Exception("Connection pool is empty");
        }

        return array_shift($this->connections);
    }

    /**
     * Release a connection back to the pool
     * @param PDO $connection The connection to release
     */
    public function releaseConnection(PDO $connection) {
        if (count($this->connections) < $this->poolSize) {
            $this->connections[] = $connection;
        } else {
            // Optionally, close the connection if the pool is full
            $connection = null;
        }
    }
}
