<?php
require_once '../config/database.php';
require_once '../includes/Database.php';
require_once '../includes/Contacts.php';

$database = new Database();
$db = $database->getPDO();
$contacts = new Contacts($db);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);

    // Basic validation
    if (empty($name) || empty($surname) || empty($email)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        try {
            $contacts->create($name, $surname, $email);
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $error = "Email already exists!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Create Contact</h1>
    <form method="POST">
        <div class="tab">
            <button type="button" class="tablinks active" onclick="openTab(event, 'general')">General</button>
        </div>

        <div id="general" class="tabcontent" style="display:block;">
            <label>Name:</label>
            <input type="text" name="name" required>
            <label>Surname:</label>
            <input type="text" name="surname" required>
            <label>Email:</label>
            <input type="email" name="email" required>
            <?php if (isset($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>
            <button type="submit">Save Contact</button>
        </div>
    </form>
    <script src="../assets/js/scripts.js"></script>
</body>
</html>