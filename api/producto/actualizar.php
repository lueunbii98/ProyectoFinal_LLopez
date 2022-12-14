<?php
    // encabezados obligatorios
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: *");

    include_once '../configuracion/conexion.php';
    include_once '../objetos/productos.php';
    $conex = new Conexion();
    $db = $conex->obtenerConexion();
    $producto = new Productos($db);
    // obtener los datos
    $data = json_decode(file_get_contents("php://input"));
    // asegurar que los datos no esten vacios
    if(
    !empty($data->id) &&
    !empty($data->nombre) &&
    !empty($data->numero_producto) &&
    !empty($data->color)&&
    !empty($data->precio_unitario)&&
    !empty($data->cantidad_inventario)
    ){
        $producto->id = $data->id;
        $producto->nombre = $data->nombre;
        $producto->numero_producto = $data->numero_producto;
        $producto->color = $data->color;
        $producto->precio_unitario = $data->precio_unitario;
        $producto->cantidad_inventario = $data->cantidad_inventario;

        if($producto->actualizar_producto()){
            // asignar codigo de respuesta - 201 creado
            http_response_code(200);
            // informar al usuario
            echo json_encode(array("message" => "El producto ha sido actualizado."));
        }
        else{
            // asignar codigo de respuesta - 503 servicio no disponible
            http_response_code(200);
            // informar al usuario
            echo json_encode(array("message" => "No se puede actualizar el producto."));
        }
    }
    // informar al usuario que los datos estan incompletos
    else{
        // asignar codigo de respuesta - 400 solicitud incorrecta
        http_response_code(200);
        // informar al usuario
        echo json_encode(array("message" => "No se puede actualizar el producto. Los datos
    están incompletos."));
    }
?>