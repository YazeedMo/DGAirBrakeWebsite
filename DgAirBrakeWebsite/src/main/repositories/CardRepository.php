<?php

    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';
    require_once __DIR__ . '/../../main/model/Card.php';

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
                    $row['CardID'],
                    $row['CardNumber'],
                    $row['ExpirationDate'],
                    $row['CardType']
                    
                );
                
                $allCards[] = $card;
            }

            return $allCards;

        }

        public function createCard($card) {

            $stmt = $this->dbConnection->prepare("INSERT INTO Cards (CardID, CardNumber, ExpirationDate, CardType) VALUES (:cardId, :cardNumber, :expirationDate, :cardType)");
            return $stmt->execute([
                'cardId' => $card->getCardID(),
                'cardNumber' => $card->getCardNumber(),
                'expirationDate' => $card->getExpirationDate(),
                'cardType' => $card->getCardType()
            ]);

        }

        public function updateCard($card) {

            $stmt = $this->dbConnection->prepare("UPDATE Cards SET CardNumber = :cardNumber, ExpirationDate = :expirationDate, CardType = :cardType WHERE CardID = :cardId");
            return $stmt->execute([
                'cardId' => $card->getCardID(),
                'cardNumber' => $card->getCardNumber(),
                'expirationDate' => $card->getExpirationDate(),
                'cardType' => $card->getCardType()
            ]);
        
        }
        

        public function deleteCard($cardID) {

            $stmt = $this->dbConnection->prepare("DELETE FROM Cards WHERE CardID = :cardId");
            return $stmt->execute([
                'cardId' => $cardID
            ]);

        }

    }

?>
