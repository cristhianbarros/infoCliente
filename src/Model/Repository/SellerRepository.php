<?php

namespace HandyCommerce\Model\Repository;


class SellerRepository {
    
    const TABLE_SELLERS = "sellers";
    
    public static function all() {
        $conexion = new \HandyCommerce\Model\Conexion();
        $consulta = $conexion->prepare("SELECT id, full_name FROM " . self::TABLE_SELLERS . " ORDER BY id");
        $consulta->execute();
        $sellers = $consulta->fetchAll();

        return $sellers;
    }
    
}
