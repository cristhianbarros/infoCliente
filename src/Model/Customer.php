<?php

namespace HandyCommerce\Model;

class Customer {
 
    protected $id;
    protected $dni;
    protected $fullName;
    protected $address;
    protected $phone;
    protected $city;
    protected $quote;
    protected $balanceQuote;
    protected $perecentageVisit;
    
    function __construct($id = null, $dni, $fullName, $address, $phone, $city, $quote, $balanceQuote, $perecentageVisit) {
        $this->id = $id;
        $this->dni = $dni;
        $this->fullName = $fullName;
        $this->address = $address;
        $this->phone = $phone;
        $this->city = $city;
        $this->quote = $quote;
        $this->balanceQuote = $balanceQuote;
        $this->perecentageVisit = $perecentageVisit;
    }

    
    function getId() {
        return $this->id;
    }

    function getDni() {
        return $this->dni;
    }

    function getFullName() {
        return $this->fullName;
    }

    function getAddress() {
        return $this->address;
    }

    function getPhone() {
        return $this->phone;
    }

    function getCity() {
        return $this->city;
    }

    function getQuote() {
        return $this->quote;
    }

    function getBalanceQuote() {
        return $this->balanceQuote;
    }

    function getPerecentageVisit() {
        return $this->perecentageVisit;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDni($dni) {
        $this->dni = $dni;
    }

    function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }

    function setCity($city) {
        $this->city = $city;
    }

    function setQuote($quote) {
        $this->quote = $quote;
    }

    function setBalanceQuote($balanceQuote) {
        $this->balanceQuote = $balanceQuote;
    }

    function setPerecentageVisit($perecentageVisit) {
        $this->perecentageVisit = $perecentageVisit;
    }
    
}
