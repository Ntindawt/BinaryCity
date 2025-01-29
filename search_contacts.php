<?php
require_once 'config/database.php';
require_once 'includes/Database.php';
require_once 'includes/Contacts.php';

$database = new Database();
$db = $database->getPDO();
$contacts = new Contacts($db);

$query = $_GET['q'] ?? '';
$results = $contacts->search($query);

header('Content-Type: application/json');
echo json_encode($results);