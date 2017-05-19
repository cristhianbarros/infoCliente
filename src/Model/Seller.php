<?php

namespace HandyCommerce\Model;

class Seller {
    
    protected $id;
    protected $fullName;
    
    function __construct($id, $fullName) {
        $this->id = $id;
        $this->fullName = $fullName;
    }

    
    function getId() {
        return $this->id;
    }

    function getFullName() {
        return $this->fullName;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFullName($fullName) {
        $this->fullName = $fullName;
    }


    
}
