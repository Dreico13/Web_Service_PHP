<?php
/*
Verificar:
- Definición de datos privados en objetos
- Errores y su gestión
- Estrategia de funcionamiento
- Objetos vs tipos convencionales
- Strong typed data
*/
include_once __DIR__."/ServerApi/com/clsRequest.php";
include_once __DIR__."/ServerApi/com/clsServerApi.php";
include_once __DIR__."/ServerApi/com/clsResponse.php";
include_once __DIR__."/SecurityController/clsSecurityController.php";
include_once __DIR__."/Cart/clsCartController.php";



$initTimer = microtime(true);

//////////////////////////////////

$serverApi= new clsServerApi("./ServerApi/xml/dbxml.xml");
$obj_request = new clsRequest();

//////////////////////////////////

$err = $serverApi -> Validate();

//////////////////////////////////

if (count($err) > 0){

    $obj_response = new clsResponse(true, $err, $initTimer);
    $obj_response -> GetResponse(); 

} else {

    $action = $obj_request -> GetValue("action");
       
       switch ($action) {

            case "login":

                if (!isset($_COOKIE["token"])) {

                    $user = $obj_request -> GetValue("user");
                    $pwd = $obj_request -> GetValue("pwd");
        
                    $sc=new clsSecurityController($user,$pwd);
                    
                    //Pasamos el resultado que nos viene del security controller en SimpleXMLElement a array
                    $dbResult = get_object_vars($sc -> doLogin());
                    
                    if ($dbResult["error"] == 0) {
                        $sc -> CreateSession($dbResult["conn_guid"]);
                    }

                    $obj_response = new clsResponse(true,$err,$initTimer,$dbResult);
                    $obj_response -> GetResponse();

                } else {
                    $obj_response = new clsResponse(true,$err,$initTimer,clsErrors::userLoggedError());
                    $obj_response -> GetResponse();
                }
                
                
                break;

            case "logout":

                $cid = $obj_request -> GetValue("cid");
        
                $sc=new clsSecurityController("","","",$cid);

                $dbResult = get_object_vars($sc -> doLogout());

                $obj_response = new clsResponse(true,$err,$initTimer,$dbResult);
                $obj_response -> GetResponse();

                break;
            
            case "register":

                if (!isset($_COOKIE["token"])) {

                    $user = $obj_request -> GetValue("user");
                    $pwd = $obj_request -> GetValue("pwd");
                    $email = $obj_request -> GetValue("email");
                
                    $sc=new clsSecurityController($user,$pwd,$email);

                    $dbResult = get_object_vars($sc -> doRegistration());

                    $obj_response = new clsResponse(true,$err,$initTimer,$dbResult);
                    $obj_response -> GetResponse();

                } else {
                    $obj_response = new clsResponse(true,$err,$initTimer,clsErrors::userLoggedError());
                    $obj_response -> GetResponse();
                }
                
                break;

            case "add_to_cart":

                if (isset($_COOKIE["token"])) {

                    $product_id = $obj_request -> GetValue("product_id");
                    $quantity = $obj_request -> GetValue("quantity");

                    $cart = new clsCartController($product_id,$quantity);

                    $dbResult = get_object_vars($cart -> tryAddToCart());

                    $obj_response = new clsResponse(true,$err,$initTimer,$dbResult);
                    $obj_response -> GetResponse();

                } else {
                    $obj_response = new clsResponse(true,$err,$initTimer,clsErrors::userNotLoggedError());
                    $obj_response -> GetResponse();
                }

                break;
       }
}

die;
/////////////////////////////////////////////


?>