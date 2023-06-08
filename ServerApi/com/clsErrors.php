<?php

class clsErrors {

    public int $num_error;
    public string $message_error;
    public int $severity;
    public string $user_message;

///////////////////////////////////////////////
    public function __construct(int $pNumError,string $pDescription1=NULL,string $pDescription2=NULL) {

        switch ($pNumError) {
            case 1:
                $this -> num_error = -1;
                $this -> message_error = "El parámetro action no se encuentra en la URL";
                $this -> severity = 10;
                $this -> user_message = "Inicia sesión, cierra sesión o registrate";
                break;
            case 2:
                $this -> num_error = -2;
                $this -> message_error = "El parámetro action=login o action=logout no se encuentra en la URL";
                $this -> severity = 10;
                $this -> user_message = "Inicia sesión, cierra sesión o registrate";
                break;
            case 3:
                $this -> num_error = -3;
                $this -> message_error = "No existe el parámetro ". $pDescription1;
                $this -> severity = 5;
                $this -> user_message = "Usuario o contraseña incorrectos";
                break;
            case 4:
                $this -> num_error = -4;
                $this -> message_error = "El contenido del parámetro ". $pDescription1 . " se encuentra vacío";
                $this -> severity = 3;
                $this -> user_message = "Usuario o contraseña incorrectos";
                break;
            case 5:
                $this -> num_error = -5;
                $this -> message_error = "El contenido del parámetro ". $pDescription1 . " no es de tipo string";
                $this -> severity = 3;
                $this -> user_message = "Usuario o contraseña incorrectos";
                break;
            case 6:
                $this -> num_error = -6;
                $this -> message_error = "El contenido del parámetro ". $pDescription1 . " tiene menos de " . $pDescription2 . " carácteres";
                $this -> severity = 3;
                $this -> user_message = "Usuario o contraseña incorrectos";
                break;
        }
    }

//////////////////////////////////////////////////
    public static function userLoggedError() {
        $error = ["error" => "-1", "message" => "Necesitas hacer logout para realizar esta acción"];
        return $error;
    }

///////////////////////////////////////////////////
    public static function userNotLoggedError() {
        $error = ["error" => "-1", "message" => "Necesitas hacer login para realizar esta acción"];
        return $error;
    }
}
?>