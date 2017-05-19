<?php

namespace HandyCommerce\Model\Repository;

class CountryRepository {
    
    const TABLE_COUNTRIES = 'countries';
    
    public static function all() {
        $conexion = new \HandyCommerce\Model\Conexion();
        $consulta = $conexion->prepare("SELECT id, name FROM " . self::TABLE_COUNTRIES . " ORDER BY id");
        $consulta->execute();
        $countries = $consulta->fetchAll();
        
        return $countries;
    }
    
}
