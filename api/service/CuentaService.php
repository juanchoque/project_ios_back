<?php
    require_once 'database_connections.php';
    
    class CuentaService{
        function listCuenta($buscar, $limit, $offset){
            
            // mysqli query to fetch all data from database
            $pdo = Database::connect();
            $sql = "SELECT * from cuenta where estado = 'A' order by id desc ";
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
        
        function saveCuenta(Cuenta $cuenta){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = true;
            $aux = array();
            $LAST_ID = 1;//por defecto
            $rcuenta = new Cuenta();
            try {
                $sql = "INSERT into cuenta (ci,celular,nombres,aparteno, ciudad, tipo_cuenta) VALUES ('" .$cuenta->getCi() ."','".$cuenta->getCelular()."','".$cuenta->getNombres()."','" . $cuenta->getAparteno() . "',".$cuenta->getCiudad().",".$cuenta->getTipoCuenta().")";
                $q = $pdo->prepare($sql);
                $res = $q->execute();
                
                $LAST_ID = $pdo->lastInsertId();
            } catch (Exception $ex) {
                $result = false;
                $LAST_ID = 1;
            }
            Database::disconnect();
            
            $aux[0] = array('id'=>$LAST_ID);
            $rcuenta = $aux[0];
            return $rcuenta;
        }
        
        function updateCuenta(Cuenta $cuenta){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = true;
            try {
                $sql = "UPDATE cuenta SET ci = '".$cuenta->getCi()."', nombres = '".$cuenta->getNombres()."', ciudad = ".$cuenta->getCiudad().", tipo_cuenta = ".$cuenta->getTipoCuenta()." where id = ".$cuenta->getId();
                $q = $pdo->prepare($sql);
                $res = $q->execute();
            } catch (Exception $ex) {
                $result = false;
            }
            Database::disconnect();
            return $result;
        }
        
        function deleteCuenta(Cuenta $cuenta){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = true;
            try {
                $sql = "UPDATE cuenta SET estado = 'X' where id = ".$cuenta->getId();
                $q = $pdo->prepare($sql);
                $res = $q->execute();
            } catch (Exception $ex) {
                $result = false;
            }
            Database::disconnect();
            return $result;
        }
        
        function obtenerCuenta(Cuenta $cuenta){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $aux = array();
            $rcuenta = new Cuenta();
            $rid = 0;
            try {
                $sql = "SELECT * from cuenta WHERE estado <> 'X' and celular = '" . $cuenta->getCelular() . "' order by id desc";
                $result = $pdo->query($sql);
                
                foreach ($result as $row) {
                    $aux[] = $row;
                    break;
                }
            } catch (Exception $ex) {
                $aux = array();
            }
            Database::disconnect();
            
            if(count($aux) > 0){
                $rcuenta = $aux[0];
            }
            return $rcuenta;
        }
    }
?>

