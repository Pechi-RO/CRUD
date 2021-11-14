<?php
if(!isset($_POST['id'])){
    header("Location:index.php");
    die();
}
session_start();
require dirname(__DIR__, 2)."/vendor/autoload.php";
use Tienda\Articulos;
(new Articulos)->delete($_POST['id']);
$_SESSION['mensaje']="Articulo borrado";
header("Location:index.php");