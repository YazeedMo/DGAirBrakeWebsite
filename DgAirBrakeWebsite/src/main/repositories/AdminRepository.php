<?php

    require_once __DIR__ . '/../../main/model/User.php';
    require_once __DIR__ . '/../../main/model/Admin.php';
    require_once __DIR__ . '/../../main/config/DatabaseConnection.php';
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
                    $row['Username'],
                    $row['Password'],
                    $row['Email']
                );
                $admin->setUserID($row['UserID']);
                $admin->setAdminID($row['AdminID']);

                $allAdmins[] = $admin;

            }

            return $allAdmins;

        }

        public function getAdminByID($adminID) {

            $sql = "SELECT * FROM Users_Admins WHERE AdminID = :adminId";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'adminId' => $adminID
            ]);

            $row = $stmt->fetch();

            if ($row) {

                $admin = new Admin(
                    $row['"Username'],
                    $row['Password'],
                    $row['Email']
                );
                $admin->setAdminID($row['AdminID']);

                return $admin;
            }
        }

        public function createAdmin($admin) {

            $sql = "CALL AddAdmin(:username, :password, :email)";

            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute([
                'username' => $admin->getUsername(),
                'password' => $admin->getPassword(),
                'email' => $admin->getEmail()
            ]);

            if ($stmt->rowCount() > 0) {
                return $this->getAdminByID($this->dbConnection->lastInsertId());
            }
            else {
                return false;
            }

        }

        public function updateAdmin($admin) {

            $sql = "CALL UpdateAdmin(:userId, :adminId, :username, :password, :email)";
            $stmt = $this->dbConnection->prepare($sql);
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