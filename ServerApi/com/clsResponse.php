<?php

include_once __DIR__."/clsRequest.php";
include_once __DIR__."/clsEchos.php";

class clsResponse {

    private array $obj_errors;
    private object $obj_request;
    private bool $responseType;
    private float $initTimer;
    private object $obj_xmlUtils;
    private array $responseData;
    private SimpleXMLElement $xml;

//////////////////////////////////////////////////
    public function __construct(bool $pResponseType, array $pObjectErrors, float $pInitTimer, array $pResponseData = []) {
        $this -> initTimer = $pInitTimer;
        $this -> responseType = $pResponseType;
        $this -> obj_xmlUtils = new clsXMLUtils();
        $this -> obj_request = new clsRequest();
        $this -> obj_errors = $pObjectErrors;
        $this -> responseData = $pResponseData;
        $this -> Init();        
    }
//////////////////////////////////////////////////
    private function Init() {
        $this -> setContents();
    }
//////////////////////////////////////////////////
    private function setHeader() :mixed {
        if ($this -> responseType) {
            return header("Content-type: text/xml");
        }
    }
//////////////////////////////////////////////////
    private function setContents() : void {
        //Comprobamos que sea true para mostrar en formato XML en el navegador web
            $totalTimer = microtime(true)-$this -> initTimer;
            //Introducimos XML
            $xmlstr="<ws_response>
            <head>
                <server_id>1</server_id>
                <server_time>".date("Y-m-d H:i:s")."</server_time>
                <execution_time>".number_format((float)$totalTimer,3,'.','')."</execution_time>
                <url>".htmlspecialchars($this -> obj_request -> GetUrl())."</url>
                <webmethod>";
                    if ($this -> obj_request -> GetValue("action") == "login") {
                        $xmlstr = $xmlstr. "<name>Log into the system</name>";
                    } elseif ($this -> obj_request -> GetValue("action") == "logout") {
                        $xmlstr = $xmlstr. "<name>Logout into the system</name>";
                    } elseif ($this -> obj_request -> GetValue("action") == "register") {
                        $xmlstr = $xmlstr. "<name>Register into the system</name>";
                    } elseif ($this -> obj_request -> GetValue("action") == "add_to_cart") {
                        $xmlstr = $xmlstr. "<name>Add to Cart</name>";
                    } else {
                        $xmlstr = $xmlstr. "<name>Undefined</name>";
                    }
                    $xmlstr = $xmlstr . "<parameters>";
                    
                    foreach($_GET as $key => $value) {
                        if ($key == NULL) {
                            //Si action=login o action=logout existen, comprobamos los demás parámetros
                            $xmlstr = $xmlstr. "<parameter>";
                            $xmlstr = $xmlstr. "<name>undefined</name>";
                            $xmlstr = $xmlstr. "<value>undefined</value>";
                            $xmlstr = $xmlstr. "</parameter>";
                                            
                        } else {
                            //Si action=login o action=logout no existen en la URL
                            $xmlstr = $xmlstr. "<parameter>";
                            $xmlstr = $xmlstr. "<name>".$key."</name>";

                            if ($value == "") {
                                $xmlstr = $xmlstr. "<value>undefined</value>";
                                $xmlstr = $xmlstr. "</parameter>";
                            } else {
                                $xmlstr = $xmlstr. "<value>".$value."</value>";
                                $xmlstr = $xmlstr. "</parameter>";
                            }
                        }
                                
                    }
                    $xmlstr = $xmlstr . "</parameters>
                </webmethod>
                <errors>";
                
                    foreach ($this -> obj_errors as $error) {
                        if ($error != NULL) {
                            if ($this -> obj_request -> Exists("action")) {

                                if ($this -> obj_request -> GetValue("action") == "login" || $this -> obj_request -> GetValue("action") == "logout" || $this -> obj_request -> GetValue("action") == "register" || $this -> obj_request -> GetValue("action") == "add_to_cart") {
                                    //Si action=login o action=logout existen, comprobamos los demás parámetros
                                    $xmlstr = $xmlstr. "<error>";
                                    $xmlstr = $xmlstr. "<num_error>".$error -> num_error."</num_error>";
                                    $xmlstr = $xmlstr. "<message_error>".$error -> message_error."</message_error>";
                                    $xmlstr = $xmlstr. "<severity>".$error -> severity."</severity>";
                                    $xmlstr = $xmlstr. "<user_message>".$error -> user_message."</user_message>";
                                    $xmlstr = $xmlstr. "</error>";
                                    
                                } else {
                                    //Si action=login o action=logout no existen en la URL
                                    $xmlstr = $xmlstr. "<error>";
                                    $xmlstr = $xmlstr. "<num_error>".$error -> num_error."</num_error>";
                                    $xmlstr = $xmlstr. "<message_error>".$error -> message_error."</message_error>";
                                    $xmlstr = $xmlstr. "<severity>".$error -> severity."</severity>";
                                    $xmlstr = $xmlstr. "<user_message>".$error -> user_message."</user_message>";
                                    $xmlstr = $xmlstr. "</error>";
                                }
                            } else {
                                //Si action no existe en la URL
                                $xmlstr = $xmlstr. "<error>";
                                $xmlstr = $xmlstr. "<num_error>".$error -> num_error."</num_error>";
                                $xmlstr = $xmlstr. "<message_error>".$error -> message_error."</message_error>";
                                $xmlstr = $xmlstr. "<severity>".$error -> severity."</severity>";
                                $xmlstr = $xmlstr. "<user_message>".$error -> user_message."</user_message>";
                                $xmlstr = $xmlstr. "</error>";
                            }
                            
                        }
                    }
                    $xmlstr = $xmlstr . "</errors>
                </head>
                <body>
                    <response_data>";
                    if (isset($this -> responseData)) {
                         foreach ($this -> responseData as $key => $value) {
                            $xmlstr = $xmlstr . "<".$key.">". $value ."</".$key.">";
                        }
                    }
                    $xmlstr = $xmlstr . "</response_data>
                </body>
                <token>";
                    if (isset($_COOKIE["token"])) {

                        $xmlstr = $xmlstr . "<guid>". $_COOKIE["token"] . "</guid>";
                    }
                $xmlstr = $xmlstr. "</token>
            </ws_response>";
            
            $this -> xml = new SimpleXMLElement($xmlstr); 
            
    }
//////////////////////////////////////////////////
    public function GetResponse() : void {

        if ($this -> responseType) {
            //Seteamos el header
            $this -> setHeader();
            //Printamos el XML por la web
            echo $this -> xml -> asXML();

        } else {
            //Comprobamos si se ha agregado algo para imprimir en clsEcho
            if (count(clsEchos::$arrEcho)>0){
                foreach (clsEchos::$arrEcho as $value) {
                    echo $value;
                }
            }
            
            if (count(clsEchos::$arrVar_dump)>0){
                foreach (clsEchos::$arrVar_dump as $value) {
                    var_dump($value);
                }
            }

            if (count(clsEchos::$arrPrint_r)>0){
                foreach (clsEchos::$arrPrint_r as $value) {
                    print_r($value);
                }
            }
        }
    }
//////////////////////////////////////////////////
}

?>