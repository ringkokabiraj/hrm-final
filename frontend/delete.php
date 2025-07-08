<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $apiBase = getenv('API_URL') ?: 'http://backend/employees';

    $options = [
        'http' => [
            'method' => 'DELETE',
        ]
    ];

    $context = stream_context_create($options);
    $response = @file_get_contents("$apiBase/$id", false, $context);

    if ($response !== false) {
        header("Location: /");
        exit;
    } else {
        echo "Delete failed.";
    }
} else {
    echo "Invalid request.";
}
?>