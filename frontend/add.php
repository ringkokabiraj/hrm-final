<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['role'])) {
    $name = trim($_POST['name']);
    $role = trim($_POST['role']);

    $data = http_build_query(['name' => $name, 'role' => $role]);

    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded",
            'content' => $data
        ]
    ];

    $context = stream_context_create($options);
    $apiUrl = getenv('API_URL') ?: 'http://backend/employees';
    $response = @file_get_contents($apiUrl, false, $context);

    if ($response !== false) {
        header("Location: /");
        exit;
    } else {
        echo "Add failed. Backend unreachable or rejected request.";
    }
} else {
    echo "Invalid request.";
}
?>
