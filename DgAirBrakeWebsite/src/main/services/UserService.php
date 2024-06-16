<?php

    require_once __DIR__ . '/../../main/model/User.php';
    require_once __DIR__ . '/../../main/repositories/AdminRepository.php';
    require_once __DIR__ . '/../../main/repositories/CustomerRepository.php';
    require_once __DIR__ . '/../../main/repositories/AddressRepository.php';
    require_once __DIR__ . '/../../main/repositories/CardRepository.php';

    class UserService {

        private $userRepo;
        private $customerRepo;
        private $addressRepo;
        private $cardRepo;

        public function __construct() {
            $this->userRepo = new AdminRepository;
            $this->customerRepo = new CustomerRepository;
            $this->addressRepo = new AddressRepository;
            $this->cardRepo = new CardRpository;
        }

        public function getUserByUsername($username) {

            $user = $this->userRepo->getUserByUsername($username);

            if ($user === null) {
                return null;
            }
            else {
                return $user;
            }


        }

        public function getCustomerProfileData($customerID) {

            $customer = $this->customerRepo->getCustomerByID($customerID);
            $address = $this->addressRepo->getAddressByCustomerID($customerID);
            $customer = $this->customerRepo->getCustomerByID($customerID);
            $card = $this->cardRepo->getCardByID($customer->getCardID());

            $customerDetails = new stdClass();
            $customerDetails->customerUsername = $customer->getUsername();
            $customerDetails->customerEmail = $customer->getEmail();
            $customerDetails->addressString = $address->getAddressString();
            $customerDetails->areaCode = $address->getAreaCode();
            $customerDetails->cardNumber = $card->getCardNumber();
            $customerDetails->cardExpirationDate = $card->getExpirationDate();
            $customerDetails->cardType = $card->getCardType();

            return $customerDetails;

        }

    }

?>