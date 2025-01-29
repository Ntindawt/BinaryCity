<?php
require_once 'config/database.php';
require_once 'includes/Database.php';

$database = new Database();
$db = $database->getPDO();

$client_id = $_GET['client_id'];
$contact_id = $_GET['contact_id'];

// Check if link already exists
$stmt = $db->prepare("SELECT * FROM client_contacts WHERE client_id = ? AND contact_id = ?");
$stmt->execute([$client_id, $contact_id]);

if (!$stmt->fetch()) {
    $stmt = $db->prepare("INSERT INTO client_contacts (client_id, contact_id) VALUES (?, ?)");
    $stmt->execute([$client_id, $contact_id]);
}

// Redirect back to linking page
header("Location: clients/link_contacts.php?client_id=$client_id");