<?php
require_once '../config/database.php';
require_once '../includes/Database.php';

$database = new Database();
$db = $database->getPDO();

$client_id = $_GET['client_id'];
$contact_id = $_GET['contact_id'];

$stmt = $db->prepare("DELETE FROM client_contacts WHERE client_id = ? AND contact_id = ?");
$stmt->execute([$client_id, $contact_id]);

header("Location: link_contacts.php?client_id=$client_id");