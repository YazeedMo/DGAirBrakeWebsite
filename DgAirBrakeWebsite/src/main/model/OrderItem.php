<?php

class OrderItem {
    private $orderItemID;
    private $orderID;
    private $productID;
    private $quantity;
    private $price;

    // Constructor
    public function __construct($orderItemID, $orderID, $productID, $quantity, $price) {
        $this->orderItemID = $orderItemID;
        $this->orderID = $orderID;
        $this->productID = $productID;
        $this->quantity = $quantity;
        $this->price = $price;
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
