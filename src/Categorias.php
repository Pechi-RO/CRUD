<?php
namespace Tienda;
use PDO;
use PDOException;
use Faker;
class Categorias extends Conexion{
    private $id;
    private $nombre;
    private $descripcion;

    public function __construct()
    {
        parent::__construct();
    }

    //-------CRUD

    public function create()
    {
        $q = "insert into categorias(nombre, descripcion) values(:n, :d)";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':d' => $this->descripcion,
                
            ]);
        } catch (PDOException $ex) {
            die("Error al insertar categoria: " . $ex->getMessage());
        };
        parent::$conexion = null;
    }
    //----------------------------------------------------------------------------------------
    public function read($id)
    {
        $q = "select libros.*, nombre, descripcion from categorias, articulos where 
        fk_art_cat=categoria_id.id AND categorias.id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al recuperar una categoria: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    //-------------------------------------------------------------------------------
    public function update($id)
    {
        $q = "update categorias set nombre=:n, descripcion=:d where id=:id";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':d' => $this->descripcion,
                                ':id' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al actualizar categorias: " . $ex->getMessage());
        }
    }
    public function delete($id)
    {
        $q = "delete from categorias where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al borrar categoria: " . $ex->getMessage());
        }
        parent::$conexion = null;
    }
   

    //---OTROS METODOS

    public function readAll()
    {
        $q = "select * from categorias order by id";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al devolver las categorias: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt;
    }


    public function generarCategorias($c)
    {
        if (!$this->hayCategorias()) {
            $faker = Faker\Factory::create('es_ES');

            for ($i = 0; $i < $c; $i++) {
                $nombre = $faker->name(10);
                $descripcion = $faker->text(20);
                
                (new Categorias)->setNombre($nombre)
                    ->setDescripcion($descripcion)
                    ->create();
            }
        }
    }
    public function hayCategorias()
    {
        $q = "select * from categorias";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al comprobar si hay categorias: " . $ex->getMessage());
        }
        $totalLibros = $stmt->rowCount();
        parent::$conexion = null;
        return ($totalLibros > 0);
    }
    public function devolverId(){
        $q="select id from categorias order by id";
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
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }
}