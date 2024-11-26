<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBAC Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/css/dashboard.css"> <!-- Link to the new CSS file -->
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Admin Dashboard</h1>
        <nav class="nav nav-pills justify-content-center mb-4">
            <a class="nav-link active" href="dashboard.php">Users</a>
            <a class="nav-link" href="roles.php">Roles</a>
            <a class="nav-link" href="logout.php">Logout</a>
        </nav>

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUser Modal">Add New User</button>

        <div id="usersTable" class="table-responsive"></div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUser Modal" tabindex="-1" aria-labelledby="addUser ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUser ModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUser Form">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role_id" class="form-label">Role ID</label>
                            <input type="number" class="form-control" id="role_id" name="role_id" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        // Load Users
        function loadUsers() {
            $.ajax({
                url: "get_users.php",
                method: "GET",
                success: function (data) {
                    let users = JSON.parse(data);
                    let table = `<table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead><tbody>`;
                    users.forEach(user => {
                        table += `<tr>
                                    <td>${user.id}</td>
                                    <td>${user.username}</td>
                                    <td>${user.email}</td>
                                    <td>${user.role_name}</td>
                                    <td>${user.status}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" onclick="editUser (${user.id})">Edit</button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteUser (${user.id})">Delete</button>
                                    </td>
                                </tr>`;
                    });
                    table += `</tbody></table>`;
                    $('#usersTable').html(table);
                }
            });
        }

        // Call loadUsers on page load
        $(document).ready(function() {
            loadUsers();

            // Handle form submission for adding a new user
            $('#addUser Form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "add_user.php",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        toastr.success('User  added successfully!');
                        $('#addUser Form')[0].reset();
                        $('#addUser Modal').modal('hide');
                        loadUsers();
                    },
                    error: function() {
                        toastr.error('Error adding user.');
                    }
                });
            });
        });
    </script>
</body>
</html>