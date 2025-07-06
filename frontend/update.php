<?php
$apiBase = getenv('API_URL') ?: 'http://backend/employees';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Missing employee ID.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $role = $_POST['role'] ?? '';

    $data = http_build_query(['name' => $name, 'role' => $role]);
    $options = [
        'http' => [
            'method' => 'PUT',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $data
        ]
    ];
    $context = stream_context_create($options);
    $result = @file_get_contents("$apiBase/$id", false, $context);

    if ($result !== false) {
        header("Location: index.php");
        exit;
    } else {
        echo "Update failed.";
        exit;
    }
} else {
    // GET request to fetch employee data
    $employeeJson = @file_get_contents("$apiBase/$id");
    $employee = $employeeJson ? json_decode($employeeJson, true) : null;

    if (!$employee) {
        echo "Employee not found.";
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head><title>Edit Employee</title></head>
    <body>
        <h1>Edit Employee #<?= htmlspecialchars($employee['id']) ?></h1>
        <form method="post">
            Name: <input type="text" name="name" value="<?= htmlspecialchars($employee['name']) ?>"><br><br>
            Role: <input type="text" name="role" value="<?= htmlspecialchars($employee['role']) ?>"><br><br>
            <input type="submit" value="Update">
        </form>
    </body>
    </html>
<?php
}
