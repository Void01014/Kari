<?php
    class ListingController{
        private $pdo;

        ////////////////////////////////////////////
        
        public function __construct($pdo)
        {
            $this->pdo = $pdo;
        }

        ////////////////////////////////////////////
        
        public function showListingForm(){
            $pageTitle = "ListingForm";

            ob_start();
            include "../app/views/listings/addListing.php";
            
            $content = ob_get_clean();
            
            include "../app/views/main.php";
            
        }

        public function showAllListings(){
            $traveler_id = $_SESSION['user_object']->getID();
            $city = $_GET['city'] ?? null;
            $min = $_GET['min_price'] ?? null;
            $max = $_GET['max_price'] ?? null;
        
            $listings = Listing::getAllListings($this->pdo, $traveler_id, $city, $min, $max);
            $disabled_dates = Listing::getDisabledDate($this->pdo);
            $pageTitle = "allListings";

            ob_start();
            include "../app/views/listings/listings.php";
            
            $content = ob_get_clean();
            
            include "../app/views/main.php";
            
        }

        ////////////////////////////////////////////

        public function toggleFavorite(){
            header('Content-Type: application/json');

            if (!isset($_SESSION['user_object'])) {
                echo json_encode(['success' => false, 'message' => 'Login required']);
                exit;
            }
            $listing_id = $_POST['listing_id'];
            $traveler_id = $_SESSION['user_object']->getID();

            if(Favorite::isAlreadyFavorited($this->pdo, $listing_id, $traveler_id))
                $result = Favorite::removeFromFavorite($this->pdo, $listing_id, $traveler_id);
            else{
                $result = Favorite::addToFavorite($this->pdo, $listing_id, $traveler_id);
            }
            echo json_encode(['success' => $result]);
            exit;
        }
        
        ////////////////////////////////////////////

        public function registerListing(){
            $image = time() . "_" . $_FILES['image']['name'];
            $destination = __DIR__ . "/../../public/uploads/" . $image;

            move_uploaded_file($_FILES['image']['tmp_name'], $destination);

            $hostID = $_SESSION['user_object']->getID();
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $location = $_POST['location'];

            $listing = new Listing($this->pdo);

            $listing->setTitle($title);
            $listing->setDesc($description);
            $listing->setPrice($price);
            $listing->setLocation($location);
            $listing->setImage($image);

            if($listing->validateAll()){
                $listing->push($hostID);
                $_SESSION['success_listing_registration'] = true;
                header("Location: /Kari/addListing");
                exit;
            }else{
                header("location: /Kari/addListing");
                exit();
            }
        }
    }