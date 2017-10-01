<?php

namespace classes;

class Database
{
    private $host;
    private $username;
    private $password;
    private $dbName;

    public function __construct()
    {
        //You must use your details here in order to connect to database
        $this->host = 'hostname';
        $this->username = 'username';
        $this->password = 'password';
        $this->dbName = 'database';
    }

    public function dbConnect()
    {
        $connection = new \mysqli($this->host, $this->username, $this->password, $this->dbName);

        if (mysqli_connect_error()) {
            die('Connection failed: ' . mysqli_connect_error());
        }

        return $connection;
    }
}
