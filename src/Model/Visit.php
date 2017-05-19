<?php

namespace HandyCommerce\Model;

class Visit {

    protected $id;
    protected $date;
    protected $netValue;
    protected $visitValue;
    protected $comments;
    protected $customerId;
    protected $sellerId;

    function __construct($id = null, $date, $netValue, $visitValue, $comments, $customerId, $sellerId) {
        $this->id = $id;
        $this->date = $date;
        $this->netValue = $netValue;
        $this->visitValue = $visitValue;
        $this->comments = $comments;
        $this->customerId = $customerId;
        $this->sellerId = $sellerId;
    }

    function getId() {
        return $this->id;
    }

    function getDate() {
        return $this->date;
    }

    function getNetValue() {
        return $this->netValue;
    }

    function getVisitValue() {
        return $this->visitValue;
    }

    function getComments() {
        return $this->comments;
    }

    function getCustomerId() {
        return $this->customerId;
    }

    function getSellerId() {
        return $this->sellerId;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setNetValue($netValue) {
        $this->netValue = $netValue;
    }

    function setVisitValue($visitValue) {
        $this->visitValue = $visitValue;
    }

    function setComments($comments) {
        $this->comments = $comments;
    }

    function setCustomerId($customerId) {
        $this->customerId = $customerId;
    }

    function setSellerId($sellerId) {
        $this->sellerId = $sellerId;
    }

}
