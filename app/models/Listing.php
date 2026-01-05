<?php
class Listing
{
    private $pdo;
    private $id;
    private $title;
    private $description;
    private $price;
    private $location;
    private $image;
    private $publish_date;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    ////////////////////////////////////////////

    public function getID(){
        return $this->id;
    }
    public function getTitele(){
        return $this->title;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getPrice(){
        return $this->price;
    }
    public function getImage(){
        return $this->image;
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
        return $this->price > 0;
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
        $this->price = $price;
    }
    public function setLocation($location)
    {
        $this->location = $location;
    }
    public function setImage($image)
    {
        $this->image = $image;
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
            ':price_per_night' => $this->price,
            ':location'        => $this->location,
            ':image_url'       => $this->image
        ]);
    }

    ////////////////////////////////////////////

    public function getAll()
    {
        $listings = [];
        $sql = "SELECT * FROM listing WHERE status = 'active'";
        $stmt = $this->pdo->query($sql);
        
    }
}
