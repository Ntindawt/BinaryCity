<?php
// Check if class already exists to prevent redeclaration
if (!class_exists('Clients')) {
    class Clients {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        // Generate unique client code (ABC123)
        public function generateClientCode() {
            do {
                $letters = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3);
                $numbers = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
                $code = $letters . $numbers;
                $stmt = $this->db->prepare("SELECT id FROM clients WHERE client_code = ?");
                $stmt->execute([$code]);
            } while ($stmt->fetch());
            return $code;
        }

        // Create a new client
        public function create($name) {
            $code = $this->generateClientCode();
            $stmt = $this->db->prepare("INSERT INTO clients (name, client_code) VALUES (?, ?)");
            return $stmt->execute([$name, $code]);
        }

        // List all clients (sorted by name)
        public function listAll() {
            $stmt = $this->db->query("SELECT * FROM clients ORDER BY name ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Get linked contacts for a client
        public function getLinkedContacts($client_id) {
            $stmt = $this->db->prepare("
                SELECT c.* 
                FROM contacts c
                INNER JOIN client_contacts cc ON c.id = cc.contact_id
                WHERE cc.client_id = ?
                ORDER BY c.surname ASC, c.name ASC
            ");
            $stmt->execute([$client_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
?>