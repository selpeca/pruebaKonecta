<?php
class Database
{
    public static function StartUp()
    {
        $pdo = new PDO('mysql:host=' . HOST . ':'.PORT.';dbname=' . DATABASE . ';charset=utf8', USER, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        return $pdo;
    }
}