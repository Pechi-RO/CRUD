<?php
if (!isset($_GET['id'])) {
    header("Location:index.php");
    die();
}

$id = $_GET['id'];

session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Tienda\{Articulos, Categorias};

$estacategoria = (new Categorias)->read($id);

$articulos = (new Articulos)->devolverArticulos();
function hayError($n, $d,)
{
    global $id;
    $error = false;
    
   
    if (strlen($n) == 0) {
        $error = true;
        $_SESSION['error_nombre'] = "Rellene el nombre";
    }
    if (strlen($d) ==0) {
        $error = true;
        $_SESSION['error_descripcion'] = "Rellene la descripcion";
    }
    return $error;
}

if (isset($_POST['btnUpdate'])) {
    $nombre = trim(ucwords($_POST['nombre']));
    $descripcion = trim(ucfirst($_POST['descripcion']));
    if (!hayError($nombre, $descripcion)) {
        (new Categorias)->setNombre($nombre)
            ->setDescripcion($descripcion)
            ->update($id);
        $_SESSION['mensaje'] = "Categoria actualizada";
        header("Location:index.php");
    } else {
        header("Location:{$_SERVER['PHP_SELF']}?id=$id");
    }
} else {
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

        <title>Crear Categoria</title>





    </head>

    <body style="background-color:silver">
        <h5 class="text-center">Nueva Categoria</h5>
        <div class="container mt-2">
            <div class="bg-success p-4 text-white rounded shadow-lg mx-auto" style="width:40rem">
                <form name="ccategoria" method="POST" action="<?php echo $_SERVER['PHP_SELF'] . "?id=$id" ?>">
                    <div class="mb-3">
                        <label for="t" class="form-label">nombre categoria</label>
                        <input type="text" class="form-control" id="t" placeholder="nombre" name="titulo" required value="<?php echo $estacategoria->nombre ?>" />
                        <?php
                        if (isset($_SESSION['error_nombre'])) {
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
                        <label for="s" class="form-label">descripcion cateoria</label>
                        <textarea class="form-control" id="s" rows="4" name="sinopsis"><?php echo $estacategoria->descripcion ?></textarea>
                        <?php
                        if (isset($_SESSION['error_descripcion'])) {
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
                        <label for="a" class="form-label">Articulo</label>
                        <select class="form-select" name="articulo_id" id="a">
                            <?php
                            foreach ($articulos as $item) {
                                if ($item->id == $estacategoria->id) {
                                    echo "\n<option value='{$item->id}' selected>{$item->nombre}, {$item->precio}</option>";
                                } else {
                                    echo "\n<option value='{$item->id}' selected>{$item->nombre}, {$item->precio}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <button type='submit' name="btnUpdate" class="btn btn-info"><i class="fas fa-edit"></i> Editar</button>
                        <a href="index.php" class="btn btn-primary"><i class="fas fa-backward"></i> Volver</a>
                    </div>

                </form>
            </div>
        </div>
    </body>

    </html>
<?php } ?>