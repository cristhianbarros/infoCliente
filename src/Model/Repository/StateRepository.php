<?php

namespace HandyCommerce\Model\Repository;

class StateRepository {

    const TABLE_STATES = 'states';

    public static function all() {
        $conexion = new \HandyCommerce\Model\Conexion();
        $consulta = $conexion->prepare("SELECT id, name FROM " . self::TABLE_STATES . " ORDER BY id");
        $consulta->execute();
        $states = $consulta->fetchAll();

        return $states;
    }

    public static function findByCountry($id) {
        $conexion = new \HandyCommerce\Model\Conexion();
        $consulta = $conexion->prepare("SELECT id, name FROM " . self::TABLE_STATES . " WHERE country_id = :id ORDER BY id");
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $error = $conexion->errorInfo();

        if ($error[2]) {
            echo "PDOStatement::errorInfo(): ";
            print_r($error[2]);
        }

        $states = $consulta->fetchAll();

        return $states;
    }

}
