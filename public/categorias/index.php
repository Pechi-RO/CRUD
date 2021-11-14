<?php
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Tienda\Categorias;

(new Categorias)->generarCategorias(30);
$stmt = (new Categorias)->readAll();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BootStrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Categorias</title>
</head>

<body style="background-color:silver">
    <h3 class="text-center">estión de Categorias</h3>
    <div class="container mt-2">
        <?php
            if(isset($_SESSION['mensaje'])){
                echo <<<TXT
                <div class="alert alert-primary" role="alert">
                {$_SESSION['mensaje']}
                </div>
                TXT;
                unset($_SESSION['mensaje']);
            }
        ?>
        <a href="clibro.php" class="btn btn-primary mb-2"><i class="fas fa-book-medical"></i> Nueva categoria</a>
        <table class="table table-info table-striped" id="tablacategorias">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>

                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
                    
                    echo <<<TXT
                    <tr>
                    <th scope="row"><a href="dcategoria.php?id={$fila->id}"</a></th>
                    <td>{$fila->nombre}</td>
                    
                    <td>{$fila->descripcion}</td>
                    <td>
                    <form name='s' action='blibro.php' method='POST'>
                    <input type='hidden' name='id' value='{$fila->id}'>
                    <a href="ucategoria.php?id={$fila->id}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Desea Borrar el Libro?')"><i class="fas fa-trash-alt"></i></button>
                    </form>
                    </td>
                </tr>
                TXT;
                }
                ?>
            </tbody>
        </table>

    </div>
    <script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
        $('#tablalibros').DataTable();
} );
    </script>
</body>

</html>