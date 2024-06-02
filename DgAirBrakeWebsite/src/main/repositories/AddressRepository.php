<?php

    require_once __DIR__ . '/../../main/model/Address.php';
    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';

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
                    $row['AddressString'],
                    $row['AreaCode']
                );
                $address->setAddressID($row['AddressID']);

                $allAddresses[] = $address;
            }

            return $allAddresses;

        }

        public function getAddressByID($addressID) {

            $sql = "SELECT * FROM Addresses WHERE AddressID = :addressId";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'addressId' => $addressID
            ]);

            $row = $stmt->fetch();

            if ($row) {

                $address = new Address(
                    $row['AddressString'],
                    $row['AreaCode']
                );
                $address->setAddressID($row['AddressID']);

                return $address;

            }

        }

        public function createAddress($address) {

            $sql = "INSERT INTO Addresses(AddressString, AreaCode) VALUES (:addressString, :areaCode)";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'addressString' => $address->getAddressString(),
                'areaCode' => $address->getAreaCode()
            ]);

            if ($stmt->rowCount() > 0) {
                return $this->getAddressByID($this->dbConnection->lastInsertId());
            }
            else {
                return false;
            }

        }

        public function updateAddress($address) {

            $sql = "UPDATE Addresses SET AddressString = :addressString, AreaCode = :areaCode WHERE AddressID = :addressId";

            $stmt = $this->dbConnection->prepare($sql);
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