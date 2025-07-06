<?php
$apiUrl = getenv('API_URL') ?: 'http://backend/employees';

$employees = @file_get_contents($apiUrl);
$employees = $employees ? json_decode($employees, true) : [];

?>

<!DOCTYPE html>
<html>
<head>
    <title>HRM Employee List</title>
</head>
<body>
    <h1>HRM Employee List</h1>
    <a href="add.html">Add New Employee</a>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php if (!empty($employees)): ?>
            <?php foreach ($employees as $emp): ?>
                <tr>
                    <td><?= htmlspecialchars($emp['id']) ?></td>
                    <td><?= htmlspecialchars($emp['name']) ?></td>
                    <td><?= htmlspecialchars($emp['role']) ?></td>
                    <td>
                        <a href="update.php?id=<?= $emp['id'] ?>">Edit</a> |
                        <a href="delete.php?id=<?= $emp['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4">No employees found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
