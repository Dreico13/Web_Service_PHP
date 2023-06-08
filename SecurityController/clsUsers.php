<?php

include_once("/opt/lampp/htdocs/COM/DbUtils/clsControllerDB.php");
include_once __DIR__."/clsConn.php";

class clsUsers {

    private clsControllerDb $obj_clsControllerDB;
    private string $user;
    private string $pwd;
    private string $email;

//////////////////////////////////////////////////////////////
    public function Login($pUser,$pPwd) {
        $this -> user = $pUser;
        $this -> pwd = $pPwd;
        $this -> obj_clsControllerDB = new clsControllerDb("sp_sap_user_login", [$this -> user, $this -> pwd]);
        return $this -> obj_clsControllerDB -> getResponseFromDB();
    }

//////////////////////////////////////////////////////////////
    public function Registration($pEmail, $pPwd, $pUser) {
        $this -> user = $pUser;
        $this -> pwd = $pPwd;
        $this -> email = $pEmail;
        $this -> obj_clsControllerDB = new clsControllerDb("sp_sap_user_register", [$this -> email, $this -> pwd,$this -> user]);
        return $this -> obj_clsControllerDB -> getResponseFromDB();
    }

/////////////////////////////////////////////////////////////
    

}

?>