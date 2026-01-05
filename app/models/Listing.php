<?php
class Listing
{
    private $pdo;
    private $id;
    private $title;
    private $description;
    private $price_per_night;
    private $location;
    private $image_url;
    private $publish_date;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    ////////////////////////////////////////////

    public function getID(){
        return $this->id;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getPrice(){
        return $this->price_per_night;
    }
    public function getLocation(){
        return $this->location;
    }
    public function getImage(){
        return $this->image_url;
    }
    public function getPubDate(){
        return $this->publish_date;
    }
    
    ////////////////////////////////////////////
    
    private function validateTitle()
    {
        return strlen($this->title) >= 3;
    }
    private function validateDesc()
    {
        return strlen($this->description) >= 3;
    }
    private function validatePrice()
    {
        return $this->price_per_night > 0;
    }


    public function validateAll()
    {
        return $this->validateTitle()
            && $this->validateDesc()
            && $this->validatePrice();
    }

    ////////////////////////////////////////////

    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function setDesc($description)
    {
        $this->description = $description;
    }
    public function setPrice($price)
    {
        $this->price_per_night = $price;
    }
    public function setLocation($location)
    {
        $this->location = $location;
    }
    public function setImage($image)
    {
        $this->image_url = $image;
    }

    ////////////////////////////////////////////

    public function push($hostID)
    {
        $sql = "INSERT INTO listing (hostID, title, description, price_per_night, location, image_url)
                    VALUES (:hostID, :title, :description, :price_per_night, :location, :image_url)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':hostID'          => $hostID,
            ':title'           => $this->title,
            ':description'     => $this->description,
            ':price_per_night' => $this->price_per_night,
            ':location'        => $this->location,
            ':image_url'       => $this->image_url
        ]);
    }

    ////////////////////////////////////////////

    public static function getAllListings($pdo)
    {
        $listings = [];
        $sql = "SELECT * FROM listing WHERE status = 'active'";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Listing', [$pdo]);
    }
}
