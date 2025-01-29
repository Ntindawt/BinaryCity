<?php
require_once '../config/database.php';
require_once '../includes/Database.php';
require_once '../includes/Clients.php';

$database = new Database();
$db = $database->getPDO();
$clients = new Clients($db);
$clientList = $clients->listAll();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Clients</h1>
    <a href="create.php">Create New Client</a>
    <?php if (empty($clientList)): ?>
        <p>No clients found.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Client Code</th>
                <th>Linked Contacts</th>
            </tr>
            <?php foreach ($clientList as $client): ?>
                <tr>
                    <td><?= htmlspecialchars($client['name']) ?></td>
                    <td><?= htmlspecialchars($client['client_code']) ?></td>
                    <td><a href="link_contacts.php?client_id=<?= $client['id'] ?>">Manage Contacts</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>