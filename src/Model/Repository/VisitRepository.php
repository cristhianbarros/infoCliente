<?php

namespace HandyCommerce\Model\Repository;

use HandyCommerce\Model\Visit as v;

class VisitRepository {

    const TABLE_VISITS = "customers_x_visits";

    public static function save(v $v) {

        $conexion = new \HandyCommerce\Model\Conexion();

        $id = $v->getId();

        $date = $v->getDate();
        $net_value = $v->getNetValue();
        $visit_value = $v->getVisitValue();
        $comments = $v->getComments();
        $customer_id = $v->getCustomerId();
        $seller_id = $v->getSellerId();


        if (is_null($id)) {
            
            $string_transact = "START TRANSACTION;
                                    INSERT INTO " . self::TABLE_VISITS . " (date, net_value, visit_value, comments, customer_id, seller_id) VALUES (:date, :net_value, :visit_value, :comments, :customer_id, :seller_id);
                                    SELECT @ANT_BALANCE_QUOTA:= balance_quota FROM customers WHERE id = :customer_id;    
                                    SELECT @BALANCE_QUOTA:=(@ANT_BALANCE_QUOTA - :visit_value) FROM customers WHERE id = :customer_id;
                                    SELECT @COMMENTS:= comments FROM customers_x_visits WHERE id = LAST_INSERT_ID();
                                    SELECT @ADD_COMMENTS:= CONCAT(' VALOR BALANCE SALDO: ', @ANT_BALANCE_QUOTA,', NUEVO VALOR BALANCE SALDO: ', @BALANCE_QUOTA);
                                    UPDATE customers SET balance_quota = @BALANCE_QUOTA WHERE id = :customer_id;
                                    UPDATE customers_x_visits SET comments = CONCAT(@COMMENTS, ' NOTA: ',@ADD_COMMENTS)  WHERE id = LAST_INSERT_ID();
                                COMMIT;";
            
            $consulta = $conexion->prepare($string_transact);
            $consulta->bindParam(':date', $date);
            $consulta->bindParam(':net_value', $net_value);
            $consulta->bindParam(':visit_value', $visit_value);
            $consulta->bindParam(':comments', $comments);
            $consulta->bindParam(':customer_id', $customer_id);
            $consulta->bindParam(':seller_id', $seller_id);
            $consulta->execute();
            
            $error = $conexion->errorInfo();
            
            if ($error[2]) {
                echo "PDOStatement::errorInfo(): ";
                print_r($error[2]);
            }
            
            
        } 

        $conexion = null;
    }

    public static function visitsByCustomer($id) {

        $conexion = new \HandyCommerce\Model\Conexion();
        $consulta = $conexion->prepare('SELECT date, net_value, visit_value, comments, s.full_name seller FROM '.self::TABLE_VISITS.' INNER JOIN sellers s ON s.id = seller_id WHERE customer_id = :id');
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $error = $conexion->errorInfo();
        $visits = $consulta->fetchAll();

        if ($error[2]) {
            echo "PDOStatement::errorInfo(): ";
            print_r($error[2]);
        }
        
        $conexion = null;
        
        return $visits;
        
    }
    
    public static function getDataVisitsGraphic() {
        
        $conexion = new \HandyCommerce\Model\Conexion();
        $consulta = $conexion->prepare('SELECT city.name, COUNT(name) visitas FROM '.self::TABLE_VISITS.' cxv INNER JOIN customers c ON cxv.customer_id = c.id INNER JOIN cities city ON c.city_id = city.id GROUP BY name');
        
        $consulta->execute();
        $error = $conexion->errorInfo();
        $data = $consulta->fetchAll();

        if ($error[2]) {
            echo "PDOStatement::errorInfo(): ";
            print_r($error[2]);
        }
        
        $conexion = null;
        
        return $data;
    }

}
