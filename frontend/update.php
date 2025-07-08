<?php
$apiBase = getenv('API_URL') ?: 'http://backend/employees';

// Check if it's a POST request for updating the employee
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['name'], $_POST['role'])) {
    $id = intval($_POST['id']);
    $data = http_build_query([
        'name' => $_POST['name'],
        'role' => $_POST['role']
    ]);

    $options = [
        'http' => [
            'method' => 'PUT',
            'header' => "Content-type: application/x-www-form-urlencoded",
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
        exit;
    }
}

// If it's a GET request, fetch employee data to show in form
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $employeeData = @file_get_contents("$apiBase/$id");
    $employee = $employeeData ? json_decode($employeeData, true) : null;

    if (!$employee || !isset($employee['id'])) {
        echo "Employee not found or invalid JSON returned.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
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
        }
        form {
            max-width: 500px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-top: 15px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
        }
        input[type="submit"] {
            margin-top: 20px;
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<header>
    <h1>Edit Employee</h1>
</header>

<main>
    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($employee['id']) ?>">

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($employee['name']) ?>" required>

        <label for="role">Role:</label>
        <input type="text" id="role" name="role" value="<?= htmlspecialchars($employee['role']) ?>" required>

        <input type="submit" value="Update Employee">
    </form>
</main>

</body>
</html>
