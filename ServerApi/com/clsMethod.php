<?php

include_once __DIR__."/clsParams.php";

class clsMethod {

    private simpleXMLElement $xml_WebMethodNode;
    private object $obj_xmlutil;
    private object $obj_request;
    private object $obj_response;
    private array $arrParamsCollection = [];
    private array $arrParamErrors = [];

//////////////////////////////////////////
    public function __construct(SimpleXMLElement $pNode) {
        $this -> xml_WebMethodNode = $pNode;
        $this -> obj_xmlutil = new clsXMLUtils();
        $this -> obj_request = new clsRequest();
        $this -> Init();
    }

//////////////////////////////////////////
    public function Init() :void {
        $this -> ParseParams();
    }

/////////////////////////////////////////
    private function ParseParams() :void {
        $arrParams = $this -> obj_xmlutil -> ApplyXPathToObject('params_collection/param',$this -> xml_WebMethodNode);
        if ($arrParams) {
            $arrParams = $this -> obj_xmlutil -> getResult();
            foreach($arrParams as $param) {
                $this -> addParams($param);
            }
        }
    }
//////////////////////////////////////////
    private function addParams(SimpleXMLElement $pParams) :void {
        $obj_params = new clsParams($pParams);
        array_push($this -> arrParamsCollection, $obj_params); 
        
    }
//////////////////////////////////////////
    public function HasActionValue(string $pActionValue) :bool {
        
        if (strval($this->xml_WebMethodNode->params_collection->param->default) == $pActionValue){
            return True;
        } else {
            return False;
        }
              
    }
///////////////////////////////////////////
    public function ValidateMethod() :array {
        $i=0;
        foreach($this -> arrParamsCollection as $param) {
            $this -> arrParamErrors = array_merge($this  -> arrParamErrors,$param -> ValidateParams($param));
            $i++;
        }
        return $this -> arrParamErrors;
    }
    
}

?>