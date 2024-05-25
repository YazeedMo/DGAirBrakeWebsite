<?php

    require_once '../config/DatabaseConfig.php';

    class DatabaseConnection {

        private static $instance = null;

        private function __construct($host, $database, $username, $password, $charset) {

            $attr = "mysql:host=$host;dbname=$database;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                self::$instance = new PDO($attr, $username, $password, $options);
            } catch (PDOException $e) {
                die('Connection failed: ' . $e->getMessage() . '<br>');
            }
            
        }


        public static function getInstance() {

            if (self::$instance === null) {
                new self(DatabaseConfig::HOST, DatabaseConfig::DATABASE, DatabaseConfig::USERNAME, DatabaseConfig::PASSWORD, DatabaseConfig::CHARSET);
            }

            return self::$instance;

        }

    }

?>