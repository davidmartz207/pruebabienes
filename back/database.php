<?php
class database {
    public $connected = false;
    public $cnx;

    public function __construct($host, $user, $pass, $name) {

        try {
            $this->cnx = new mysqli($host,$user,$pass,$name);
            $connected = true;
         } catch (mysqli_sql_exception $e) {
            $connected = false;
            throw $e;
         }
    }
}
