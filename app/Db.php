<?php

/**
 * Provide functionality for use PDO with one connection
 */
class Db extends PDO
{
    /**
     * @var PDO Link to connection
     */
    private static $objInstance;

    /**
     * Creates a PDO instance representing a connection to a database
     * @link http://php.net/manual/en/pdo.construct.php
     * @param $dsn
     */
    public function __construct($dsn)
    {
        parent::__construct($dsn);
    }

    /**
     * @static Return PDO connection instance
     * @return PDO Link to connection
     * @throws Exception
     */
    public static function getInstance()
    {
        if (!self::$objInstance) {
            include_once '../config/config.php';
            if (!isset($db)) {
                throw new Exception('Database configuration not found');
            }
            self::$objInstance = new self('pgsql:host=' . $db['host'] . ';dbname=' . $db['database'] . ';user=' . $db['user'] . ';password=' . $db['pass']);
            self::$objInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if (NULL === self::$objInstance) {
                throw new Exception('Could not connect to database');
            }
        }
        return self::$objInstance;
    }
}