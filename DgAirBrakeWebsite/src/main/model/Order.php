<?php

class Order implements JsonSerializable {
    private $orderID;
    private $customerID;
    private $orderDate;
    private $totalAmount;
    private $orderStatus;

    // Constructor
    public function __construct($customerID, $orderDate, $totalAmount, $orderStatus) {
        $this->customerID = $customerID;
        $this->orderDate = $orderDate;
        $this->totalAmount = $totalAmount;
        $this->orderStatus = $orderStatus;
    }

    // Getters
    public function getOrderID() {
        return $this->orderID;
    }

    public function getCustomerID() {
        return $this->customerID;
    }

    public function getOrderDate() {
        return $this->orderDate;
    }

    public function getTotalAmount() {
        return $this->totalAmount;
    }

    public function getOrderStatus() {
        return $this->orderStatus;
    }

    // Setters
    public function setOrderID($OrderID) {
        $this->orderID = $OrderID;
    }

    public function setCustomerID($CustomerID) {
        $this->customerID = $CustomerID;
    }

    public function setOrderDate($OrderDate) {
        $this->orderDate = $OrderDate;
    }

    public function setTotalAmount($TotalAmount) {
        $this->totalAmount = $TotalAmount;
    }

    public function setOrderStatus($OrderStatus) {
        $this->orderStatus = $OrderStatus;
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
