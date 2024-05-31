<?php 
    


    include('../models/ProductoDAO.php');

    header("Content-Type: application/json");
    $method = $_SERVER['REQUEST_METHOD'];
    $productoDAO = new Producto();
    switch ($method) {
        case 'GET':

            $productos = $productoDAO->traerProductos();
            print_r(json_encode($productos));
            break;

        case 'POST':

           
            try {
                // Recibir y decodificar JSON
                $data = json_decode(file_get_contents("php://input"), true);
            
                if (isset($data['nombre']) && isset($data['descripcion']) && isset($data['precio'])) {
                    $nombre = $data['nombre'];
                    $descripcion = $data['descripcion'];
                    $precio = $data['precio'];
            
                    if (!empty($nombre) && !empty($descripcion) && !empty($precio)) {
                        $resultado = $productoDAO->agregarProducto(null, $nombre, $descripcion, $precio);
                        echo json_encode(['message' => 'Producto agregado exitosamente']);
                    } else {
                        echo json_encode(['error' => 'Todos los campos son obligatorios']);
                    }
                } else {
                    echo json_encode(['error' => 'Faltan algunos campos en la solicitud JSON']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'Error al agregar producto nuevo: ' . $e->getMessage()]);
            }
        
            
            break;

        case "GET":

            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
                $productoDAO = new ProductoDAO();
                $producto = $productoDAO->buscarProducto('id', $_GET['id']);
                if ($producto) {
                    echo json_encode($producto);
                } else {
                    echo json_encode(['error' => 'Producto no encontrado']);
                }
            } elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['nombre'])) {
                $productoDAO = new ProductoDAO();
                $producto = $productoDAO->buscarProducto('nombre', $_GET['nombre']);
                if ($producto) {
                    echo json_encode($producto);
                } else {
                    echo json_encode(['error' => 'Producto no encontrado']);
                }
            }
            
            break;

        case 'PUT':
            try {
                // Recibir y decodificar JSON
                $data = json_decode(file_get_contents("php://input"), true);
                
                if (isset($data['id']) && isset($data['nombre']) && isset($data['descripcion']) && isset($data['precio'])) {
                    $id = $data['id'];
                    $nombre = $data['nombre'];
                    $descripcion = $data['descripcion'];
                    $precio = $data['precio'];
                    
                    if (!empty($id) && !empty($nombre) && !empty($descripcion) && !empty($precio)) {
                        $resultado = $productoDAO->actualizarProducto($id, $nombre, $descripcion, $precio);
                        if ($resultado) {
                            echo json_encode(['message' => 'Producto actualizado exitosamente']);
                        } else {
                            echo json_encode(['error' => 'Error al actualizar el producto']);
                        }
                    } else {
                        echo json_encode(['error' => 'Todos los campos son obligatorios']);
                    }
                } else {
                    echo json_encode(['error' => 'Faltan algunos campos en la solicitud JSON']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'Error al actualizar producto: ' . $e->getMessage()]);
            }
           
            
            break;
        case 'DELETE':

            try {
               
                    $id = $_GET['id'];
                    
                    
                    $resultado = $productoDAO->borrarProductoPorId($id);
                    if ($resultado) {
                        echo json_encode(['message' => 'Producto eliminado exitosamente']);
                    } else {
                        echo json_encode(['error' => 'Error al eliminar el producto']);
                    }
                    
            } catch (Exception $e) {
                echo json_encode(['error' => 'Error al eliminar producto: ' . $e->getMessage()]);
            }
            
            break;
        
        default:
            # code...
            break;
    }

?>