<?php
    class AuthController {
        private $pdo;

        ////////////////////////////////////////////
        
        public function __construct($pdo)
        {
            $this->pdo = $pdo;
        }
        
        ////////////////////////////////////////////
        
        public function showSignUp(){
            $pageTitle = "profile";

            ob_start();
            include  "../app/views/auth/signUp.php";
            
            $content = ob_get_clean();
            
            include "../app/views/main.php";
        }
        public function showLogin(){
            $pageTitle = "login";
            
            ob_start();
            include "../app/views/auth/signIn.php";
            
            $content = ob_get_clean();
            
            include "../app/views/main.php";
        }
        
        ////////////////////////////////////////////

        public function registerUser(){
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $role = $_POST["role"];
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $user = new user($this->pdo);
            $user->setName($username);
            $user->setEmail($email);
            $user->setpassword($hash);
            $user->setRole($role);
            
            if ($user->validateAll()) {
                $user->push();
                $_SESSION['success_user_registration'] = true;
                header("Location: /Kari/login");
                exit;
            } else {
                header("Location: /Kari/signUp");
                exit();
            }

        }

        public function login(){
            $email = $_POST["email"];
            $password = $_POST["password"];

            $user = new user($this->pdo);
            
            if ($user->LoadByEmail($email, $password)) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_object'] = $user;
                
                header("Location: /Kari/home");
                exit();
            } else {
                $_SESSION['error-login'] = "Invalid email or wrong password";
                header("Location: /Kari/login");
                exit();
            }
        }

        public function logout(){
            $_SESSION = [];
            session_destroy();
            header("Location: /Kari/login");

            exit();
        }
    }