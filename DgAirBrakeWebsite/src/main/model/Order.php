<?php

class Order implements JsonSerializable {
    private $orderID;
    private $customerID;
    private $orderDate;
    private $totalAmount;
    private $orderStatus;

    // Constructor
    public function __construct($orderID, $customerID, $orderDate, $totalAmount, $orderStatus) {
        $this->orderID = $orderID;
        $this->customerID = $customerID;
        $this->orderDate = $orderDate;
        $this->totalAmount = $totalAmount;
        $this->orderStatus = $orderStatus;
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

    public function jsonSerialize() {

        return [
            'orderID' => $this->getOrderID(),
            'customerID' => $this->getCustomerID(),
            'orderDate' => $this->getOrderDate(),
            'totalAmount' => $this->getTotalAmount(),
            'orderStatus' => $this->getOrderStatus()
        ];

    }

    public function __toString() {
        
        $desc = "$this->orderID<br>
                 $this->customerID<br>
                 $this->orderDate<br>
                 $this->totalAmount<br>
                 $this->orderStatus<br>";

        return $desc;

    }

}

?>
