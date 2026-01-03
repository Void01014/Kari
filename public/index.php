<?php
    require_once "../app/models/User.php";
    require_once "../app/models/Listing.php";
    require_once "../app/core/Database.php";
    require_once "../app/controllers/AuthController.php";
    require_once "../app/controllers/HomeController.php";
    require_once "../app/controllers/UserController.php";
    require_once "../app/controllers/HostController.php";
    
    session_start();

    $user = $_SESSION['user_object'] ?? null;


    $db = new Database("localhost", "kari_db", "root", "");
    $pdo = $db->getConnection();
    $url = $_GET['url'] ?? 'home';
    $authController = new AuthController($pdo);
    $userController = new UserController($pdo);
    $homeController = new HomeController($pdo);
    $hostController = new HostController($pdo);
    $whiteList = ["login", "signUp", "login-action", "register-action"];
    
    if (!isset($_SESSION['logged_in']) && !in_array($url, $whiteList)) {
        header('Location: /Kari/signUp');
        exit();
    }
    if (isset($_SESSION['logged_in']) && in_array($url, ["login", "signUp"])) {
        header('Location: /Kari/home');
        exit();
    }

    switch ($url){
        case 'signUp':
            $authController->showSignUp();
            break;
        case 'register-action':
            $authController->registerUser();
            break;
        case 'login':
            $authController->showLogin();
            break;
        case 'login-action':
            $authController->login();
            break;
        case 'home':
            $homeController->showHome();
            break;
        case 'profile':
            $userController->showProfile();         
            break;
        case 'addListing':
            $hostController->showListingForm();         
            break;
        case 'addListing-action':
            $hostController->registerListing();         
            break;
        case 'logout-action':
            $authController->logout();         
            break;
        
    }
?>