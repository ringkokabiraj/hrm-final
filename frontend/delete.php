<?php
$id = $_POST['id'];
$options = ['http' => ['method' => 'DELETE']];
$context = stream_context_create($options);
file_get_contents("http://backend:8080/employees/$id", false, $context);
header("Location: /");
?>
