<?php

class OrderItem {
    private $orderItemID;
    private $orderID;
    private $productID;
    private $quantity;
    private $price;

    // Constructor
    public function __construct($orderID, $productID, $quantity, $price) {
        $this->orderID = $orderID;
        $this->productID = $productID;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    // Getters
    public function getOrderItemID() {
        return $this->orderItemID;
    }

    public function getOrderID() {
        return $this->orderID;
    }

    public function getProductID() {
        return $this->productID;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getPrice() {
        return $this->price;
    }

    // Setters
    public function setOrderItemID($OrderItemID) {
        $this->orderItemID = $OrderItemID;
    }

    public function setOrderID($OrderID) {
        $this->orderID = $OrderID;
    }

    public function setProductID($ProductID) {
        $this->productID = $ProductID;
    }

    public function setQuantity($Quantity) {
        $this->quantity = $Quantity;
    }

    public function setPrice($Price) {
        $this->price = $Price;
    }

    public function jsonSerialize() {

        return [
            'orderItemID' => $this->getOrderItemID(),
            'orderID' => $this->getOrderID(),
            'productID' => $this->getProductID(),
            'quantity' => $this->getQuantity(),
            'price' => $this->getPrice()
        ];

    }

    public function __toString() {
        
        $desc = "$this->orderItemID<br>
                 $this->orderID<br>
                 $this->productID<br>
                 $this->quantity<br>
                 $this->price<br>";
        
        return $desc;

    }

}

?>
