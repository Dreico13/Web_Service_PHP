<?php

include_once __DIR__."/clsXMLUtils.php";
include_once __DIR__."/clsMethod.php";
include_once __DIR__."/clsErrors.php";
include_once __DIR__."/clsEchos.php";

class clsServerApi{
    private string $configfile;
    private object $obj_xmlutil;
    private object $obj_request;
    private array $arrWebMethods = [];
    private array $arrErrors = [];
   
////////////////////////////////////////////////////
    public function __construct(string $configfile){
        $this->obj_xmlutil = new clsXMLUtils();
        $this->obj_request = new clsRequest();
        $this->configfile = $configfile;
        $this->Init();
    }
////////////////////////////////////////////////////
    private function Init() :void{
        $this -> ReadConfigurationFile();
        $this -> ParseWebMethods();
    }
////////////////////////////////////////////////////
    private function ReadConfigurationFile() :void {
        $this->obj_xmlutil->ReadFile($this->configfile);
    }

////////////////////////////////////////////////////
    private function ParseWebMethods() :void {
        $arrMethods=$this->obj_xmlutil->ApplyXpath('//web_methods_collection/web_method');
        if ($arrMethods) {
            $arrMethods = $this -> obj_xmlutil -> getResult();
            foreach ($arrMethods as $Method) {
                $this->addMethod($this->obj_xmlutil->arrayToXML($Method));
            }
        }
    }
////////////////////////////////////////////////////
    private function addMethod(SimpleXMLElement $XMLMethod): void{
        $obj_methods = new clsMethod($XMLMethod);
        array_push($this -> arrWebMethods, $obj_methods);
       
    }
////////////////////////////////////////////////////
    public function Validate() :array {
        $cont=0;
        if ($this -> obj_request -> Exists("action")) {

            $pActionValue = $this -> obj_request -> GetValue("action");

            foreach($this -> arrWebMethods as $method) {
                
                if ($method -> HasActionValue($pActionValue)) {
                    //Retornamos la validación
                     return $method -> ValidateMethod();
                } else {
                    $cont++;
                }
            }

            if ($cont == count($this -> arrWebMethods)) {
                $obj_error = new clsErrors(2);
                array_push($this -> arrErrors, $obj_error);
                return $this -> arrErrors;
            }

        } else {
            $obj_error = new clsErrors(1);
            array_push($this -> arrErrors, $obj_error);
            return $this -> arrErrors;
            
        }
        
    }
////////////////////////////////////////////////////
    public function Print(): void {
        // echo $this->obj_xmlutil->getXML();
    }

///////////////////////////////////////////////////
    public function PrintMethods() : void {
        clsEchos::SetVarDump("Hola, estoy haciendo una prueba");
    }


}




?>