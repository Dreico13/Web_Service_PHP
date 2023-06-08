<?php

include_once __DIR__."/clsUsers.php";
include_once __DIR__."/clsConn.php";

class clsSecurityController {

    private clsUsers $obj_clsUsers;
    private clsConn $obj_clsConn;
    private string $user;
    private string $pwd;
    private string $email;
    private string $cid;

//////////////////////////////////////
    function __construct(string $pUser="",string $pPwd="", string $pEmail = "", string $pCid = "") {
        $this -> obj_clsUsers = new clsUsers();
        $this -> obj_clsConn = new clsConn();
        $this -> user = $pUser;
        $this -> pwd = $pPwd;
        $this -> email = $pEmail;
        $this -> cid = $pCid;
    }

/////////////////////////////////////
    public function doLogin() {
        return $this -> obj_clsUsers -> Login($this -> user, $this -> pwd);
    }

/////////////////////////////////////
    public function doRegistration() {
        return $this -> obj_clsUsers -> Registration($this -> email,$this -> pwd,$this -> user);
    }

//////////////////////////////////////
    public function CreateSession($cid) {
        $this -> obj_clsConn -> setCookie($cid);
    }

//////////////////////////////////////
    public function doLogout() {
        return $this -> obj_clsConn -> Logout($this->cid);
    }
}

?>
