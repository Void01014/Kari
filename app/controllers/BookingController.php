<?php
    class BookingController{
        private $pdo;

        ////////////////////////////////////////////
        
        public function __construct($pdo)
        {
            $this->pdo = $pdo;
        }
        
        ////////////////////////////////////////////

        public function registerBooking(){
            $traveler_id = $_SESSION["user_object"]->getID() ?? '';
            $traveler_name = $_SESSION["user_object"]->getName() ?? '';
            $traveler_email = $_SESSION["user_object"]->getEmail() ?? '';
            $listing_id = $_POST['listing_id'];
            $guests = $_POST['guests'];
            $start_date = new DateTime($_POST['start_date'])    ;
            $end_date = new DateTime($_POST['end_date']);

            $booking = new Booking($this->pdo);
            $booking->setListingID($listing_id);
            $listingData = $booking->getListingData();

            if($listingData){
                $price_per_night=  $listingData['price_per_night'];
                $interval = $start_date->diff($end_date);
                $days = $interval->days;

                $booking->setHostID($listingData['hostID']);
                $booking->setTravelerID($traveler_id);
                $booking->setTotalPrice($price_per_night * $days);
                $booking->setStartDate($start_date);
                $booking->setEndDate($end_date);
                $booking->setGuests($guests);
                
                if ($days < 1) {
                   die("Error: Minimum stay is 1 night.");
                }

            }else {
                die("Listing not found.");
            }

            if($booking->isAvailable($listing_id, $start_date, $end_date)){
                if($booking->push()){
                    $Bookingsata = [
                        'title'    => $listingData['title'],
                        'location' => $listingData['location'],
                        'today'    => (new DateTime())->format('Y-m-d'),
                        'start'    => $start_date->format('Y-m-d'),
                        'end'      => $end_date->format('Y-m-d'),
                        'price'    => $price_per_night*$days
                    ];
                    PDF::renderPDF($Bookingsata, $traveler_name);
                    Email::sendBookingConfirmation($traveler_email, $traveler_name, $Bookingsata);                
                };
                $_SESSION['success_booking_registration'] = true;
                header("Location: /Kari/allListings");
                exit;
            }else{
                $_SESSION['error_booking_registration'] = false;
                header("location: /Kari/allListings");
                exit();
            }
        }
    }
?>