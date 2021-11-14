<?php

namespace Tienda;
use PDO;
use PDOException;
use Faker;

class Articulos extends Conexion{

    private $id;
    private $nombre;
    private $precio;
    private $categoria_id;

    public function __construct()
    {
        parent::__construct();
        
    }

    //-----------CRUD---------------

    public function create(){
        $q="insert into articulos(nombre,precio,categoria_id) values(:n,:p,:ci)";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':p'=>$this->precio,
                ':ci'=>$this->categoria_id
            ]);
        }catch(PDOException $ex){
            die("Error al crear articulos".$ex->getMessage());
        }
        parent::$conexion=null;

    }
    public function read($id){
        $q="select * from articulos where id=:i";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':i'=>$id
            ]);
        }catch(PDOException $ex){
            die("Error al leer articulos:".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetch(PDO::FETCH_OBJ);

    }
    public function update(){
        $q="update autores set nombre=:n, precio=:p ,categoria_id=:ci where id=:i";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':p'=>$this->precio,
                ':ci'=>$this->categoria_id,
                ':i'=>$this->id
            ]);

        }catch(PDOException $ex){
            die("Error al actualizar acrticulos".$ex->getMessage());
        }
        parent::$conexion=null;

    }
    public function delete($id){
        $q="delete from articulos where id=:i";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':i'=>$id
            ]);

        }catch(PDOException $ex){
            die("Error al borrar articulos:".$ex->getMessage());
        }
        parent::$conexion=null;

    }


    //---------Otros metodos

    public function readAll()
    {
        $q = "select * from articulos order by id";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al recuperar Todos los articulos: " . $ex->getMessage());
        }
        parent::$conexion = null; //cerramos la conexion
        return $stmt;
    }

    public function generarArticulos($c){

        if ($this->hayArticulos()==0){
        $faker= Faker\Factory::create('es_ES');
        $articulos = (new Articulos)->devolverId();

        for($i=0;$i<$c;$i++){
            $nombre=$faker->name(10);
            $precio=$faker->randomNumber(2);
            $categoria_id = $articulos[array_rand($articulos, 1)];

            (new Articulos)->setNombre($nombre)
            ->setPrecio($precio)
            ->setCategoria_id($categoria_id)
            ->create();
        }
    }

    }

    public function hayArticulos(){
        $q="select id from articulos order by id";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error en hay articulos".$ex->getMessage());
        }
        parent::$conexion==null;
        return $stmt->rowCount();

    }

    public function devolverId(){
        $q="select id from articulos order by id";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute();

        }catch(PDOException $ex){
            die("error al devolver la id:".$ex->getMessage());
        }
        $id=[];
        while($fila=$stmt->fetch(PDO::FETCH_OBJ)){
            $id[]=$fila->id;
        }
        parent::$conexion==null;
        return $id;
    }
    public function devolverArticulos()
    {
        $q = "select nombre, precio, id from articulos order by id";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("error en devolverArticulos: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }



    /**
     * Get the value of precio
     */ 
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     *
     * @return  self
     */ 
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get the value of categoria_id
     */ 
    public function getCategoria_id()
    {
        return $this->categoria_id;
    }

    /**
     * Set the value of categoria_id
     *
     * @return  self
     */ 
    public function setCategoria_id($categoria_id)
    {
        $this->categoria_id = $categoria_id;

        return $this;
    }
}