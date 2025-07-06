<?php
$name = $_POST['name'];
$role = $_POST['role'];

$data = json_encode(['name' => $name, 'role' => $role]);

$options = [
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n" .
                    "Content-Length: " . strlen($data) . "\r\n",
        'content' => $data
    ]
];

$context = stream_context_create($options);
$response = @file_get_contents("http://backend:8080/employees", false, $context);

if ($response !== false) {
    header("Location: /");
    exit;
} else {
    echo "Add failed.";
}
?>
