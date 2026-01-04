<?php
include("auth.php");
include("config.php");

if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = [
        'type' => '',
        'message' => ''
    ];
}

$edit_service = null;

// Fetch service data for editing
if (isset($_GET['edit'])) {
    $service_id = $_GET['edit'];
    $query = "SELECT * FROM services WHERE service_id = '$service_id'";
    $result = mysqli_query($conn, $query);
    $edit_service = mysqli_fetch_assoc($result);
}

//============== Add or update service according to button pressed ===========//
if (isset($_POST['add-service']) || isset($_POST['update-service'])) {
    $service_name = $_POST['service_name'];
    $service_icon = $_FILES['service_icon']['name'];
    $service_image = $_FILES['service_image']['name'];
    $service_details = $_POST['service_details'];
    $target_dir = "uploads/services/";

    // Validate image types for service_icon and service_image
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    $icon_ext = strtolower(pathinfo($service_icon, PATHINFO_EXTENSION));
    $image_ext = strtolower(pathinfo($service_image, PATHINFO_EXTENSION));

    if (
        !in_array($icon_ext, $allowed_extensions) && !empty($service_icon) ||
        !in_array($image_ext, $allowed_extensions) && !empty($service_image)
    ) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Only JPG and PNG files are allowed for icons and images.'];
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    }

    // Generate unique names for uploaded files
    $unique_icon_name = time() . "_icon_" . basename($service_icon);
    $unique_image_name = time() . "_image_" . basename($service_image);
    $target_icon_file = $target_dir . $unique_icon_name;
    $target_image_file = $target_dir . $unique_image_name;

    // Handle image uploads
    if (!empty($service_icon) && !move_uploaded_file($_FILES['service_icon']['tmp_name'], $target_icon_file)) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to upload service icon.'];
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    }

    if (!empty($service_image) && !move_uploaded_file($_FILES['service_image']['tmp_name'], $target_image_file)) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to upload service image.'];
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    }

    if (empty($service_details)) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Service details cannot be empty.'];
    } else {
        if (isset($_POST['update-service']) && $_POST['service_id']) {
            // Update existing service
            $service_id = $_POST['service_id'];

            // Fetch current icon and image for the service
            $query = "SELECT service_icon, service_image FROM services WHERE service_id = '$service_id'";
            $result = mysqli_query($conn, $query);
            $existing_service = mysqli_fetch_assoc($result);

            // Unlink old files if new ones are uploaded
            if (!empty($service_icon) && file_exists($existing_service['service_icon'])) {
                unlink($existing_service['service_icon']);
            }

            if (!empty($service_image) && file_exists($existing_service['service_image'])) {
                unlink($existing_service['service_image']);
            }

            // Prepare SQL update statement
            $set_clause = "service_name = '$service_name', service_details = '$service_details'";
            if (!empty($service_icon)) {
                $set_clause .= ", service_icon = '$target_icon_file'";
            }
            if (!empty($service_image)) {
                $set_clause .= ", service_image = '$target_image_file'";
            }

            $query = "UPDATE services SET $set_clause WHERE service_id = '$service_id'";
            if (mysqli_query($conn, $query)) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Service updated successfully!'];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to update service.'];
            }
        } else {
            // Add new service
            $query = "INSERT INTO services (service_name, service_icon, service_image, service_status, service_details) 
                      VALUES ('$service_name', '$target_icon_file', '$target_image_file', 1, '$service_details')";
            if (mysqli_query($conn, $query)) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Service added successfully!'];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error while adding service.'];
            }
        }
    }

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

