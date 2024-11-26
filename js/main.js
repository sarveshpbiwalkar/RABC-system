// Load Users
function loadUsers() {
    $.ajax({
        url: "api/users/get_users.php",
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
                                <button class="btn btn-warning btn-sm" onclick="editUser(${user.id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Delete</button>
                            </td>
                        </tr>`;
            });
            table += "</tbody></table>";
            $("#usersTable").html(table);
        }
    });
}

// On Page Load
$(document).ready(function () {
    loadUsers();
});


function showSuccess(message) {
    toastr.success(message);
}

function showError(message) {
    toastr.error(message);
}
