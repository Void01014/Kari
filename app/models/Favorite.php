<?php
class Favorite
{
    public static function addToFavorite($pdo, $listing_id, $traveler_id)
    {
        $sql = "INSERT INTO favorites (listing_id, traveler_id) VALUES (:listing_id, :traveler_id)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':listing_id'  => $listing_id,
            ':traveler_id' => $traveler_id
        ]);
    }

    public static function removeFromFavorite($pdo, $listing_id, $traveler_id)
    {
        $sql = "DELETE FROM favorites WHERE listing_id = :listing_id AND traveler_id = :traveler_id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':listing_id'  => $listing_id,
            ':traveler_id' => $traveler_id
        ]);
    }

    public static function isAlreadyFavorited($pdo, $listing_id, $traveler_id)
    {
        $sql = "SELECT id FROM favorites WHERE listing_id = ? AND traveler_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$listing_id, $traveler_id]);
        return $stmt->fetch() ? true : false;
    }
}