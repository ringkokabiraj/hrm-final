<?php
$apiUrl = getenv('API_URL') ?: 'http://backend/employees';
$employees = @file_get_contents($apiUrl);
$employees = $employees ? json_decode($employees, true) : [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>HRM Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f8fa;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #007BFF;
            color: white;
            padding: 20px 40px;
            text-align: center;
        }
        main {
            padding: 40px;
        }
        h1 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
        }
        a.button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        a.button:hover {
            background-color: #218838;
        }
        .action-links a {
            margin: 0 5px;
            color: #007BFF;
            text-decoration: none;
        }
        .action-links a:hover {
            text-decoration: underline;
        }
        footer {
            margin-top: 40px;
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>

<header>
    <h1>Human Resource Management System</h1>
</header>

<main>
    <a class="button" href="add.php">➕ Add New Employee</a>

    <table>
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
                    <td class="action-links">
                        <a href="update.php?id=<?= $emp['id'] ?>">✏️ Edit</a>
                        <a href="delete.php?id=<?= $emp['id'] ?>" onclick="return confirm('Are you sure you want to delete this employee?')">🗑️ Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4">No employees found.</td></tr>
        <?php endif; ?>
    </table>
</main>

<footer>
    <p>&copy; <?= date('Y') ?> HRM System. All rights reserved.</p>
</footer>

</body>
</html>
