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
            include "../app/views/host/addListing.php";
            
            $content = ob_get_clean();
            
            include "../app/views/main.php";
            
        }

        public function showAllListings(){
            $listings = Listing::getAllListings($this->pdo);
            $pageTitle = "allListings";

            ob_start();
            include "../app/views/listings/listings.php";
            
            $content = ob_get_clean();
            
            include "../app/views/main.php";
            
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