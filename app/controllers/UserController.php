<?php
    class UserController {
        private $pdo;

        ////////////////////////////////////////////
        
        public function __construct($pdo)
        {
            $this->pdo = $pdo;
        }
        
        ////////////////////////////////////////////

        public function showProfile(){
            $pageTitle = "profile";

            ob_start();
            include  "../app/views/user/profile.php";
            
            $content = ob_get_clean();
            
            include "../app/views/main.php";
        }
    }