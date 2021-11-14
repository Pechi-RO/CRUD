<?php
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Tienda\Articulos;

function hayError($n,$p)
{
    $error = false;
    if (strlen($n) == 0) {
        $_SESSION['error_nombre'] = "Rellene el Nombre";
        $error = true;
    }
    if (strlen($p) == 0) {
        $_SESSION['error_precio'] = "Rellene el precio";
        $error = true;
    }
    return $error;
}
if (isset($_POST['btnCrear'])) {
    //Procesamos el formulario
    $nombre = trim(ucwords($_POST['nombre']));
    $precio = trim(ucwords($_POST['precio']));
    
    if (!hayError($nombre, $precio, $pais)) {
        //podemos hacer el insert 
        (new Articulos)->setNombre($nombre)
            ->setPrecio($precio)
            ->create();
        $_SESSION['mensaje'] = "Articulo creado con éxito.";
        header("Location:index.php");
        die();
    }
    header("Location:{$_SERVER['PHP_SELF']}");
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

        <title>Crear Articulo</title>





    </head>

    <body style="background-color:silver">
        <h3 class="text-center">Nuevo Articulo</h3>
        <div class="container mt-2">
            <form name="carticulo" action="<?php echo $_SERVER['PHP_SELF']; ?>" method='POST'>
                <div class="bg-success p-4 text-white rounded shadow-lg m-auto" style="width:40rem">
                    <div class="mb-3">
                        <label for="n" class="form-label">Nombre Articulo</label>
                        <input type="text" class="form-control" id="n" placeholder="Nombre" name="nombre" required>
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
                        <label for="a" class="form-label">Precio Articulo</label>
                        <input type="text" class="form-control" id="a" placeholder="Apellidos" name="apellidos" required>
                        <?php
                        if (isset($_SESSION['error_precio'])) {
                            echo <<<TXT
                            <div class="mt-2 text-danger fw-bold" style="font-size:small">
                                {$_SESSION['error_precio']}
                            </div>
                            TXT;
                            unset($_SESSION['error_apellidos']);
                        }
                        ?>
                    </div>
                   

                    <div>
                        <button type='submit' name="btnCrear" class="btn btn-info"><i class="fas fa-save"></i> Crear</button>
                        <button type="reset" class="btn btn-warning"><i class="fas fa-broom"></i> Limpiar</button>
                    </div>
                </div>
            </form>
        </div>
    </body>

    </html>
<?php } ?>