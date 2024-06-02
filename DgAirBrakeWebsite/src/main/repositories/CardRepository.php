<?php

    require_once __DIR__ . '/../../main/model/Card.php';
    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';

    class CardRpository {

        private $dbConnection;

        public function __construct() {
            
            $this->dbConnection = DatabaseConnection::getInstance();

        }

        public function getAllCards() {

            $allCards = array();

            $query = "SELECT * FROM Cards";

            $result = $this->dbConnection->query($query);
            while ($row = $result->fetch()) {
                $card = new Card(
                    $row['CardNumber'],
                    $row['ExpirationDate'],
                    $row['CardType']
                );
                $card->setCardID($row['CardID']);
                
                $allCards[] = $card;
            }

            return $allCards;

        }

        public function getCardByID($cardID) {

            $sql = "SELECT * FROM Cards WHERE CardID = :cardId";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'cardId' =>$cardID
            ]);

            $row = $stmt->fetch();

            if ($row) {

                $card = new Card(
                    $row['CardNumber'],
                    $row['ExpirationDate'],
                    $row['CardType']
                );
                $card->setCardID($row['CardID']);

                return $card;

            }

        }

        public function getCardByCardNumber($cardNumber) {

            $sql = "SELECT * FROM Cards WHERE CardNumber = :cardNumber";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute(['cardNumber' => $cardNumber]);
            $row = $stmt->fetch();

            if ($row) {

                $card =  new Card(
                    $row['CardNumber'],
                    $row['ExpirationDate'],
                    $row['CardType']
                );
                $card->setCardID($row['CardID']);

                return $card;
            }
            
            return null;

        }

        public function createCard($card) {

            $sql = "INSERT INTO Cards (CardNumber, ExpirationDate, CardType) VALUES (:cardNumber, :expirationDate, :cardType)";

            $stmt = $this->dbConnection->prepare($sql);
            
            $stmt->execute([
                'cardNumber' => $card->getCardNumber(),
                'expirationDate' => $card->getExpirationDate(),
                'cardType' => $card->getCardType()
            ]);

            if ($stmt->rowCount() > 0) {
                return $this->getCardByID($this->dbConnection->lastInsertId());
            }
            else {
                return false;
            }
        }

        public function updateCard($card) {

            $sql = "UPDATE Cards SET CardNumber = :cardNumber, ExpirationDate = :expirationDate, CardType = :cardType WHERE CardID = :cardId";

            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'cardId' => $card->getCardID(),
                'cardNumber' => $card->getCardNumber(),
                'expirationDate' => $card->getExpirationDate(),
                'cardType' => $card->getCardType()
            ]);
        
        }
        

        public function deleteCard($cardID) {

            $sql = "DELETE FROM Cards WHERE CardID = :cardId";

            $stmt = $this->dbConnection->prepare($sql);
            return $stmt->execute([
                'cardId' => $cardID
            ]);

        }

    }

?>
