<?php
$name = $_POST['name'];
$role = $_POST['role'];

$data = http_build_query(['name' => $name, 'role' => $role]);
$options = [
    'http' => [
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
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
