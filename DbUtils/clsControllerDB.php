<?php
//Ruta dentro de docker
include("/opt/lampp/htdocs/WEB_SERVICE_PHP/Interfaces/ControllerDataBaseInterface.php"); 
include_once __DIR__."/clsConnectionDB.php";


class clsControllerDb implements ControllerDataBaseInterface {

    private PDO $db;
    private clsConnectionDB $obj_connectionDB;
    private $request;
    private array $procedureData;

////////////////////////////////////////////

    public function __construct(string $pName_procedure, array $pParams = [])
    {
        $this -> obj_connectionDB = new clsConnectionDB();
        $this -> db = $this -> obj_connectionDB -> getPDODB();
        $this -> init($pName_procedure, $pParams);
        
    }

//////////////////////////////////////////

    private function init(string $pName_procedure, array $pParams = []) {
        $this -> prepareProcedure($pName_procedure,$pParams);
        $this -> executeProcedure();
        $this -> fetchExecutionProcedure();
    }

//////////////////////////////////////////

    public function prepareProcedure(string $name_procedure, array $params = []): void
    {
        
        if (count($params) == 0) {
            
            $this -> request = $this -> db -> prepare("EXEC ".$name_procedure);
            
        
        } else {
            $name_procedure_modificated = $this -> setInterrogation($name_procedure, $params);
            $this -> request = $this -> db -> prepare("EXEC ".$name_procedure_modificated);
            

            foreach ($params as $key => $value){

                $this -> request -> bindValue($key+1,$value);
            }
            
        }
    }

//////////////////////////////////////////

    private function setInterrogation(string $pNameProcedure , array $pParams) {
        
        for ($i = 0; $i < count($pParams);$i++) {
            
            if ($i == count($pParams)-1) {
                $pNameProcedure = $pNameProcedure." ?";
                break;
            }
            $pNameProcedure = $pNameProcedure." ?,";
        }
        return $pNameProcedure;
    }

//////////////////////////////////////////

    public function executeProcedure(): void
    {
        $this -> request -> execute();
    }

//////////////////////////////////////////

    public function fetchExecutionProcedure(): void
    {
        if ($this -> request -> rowCount() === 1) {
            $this -> request -> nextRowset();
        }
        $this -> procedureData = $this -> request -> fetchAll(PDO::FETCH_ASSOC);
    }

//////////////////////////////////////////

    public function getResponseFromDB() {
        
        foreach ($this -> procedureData[0] as $value) {
            $obj_xml = simplexml_load_string($value);
            return $obj_xml;
        }
        
    }

}

?>