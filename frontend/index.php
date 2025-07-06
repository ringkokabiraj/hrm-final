<!DOCTYPE html>
<html>
<head>
    <title>HRM - Employee List</title>
</head>
<body>
    <h1>HRM - Employee List</h1>

    <form action="add.php" method="POST">
        <label>Name:</label>
        <input type="text" name="name" required><br>
        <label>Role:</label>
        <input type="text" name="role" required><br>
        <input type="submit" value="Add Employee">
    </form>

    <hr>

    <?php
    $response = @file_get_contents("http://backend:80/employees");
    $employees = json_decode($response, true);

    if ($employees && is_array($employees)) {
        echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Role</th><th>Actions</th></tr>";
        foreach ($employees as $emp) {
            echo "<tr>
                    <td>{$emp['id']}</td>
                    <td>{$emp['name']}</td>
                    <td>{$emp['role']}</td>
                    <td>
                        <form action='delete.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='id' value='{$emp['id']}'>
                            <input type='submit' value='Delete'>
                        </form>
                        <form action='update.php' method='GET' style='display:inline;'>
                            <input type='hidden' name='id' value='{$emp['id']}'>
                            <input type='submit' value='Update'>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No data available.";
    }
    ?>
</body>
</html>
