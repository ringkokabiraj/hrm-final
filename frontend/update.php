<?php
$apiBase = getenv('API_URL') ?: 'http://backend/employees';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Handle update submission
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
    // Display form for update
    $id = $_GET['id'];
    $employee = @file_get_contents("$apiBase/$id");
    $employee = $employee ? json_decode($employee, true) : null;

    if (!$employee) {
        echo "Employee not found.";
        exit;
    }
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Update Employee</title>
    </head>
    <body>
        <h2>Update Employee</h2>
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
