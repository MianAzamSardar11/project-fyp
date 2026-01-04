<?php
include("auth.php");
include("config.php");

if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = [
        'type' => '',
        'message' => ''
    ];
}

$edit_portfolio_item = null;

// Fetch all services for the dropdown
$services = mysqli_query($conn, "SELECT service_id, service_name FROM services");

// Fetch categories dynamically via AJAX
if (isset($_GET['fetch_categories'])) {
    $service_id = $_GET['fetch_categories'];
    $categories_query = "SELECT service_category_id, service_category_name FROM service_category WHERE service_id = '$service_id'";
    $categories_result = mysqli_query($conn, $categories_query);
    $categories = [];
    while ($row = mysqli_fetch_assoc($categories_result)) {
        $categories[] = $row;
    }
    echo json_encode($categories);
    exit;
}


// Fetch portfolio data for editing
if (isset($_GET['edit'])) {
    $portfolio_id = $_GET['edit'];
    $query = "SELECT * FROM portfolio WHERE portfolio_id = '$portfolio_id'";
    $result = mysqli_query($conn, $query);
    $edit_portfolio_item = mysqli_fetch_assoc($result);
}

if (isset($_POST['add-portfolio-item']) || isset($_POST['update-portfolio-item'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $url = mysqli_real_escape_string($conn, $_POST['url']);
    $service_id = $_POST['service_id'];
    $category_id = $_POST['category_id'];
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/portfolio/";
    $unique_name = time() . "_" . basename($image);
    $target_file = $target_dir . $unique_name;

    if ($image && move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $uploaded_file = $target_file;
    }

    if (isset($_POST['update-portfolio-item']) && $_POST['portfolio_id']) {
        $portfolio_id = $_POST['portfolio_id'];
        $set_clause = "portfolio_title = '$title', portfolio_url = '$url', service_id = '$service_id', service_category_id = '$category_id'";
        if ($image) {
            $set_clause .= ", portfolio_image = '$uploaded_file'";
        }
        $query = "UPDATE portfolio SET $set_clause WHERE portfolio_id = '$portfolio_id'";
    } else {
        $query = "INSERT INTO portfolio (portfolio_title, portfolio_url, service_id, service_category_id, portfolio_image, portfolio_status) VALUES ('$title', '$url', '$service_id', '$category_id', '$uploaded_file', 1)";
    }

    if (mysqli_query($conn, $query)) {
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Operation completed successfully.'];
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to process request.'];
    }
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}


// Delete Portfolio Item
if (isset($_GET['delete'])) {
    $portfolio_id = $_GET['delete'];
    $query = "DELETE FROM portfolio WHERE portfolio_id = '$portfolio_id'";
    mysqli_query($conn, $query);
    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Portfolio item deleted successfully.'];
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Toggle Status
if (isset($_GET['toggle_status'])) {
    $portfolio_id = $_GET['toggle_status'];
    $query = "UPDATE portfolio SET portfolio_status = 1 - portfolio_status WHERE portfolio_id = '$portfolio_id'";
    mysqli_query($conn, $query);
    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Status updated successfully.'];
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio </title>
    <?php include("includes/css-links.php"); ?>
</head>

<body>
    <div id="app">
        <?php include("includes/sidebar.php"); ?>
        <div id="main">
            <?php include("includes/navbar.php"); ?>
            <div class="main-content container-fluid">
                <section>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4><?= $edit_portfolio_item ? 'Edit Portfolio Item' : 'Add Portfolio Item' ?></h4>
                            <?php if ($_SESSION['alert']['message']): ?>
                                <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
                                    <?= $_SESSION['alert']['message'] ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php $_SESSION['alert'] = ['type' => '', 'message' => '']; ?>
                            <?php endif; ?>
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" name="portfolio_id" value="<?= $edit_portfolio_item['portfolio_id'] ?? '' ?>">
                            <div class="card-body pt-1">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter portfolio title"
                                            value="<?= htmlspecialchars($edit_portfolio_item['portfolio_title'] ?? '') ?>" required>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="service_id">Service</label>
                                        <select name="service_id" id="service_id" class="form-select" required>
                                            <option value="">Select Service</option>
                                            <?php while ($service = mysqli_fetch_assoc($services)): ?>
                                                <option value="<?= $service['service_id'] ?>" <?= isset($edit_portfolio_item) && $edit_portfolio_item['service_id'] == $service['service_id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($service['service_name']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="category_id">Category</label>
                                        <select name="category_id" id="category_id" class="form-select" required>
                                            <option value="">Select Category</option>
                                            <?php if (isset($edit_portfolio_item)): ?>
                                                <?php
                                                $categories = mysqli_query($conn, "SELECT service_category_id, service_category_name FROM service_category WHERE service_id = '{$edit_portfolio_item['service_id']}'");
                                                while ($category = mysqli_fetch_assoc($categories)): ?>
                                                    <option value="<?= $category['service_category_id'] ?>" <?= $edit_portfolio_item['service_category_id'] == $category['service_category_id'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($category['service_category_name']) ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>


                                    <div class="col-md-4 mb-3">
                                        <label for="url">URL</label>
                                        <input type="text" name="url" id="url" class="form-control" placeholder="Enter portfolio URL"
                                            value="<?= htmlspecialchars($edit_portfolio_item['portfolio_url'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" id="image" class="form-control">
                                        <?php if ($edit_portfolio_item && $edit_portfolio_item['portfolio_image']): ?>
                                            <img src="<?= $edit_portfolio_item['portfolio_image'] ?>" alt="Image" width="50" class="mt-2">
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" name="<?= $edit_portfolio_item ? 'update-portfolio-item' : 'add-portfolio-item' ?>"
                                        class="btn btn-orange ms-auto d-block w-25"><?= $edit_portfolio_item ? 'Update' : 'Add' ?></button>
                                </div>

                            </div>
                        </form>
                    </div>
                </section>

                <section>
                    <div class="card">
                        <div class="card-header">Portfolio Items List</div>
                        <div class="card-body">
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Service</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT p.*, s.service_name, c.service_category_name FROM portfolio p 
                               LEFT JOIN services s ON p.service_id = s.service_id
                               LEFT JOIN service_category c ON p.service_category_id = c.service_category_id");

                                    while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><img src="<?= $row['portfolio_image'] ?>" alt="Image" width="50"></td>
                                            <td><?= htmlspecialchars($row['portfolio_title']) ?></td>
                                            <td><?= htmlspecialchars($row['service_name']) ?></td>
                                            <td><?= htmlspecialchars($row['service_category_name']) ?></td>
                                            <td>
                                                <span class="badge bg-<?= $row['portfolio_status'] ? 'success' : 'danger' ?>">
                                                    <?= $row['portfolio_status'] ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-orange btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="?edit=<?= $row['portfolio_id'] ?>">Edit</a>
                                                        <a class="dropdown-item" href="?delete=<?= $row['portfolio_id'] ?>">Delete</a>
                                                        <a class="dropdown-item" href="?toggle_status=<?= $row['portfolio_id'] ?>">
                                                            <?= $row['portfolio_status'] ? 'Deactivate' : 'Activate' ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <?php include("includes/javascript-links.php"); ?>

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



</body>

</html>