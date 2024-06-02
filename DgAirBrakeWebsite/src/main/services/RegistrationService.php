<?php

    require_once __DIR__ . '/../../main/model/Customer.php';
    require_once __DIR__ . '/../../main/model/Address.php';
    require_once __DIR__ . '/../../main/model/Card.php';

    require_once __DIR__ . '/../../main/repositories/CustomerRepository.php';
    require_once __DIR__ . '/../../main/repositories/AddressRepository.php';
    require_once __DIR__ . '/../../main/repositories/CardRepository.php';
    require_once __DIR__ . '/../../main/repositories/CardRepository.php';

    class RegistrationService {

        private $customerRepo;
        private $addressRepo;
        private $cardRepo;

        public function __construct() {
            $this->customerRepo = new CustomerRepository;
            $this->addressRepo = new AddressRepository;
            $this->cardRepo = new CardRpository;
        }

        public function validateUsername($username) {

            $user = $this->customerRepo->getUserByUsername($username);

            if ($user === null) {
                return true;
            }
            return false;

        }

        public function validateCardNumber($cardNumber) {

            $cardRepo = new CardRpository;

            $card = $cardRepo->getCardByCardNumber($cardNumber);

            if ($card === null) {
                return true;
            }
            return false;

        }

        private function addCard($cardNumber, $expirationDate, $cardType) {

            $newCard = new Card($cardNumber, $expirationDate, $cardType);

            return $this->cardRepo->createCard($newCard);

        }

        private function addAddress($addressString, $areaCode) {

            $newAddress = new Address($addressString, $areaCode);

            return $this->addressRepo->createAddress($newAddress);

        }

        public function addCustomer($username, $password, $email, $addressString, $areaCode, $cardNumber, $expirationDate, $cardType) {

            $this->addAddress($addressString, $areaCode);

            $newCard = $this->addCard($cardNumber, $expirationDate, $cardType);
            $newCardID = $newCard->getCardID();

            $newCustomer = new Customer($username, $password, $email, $newCardID);

            return $this->customerRepo->createCustomer($newCustomer);

        }

    }

?>