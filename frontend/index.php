<?php
$api_url = getenv('API_URL') ?: 'http://backend:8080/employees';
$employees = json_decode(file_get_contents($api_url), true);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Human Resource Management/title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2 class="mb-4">Human Resource Management Employee List</h2>

  <table class="table table-striped">
    <thead><tr><th>ID</th><th>Name</th><th>Role</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach ($employees as $emp): ?>
      <tr>
        <td><?= $emp['id'] ?></td>
        <td><?= $emp['name'] ?></td>
        <td><?= $emp['role'] ?></td>
        <td>
          <form method="post" action="update.php" class="d-inline-flex">
            <input type="hidden" name="id" value="<?= $emp['id'] ?>">
            <input type="text" name="name" value="<?= $emp['name'] ?>" class="form-control form-control-sm me-1" required>
            <input type="text" name="role" value="<?= $emp['role'] ?>" class="form-control form-control-sm me-1" required>
            <button class="btn btn-sm btn-warning me-1" type="submit">Update</button>
          </form>
          <form method="post" action="delete.php" class="d-inline">
            <input type="hidden" name="id" value="<?= $emp['id'] ?>">
            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>

  <h4 class="mt-5">Add New Employee</h4>
  <form action="add.php" method="post" class="row g-2">
    <div class="col-md-4">
      <input class="form-control" name="name" placeholder="Name" required>
    </div>
    <div class="col-md-4">
      <input class="form-control" name="role" placeholder="Role" required>
    </div>
    <div class="col-md-4">
      <button class="btn btn-success" type="submit">Add Employee</button>
    </div>
  </form>
</body>
</html>
