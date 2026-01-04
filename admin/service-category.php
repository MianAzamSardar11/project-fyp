<?php
include("auth.php");
include("config.php");

if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = [
        'type' => '',
        'message' => ''
    ];
}

$edit_category = null;

// Fetch sub-category data for editing
if (isset($_GET['edit'])) {
    $category_id = $_GET['edit'];
    $query = "SELECT * FROM service_category WHERE service_category_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_category = $result->fetch_assoc();
}

// Add or update sub-category
if (isset($_POST['add-category']) || isset($_POST['update-category'])) {
    $name = trim($_POST['name']);
    $service_id = $_POST['service_id'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'] ?? null;

    if (empty($name) || empty($service_id) || empty($price)) {
        $_SESSION['alert'] = ['type' => 'warning', 'message' => 'Warning! All fields are required.'];
    } else {
        if (isset($_POST['update-category'])) {
            $query = "UPDATE service_category 
                      SET service_category_name = ?, service_id = ?, service_category_price = ? 
                      WHERE service_category_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sidi", $name, $service_id, $price, $category_id);
        } else {
            $query = "INSERT INTO service_category 
                      (service_category_name, service_id, service_category_price, service_category_status) 
                      VALUES (?, ?, ?, 1)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sid", $name, $service_id, $price);
        }

        if ($stmt->execute()) {
            $_SESSION['alert'] = ['type' => 'success', 'message' => 'Operation completed successfully.'];
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error while processing the request.'];
        }
    }
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Delete sub-category
if (isset($_GET['delete'])) {
    $sub_category_id = $_GET['delete'];
    $query = "DELETE FROM service_category WHERE service_category_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $sub_category_id);

    if ($stmt->execute()) {
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Sub-category deleted successfully.'];
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error deleting sub-category.'];
    }
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Toggle sub-category status
if (isset($_GET['toggle_status'])) {
    $sub_category_id = $_GET['toggle_status'];
    $query = "UPDATE service_category 
              SET service_category_status = NOT service_category_status 
              WHERE service_category_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $sub_category_id);

    if ($stmt->execute()) {
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Status updated successfully.'];
    }
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Category </title>
    <?php include("includes/css-links.php"); ?>
</head>

<body>
    <div id="app">
        <?php include("./includes/sidebar.php"); ?>
        <div id="main">
            <?php include("./includes/navbar.php"); ?>
            <div class="main-content container-fluid">
                <section>
                    <div class="row">
                        <div class="col-12">
                            <div class="card p-2">
                                <div class="card-header pb-2 d-flex justify-content-between">
                                    <h4 class="card-title"><?= $edit_category ? 'Edit Category' : 'Add Category' ?></h4>
                                    <?php if ($_SESSION['alert']['message']): ?>
                                        <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
                                            <?= $_SESSION['alert']['message'] ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        <?php $_SESSION['alert'] = ['type' => '', 'message' => '']; ?>
                                    <?php endif; ?>
                                </div>
                                <form action="" method="post">
                                    <input type="hidden" name="category_id" value="<?= htmlspecialchars($edit_category['service_category_id'] ?? '') ?>">
                                    <div class="card-body pt-2">
                                        <div class="row">
                                            <div class="col-sm-4 mb-3">
                                                <label for="name">Category Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter here..."
                                                    value="<?= htmlspecialchars($edit_category['service_category_name'] ?? '') ?>" required>
                                            </div>
                                            <div class="col-sm-4 mb-3">
                                                <label for="service_id">Service</label>
                                                <select class="form-select" id="service_id" name="service_id" required>
                                                    <option value="" disabled selected>Select Service</option>
                                                    <?php
                                                    $services = mysqli_query($conn, "SELECT service_id, service_name FROM services WHERE service_status = 1");
                                                    while ($service = mysqli_fetch_assoc($services)) {
                                                        $selected = isset($edit_category) && $edit_category['service_id'] == $service['service_id'] ? 'selected' : '';
                                                        echo "<option value=\"{$service['service_id']}\" $selected>{$service['service_name']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-sm-4 mb-3">
                                                <label for="price">Price</label>
                                                <input type="number" class="form-control" id="price" name="price" placeholder="Enter price..."
                                                    value="<?= htmlspecialchars($edit_category['service_category_price'] ?? '') ?>" required>
                                            </div>
                                            <div class="col-sm-12">
                                                <button class="btn btn-orange w-25 ms-auto d-block" name="<?= $edit_category ? 'update-category' : 'add-category' ?>">
                                                    <?= $edit_category ? 'Update' : 'Submit' ?>
                                                </button>
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
                            <h4>Service Categories</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-md" id="table1">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Service</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "
                                    SELECT 
                                        sc.service_category_id, 
                                        sc.service_category_name, 
                                        sc.service_category_price, 
                                        sc.service_category_status, 
                                        s.service_name 
                                    FROM service_category sc 
                                    JOIN services s ON sc.service_id = s.service_id
                                ";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['service_category_name']) ?></td>
                                            <td><?= htmlspecialchars($row['service_name']) ?></td>
                                            <td><?= htmlspecialchars($row['service_category_price']) ?></td>
                                            <td>
                                                <span class="badge <?= $row['service_category_status'] == 1 ? 'bg-success' : 'bg-danger' ?>">
                                                    <?= $row['service_category_status'] == 1 ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </td>
                                            <td>

                                                <div class="dropdown">
                                                    <button class="btn btn-orange dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="?edit=<?= $row['service_category_id'] ?>">Edit</a>
                                                        <a class="dropdown-item" href="?delete=<?= $row['service_category_id'] ?>">Delete</a>
                                                        <a class="dropdown-item" href="?toggle_status=<?= $row['service_category_id'] ?>"> <?= $row['service_category_status'] == 1 ? 'Inactive' : 'Active' ?></a>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <?php include("./includes/javascript-links.php"); ?>
</body>

</html>