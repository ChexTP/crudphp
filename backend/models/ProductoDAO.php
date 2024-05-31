<?php 

require('../conexiones/conexion.php');


class Producto {
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;

    // Constructor
    function __construct($id=null, $nombre=null, $descripcion=null, $precio=null) {
        $this->id= $id;
        $this->nombre= $nombre;
        $this->descripcion= $descripcion;
        $this->precio= $precio;
    }

    public function traerProductos(){
        $conn= new Conexion('localhost','root','phpcrud','');
        try {
            $conexion=$conn->Conectar();
            $sql='SELECT * from productos';
            $stmt=$conexion->query($sql);
            $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
            $conn->Desconectar();
        } catch (PDOException $e) {
            echo "error al conectarse a la base de datos".$e;
        }
    }

    public function agregarProducto($id,$nombre,$descripcion,$precio){
        $conn= new Conexion('localhost','root','phpcrud','');
        try {
            $conexion = $conn->Conectar();
            $stmt = $conexion->prepare('INSERT INTO productos (id,nombre, descripcion, precio) VALUES (?,?,?,?)');
            
            // Vincular los parámetros

            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $nombre);
            $stmt->bindParam(3, $descripcion);
            $stmt->bindParam(4, $precio);
            $stmt->execute();
            
            // Desconectar después de la ejecución
            $conn->Desconectar();
            
            return "Producto agregado correctamente";
        } catch (PDOException $e) {
            echo "Error al conectarse a la base de datos: ".$e->getMessage();
        }  //throw $th;
        

    }

    public function buscarProducto($criterio, $valor) {
        $conn = new Conexion('localhost', 'root', 'phpcrud', '');
        try {
            $conexion = $conn->Conectar();
            // Preparar la consulta SQL
            $sql = '';
            if ($criterio == 'id') {
                $sql = 'SELECT * FROM productos WHERE id = :valor';
            } elseif ($criterio == 'nombre') {
                $sql = 'SELECT * FROM productos WHERE nombre = :valor';
            } else {
                throw new Exception("Criterio de búsqueda no válido.");
            }
    
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $conn->Desconectar();
            return $row;
        } catch (PDOException $e) {
            echo "Error al buscar el producto: " . $e->getMessage();
        }
    }

    public function actualizarProducto($id, $nombre, $descripcion, $precio) {
        $conn = new Conexion('localhost', 'root', 'phpcrud', '');
        try {
            $conexion = $conn->Conectar();
            $sql = 'UPDATE productos SET nombre = ?, descripcion = ?, precio = ? WHERE id = ?';
            $stmt = $conexion->prepare($sql);
            
            $stmt->bindParam(1, $nombre);
            $stmt->bindParam(2, $descripcion);
            $stmt->bindParam(3, $precio,);
            $stmt->bindParam(4, $id);
            $stmt->execute();
            $conn->Desconectar();
            return true;
        } catch (PDOException $e) {
            echo "Error al actualizar el producto: " . $e->getMessage();
            return false;
        }
    }
    public function borrarProductoPorId($id) {
        $conn = new Conexion('localhost', 'root', 'phpcrud', '');
        try {
            $conexion = $conn->Conectar();
            $sql = 'DELETE FROM productos WHERE id = ?';
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $conn->Desconectar();
            return true;
        } catch (PDOException $e) {
            echo "Error al borrar el producto: " . $e->getMessage();
            return false;
        }
    }




    
    

}




?>