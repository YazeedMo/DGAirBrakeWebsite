<?php

    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';
    require_once __DIR__ . '/../../main/model/User.php';
    require_once __DIR__ . '/../../main/model/Admin.php';
    require_once __DIR__ . '/../../main/repositories/UserRepository.php';

    class AdminRepository extends UserRepository {

        public function __construct() {
            parent::__construct();
        }

        public function getAllAdmins() {

            $allAdmins = array();

            $query = "SELECT * FROM Users_Admins";
            $result = $this->dbConnection->query($query);

            while ($row = $result->fetch()) {

                $admin = new Admin(
                    $row['AdminID'],
                    $row['UserID'],
                    $row['Username'],
                    $row['Password'],
                    $row['Email']
                );

                $allAdmins[] = $admin;

            }

            return $allAdmins;

        }

        public function createAdmin($admin) {

            $stmt = $this->dbConnection->prepare("CALL AddAdmin(:userId, :adminId, :username, :password, :email)");
            return $stmt->execute([
                'userId' => $admin->getUserId(),
                'adminId' => $admin->getAdminId(),
                'username' => $admin->getUsername(),
                'password' => $admin->getPassword(),
                'email' => $admin->getEmail()
            ]);

        }

        public function updateAdmin($admin) {

            $stmt = $this->dbConnection->prepare("CALL UpdateAdmin(:userId, :adminId, :username, :password, :email)");
            return $stmt->execute([
                'userId' => $admin->getUserId(),
                'adminId' => $admin->getAdminId(),
                'username' => $admin->getUsername(),
                'password' => $admin->getPassword(),
                'email' => $admin->getEmail()
            ]);

        }

    }

?>