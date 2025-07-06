<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = @file_get_contents("http://backend:8080/employees/$id");
    $emp = json_decode($data, true);
    if (!$emp) {
        echo "Employee not found.";
        exit;
    }
    ?>

    <h2>Update Employee</h2>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $emp['id'] ?>">
        <label>Name:</label>
        <input type="text" name="name" value="<?= $emp['name'] ?>" required><br>
        <label>Role:</label>
        <input type="text" name="role" value="<?= $emp['role'] ?>" required><br>
        <input type="submit" value="Update">
    </form>

    <?php
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    $data = http_build_query(['name' => $name, 'role' => $role]);
    $options = [
        'http' => [
            'method' => 'PUT',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $data
        ]
    ];

    $context = stream_context_create($options);
    $response = @file_get_contents("http://backend:8080/employees/$id", false, $context);

    if ($response !== false) {
        header("Location: /");
        exit;
    } else {
        echo "Update failed.";
    }
} else {
    echo "Invalid request.";
}
?>
