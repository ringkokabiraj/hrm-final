<?php
$mysqli = new mysqli(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASSWORD'), getenv('DB_NAME'));
$redis = new Redis();
$redis->connect(getenv('REDIS_HOST'), 6379);

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === '/employees' && $method === 'GET') {
    if ($redis->exists('employees')) {
        echo $redis->get('employees');
        exit;
    }
    $res = $mysqli->query("SELECT * FROM employees");
    $rows = [];
    while ($row = $res->fetch_assoc()) $rows[] = $row;
    $json = json_encode($rows);
    $redis->set('employees', $json, 60);
    echo $json;

} elseif ($path === '/employees' && $method === 'POST') {
    $name = $_POST['name'] ?? '';
    $role = $_POST['role'] ?? '';
    $stmt = $mysqli->prepare("INSERT INTO employees (name, role) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $role);
    $stmt->execute();
    $redis->del('employees');
    echo json_encode(["message" => "Employee added"]);

} elseif (preg_match('#^/employees/(\d+)$#', $path, $matches)) {
    $id = (int)$matches[1];

    if ($method === 'GET') {
        $stmt = $mysqli->prepare("SELECT * FROM employees WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $employee = $result->fetch_assoc();

        if ($employee) {
            echo json_encode($employee);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Employee not found"]);
        }

    } elseif ($method === 'PUT') {
        parse_str(file_get_contents("php://input"), $_PUT);
        $name = $_PUT['name'] ?? '';
        $role = $_PUT['role'] ?? '';
        $stmt = $mysqli->prepare("UPDATE employees SET name=?, role=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $role, $id);
        $stmt->execute();
        $redis->del('employees');
        echo json_encode(["message" => "Updated"]);

    } elseif ($method === 'DELETE') {
        $stmt = $mysqli->prepare("DELETE FROM employees WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $redis->del('employees');
        echo json_encode(["message" => "Deleted"]);
    }
} else {
    http_response_code(404);
    echo json_encode(["error" => "Not Found"]);
}
