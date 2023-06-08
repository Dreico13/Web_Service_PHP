<?php

interface ConnectionDbInterface {

    public function getPDODB(): PDO;

    public function initConnection(): void;

}


?>