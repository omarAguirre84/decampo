<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/api/productos', function () {
    $prod = new Producto();
    return json_encode(['data'=>$prod->listar()]);
});

$app->patch('/api/productos', function (Request $request, Response $response) {
    $prod = Producto::obtener($request->getParam('id'));
    $prod->nombre = $request->getParam('nombre');
    $prod->precio_pesos = $request->getParam('precio_pesos');
    $prod->modificar();
    return json_encode(['data' => Producto::obtener($prod->id)]);
});

$app->post('/api/productos', function (Request $request, Response $response) {
    $prod = Producto::obtener();
    $prod->nombre = $request->getParam('nombre');
    $prod->precio_pesos = $request->getParam('precio_pesos');
    $prod->alta();
    return json_encode(['data' => Producto::obtener($prod->id)]);
});

$app->delete('/api/productos', function (Request $request, Response $response) {
    $prod = Producto::obtener($request->getParam('id'));
    return json_encode(['data' => $prod->baja()]);
});