//=========== Delete a service from the database =========//
if (isset($_GET['delete'])) {
    $service_id = $_GET['delete'];

    // Fetch current icon and image for the service
    $query = "SELECT service_icon, service_image FROM services WHERE service_id = '$service_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // Unlink the service icon
    if (!empty($row['service_icon']) && file_exists($row['service_icon'])) {
        unlink($row['service_icon']);
    }

    // Unlink the service image
    if (!empty($row['service_image']) && file_exists($row['service_image'])) {
        unlink($row['service_image']);
    }

    // Delete the service record from the database
    $query = "DELETE FROM services WHERE service_id = '$service_id'";
    if (mysqli_query($conn, $query)) {
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Service deleted successfully'];
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to delete service.'];
    }

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Toggle service status
if (isset($_GET['toggle_status'])) {
    $service_id = $_GET['toggle_status'];
    $query = "SELECT service_status FROM services WHERE service_id = '$service_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $new_status = $row['service_status'] == 1 ? 0 : 1;
        $query = "UPDATE services SET service_status = '$new_status' WHERE service_id = '$service_id'";
        mysqli_query($conn, $query);
    }

    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Service status updated successfully'];
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <?php include("includes/css-links.php") ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.0/tinymce.min.js"></script>
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
                                    <h4 class="card-title"><?= $edit_service ? 'Edit Service' : 'Add Service' ?></h4>

                                    <?php if ($_SESSION['alert']['message']): ?>
                                        <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
                                            <?= $_SESSION['alert']['message'] ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        <?php $_SESSION['alert'] = ['type' => '', 'message' => '']; ?>
                                    <?php endif; ?>
                                </div>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="service_id" value="<?= $edit_service['service_id'] ?? '' ?>">
                                    <div class="card-body pt-2">
                                        <div class="row">
                                            <div class="col-sm-4 mb-3">
                                                <label for="service_name">Service Name</label>
                                                <input type="text" class="form-control" id="service_name" name="service_name" placeholder="Enter here..."
                                                    value="<?= htmlspecialchars($edit_service['service_name'] ?? '') ?>" required>
                                            </div>
                                            <div class="col-sm-4 mb-3">
                                                <label for="service_icon">Service Icon</label>
                                                <input type="file" class="form-control" id="service_icon" name="service_icon" accept=".jpg,.jpeg,.png">
                                            </div>

                                            <div class="col-sm-4 mb-3">
                                                <label for="service_image">Service Image</label>
                                                <input type="file" class="form-control" id="service_image" name="service_image" accept=".jpg,.jpeg,.png">
                                            </div>


                                            <div class="col-sm-12 mb-3">
                                                <label for="service_details">Service Details</label>
                                                <textarea id="full" name="service_details"><?= htmlspecialchars($edit_service['service_details'] ?? '') ?></textarea>
                                            </div>

                                            <div class="col-sm-12 my-3">
                                                <div class="d-grid">
                                                    <button class="btn btn-orange w-25 d-block ms-auto" name="<?= $edit_service ? 'update-service' : 'add-service' ?>">
                                                        <?= $edit_service ? 'Update' : 'Submit' ?>
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
                <!-- Service List Section -->
                <section class="section">
                    <div class="card">
                        <div class="card-header">Service List</div>
                        <div class="card-body">
                            <table class="table table-md" id="table1">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM services");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <td> <a href="service-details.php?service_id=<?php echo $row['service_id'] ?>">
                                                    <img src="<?= $row['service_image'] ?>" height="50px" alt=""></a></td>
                                            <td><?= htmlspecialchars($row['service_name']) ?></td>

                                            <td>
                                                <span class="badge <?= $row['service_status'] == 1 ? 'bg-success' : 'bg-danger' ?>">
                                                    <?= $row['service_status'] == 1 ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-orange dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="?edit=<?= $row['service_id'] ?>">Edit</a>
                                                        <a class="dropdown-item" href="?delete=<?= $row['service_id'] ?>">Delete</a>
                                                        <a class="dropdown-item" href="?toggle_status=<?= $row['service_id'] ?>"> <?= $row['service_status'] == 1 ? 'Inactive' : 'Active' ?></a>
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

    <script>
        // Initialize TinyMCE editor
        tinymce.init({
            selector: '#full',
            menubar: false,
            plugins: 'lists link image',
            toolbar: 'undo redo | bold italic | bullist numlist | link image',
            setup: function(editor) {
                editor.on('change', function() {
                    // Whenever the content changes, update the hidden field
                    document.getElementById('service_details').value = tinymce.get('full').getContent();
                });
            }
        });
    </script>
</body>

</html>