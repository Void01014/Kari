<?php
class user
{
    private $pdo;
    private $id;
    private $name;
    private $email;
    private $password;
    private $role;
    private $status;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    ////////////////////////////////////////////

    public function getID(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getRole(){
        return $this->role;
    }
    
    ////////////////////////////////////////////
    
    private function validateUsername()
    {
        return strlen($this->name) >= 3;
    }

    private function validateEmail()
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    private function validatePassword()
    {
        return strlen($this->password) >= 8;
    }
    private function validateRole()
    {
        $allowedRoles = ['traveler', 'host'];
        return in_array($this->role, $allowedRoles, true);
    }

    public function validateAll()
    {
        return $this->validateUsername()
            && $this->validateEmail()
            && $this->validatePassword()
            && $this->validateRole();
    }

    ////////////////////////////////////////////

    public function setName($name)
    {
        $this->name = $name;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function setRole($role)
    {
        $this->role = $role;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }

    ////////////////////////////////////////////

    public function push()
    {
        $sql = "INSERT INTO users (username, email, password_hash, role)
                    VALUES (:username, :email, :password_hash, :role)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':username' => $this->name,
            ':email' => $this->email,
            ':password_hash' => $this->password,
            ':role' => $this->role
        ]);
    }

    ////////////////////////////////////////////

    private function verify_password($password, $stored_hash)
    {
        return password_verify($password, $stored_hash);
    }

    public function LoadByEmail($email, $password)
    {
        $sql = "SELECT id, username, email, password_hash, role, status FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && $this->verify_password($password, $row['password_hash'])) {
            $this->id = $row['id'];
            $this->setName($row['username']);
            $this->setEmail($row['email']);
            $this->setRole($row['role']);
            $this->setStatus($row['status']);

            return true; 
        }
        return false;    
    }

    public function __sleep() {
        return ['id', 'name', 'email', 'role'];
    }
}
