<?php
include("auth.php");
include("config.php");

if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = [
        'type' => '',
        'message' => ''
    ];
}

$edit_pricing = null;

// Fetch pricing data for editing
if (isset($_GET['edit'])) {
    $pricing_id = $_GET['edit'];
    $query = "SELECT * FROM pricing WHERE pricing_id = '$pricing_id'";
    $result = mysqli_query($conn, $query);
    $edit_pricing = mysqli_fetch_assoc($result);
}

// Add or update pricing based on button pressed
if (isset($_POST['add-pricing']) || isset($_POST['update-pricing'])) {
    $feature = $_POST['feature'];
    $category = $_POST['category'];

    if (isset($_POST['update-pricing']) && $_POST['pricing_id']) {
        // Update pricing in database
        $pricing_id = $_POST['pricing_id'];
        $query = "UPDATE pricing SET pricing_feature = '$feature', pricing_category = '$category' WHERE pricing_id = '$pricing_id'";
        if (mysqli_query($conn, $query)) {
            $_SESSION['alert'] = ['type' => 'success', 'message' => 'Congratulations! Operation completed successfully.'];
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to update pricing.'];
        }
    } else {
        // Add pricing to database
        $query = "INSERT INTO pricing (pricing_feature, pricing_category) VALUES ('$feature', '$category')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['alert'] = ['type' => 'success', 'message' => 'Congratulations! Operation completed successfully.'];
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error while adding pricing.'];
        }
    }

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Delete a pricing entry
if (isset($_GET['delete'])) {
    $pricing_id = $_GET['delete'];
    $query = "DELETE FROM pricing WHERE pricing_id = '$pricing_id'";
    if (mysqli_query($conn, $query)) {
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Congratulations! Operation completed successfully.'];
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to delete pricing.'];
    }

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Toggle pricing status
if (isset($_GET['toggle_status'])) {
    $pricing_id = $_GET['toggle_status'];
    $query = "SELECT pricing_status FROM pricing WHERE pricing_id = '$pricing_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $new_status = $row['pricing_status'] == 1 ? 0 : 1;
        $query = "UPDATE pricing SET pricing_status = '$new_status' WHERE pricing_id = '$pricing_id'";
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
    <title>Pricing</title>
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
                                    <h4 class="card-title"><?= $edit_pricing ? 'Edit Pricing' : 'Add Pricing' ?></h4>

                                    <?php if ($_SESSION['alert']['message']): ?>
                                        <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
                                            <?= $_SESSION['alert']['message'] ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        <?php $_SESSION['alert'] = ['type' => '', 'message' => '']; ?>
                                    <?php endif; ?>
                                </div>
                                <form action="" method="post">
                                    <input type="hidden" name="pricing_id" value="<?= $edit_pricing['pricing_id'] ?? '' ?>">
                                    <div class="card-body pt-2">
                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                <label for="feature">Feature</label>
                                                <input type="text" class="form-control" id="feature" name="feature" placeholder="Enter feature"
                                                    value="<?= htmlspecialchars($edit_pricing['pricing_feature'] ?? '') ?>" required>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label for="category">Category</label>
                                                <select class="form-select" id="category" name="category" required>
                                                    <option value="">Select Category</option>
                                                    <option value="Basic" <?= isset($edit_pricing['pricing_category']) && $edit_pricing['pricing_category'] == 'Basic' ? 'selected' : '' ?>>Basic</option>
                                                    <option value="Standard" <?= isset($edit_pricing['pricing_category']) && $edit_pricing['pricing_category'] == 'Standard' ? 'selected' : '' ?>>Standard</option>
                                                    <option value="Premium" <?= isset($edit_pricing['pricing_category']) && $edit_pricing['pricing_category'] == 'Premium' ? 'selected' : '' ?>>Premium</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-12 my-3">
                                                <div class="d-grid">
                                                    <button class="btn btn-orange w-25 d-block ms-auto" name="<?= $edit_pricing ? 'update-pricing' : 'add-pricing' ?>">
                                                        <?= $edit_pricing ? 'Update' : 'Submit' ?>
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
                            Pricing List
                        </div>
                        <div class="card-body">
                            <table class="table table-md" id="table1">
                                <thead>
                                    <tr>
                                        <th>Feature</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM pricing");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['pricing_feature']) ?></td>
                                            <td><?= htmlspecialchars($row['pricing_category']) ?></td>
                                            <td>
                                                <span class="badge <?= $row['pricing_status'] == 1 ? 'bg-success' : 'bg-danger' ?>">
                                                    <?= $row['pricing_status'] == 1 ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-orange btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="?edit=<?= $row['pricing_id'] ?>">Edit</a>
                                                        <a class="dropdown-item" href="?delete=<?= $row['pricing_id'] ?>">Delete</a>
                                                        <a class="dropdown-item" href="?toggle_status=<?= $row['pricing_id'] ?>"> <?= $row['pricing_status'] == 1 ? 'Inactive' : 'Active' ?></a>

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
