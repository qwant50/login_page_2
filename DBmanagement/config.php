<?php

Class GetConnection {
/*    private $mysql_hostname = 'localhost';
    private $mysql_database = 'datar8_AndyGroup';
    private $mysql_user = 'datar8_db_form';
    private $mysql_password = 'db_form';*/

    private $mysql_hostname = 'localhost';
    private $mysql_database = 'AndyGroup';
    private $mysql_user = 'root';
    private $mysql_password = '';
    public function Connect(){
        $mysqli = new mysqli($this->mysql_hostname, $this->mysql_user, $this->mysql_password, $this->mysql_database);
        if ($mysqli->connect_errno) die('Cant connect to MySQL: ' . $mysqli->connect_error);
        return $mysqli;

    }
};

$obj = new GetConnection();
$mysqli = $obj->Connect();

?>





