<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $options = [
        'http' => [
            'method' => 'DELETE',
            'header' => 'Content-type: application/x-www-form-urlencoded'
        ]
    ];

    $context = stream_context_create($options);
    $response = @file_get_contents("http://backend:80/employees/$id", false, $context);

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
