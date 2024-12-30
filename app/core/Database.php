<?php
/**
 * Database Class
 *
 * This class handles the database connection using the Singleton pattern.
 */
class Database {
    /** @var Database|null The single instance of this class */
    private static $instance = null;
    /** @var mysqli The database connection */
    private $conn;


    /**
     * Private constructor to prevent direct creation of object
     */
    private function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    /**
     * Get the single instance of the Database class
     *
     * @return Database The instance of the Database class
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Get the database connection
     *
     * @return mysqli The database connection
     */
    public function getConnection() {
        return $this->conn;
    }

    /**
     * Execute a SQL query
     *
     * @param string $sql The SQL query to execute
     * @return mysqli_result|bool The result of the query
     */
    public function query($sql) {
        return $this->conn->query($sql);
    }

    /**
     * Prepare a SQL statement
     *
     * @param string $sql The SQL statement to prepare
     * @return mysqli_stmt|false The prepared statement
     */
    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }
}