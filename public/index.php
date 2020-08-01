<?php
require '../vendor/autoload.php';

$app = new \Slim\App;
require '../constantes.php';
require '../src/db/Db.php';
require '../src/rutas/Productos.php';
require '../src/modelos/Producto.php';
require '../src/helpers/Helper.php';
$app->run();

