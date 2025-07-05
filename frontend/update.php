<?php
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
file_get_contents("http://backend:8080/employees/$id", false, $context);
header("Location: /");
?>
