<?php

class clsRequest{
   
    function __construct(){
       
    }
/////////////////////////////////////////////////////
    public function Exists(string $pName): bool{
        if (isset($_GET[$pName])){
            return true;
        }else{
            return false;
        }
    }

/////////////////////////////////////////////////////
    public function GetValue(string $pName): mixed{
        if($this->Exists($pName)){
            return $_GET[$pName];
        }
        else{
            return "undefined";
        }
    }
/////////////////////////////////////////////////////
    public function GetUrl() {
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $actual_link;
    }
/////////////////////////////////////////////////////

}


?>