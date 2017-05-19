<?php

namespace HandyCommerce\Model\Repository;

class CityRepository {

    const TABLE_CITIES = 'cities';

    public static function all() {
        $conexion = new \HandyCommerce\Model\Conexion();
        $consulta = $conexion->prepare("SELECT id, name FROM " . self::TABLE_CITIES . " ORDER BY id");
        $consulta->execute();
        $cities = $consulta->fetchAll();

        return $cities;
    }

    public static function findByState($id) {
        $conexion = new \HandyCommerce\Model\Conexion();
        $consulta = $conexion->prepare("SELECT id, name FROM " . self::TABLE_CITIES . " WHERE state_id = :id ORDER BY id");
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $error = $conexion->errorInfo();

        if ($error[2]) {
            echo "PDOStatement::errorInfo(): ";
            print_r($error[2]);
        }

        $cities = $consulta->fetchAll();

        return $cities;
    }

}
