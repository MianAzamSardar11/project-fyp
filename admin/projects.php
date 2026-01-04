<?php
include("auth.php");
include("config.php");

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize session alert
if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = ['type' => '', 'message' => ''];
}

$edit_project = null;

// Fetch project data for editing
if (isset($_GET['edit'])) {
    $project_id = mysqli_real_escape_string($conn, $_GET['edit']);
    $query = "SELECT * FROM projects WHERE project_id = '$project_id'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error fetching project: " . mysqli_error($conn));
    }
    $edit_project = mysqli_fetch_assoc($result);
}

// Fetch clients and services
$clients = mysqli_query($conn, "SELECT client_id, client_name FROM clients WHERE client_status = 1");
$services = mysqli_query($conn, "SELECT service_id, service_name FROM services WHERE service_status = 1");

if (!$clients || !$services) {
    die("Error fetching clients or services: " . mysqli_error($conn));
}

// Handle Add/Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = mysqli_real_escape_string($conn, $_POST['client_id']);
    $service_id = mysqli_real_escape_string($conn, $_POST['service_id']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $project_price = mysqli_real_escape_string($conn, $_POST['project_price']);

    if (isset($_POST['update-project']) && $_POST['project_id']) {
        // Update project
        $project_id = mysqli_real_escape_string($conn, $_POST['project_id']);
        $query = "UPDATE projects 
                  SET client_name = '$client_id', service_name = '$service_id', service_category = '$category_id', project_price = '$project_price' 
                  WHERE project_id = '$project_id'";
        $result = mysqli_query($conn, $query);
        $message = $result ? 'Project updated successfully.' : 'Failed to update project.';
    } else {
        // Add project
        $query = "INSERT INTO projects (client_name, service_name, service_category, project_price) 
                  VALUES ('$client_id', '$service_id', '$category_id', '$project_price')";
        $result = mysqli_query($conn, $query);
        $message = $result ? 'Project added successfully.' : 'Error while adding project.';
    }

    // Set alert and redirect
    $_SESSION['alert'] = ['type' => $result ? 'success' : 'danger', 'message' => $message];
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Handle Delete Project
if (isset($_GET['delete'])) {
    $project_id = mysqli_real_escape_string($conn, $_GET['delete']);
    $query = "DELETE FROM projects WHERE project_id = '$project_id'";
    $result = mysqli_query($conn, $query);
    $_SESSION['alert'] = ['type' => $result ? 'success' : 'danger', 'message' => 'Project deleted successfully.'];
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Toggle Project Status
if (isset($_GET['toggle_status'])) {
    $project_id = mysqli_real_escape_string($conn, $_GET['toggle_status']);
    $query = "SELECT project_status FROM projects WHERE project_id = '$project_id'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error fetching project status: " . mysqli_error($conn));
    }
    $row = mysqli_fetch_assoc($result);
    $new_status = $row['project_status'] == 'completed' ? 'pending' : 'completed';

    $query = "UPDATE projects SET project_status = '$new_status' WHERE project_id = '$project_id'";
    mysqli_query($conn, $query);
    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Project status updated successfully.'];
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
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
                                <div class="card-header d-flex justify-content-between pb-2">
                                    <h4 class="card-title"><?= $edit_project ? 'Edit Project' : 'Add Project' ?></h4>

                                    <?php if ($_SESSION['alert']['message']): ?>
                                        <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
                                            <?= $_SESSION['alert']['message'] ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        <?php $_SESSION['alert'] = ['type' => '', 'message' => '']; ?>
                                    <?php endif; ?>
                                </div>
                                <form action="" method="post">
                                    <input type="hidden" name="project_id" value="<?= $edit_project['project_id'] ?? '' ?>">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                <label for="client_id">Client Name</label>
                                                <select class="form-select" id="client_id" name="client_id" required>
                                                    <option value="">Select Client</option>
                                                    <?php while ($client = mysqli_fetch_assoc($clients)): ?>
                                                        <option value="<?= $client['client_id'] ?>" <?= $edit_project && $edit_project['client_name'] == $client['client_id'] ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($client['client_name']) ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <label for="service_id">Service</label>
                                                <select class="form-select" id="service_id" name="service_id" required>
                                                    <option value="">Select Service</option>
                                                    <?php while ($service = mysqli_fetch_assoc($services)): ?>
                                                        <option value="<?= $service['service_id'] ?>" <?= $edit_project && $edit_project['service_name'] == $service['service_id'] ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($service['service_name']) ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label for="category_id">Service Category</label>
                                                <select class="form-select" id="category_id" name="category_id" required>
                                                    <option value="">Select Category</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label for="project_price">Price</label>
                                                <input type="number" class="form-control" id="project_price" name="project_price" placeholder="Enter project price"
                                                    value="<?= htmlspecialchars($edit_project['project_price'] ?? '') ?>" required>
                                            </div>
                                            <div class="d-grid my-3">
                                                <button class="btn btn-orange ms-auto w-25 d-block" name="<?= $edit_project ? 'update-project' : 'add-project' ?>">
                                                    <?= $edit_project ? 'Update' : 'Add' ?>
                                                </button>
                                            </div>
                                        </div>
                                </form>
                            </div>
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
                                    <th>Service</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = mysqli_query($conn, "SELECT 
                                        p.project_id, 
                                        p.project_price, 
                                        p.project_status, 
                                        s.service_name, 
                                        c.service_category_name, 
                                        cn.client_name 
                                    FROM projects p 
                                    LEFT JOIN clients cn ON p.client_name = cn.client_id 
                                    LEFT JOIN services s ON p.service_name = s.service_id 
                                    LEFT JOIN service_category c ON p.service_category = c.service_category_id");

                                while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?= $row['client_name'] ?></td>
                                        <td><?= $row['service_name'] ?></td>
                                        <td><?= $row['service_category_name'] ?></td>
                                        <td><?= $row['project_price'] ?></td>
                                        <td>
                                            <span class="badge <?= $row['project_status'] == 'completed' ? 'bg-success' : 'bg-danger' ?>">
                                                <?= $row['project_status'] == 'completed' ? 'Completed' : 'Pending' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-orange dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="?edit=<?= $row['project_id'] ?>">Edit</a>
                                                    <a class="dropdown-item" href="?delete=<?= $row['project_id'] ?>">Delete</a>
                                                    <a class="dropdown-item" href="?toggle_status=<?= $row['project_id'] ?>">
                                                        <?= $row['project_status'] == 'completed' ? 'Pending' : 'Completed' ?>
                                                    </a>
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

            <!-- Fetching categories dynamically -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const serviceSelect = document.getElementById("service_id");
                    const categorySelect = document.getElementById("category_id");

                    serviceSelect.addEventListener("change", function() {
                        const serviceId = this.value;
                        categorySelect.innerHTML = '<option value="">Select Category</option>';
                        if (serviceId) {
                            fetch("fetch_categories", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/x-www-form-urlencoded"
                                    },
                                    body: "service_id=" + serviceId
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.error) {
                                        console.error("Error fetching categories:", data.error);
                                        return;
                                    }

                                    data.forEach(category => {
                                        const option = document.createElement("option");
                                        option.value = category.service_category_id;
                                        option.textContent = category.service_category_name;
                                        categorySelect.appendChild(option);
                                    });
                                })
                                .catch(error => {
                                    console.error("Error fetching categories:", error);
                                });
                        }
                    });
                });
            </script>
        </div>
    </div>
    <?php include("includes/javascript-links.php") ?>
</body>

</html>