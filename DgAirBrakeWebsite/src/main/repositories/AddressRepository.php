<?php

    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';
    require_once __DIR__ . '/../../main/model/Address.php';

    class AddressRepository {

        private $dbConnection;

        public function __construct() {
            
            $this->dbConnection = DatabaseConnection::getInstance();

        }

        public function getAllAddresses() {

            $allAddresses = array();

            $query = "SELECT * FROM Addresses";
            $result = $this->dbConnection->query($query);

            while ($row = $result->fetch()) {
                $address = new Address(
                    $row['AddressID'],
                    $row['AddressString'],
                    $row['AreaCode']
                );

                $allAddresses[] = $address;
            }

            return $allAddresses;

        }

        public function createAddress($address) {

            $stmt = $this->dbConnection->prepare("INSERT INTO Addresses(AddressID, AddressString, AreaCode) VALUES (:addressId, :addressString, :areaCode)");
            return $stmt->execute([
                'addressId' => $address->getAddressID(),
                'addressString' => $address->getAddressString(),
                'areaCode' => $address->getAreaCode()
            ]);

        }

        public function updateAddress($address) {

            $stmt = $this->dbConnection->prepare("UPDATE Addresses SET AddressString = :addressString, AreaCode = :areaCode WHERE AddressID = :addressId");
            return $stmt->execute([
                'addressString' => $address->getAddressString(),
                'areaCode' => $address->getAreaCode(),
                'addressId' => $address->getAddressID()
            ]);

        }

        public function deleteAddress($addressID) {

            // Delete from CustomerAddresses table first
            $stmt = $this->dbConnection->prepare("DELETE FROM CustomerAddresses WHERE AddressID = :addressId");
            $stmt->execute([
                'addressId' => $addressID
            ]);

            // Then delete from Addresses tables
            $stmt = $this->dbConnection->prepare("DELETE FROM Addresses WHERE AddressID = :addressId");
            return $stmt->execute([
                'addressId' => $addressID
            ]);

        }

    }

?>