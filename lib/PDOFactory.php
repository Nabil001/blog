<?php

namespace Library;

class PDOFactory {

    private function __construct() {}
    private function __clone() {}

    public static function getInstance() {
        $parser = new \DOMDocument();
        $parser->load('config/pdo.xml');
        $database = $parser->getElementsByTagName('database')[0];
        $user = $parser->getElementsByTagName('user')[0];
        $pdo = new \PDO('mysql:host='.
                        $database->getAttribute('host').
                        ';dbname='.$database->getAttribute('dbname'),
                        $user->getAttribute('id'),
                        $user->getAttribute('passwd')
                        );
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

}
