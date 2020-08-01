<?php
  class Db{
    private $host ='localhost';
    private $user = '';
    private $pass = '';
    private $db_name = 'decampo';

    public function connectDB(){
      $mysqlConnect = "mysql:host=$this->host;dbname=$this->db_name";
      $dbConnecion = new PDO($mysqlConnect, $this->user, $this->pass);
      $dbConnecion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $dbConnecion;
    }
  }
