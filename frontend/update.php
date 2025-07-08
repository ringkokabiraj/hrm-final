<?php
$apiBase = getenv('API_URL') ?: 'http://backend/employees';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Submit updated data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    $data = json_encode(['name' => $name, 'role' => $role]);

    $options = [
        'http' => [
            'method' => 'PUT',
            'header' => "Content-Type: application/json",
            'content' => $data
        ]
    ];

    $context = stream_context_create($options);
    $response = @file_get_contents("$apiBase/$id", false, $context);

    if ($response !== false) {
        header("Location: /");
        exit;
    } else {
        echo "Update failed.";
    }

} elseif (isset($_GET['id'])) {
    // Show edit form
    $id = trim($_GET['id']);
    $response = @file_get_contents("$apiBase/$id");

    if ($response === false) {
        echo "Employee not found. API call failed.";
        exit;
    }

    $employee = json_decode($response, true);

    if (!isset($employee['id'])) {
        echo "Employee not found or invalid JSON returned.";
        exit;
    }

    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Edit Employee</title>
    </head>
    <body>
        <h2>Edit Employee</h2>
        <form method="POST" action="update.php">
            <input type="hidden" name="id" value="<?= htmlspecialchars($employee['id']) ?>">
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($employee['name']) ?>" required><br><br>
            <label>Role:</label>
            <input type="text" name="role" value="<?= htmlspecialchars($employee['role']) ?>" required><br><br>
            <button type="submit">Update</button>
        </form>
    </body>
    </html>

<?php
} else {
    echo "Invalid request.";
}
?>
