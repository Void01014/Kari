<?php
class Booking
{
    private $pdo;
    private $id;
    private $listing_id;
    private $host_id;
    private $traveler_id;
    private $total_price;
    private $start_date;
    private $end_date;
    private $guests;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    ////////////////////////////////////////////

    public function getID()
    {
        return $this->id;
    }
    public function getListingID()
    {
        return $this->listing_id;
    }
    public function getHostID()
    {
        return $this->host_id;
    }
    public function getTravelerID()
    {
        return $this->traveler_id;
    }
    public function getTotalPrice()
    {
        return $this->total_price;
    }
    public function getStartDate()
    {
        return $this->start_date;
    }
    public function getEndDate()
    {
        return $this->end_date;
    }
    public function getGuests()
    {
        return $this->guests;
    }

    ////////////////////////////////////////////

    public function setID($id)
    {
        $this->id = $id;
    }
    public function setListingID($listing_id)
    {
        $this->listing_id = $listing_id;
    }
    public function setHostID($host_id)
    {
        $this->host_id = $host_id;
    }
    public function setTravelerID($traveler_id)
    {
        $this->traveler_id = $traveler_id;
    }
    public function setTotalPrice($total_price)
    {
        $this->total_price = $total_price;
    }
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
    }
    public function setGuests($guests)
    {
        $this->guests = $guests;
    }

    ////////////////////////////////////////////

    public function getListingData()
    {
        $sql = "SELECT price_per_night, hostID FROM listing WHERE id = :listing_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':listing_id' => $this->listing_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    ////////////////////////////////////////////


    public function isAvailable($listing_id, $start_date, $end_date)
    {
        $sql = "SELECT COUNT(*) FROM bookings
                WHERE listing_id = :listing_id
                AND status = 'confirmed'
                AND (start_date <= :end)
                AND (end_date >= :start)
                ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(
            [
                ':listing_id' => $listing_id,
                ':end'        => $end_date->format('Y-m-d'),
                ':start'      => $start_date->format('Y-m-d')
            ]
        );

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    ////////////////////////////////////////////

    public function push()
    {
        $sql = "INSERT INTO bookings (listing_id, host_id, traveler_id, start_date, end_date, guests, total_price, status)
            VALUES (:listing_id, :host_id, :traveler_id, :start_date, :end_date, :guests, :total_price, 'confirmed')";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':listing_id'  => $this->listing_id,
            ':host_id'     => $this->host_id,
            ':traveler_id' => $this->traveler_id,
            ':start_date'  => $this->start_date->format('Y-m-d'),
            ':end_date'    => $this->end_date->format('Y-m-d'),
            ':guests'      => $this->guests,
            ':total_price' => $this->total_price
        ]);
    }
}
