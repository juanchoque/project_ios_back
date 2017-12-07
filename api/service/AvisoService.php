<?php
    require_once 'database_connections.php';
    
    class AvisoService{
        function listAviso($buscar, $limit, $offset){
            
            // mysqli query to fetch all data from database
            $pdo = Database::connect();
            $sql = "SELECT * from aviso where estado = 'A' and UPPER(descripcion) LIKE UPPER(CONCAT('%','" . $buscar . "','%')) order by id desc ";
            $sqllimit = " ";
            $sqloffset = "offset ".$offset;
            
            if($limit > 0){
                $sqllimit = "limit ".$limit." ";
            }
            $sql = $sql.$sqllimit.$sqloffset;
            $result = $pdo->query($sql);
            Database::disconnect();

            $arr = Array();
            foreach ($result as $row) {
                $arr[] = $row;
            }
            // Return json array containing data from the database
            return json_encode($arr);
        
        }
        
        function listAvisoM($cuenta, $buscar, $limit, $offset){
            
            // mysqli query to fetch all data from database
            $pdo = Database::connect();
            $sql = "SELECT * from aviso where cuenta = " . $cuenta . " and estado = 'A' and UPPER(descripcion) LIKE UPPER(CONCAT('%','" . $buscar . "','%')) order by id desc ";
            $sqllimit = " ";
            $sqloffset = "offset ".$offset;
            
            if($limit > 0){
                $sqllimit = "limit ".$limit." ";
            }
            $sql = $sql.$sqllimit.$sqloffset;
            $result = $pdo->query($sql);
            Database::disconnect();

            $arr = Array();
            foreach ($result as $row) {
                $arr[] = $row;
            }
            // Return json array containing data from the database
            return json_encode($arr);
        
        }
        
        function saveAviso(Aviso $aviso){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = true;
            try {
                $sql = "INSERT into aviso (titulo, descripcion,telefono, precio,latitud,longitud, transaccion_aviso,cuenta,sub_categoria,tipo_aviso,imagen,direccion) VALUES ('" .$aviso->getTitulo() ."','".$aviso->getDescripcion()."','".$aviso->getTelefono()."',".$aviso->getPrecio().",".$aviso->getLatitud().",".$aviso->getLongitud().",".$aviso->getTransaccionAviso().",".$aviso->getCuenta().",".$aviso->getSubCategoria().",".$aviso->getTipoAviso().",'".$aviso->getImagen()."','".$aviso->getDireccion()."')";
                $q = $pdo->prepare($sql);
                $res = $q->execute();
            } catch (Exception $ex) {
                $result = false;
            }
            Database::disconnect();
            return $result;
        }
        
        function updateAviso(Aviso $aviso){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = true;
            try {
                $sql = "UPDATE aviso SET titulo = '".$aviso->getTitulo()."', descripcion = '".$aviso->getDescripcion()."', direccion = '".$aviso->getDireccion()."',telefono = '".$aviso->getTelefono()."',precio = ".$aviso->getPrecio().",imagen = '".$aviso->getImagen()."', transaccion_aviso = ".$aviso->getTransaccionAviso()." ,cuenta = ".$aviso->getCuenta().",sub_categoria = ".$aviso->getSubCategoria()." ,tipo_aviso = ".$aviso->getTipoAviso()." where id = " . $aviso->getId();
                $q = $pdo->prepare($sql);
                $res = $q->execute();
            } catch (Exception $ex) {
                $result = false;
            }
            Database::disconnect();
            return $result;
        }
        
        function deleteAviso(Aviso $aviso){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = true;
            try {
                $sql = "UPDATE aviso SET estado = 'X' where id = ".$aviso->getId();
                $q = $pdo->prepare($sql);
                $res = $q->execute();
            } catch (Exception $ex) {
                $result = false;
            }
            Database::disconnect();
            return $result;
        }
    }
?>

