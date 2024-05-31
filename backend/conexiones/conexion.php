<?php 
    class Conexion{
        private $servidor;
        private $usuario;
        private $db;
        private $password;
        private $conexion;

        public function __construct($hostaux,$usuarioaux,$dbaux,$passwordaux){
            $this->host=$hostaux;
            $this->usuario=$usuarioaux;
            $this->db=$dbaux;
            $this->password=$passwordaux;

        }

        public function Conectar(){
            try {
                $this->conexion = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->usuario, $this->password);
                return $this->conexion;
            } catch (PDOException $e) {
                echo "error de conexion". $e -> getMessage();
            }
        }

        public function Desconectar(){
            try {
                if($this->conexion=!null){
                    if ($this->conexion=null) {
                        echo "conexion a la base de datos cerrada";
                    }
                else {
                    echo "No hay conexion activa a la base de datos";
                }
                }
            } catch (Exception $e) {
                echo "error al intentar desconectar la base de datos";
            }
            

        }
    }

   
    
?>