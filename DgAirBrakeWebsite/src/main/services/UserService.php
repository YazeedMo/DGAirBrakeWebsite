<?php

    require_once __DIR__ . '/../../main/model/User.php';
    require_once __DIR__ . '/../../main/repositories/AdminRepository.php';

    class UserService {

        private $userRepo;

        public function __construct() {
            $this->userRepo = new AdminRepository;
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

    }

?>