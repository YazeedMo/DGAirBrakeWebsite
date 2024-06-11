<?php

    require_once __DIR__ . '/../../main/repositories/AdminRepository.php';
    require_once __DIR__ . '/../../main/util/Session.php';

    class LoginService {

        private $adminRepo;

        public function __construct() {
            $this->adminRepo = new AdminRepository;
        }

        public function validateUsername($username) {

            return $this->adminRepo->getUserByUsername($username);

        }

        public function verifyPassword($user, $password) {

            if (password_verify($password, $user->getPassword())) {
                setSessionCurrentUser($user);
                return true;
            }
            else {
                return false;
            }

        }

    }

?>
