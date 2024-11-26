<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_role'])) {
    $role_id = $_POST['role_id'];
    $role_name = $_POST['role_name'];

    // Update the role in the database
    $sql = "UPDATE roles SET role_name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $role_name, $role_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Role updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating role: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign_permissions'])) {
    $role_id = $_POST['role_id'];
    $permissions = $_POST['permissions'];

    // Delete existing permissions for the role
    $sql = "DELETE FROM role_permissions WHERE role_id = $role_id";
    $conn->query($sql);

    // Insert new permissions
    foreach ($permissions as $permission_id) {
        $sql = "INSERT INTO role_permissions (role_id, permission_id) VALUES ($role_id, $permission_id)";
        $conn->query($sql);
    }

    echo "<script>alert('Permissions updated successfully!');</script>";
}

$query = "SELECT * FROM roles";
$result = mysqli_query($conn, $query);
$roles = [];
while ($row = mysqli_fetch_assoc($result)) {
    $roles[] = $row;
}

$query_permissions = "SELECT * FROM permissions";
$result_permissions = mysqli_query($conn, $query_permissions);
$permissions = [];
while ($row = mysqli_fetch_assoc($result_permissions)) {
    $permissions[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Roles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/css/roles.css"> <!-- Link to the new CSS file -->
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Manage Roles and Permissions</h1>
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addRoleModal">Add New Role</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Role Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($roles as $role): ?>
                    <tr>
                        <td><?php echo $role['id']; ?></td>
                        <td><?php echo $role['role_name']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRoleModal" data-role-id="<?php echo $role['id']; ?>" data-role-name="<?php echo $role['role_name']; ?>">Edit</button>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#assignPermissionsModal" data-role-id="<?php echo $role['id']; ?>" data-role-name="<?php echo $role['role_name']; ?>">Assign Permissions</button>
                            <a href="delete_role.php?id=<?php echo $role['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Role Modal -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addRoleForm">
                        <div class="mb-3">
                            <label for="role_name" class="form-label">Role Name</label>
                            <input type="text" class="form-control" id="role_name" name="role_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Role Modal -->
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h 5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editRoleForm" method="POST" action="">
                        <input type="hidden" name="role_id" id="edit_role_id">
                        <div class="mb-3">
                            <label for="edit_role_name" class="form-label">Role Name</label>
                            <input type="text" class="form-control" id="edit_role_name" name="role_name" required>
                        </div>
                        <button type="submit" name="edit_role" class="btn btn-primary">Update Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Permissions Modal -->
    <div class="modal fade" id="assignPermissionsModal" tabindex="-1" aria-labelledby="assignPermissionsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignPermissionsModalLabel">Assign Permissions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="assignPermissionsForm" method="POST" action="">
                        <input type="hidden" name="role_id" id="assign_role_id">
                        <div class="mb-3">
                            <label for="permissions" class="form-label">Select Permissions</label>
                            <select multiple class="form-control" id="permissions" name="permissions[]" required>
                                <?php foreach ($permissions as $permission): ?>
                                    <option value="<?php echo $permission['id']; ?>"><?php echo $permission['permission_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" name="assign_permissions" class="btn btn-primary">Assign Permissions</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle form submission for adding a new role
        $('#addRoleForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "create_role.php",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    toastr.success('Role added successfully!');
                    $('#addRoleForm')[0].reset();
                    $('#addRoleModal').modal('hide');
                    location.reload(); 
                },
                error: function() {
                    toastr.error('Error adding role.');
                }
            });
        });
        // Populate the edit role modal with the selected role's data
        const editRoleModal = document.getElementById('editRoleModal');
        editRoleModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget; // Button that triggered the modal
            const roleId = button.getAttribute('data-role-id');
            const roleName = button.getAttribute('data-role-name');

            // Update the modal's content
            const modalRoleId = editRoleModal.querySelector('#edit_role_id');
            const modalRoleName = editRoleModal.querySelector('#edit_role_name');

            modalRoleId.value = roleId;
            modalRoleName.value = roleName;
        });
        // Populate the assign permissions modal with the selected role's data
        const assignPermissionsModal = document.getElementById('assignPermissionsModal');
        assignPermissionsModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget; // Button that triggered the modal
            const roleId = button.getAttribute('data-role-id');
            const roleName = button.getAttribute('data-role-name');

            // Update the modal's content
            const modalRoleId = assignPermissionsModal.querySelector('#assign_role_id');
            modalRoleId.value = roleId;

            // Optionally, you can fetch and pre-select existing permissions for the role here
        });
    </script>
</body>
</html>