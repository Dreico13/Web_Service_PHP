<?php

class clsEchos {

    public static array $arrEcho = [];
    public static array $arrVar_dump = [];
    public static array $arrPrint_r = [];

/////////////////////////////////////////////////////////
    public static function SetEcho(mixed $pValue) {
        array_push(self::$arrEcho,$pValue);
    }
/////////////////////////////////////////////////////////
    public static function SetVarDump(mixed $pValue) {
        array_push(self::$arrVar_dump,$pValue);
    }
/////////////////////////////////////////////////////////
    public static function SetPrintR(mixed $pValue) {
        array_push(self::$arrPrint_r,$pValue);
    }
/////////////////////////////////////////////////////////
}

?>