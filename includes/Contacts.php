<?php
class Contacts {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Create a new contact
    public function create($name, $surname, $email) {
        $stmt = $this->db->prepare("INSERT INTO contacts (name, surname, email) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $surname, $email]);
    }

    // List all contacts (sorted by surname)
    public function listAll() {
        $stmt = $this->db->query("SELECT * FROM contacts ORDER BY surname ASC, name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Search contacts by name/surname/email
    public function search($query) {
        $stmt = $this->db->prepare("
            SELECT * FROM contacts 
            WHERE name LIKE ? OR surname LIKE ? OR email LIKE ?
            ORDER BY surname ASC
        ");
        $searchTerm = "%$query%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get linked clients for a contact
    public function getLinkedClients($contact_id) {
        $stmt = $this->db->prepare("
            SELECT c.* 
            FROM clients c
            INNER JOIN client_contacts cc ON c.id = cc.client_id
            WHERE cc.contact_id = ?
            ORDER BY c.name ASC
        ");
        $stmt->execute([$contact_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>