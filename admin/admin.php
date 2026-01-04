<?php
include("auth.php");
include("config.php");

if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = [
        'type' => '',
        'message' => ''
    ];
}

$edit_admin = null;

// Fetch admin data for editing
if (isset($_GET['edit'])) {
    $admin_id = $_GET['edit'];
    $query = "SELECT * FROM admin WHERE admin_id = '$admin_id'";
    $result = mysqli_query($conn, $query);
    $edit_admin = mysqli_fetch_assoc($result);
}

// Add or update admin
if (isset($_POST['add-admin']) || isset($_POST['update-admin'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $role = $_POST['role'];
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
    $image = $_FILES['image']['name'];
    $update_file = '';
    $target_dir = "uploads/admin/";
    $unique_name = time() . "_" . basename($image);
    $target_file = $target_dir . $unique_name;

    if ($image && move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $update_file = "admin_image = '$target_file'";
        if (isset($_POST['admin_id']) && $_POST['admin_id']) {
            $query = "SELECT admin_image FROM admin WHERE admin_id = '{$_POST['admin_id']}'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            if ($row && file_exists($row['admin_image'])) {
                unlink($row['admin_image']);
            }
        }
    }

    if (isset($_POST['update-admin']) && $_POST['admin_id']) {
        $admin_id = $_POST['admin_id'];
        $set_clause = "admin_name = '$name', admin_email = '$email', admin_mobile = '$mobile', admin_role = '$role'";
        if ($password) $set_clause .= ", admin_password = '$password'";
        if ($update_file) $set_clause .= ", $update_file";

        $query = "UPDATE admin SET $set_clause WHERE admin_id = '$admin_id'";
        if (mysqli_query($conn, $query)) {
            $_SESSION['alert'] = ['type' => 'success', 'message' => 'Admin updated successfully.'];
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to update admin.'];
        }
    } else {
        $query = "INSERT INTO admin (admin_name, admin_email, admin_password, admin_mobile, admin_image, admin_role, admin_status) VALUES ('$name', '$email', '$password', '$mobile', '$target_file', '$role', '1')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['alert'] = ['type' => 'success', 'message' => 'Admin added successfully.'];
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to add admin.'];
        }
    }

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Delete admin
if (isset($_GET['delete'])) {
    $admin_id = $_GET['delete'];
    $query = "SELECT admin_image FROM admin WHERE admin_id = '$admin_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row && file_exists($row['admin_image'])) {
        unlink($row['admin_image']);
    }

    $query = "DELETE FROM admin WHERE admin_id = '$admin_id'";
    if (mysqli_query($conn, $query)) {
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Admin deleted successfully.'];
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to delete admin.'];
    }

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Toggle admin status
if (isset($_GET['toggle_status'])) {
    $admin_id = $_GET['toggle_status'];
    $query = "SELECT admin_status FROM admin WHERE admin_id = '$admin_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $new_status = $row['admin_status'] == 1 ? 0 : 1;
        $query = "UPDATE admin SET admin_status = '$new_status' WHERE admin_id = '$admin_id'";
        mysqli_query($conn, $query);
    }

    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Admin status updated successfully.'];
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admins</title>
    <?php include("includes/css-links.php") ?>
</head>

<body>
    <div id="app">
        <?php include("./includes/sidebar.php") ?>
        <div id="main">
            <?php include("./includes/navbar.php") ?>
            <div class="main-content container-fluid">
                <section>
                    <div class="row">
                        <div class="col-12">
                            <div class="card p-2">
                                <div class="card-header pb-2 d-flex justify-content-between">
                                    <h4 class="card-title"><?= $edit_admin ? 'Edit Admin' : 'Add Admin' ?></h4>

                                    <?php if ($_SESSION['alert']['message']): ?>
                                        <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
                                            <?= $_SESSION['alert']['message'] ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        <?php $_SESSION['alert'] = ['type' => '', 'message' => '']; ?>
                                    <?php endif; ?>
                                </div>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="admin_id" value="<?= $edit_admin['admin_id'] ?? '' ?>">
                                    <div class="card-body pt-2">
                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="<?= htmlspecialchars($edit_admin['admin_name'] ?? '') ?>" required>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?= htmlspecialchars($edit_admin['admin_email'] ?? '') ?>" required>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label for="mobile">Mobile</label>
                                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile" value="<?= htmlspecialchars($edit_admin['admin_mobile'] ?? '') ?>" required>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <label for="role">Role</label>
                                                <select class="form-select" id="role" name="role" required>
                                                    <option value="" disabled selected>Select Service</option>

                                                    <option value="Admin" <?= isset($edit_admin) && $edit_admin['admin_role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                                                    <option value="User" <?= isset($edit_admin) && $edit_admin['admin_role'] == 'User' ? 'selected' : '' ?>>User</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <?php if (!$edit_admin): // Show password only during addition 
                                                ?>
                                                    <label for="password">Password</label>
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                                                <?php endif; ?>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <label for="image">Image</label>
                                                <input type="file" class="form-control" id="image" name="image">
                                                <?php if ($edit_admin && $edit_admin['admin_image']): ?>
                                                    <img src="<?= $edit_admin['admin_image'] ?>" alt="Admin Image" width="50" class="mt-2">
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-sm-12 my-3">
                                                <div class="d-grid">
                                                    <button class="btn btn-orange w-25 d-block ms-auto" name="<?= $edit_admin ? 'update-admin' : 'add-admin' ?>">
                                                        <?= $edit_admin ? 'Update' : 'Submit' ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h4>Admin List</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm" id="table1">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM admin");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <td><img src="<?= htmlspecialchars($row['admin_image']) ?>" alt="Image" width="50"></td>
                                            <td><?= htmlspecialchars($row['admin_name']) ?></td>
                                            <td><?= htmlspecialchars($row['admin_email']) ?></td>
                                            <td><?= htmlspecialchars($row['admin_mobile']) ?></td>
                                            <td><?= htmlspecialchars($row['admin_role']) ?></td>
                                            <td>
                                                <span class="badge <?= $row['admin_status'] == 1 ? 'bg-success' : 'bg-danger' ?>">
                                                    <?= $row['admin_status'] == 1 ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-orange btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="?edit=<?= $row['admin_id'] ?>">Edit</a>
                                                        <a class="dropdown-item" href="?delete=<?= $row['admin_id'] ?>">Delete</a>
                                                        <a class="dropdown-item" href="?toggle_status=<?= $row['admin_id'] ?>"> <?= $row['admin_status'] == 1 ? 'Deactivate' : 'Activate' ?></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <?php include("./includes/javascript-links.php") ?>
</body>

</html>