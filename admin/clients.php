<?php
include("auth.php");
include("config.php");

if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = [
        'type' => '',
        'message' => ''
    ];
}

$edit_client = null;

// Fetch client data for editing
if (isset($_GET['edit'])) {
    $client_id = $_GET['edit'];
    $query = "SELECT * FROM clients WHERE client_id = '$client_id'";
    $result = mysqli_query($conn, $query);
    $edit_client = mysqli_fetch_assoc($result);
}

//============== Add or update client according to button pressed ===========//
if (isset($_POST['add-client']) || isset($_POST['update-client'])) {
    $name = $_POST['name'];
    $logo = $_FILES['logo']['name'];
    $update_file = '';
    $target_dir = "uploads/clients/";
    $unique_name = time() . "_" . basename($logo);
    $target_file = $target_dir . $unique_name;

    if ($logo && move_uploaded_file($_FILES['logo']['tmp_name'], $target_file)) {
        $update_file = "client_image = '$target_file'";
        if (isset($_POST['client_id']) && $_POST['client_id']) {
            $query = "SELECT client_image FROM clients WHERE client_id = '{$_POST['client_id']}'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            if ($row && file_exists($row['client_image'])) {
                unlink($row['client_image']);
            }
        }
    }

    if (isset($_POST['update-client']) && $_POST['client_id']) {
        //============= Update client from database ================//
        $client_id = $_POST['client_id'];
        $set_clause = "client_name = '$name'";
        if ($update_file) $set_clause .= ", $update_file";

        $query = "UPDATE clients SET $set_clause WHERE client_id = '$client_id'";
        if (mysqli_query($conn, $query)) {
            $_SESSION['alert'] = ['type' => 'success', 'message' => 'Congratulations! Operation completed successfully'];
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to update client.'];
        }
    } else {
        //============== Add client into database =================//
        $query = "INSERT INTO clients (client_name, client_image, client_status) VALUES ('$name', '$target_file', '1')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['alert'] = ['type' => 'success', 'message' => 'Congratulations! Operation completed successfully'];
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error while adding client.'];
        }
    }

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

//=========== Delete a client from the database =========//
if (isset($_GET['delete'])) {
    $client_id = $_GET['delete'];
    $query = "SELECT client_image FROM clients WHERE client_id = '$client_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row && file_exists($row['client_image'])) {
        unlink($row['client_image']);
    }

    $query = "DELETE FROM clients WHERE client_id = '$client_id'";
    if (mysqli_query($conn, $query)) {
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Congratulations! Operation completed successfully'];
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to delete client.'];
    }

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Toggle client status
if (isset($_GET['toggle_status'])) {
    $client_id = $_GET['toggle_status'];
    $query = "SELECT client_status FROM clients WHERE client_id = '$client_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $new_status = $row['client_status'] == 1 ? 0 : 1;
        $query = "UPDATE clients SET client_status = '$new_status' WHERE client_id = '$client_id'";
        mysqli_query($conn, $query);
    }

    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Congratulations! Operation completed successfully'];
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>
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
                                    <h4 class="card-title"><?= $edit_client ? 'Edit Client' : 'Add Client' ?></h4>

                                    <?php if ($_SESSION['alert']['message']): ?>
                                        <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
                                            <?= $_SESSION['alert']['message'] ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        <?php $_SESSION['alert'] = ['type' => '', 'message' => '']; ?>
                                    <?php endif; ?>
                                </div>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="client_id" value="<?= $edit_client['client_id'] ?? '' ?>">
                                    <div class="card-body pt-2">
                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter here..."
                                                    value="<?= htmlspecialchars($edit_client['client_name'] ?? '') ?>">
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label for="logo">Logo</label>
                                                <input type="file" class="form-control" id="logo" name="logo">
                                                <?php if ($edit_client && $edit_client['client_image']): ?>
                                                    <img src="<?= $edit_client['client_image'] ?>" alt="Logo" width="50" class="mt-2">
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-sm-12 my-3">
                                                <div class="d-grid">
                                                    <button class="btn btn-orange w-25 d-block ms-auto" name="<?= $edit_client ? 'update-client' : 'add-client' ?>">
                                                        <?= $edit_client ? 'Update' : 'Submit' ?>
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
                            Client List
                        </div>
                        <div class="card-body">
                            <table class="table table-md" id="table1">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Logo</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM clients");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['client_name']) ?></td>
                                            <td><img src="<?= htmlspecialchars($row['client_image']) ?>" alt="Logo" width="50"></td>
                                            <td>
                                                <span class="badge <?= $row['client_status'] == 1 ? 'bg-success' : 'bg-danger' ?>">
                                                    <?= $row['client_status'] == 1 ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-orange dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="?edit=<?= $row['client_id'] ?>">Edit</a>
                                                        <a class="dropdown-item" href="?delete=<?= $row['client_id'] ?>">Delete</a>
                                                        <a class="dropdown-item" href="?toggle_status=<?= $row['client_id'] ?>"> <?= $row['client_status'] == 1 ? 'Inactive' : 'Active' ?></a>
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