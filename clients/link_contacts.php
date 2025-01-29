<?php
// Use absolute paths to avoid inclusion errors
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/../includes/Clients.php';
require_once __DIR__ . '/../includes/Contacts.php';

$database = new Database();
$db = $database->getPDO();
$clients = new Clients($db);
$contacts = new Contacts($db);

$client_id = $_GET['client_id'] ?? null;
if (!$client_id) die("Client ID is required!");

$linkedContacts = $clients->getLinkedContacts($client_id);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Link Contacts to Client</h1>
    <div class="tab">
        <button class="tablinks active" onclick="openTab(event, 'general')">General</button>
        <button class="tablinks" onclick="openTab(event, 'contacts')">Contacts</button>
    </div>

    <div id="general" class="tabcontent" style="display:block;">
        <input type="text" id="search-contacts" placeholder="Search contacts...">
        <div id="contact-results"></div>
    </div>

    <div id="contacts" class="tabcontent">
        <?php if (empty($linkedContacts)): ?>
            <p>No contacts found.</p>
        <?php else: ?>
            <table>
                <tr><th>Full Name</th><th>Email</th><th>Action</th></tr>
                <?php foreach ($linkedContacts as $contact): ?>
                    <tr>
                        <td><?= htmlspecialchars($contact['surname']) ?>, <?= htmlspecialchars($contact['name']) ?></td>
                        <td><?= htmlspecialchars($contact['email']) ?></td>
                        <td><a href="unlink_contact.php?client_id=<?= $client_id ?>&contact_id=<?= $contact['id'] ?>">Unlink</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>

    <script src="../assets/js/scripts.js"></script>
</body>
</html>