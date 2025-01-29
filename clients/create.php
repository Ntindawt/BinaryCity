<?php
require_once '../config/database.php';
require_once '../includes/Database.php';
require_once '../includes/Clients.php';

$database = new Database();
$db = $database->getPDO();
$clients = new Clients($db);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    if (empty($name)) {
        $error = "Name is required!";
    } else {
        $clients->create($name);
        header("Location: index.php"); // Redirect to list
        exit;
    }
}

// Generate a client code (for display only)
$client_code = $clients->generateClientCode();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Create Client</h1>
    <form method="POST">
        <div class="tab">
            <button type="button" class="tablinks active" onclick="openTab(event, 'general')">General</button>
        </div>

        <div id="general" class="tabcontent" style="display:block;">
            <label>Name:</label>
            <input type="text" name="name" required>
            <label>Client Code:</label>
            <input type="text" value="<?= $client_code ?>" readonly>
            <?php if (isset($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>
            <button type="submit">Save Client</button>
        </div>
    </form>
    <script src="../assets/js/scripts.js"></script>
</body>
</html>