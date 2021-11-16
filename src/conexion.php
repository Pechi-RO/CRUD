<?php
namespace Tienda;
use PDO;
use PDOException;

class Conexion{
    protected static $conexion;
    public function __construct(){
        if(self::$conexion==null){
            self::crearConexion();
        }
    }
    public static function CrearConexion(){
        $fichero=dirname(__DIR__,1)."/.config";
        $opciones=parse_ini_file($fichero);
        $dbname=$opciones['bbdd'];
        $host=$opciones['host'];
        $usuario=$opciones['user'];
        $pass=$opciones['password'];

        $dns="mysql:host=$host;dbname=$dbname;charset=utf8mb4";

        try{
            self::$conexion=new PDO($dns, $usuario, $pass);

            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $ex){
            die("Error en la conexion con la conexion de la base de datos:".$ex->getMessage());


        }
    }



}