<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? null;
    $role = $_POST['role'] ?? null;

    if ($name && $role) {
        $data = http_build_query(['name' => $name, 'role' => $role]);
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $data
            ]
        ];

        $context = stream_context_create($options);
        $response = @file_get_contents("http://backend/employees", false, $context);

        if ($response !== false) {
            header("Location: /");
            exit;
        } else {
            echo "Add failed.";
        }
    } else {
        echo "Name and role are required.";
    }
} else {
    echo "Invalid request.";
}
?>
