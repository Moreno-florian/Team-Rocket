<?php

class Dao
{
    private static $_connection;

    private static function dbConnection(): void
    {
        try {

            self::$_connection = new PDO('mysql:host=localhost:3308; dbname=celadopole', 'root', '');  // To connect to DB with the host name , DB name , user name and password.
            self::$_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    // To prepare errors
            self::$_connection->exec('set names UTF8'); // To let the browser manage UTF8.

        } catch (Exception $e) {
            echo ('Erreur : ' . $e->getMessage() . ' ! ');   // Send the error message.		
        }
    }

    public static function getConnection(): object
    {
        self::dbConnection();
        return self::$_connection;
    }
}
