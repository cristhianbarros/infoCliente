<?php

namespace HandyCommerce\Model\Repository;

use HandyCommerce\Model\Customer as customer;

class CustomerRepository {

    const TABLE_CUSTOMER = 'customers';

    static function encode_this($string) {
        $string = utf8_encode($string);
        $control = "e5toesUnacontraseñapraencriptar";
        $string = $control . $string . $control;
        $string = base64_encode($string);
        return $string;
    }

    static function decode_this($string) {
        $string = base64_decode($string);
        $control = "e5toesUnacontraseñapraencriptar";
        $string = str_replace($control, "", "$string");

        return $string;
    }

    public static function all() {
        $conexion = new \HandyCommerce\Model\Conexion();
        $consulta = $conexion->prepare("SELECT c.id, dni, full_name, address, phone, city_id, quota, balance_quota, percentage_visit, st.id state_id, cts.id country_id, (SELECT COUNT(id) FROM customers_x_visits WHERE customer_id = c.id) number_visits FROM " . self::TABLE_CUSTOMER . " c  
                               INNER JOIN cities ct ON c.city_id = ct.id 
                               INNER JOIN states st ON ct.state_id = st.id
                               INNER JOIN countries cts ON cts.id = st.country_id ORDER BY id");
        $consulta->execute();
        $customers = $consulta->fetchAll();

        $customer_array = array();
        for ($i = 0; $i < sizeof($customers); $i++) {
            $customer_array[] = [
                "id" => $customers[$i]['id'],
                "dni" => self::decode_this($customers[$i]['dni']),
                "full_name" => $customers[$i]['full_name'],
                "address" => $customers[$i]['address'],
                "phone" => $customers[$i]['phone'],
                "city_id" => $customers[$i]['city_id'],
                "quota" => $customers[$i]['quota'],
                "balance_quota" => $customers[$i]['balance_quota'],
                "percentage_visit" => $customers[$i]['percentage_visit'],
                "state_id" => $customers[$i]['state_id'],
                "country_id" => $customers[$i]['country_id'],
                "number_visits" => $customers[$i]['number_visits']
            ];
        }


        return $customer_array;
    }

    public static function findById($id) {
        $conexion = new \HandyCommerce\Model\Conexion();
        $consulta = $conexion->prepare("SELECT c.id, dni, full_name, address, phone, city_id, quota, balance_quota, percentage_visit, st.id state_id, cts.id country_id FROM " . self::TABLE_CUSTOMER . " c  
                               INNER JOIN cities ct ON c.city_id = ct.id 
                               INNER JOIN states st ON ct.state_id = st.id
                               INNER JOIN countries cts ON cts.id = st.country_id WHERE c.id = :id");

        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $error = $conexion->errorInfo();
        if ($error[2]) {
            echo "PDOStatement::errorInfo(): ";
            print_r($error[2]);
        }

        $customer = $consulta->fetch();

        $customer_array = [
            "id" => $customer['id'],
            "dni" => self::decode_this($customer['dni']),
            "full_name" => $customer['full_name'],
            "address" => $customer['address'],
            "phone" => $customer['phone'],
            "city_id" => $customer['city_id'],
            "quota" => $customer['quota'],
            "balance_quota" => $customer['balance_quota'],
            "percentage_visit" => $customer['percentage_visit'],
            "state_id" => $customer['state_id'],
            "country_id" => $customer['country_id']
        ];

        return $customer_array;
    }

    public static function save(customer $c) {

        $conexion = new \HandyCommerce\Model\Conexion();
        $id = $c->getId();

        $dni_encode = self::encode_this($c->getDni());

        $dni = $dni_encode;
        $full_name = $c->getFullName();
        $address = $c->getAddress();
        $phone = $c->getPhone();
        $quota = $c->getQuote();
        $balance_quota = $c->getBalanceQuote();
        $percentage_visit = $c->getPerecentageVisit();
        $city_id = $c->getCity();

        if (is_null($id)) {
            $consulta = $conexion->prepare('INSERT INTO ' . self::TABLE_CUSTOMER . ' (dni, full_name, address, phone, quota, balance_quota, percentage_visit, city_id) VALUES (:dni, :full_name, :address, :phone, :quota, :balance_quota, :percentage_visit, :city_id)');
            $consulta->bindParam(':dni', $dni);
            $consulta->bindParam(':full_name', $full_name);
            $consulta->bindParam(':address', $address);
            $consulta->bindParam(':phone', $phone);
            $consulta->bindParam(':quota', $quota);
            $consulta->bindParam(':balance_quota', $quota);
            $consulta->bindParam(':percentage_visit', $percentage_visit);
            $consulta->bindParam(':city_id', $city_id);

            $consulta->execute();
            $error = $conexion->errorInfo();
            if ($error[2]) {
                echo "PDOStatement::errorInfo(): ";
                print_r($error[2]);
            }
        } else {

            $consulta = $conexion->prepare('UPDATE ' . self::TABLE_CUSTOMER . ' SET dni = :dni, full_name = :full_name, address = :address, phone = :phone, quota = :quota, balance_quota = :balance_quota, percentage_visit = :percentage_visit, city_id = :city_id WHERE id =:id');
            $consulta->bindParam(':dni', $dni);
            $consulta->bindParam(':full_name', $full_name);
            $consulta->bindParam(':address', $address);
            $consulta->bindParam(':phone', $phone);
            $consulta->bindParam(':quota', $quota);
            $consulta->bindParam(':balance_quota', $quota);
            $consulta->bindParam(':percentage_visit', $percentage_visit);
            $consulta->bindParam(':city_id', $city_id);
            $consulta->bindParam(':id', $id);
            $consulta->execute();

            $error = $conexion->errorInfo();

            if ($error[2]) {
                echo "PDOStatement::errorInfo(): ";
                print_r($error[2]);
            }
        }
    }

    public static function delete(customer $c) {

        $id = $c->getId();
        if (!is_null($id)) {
            try {
                $conexion = new \HandyCommerce\Model\Conexion();
                $consulta = $conexion->prepare("DELETE FROM " . self::TABLE_CUSTOMER . " WHERE id = :id");
                $consulta->bindParam(':id', $id);
                $consulta->execute();
            } catch (PDOException $e) {
                echo "Este es el eerror: " . $e->getMessage();
                $conexion = null;
            }
        }
    }

    public static function checkBalanceQuota($id) {
        $conexion = new \HandyCommerce\Model\Conexion();
        $consulta = $conexion->prepare("SELECT COALESCE(balance_quota, 0) balance_quota FROM " . self::TABLE_CUSTOMER . " WHERE id = :id");

        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $error = $conexion->errorInfo();
        if ($error[2]) {
            echo "PDOStatement::errorInfo(): ";
            print_r($error[2]);
        }

        $balance_quota = $consulta->fetch();
        return $balance_quota;
    }

}
