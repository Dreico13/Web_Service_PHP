<?php

include_once __DIR__."/clsErrors.php";

class clsParams {

    private simpleXMlElement $xml_ParamsNode;
    private object $obj_request;
    private object $obj_xmlutil;
    private object $obj_error;
    private simpleXMLElement $name;
    private simpleXMLElement $type;
    private simpleXMLElement $mandatory;
    private simpleXMLElement $default;
    private $min_length;
    private array $arrParamErrors = [];

//////////////////////////////////////////////////
    public function __construct($pNode) {
        $this -> xml_ParamsNode = $pNode;
        $this -> obj_request = new clsRequest();
        $this -> obj_xmlutil = new clsXMLUtils();
        $this -> Init();
    }
/////////////////////////////////////////////////
    public function Init() :void {
        $this -> ParseParam();
    }
////////////////////////////////////////////////
    private function ParseParam() :void {

        $this -> name = $this -> xml_ParamsNode["name"];

        foreach($this -> xml_ParamsNode as $key => $value) {
            switch ($key) {
                case 'type':
                    $this -> type = $value;
                    break;      
                case 'mandatory':
                    $this -> mandatory = $value;
                    break;
                case 'default':
                    $this -> default = $value;
                    break;
                case 'min_length':
                    $this -> min_length = $value;
                    break;
            }
        }
        
    }

////////////////////////////////////////////////
    public function GetDefault() :simpleXMLElement {
        return $this -> default;
    }

/////////////////////////////////////////////////
    public function ValidateParams(object $pParams) :array {
        $this -> ValidateMandatory($pParams);
        $this -> ValidateType($pParams);
        $this -> ValidateMinLength($pParams);
        return $this -> arrParamErrors;
           
    }
/////////////////////////////////////////////////
    private function ValidateMandatory(object $pParams) {

        if ($pParams -> mandatory == "yes") {
            //Si son mandatory comprobamos si no existen
            if (!$this -> obj_request -> Exists(strval($pParams -> name))) {
                $obj_error = new clsErrors(3,$pParams->name);
                array_push($this -> arrParamErrors, $obj_error);
            }
            
        }

    }
/////////////////////////////////////////////////
    private function ValidateType(object $pParams) {

        $param = $this -> obj_request -> GetValue(strval($pParams -> name));

        if ($param != "" ) {
            //Comprobamos que sea el tipo que se indica en el XML
            // if (gettype($paramUser) == $Method->ValidateType() && (!is_numeric($paramUser)) ){
            if (strval($pParams -> type) != gettype($param)) {
                $obj_error = new clsErrors(5,$pParams->name);
                array_push($this -> arrParamErrors, $obj_error);
            }
        } else {
            $obj_error = new clsErrors(4,$pParams -> name);
            array_push($this -> arrParamErrors, $obj_error);
        }

    }
////////////////////////////////////////////////
    private function ValidateMinLength(object $pParams) {
        
        $param = $this -> obj_request -> GetValue(strval($pParams -> name));

        if ($pParams -> min_length != NULL ) {
            //Comprobamos que tenga la longitud que se indica en el XML
            if (strlen($param) < intval($pParams -> min_length)) {
                $obj_error = new clsErrors(6,$pParams->name,$pParams->min_length);
                array_push($this -> arrParamErrors, $obj_error);
                
            }
        }
    }
         
}

?>