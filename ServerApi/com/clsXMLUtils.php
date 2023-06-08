<?php

class clsXMLUtils{
    
    private $obj_simplexml_base;
    private $result;

//////////////////////////////////////////////////////////////////////////////
    function __construct(){
        //echo "-> clsXMLUtils constructor";
    }
//////////////////////////////////////////////////////////////////////////////
    public function ReadFile(string $pURL):bool {
        $this->obj_simplexml_base=simplexml_load_file($pURL);
        $this->result = $this->obj_simplexml_base;
        return true;
    }
//////////////////////////////////////////////////////////////////////////////
    public function WriteXMLFile(string $pFilePath, simpleXMLElement $pXML):void{
        $f=fopen($pFilePath,"w");
        fwrite($f, $pXML);
        fclose($f);
    }
//////////////////////////////////////////////////////////////////////////////
    public function getXML(): string{
        return $this->result->asXML();
    }
//////////////////////////////////////////////////////////////////////////////
    public function ApplyXPath(string $pPath):bool{

        $arr=$this->obj_simplexml_base->xpath($pPath);
        $this->result=$this->arrayToXML($arr);
        return true;
    }
//////////////////////////////////////////////////////////////////////////////
    public function ApplyXPathToObject(string $pPath, object $pObject) {
        
        $arr = $pObject -> xpath($pPath);
        $this -> result = $this -> arrayToXML($arr);
        return true;
    }
//////////////////////////////////////////////////////////////////////////////
    public function getResult () {
        return $this -> result;
    }
//////////////////////////////////////////////////////////////////////////////
    public function arrayToXML($pArr) : simpleXMLElement {     
        $str=$this->arraytoXMLString( $pArr);
        return simplexml_load_string($str);
    }
//////////////////////////////////////////////////////////////////////////////
    private function arraytoXMLString($pArr) : string{
        $str="<xpath_result>";
        foreach($pArr as $n){
            $str=$str . $n->asXML();
        }
        $str=$str . "</xpath_result>";
        return $str;
    }
//////////////////////////////////////////////////////////////////////////////
}

?>