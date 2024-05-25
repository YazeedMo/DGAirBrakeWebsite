<?php

class OrderItem {
    private $OrderItemID;
    private $OrderID;
    private $ProductID;
    private $Quantity;
    private $Price;

    // Constructor
    public function __construct($OrderItemID, $OrderID, $ProductID, $Quantity, $Price) {
        $this->OrderItemID = $OrderItemID;
        $this->OrderID = $OrderID;
        $this->ProductID = $ProductID;
        $this->Quantity = $Quantity;
        $this->Price = $Price;
    }

    // Getters
    public function getOrderItemID() {
        return $this->OrderItemID;
    }

    public function getOrderID() {
        return $this->OrderID;
    }

    public function getProductID() {
        return $this->ProductID;
    }

    public function getQuantity() {
        return $this->Quantity;
    }

    public function getPrice() {
        return $this->Price;
    }

    // Setters
    public function setOrderItemID($OrderItemID) {
        $this->OrderItemID = $OrderItemID;
    }

    public function setOrderID($OrderID) {
        $this->OrderID = $OrderID;
    }

    public function setProductID($ProductID) {
        $this->ProductID = $ProductID;
    }

    public function setQuantity($Quantity) {
        $this->Quantity = $Quantity;
    }

    public function setPrice($Price) {
        $this->Price = $Price;
    }
}

?>
