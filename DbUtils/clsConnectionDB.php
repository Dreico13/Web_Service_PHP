<?php

include('config.php');
include_once("/opt/lampp/htdocs/COM/Interfaces/ConnectionDbInterface.php");

class clsConnectionDB implements ConnectionDbInterface {
    private $SERVERHOST = SERVERHOST;
    private $SQLDB = SQLDB;
    private $USER = USER;
    private $PASS = PASS;
    public PDO $connectionDB;

//////////////////////////////////////////

    public function __construct() {
        $this -> initConnection();
    }

//////////////////////////////////////////

    public function initConnection() : void {
        try {
            $this -> connectionDB = new PDO("sqlsrv:Server=".$this -> SERVERHOST.";Database=".$this -> SQLDB."",$this -> USER, $this -> PASS);
            //Introducimos el atributo de error que nos puede dar y la posible excepción que puede generar la conexión
            $this -> connectionDB -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (Exception $error) {
            echo "No se ha podido conectar a la bd: ". $error -> getMessage();
        }
    }

//////////////////////////////////////////

    public function getPDODB(): PDO
    {
        return $this -> connectionDB;
    }

}

?>