<?php
$apiBase = getenv('API_URL') ?: 'http://backend/employees';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? '';
    $role = $_POST['role'] ?? '';

    if ($id && $name && $role) {
        $data = json_encode(['name' => $name, 'role' => $role]);

        $options = [
            'http' => [
                'method' => 'PUT',
                'header' => "Content-Type: application/json\r\n" .
                            "Content-Length: " . strlen($data),
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
    } else {
        echo "Missing required fields.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $response = @file_get_contents("$apiBase/$id");
        if ($response !== false) {
            $employee = json_decode($response, true);
            if ($employee):
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f8fa;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #007BFF;
            color: white;
            padding: 20px 40px;
            text-align: center;
        }
        main {
            padding: 40px;
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
        }
        h2 {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"], a.button {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover, a.button:hover {
            background-color: #218838;
        }
        a.button {
            margin-left: 10px;
        }
    </style>
</head>
<body>

<header>
    <h1>Update Employee</h1>
</header>

<main>
    <form method="POST" action="update.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($employee['id']) ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($employee['name']) ?>" required>

        <label for="role">Role:</label>
        <input type="text" name="role" id="role" value="<?= htmlspecialchars($employee['role']) ?>" required>

        <input type="submit" value="Update">
        <a href="/" class="button">Cancel</a>
    </form>
</main>

</body>
</html>

<?php
            exit;
            endif;
        }
    }
    echo "<p style='text-align:center;margin-top:50px;'>Employee not found or invalid JSON returned.</p>";
}
?>
