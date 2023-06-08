<?php

interface ControllerDataBaseInterface {

    public function prepareProcedure(string $name_procedure, array $params=[]): void;

    public function executeProcedure(): void;

    public function fetchExecutionProcedure(): void;
}

?>