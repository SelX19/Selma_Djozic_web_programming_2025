let AdminUserService = {
    init: function () {
        AdminUserService.loadUsers();

        // Form submission handler
        document.getElementById("addOrEditUserForm").addEventListener("submit", function (e) {
            e.preventDefault();
            const user = Object.fromEntries(new FormData(e.target).entries());

            const isEditing = !!document.getElementById("addOrEditUserForm").dataset.editingId;
            if (isEditing) {
                user.id = document.getElementById("addOrEditUserForm").dataset.editingId;
                AdminUserService.updateUser(user);
            } else {
                AdminUserService.createUser(user);
            }

            AdminUserService.closeModal();
        });
    },

    loadUsers: function () {
        RestClient.get("users", function (users) {
            console.log("Fetched users:", users);
            const tbody = document.querySelector("tbody");
            tbody.innerHTML = "";

            if (!users || users.length === 0) {
                console.warn("No users found or empty array");
            }

            users.forEach(user => {
                const row = document.createElement("tr");
                row.innerHTML = `
    <td>${user.id}</td>
    <td>${user.first_name} ${user.last_name}</td>
    <td>
        <button class="edit-btn" onclick='AdminUserService.openEditModal("${encodeURIComponent(JSON.stringify(user))}")'>Edit</button>
        <button class="delete-btn" onclick="AdminUserService.deleteUser(${user.id})">Delete</button>
    </td>
`;
                tbody.appendChild(row);
            });
        });
    },

    createUser: function (user) {
        RestClient.post("users", user, function () {
            toastr.success("User added");
            AdminUserService.loadUsers();
        }, function (res) {
            toastr.error(res.message || "Error adding user");
        });
    },

    updateUser: function (user) {
        RestClient.patch(`users/${user.id}`, user, function () {
            toastr.success("User updated");
            AdminUserService.loadUsers();
        }, function (res) {
            toastr.error(res.message || "Error updating user");
        });
    },

    deleteUser: function (id) {
        if (!confirm("Are you sure you want to delete this user?")) return;

        RestClient.delete(`users/${id}`, null, function () {
            toastr.success("User deleted");
            AdminUserService.loadUsers();
        }, function (res) {
            toastr.error(res.message || "Error deleting user");
        });
    },

    openEditModal: function (userStr) {
        document.querySelector("#addOrEditUserModal").classList.remove("hidden");

        if (userStr) {
            const user = JSON.parse(decodeURIComponent(userStr));
            document.getElementById("form-title").innerText = "Edit User";
            document.getElementById("first_name").value = user.first_name || "";
            document.getElementById("last_name").value = user.last_name || "";
            document.getElementById("email").value = user.email || "";
            document.getElementById("specialization").value = user.specialization || "";
            document.getElementById("experience").value = user.experience || "";
            document.getElementById("bio").value = user.bio || "";
            document.getElementById("rating").value = user.rating || "";
            document.getElementById("addOrEditUserForm").dataset.editingId = user.id;
            document.getElementById("form-submit-btn").innerText = "Update";
        } else {
            document.getElementById("form-title").innerText = "Add User";
            document.getElementById("form-submit-btn").innerText = "Add";
            document.getElementById("addOrEditUserForm").reset();
            delete document.getElementById("addOrEditUserForm").dataset.editingId;
        }
    },

    closeModal: function () {
        document.querySelector("#addOrEditUserModal").classList.add("hidden");
        document.getElementById("addOrEditUserForm").reset();
        delete document.getElementById("addOrEditUserForm").dataset.editingId;
    }
};
