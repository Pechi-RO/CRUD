<?php
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Tienda\{Articulos, Categorias};


$articulos = (new Articulos)->devolverArticulos();
function hayError($t, $i, $s){
    $error=false;
  
 
    if(strlen($t)==0){
        $error=true;
        $_SESSION['error_nombre']="Rellene el nombre";
    }
    if(strlen($s)==0){
        $error=true;
        $_SESSION['error_descripcion']="REllene la descripcion";
    }
    return $error;
    

}

if(isset($_POST['btnCrear'])){
    $titulo=trim(ucwords($_POST['titulo']));
    $sinopsis=trim(ucfirst($_POST['sinopsis']));
    $isbn=trim($_POST['isbn']);
    $autor_id=$_POST['autor_id'];
    if(!hayError($titulo, $isbn, $sinopsis)){
        (new Categorias)->setNombre($nombre)
        ->setDescripcion($descripcion)
        ->create();
        $_SESSION['mensaje']="Cateogria Creada";
        header("Location:index.php");
        

    }
    else{
        header("Location:{$_SERVER['PHP_SELF']}");
    }

}

else{
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BootStrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Crear Libro</title>





</head>

<body style="background-color:silver">
    <h5 class="text-center">Nueva categoria</h5>
    <div class="container mt-2">
        <div class="bg-success p-4 text-white rounded shadow-lg mx-auto" style="width:40rem">
            <form name="ccategoria" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <div class="mb-3">
                    <label for="t" class="form-label">nombre categoria</label>
                    <input type="text" class="form-control" id="t" placeholder="nombre" name="titulo" required>
                    <?php
                        if(isset($_SESSION['error_nombre'])){
                            echo <<<TXT
                            <div class="mt-2 text-danger fw-bold" style="font-size:small">
                                {$_SESSION['error_nombre']}
                            </div>
                            TXT;
                            unset($_SESSION['error_nombre']);
                        }
                    ?>       
                </div>
                <div class="mb-3">
                    <label for="s" class="form-label">descripcion categoria</label>
                    <textarea class="form-control" id="s" rows="4" name="descripcion"></textarea>
                    <?php
                        if(isset($_SESSION['error_descripcion'])){
                            echo <<<TXT
                            <div class="mt-2 text-danger fw-bold" style="font-size:small">
                                {$_SESSION['error_descripcion']}
                            </div>
                            TXT;
                            unset($_SESSION['error_descripcion']);
                        }
                    ?>       
                </div>
               
                <div class="mb-3">
                    <label for="a" class="form-label">Articulos</label>
                    <select class="form-select" name="autor_id" id="a">
                        <?php
                        foreach ($autores as $item) {
                            echo "\n<option value='{$item->id}'>{$item->precio}, {$item->nombre}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <button type='submit' name="btnCrear" class="btn btn-info"><i class="fas fa-save"></i> Crear</button>
                    <button type="reset" class="btn btn-warning"><i class="fas fa-broom"></i> Limpiar</button>
                </div>

            </form>
        </div>
    </div>
</body>

</html>
<?php } ?>