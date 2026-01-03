<?php
    class HomeController {
        private $pdo;

        ////////////////////////////////////////////
        
        public function __construct($pdo)
        {
            $this->pdo = $pdo;
        }
        
        ////////////////////////////////////////////

        public function showHome(){
            // $pageTitle = "home";

            // ob_start();
            // include __DIR__ . "/app/views/auth/signIn.php";
            
            // $content = ob_get_clean();
            
            // include __DIR__ . "/app/views/main.php";
        }
    }