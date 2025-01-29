<?php
require_once '../config/database.php';
require_once '../includes/Database.php';
require_once '../includes/Contacts.php';

$database = new Database();
$db = $database->getPDO();
$contacts = new Contacts($db);
$contactList = $contacts->listAll();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Contacts</h1>
    <a href="create.php">Create New Contact</a>
    <?php if (empty($contactList)): ?>
        <p>No contacts found.</p>
    <?php else: ?>
        <table>
            <tr>
                <th style="text-align:left">Full Name</th>
                <th style="text-align:left">Email</th>
                <th style="text-align:center">Linked Clients</th>
            </tr>
            <?php foreach ($contactList as $contact): ?>
                <tr>
                    <td><?= htmlspecialchars($contact['surname']) ?>, <?= htmlspecialchars($contact['name']) ?></td>
                    <td><?= htmlspecialchars($contact['email']) ?></td>
                    <td style="text-align:center">
                        <?= count($contacts->getLinkedClients($contact['id'])) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>