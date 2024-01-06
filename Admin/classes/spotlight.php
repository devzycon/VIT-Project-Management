<?php
class Spotlight {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function selectAllSpotlightData() {
        try {
            $query = "SELECT * FROM spotlight";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e) {
            // Handle the exception, log error, etc.
            return false;
        }
    }

    public function insertSpotlightItem($title, $description)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO spotlight (title, description) VALUES (?, ?)");
            $stmt->execute([$title, $description]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error inserting spotlight item: " . $e->getMessage());
            return false; // Failed to insert
        }
    }
}
?>
