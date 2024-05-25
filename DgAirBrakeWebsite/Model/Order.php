<?php

class Order {
    private $OrderID;
    private $CustomerID;
    private $OrderDate;
    private $TotalAmount;
    private $OrderStatus;

    // Constructor
    public function __construct($OrderID, $CustomerID, $OrderDate, $TotalAmount, $OrderStatus) {
        $this->OrderID = $OrderID;
        $this->CustomerID = $CustomerID;
        $this->OrderDate = $OrderDate;
        $this->TotalAmount = $TotalAmount;
        $this->OrderStatus = $OrderStatus;
    }

    // Getters
    public function getOrderID() {
        return $this->OrderID;
    }

    public function getCustomerID() {
        return $this->CustomerID;
    }

    public function getOrderDate() {
        return $this->OrderDate;
    }

    public function getTotalAmount() {
        return $this->TotalAmount;
    }

    public function getOrderStatus() {
        return $this->OrderStatus;
    }

    // Setters
    public function setOrderID($OrderID) {
        $this->OrderID = $OrderID;
    }

    public function setCustomerID($CustomerID) {
        $this->CustomerID = $CustomerID;
    }

    public function setOrderDate($OrderDate) {
        $this->OrderDate = $OrderDate;
    }

    public function setTotalAmount($TotalAmount) {
        $this->TotalAmount = $TotalAmount;
    }

    public function setOrderStatus($OrderStatus) {
        $this->OrderStatus = $OrderStatus;
    }
}

?>
