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
            $pageTitle = "Home";

            ob_start();
            include "../app/views/home/home.php";
            
            $content = ob_get_clean();
            
            include "../app/views/main.php";
        }
    }