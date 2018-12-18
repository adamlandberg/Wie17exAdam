<?php

class User
{
    private $uid;
    private $pers;



    public static function checkUserSession()
    {
    }

    
    public function isLoggedIn()
    {
        if (!is_null($this->uid)) {
            return true;
        }
        return false;
    }


    public function logIn($email, $password)
    {
        global $dbh;


        $sql = "SELECT uid, password FROM user WHERE email = :email";

      
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $fetchUser = $stmt->fetch(PDO::FETCH_ASSOC);

        $hashedPwd = $fetchUser['password'];


        if (password_verify($password, $hashedPwd)) {
            $this->uid = intval($fetchUser['uid']);
        } else {
            
            $this->logOut();
        }
    }
   
    public function logOut()
    {
        $this->uid = null;
    }
   
    public function getUid()
    {
        return $this->uid;
    }
    
    public function getEmail()
    {
        global $dbh;
        $sql = "SELECT email FROM user WHERE uid = :uid";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':uid', $this->uid);
        $stmt->execute();

        return $stmt->fetchColumn();
    }
    
    public function getUserLevel()
    {
        global $dbh;
        $sql = "SELECT role FROM user WHERE uid = :uid";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':uid', $this->uid);
        $stmt->execute();

        return $stmt->fetchColumn();
    }
    
    public function isAdmin()
    {
        return (int)$this->getUserLevel() === 1;
    }
    
    public function isCostumer()
    {
        return (int)$this->getUserLevel() === 2;
    }

    public function isUser()
    {
    }
    
    public function getPersonalInformation($dbh)
    {
        $sql = "SELECT * FROM user where uid = :uid";

        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':uid', $this->uid);
        $stmt->execute();
        $pers = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->pers = $pers;
        return $this->pers;
    }
    
    public function getUids($dbh)
    {
        $this->getPersonalInformation($dbh);
        return $this->pers['uid'];
    }
    
    public function getEmails($dbh)
    {
        $this->getPersonalInformation($dbh);
        return $this->pers['email'];
    }
    
    public function getAddress($dbh)
    {
        $this->getPersonalInformation($dbh);
        return $this->pers['address'];
    }
    
    public function getPhone($dbh)
    {
        $this->getPersonalInformation($dbh);
        return $this->pers['phone'];
    }
    
    public function getName($dbh)
    {
        $this->getPersonalInformation($dbh);
        return $this->pers['name'];
    }
    
    public function getLastname($dbh)
    {
        $this->getPersonalInformation($dbh);
        return $this->pers['lastname'];
    }
   
    public function updateUser($uid, $dbh)
    {
        $sql = "UPDATE user SET email = :email, address = :address, phone = :phone, name = :name, lastname = :lastname  WHERE uid = :uid";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':email', strtolower(filter_var($_POST['personalInformation']['email'], FILTER_SANITIZE_STRING)));
        $stmt->bindParam(':address', ucfirst(strtolower(filter_var($_POST['personalInformation']['address'], FILTER_SANITIZE_STRING))));
        $stmt->bindParam(':phone', trim($_POST['personalInformation']['phone']));
        $stmt->bindParam(':name', ucfirst(strtolower(filter_var($_POST['personalInformation']['name'], FILTER_SANITIZE_STRING))));
        $stmt->bindParam(':lastname', ucfirst(strtolower(filter_var($_POST['personalInformation']['lastname'], FILTER_SANITIZE_STRING))));
        $stmt->bindParam(':uid', intval($uid));
        $stmt->execute();
    }
}
