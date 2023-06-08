<?php

include_once("/opt/lampp/htdocs/COM/DbUtils/clsControllerDB.php");

class clsConn {

    private string $cid;
    private clsControllerDb $obj_clsControllerDB;

///////////////////////////////////////////
    public function Logout($pCid) {
        $this -> cid = $pCid;
        $this -> obj_clsControllerDB = new clsControllerDb("sp_sap_user_logout", [$this -> cid]);
        //Eliminamos la cookie
        setcookie("token", "", time() - 3600, "/");
        return $this -> obj_clsControllerDB -> getResponseFromDB();
    }


///////////////////////////////////////////
    public function setCookie($pCid) {
        $this -> cid = $pCid;
        //Creamos la cookie
        setcookie("token",$this -> cid, time() + 3600, "/");
    }
    
}

?>