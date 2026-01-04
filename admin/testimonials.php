<?php
include("auth.php");
include("config.php");

if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = [
        'type' => '',
        'message' => ''
    ];
}

$edit_testimonial = null;

// Fetch testimonial data for editing
if (isset($_GET['edit'])) {
    $testimonial_id = $_GET['edit'];
    $query = "SELECT * FROM testimonials WHERE testimonial_id = '$testimonial_id'";
    $result = mysqli_query($conn, $query);
    $edit_testimonial = mysqli_fetch_assoc($result);
}

// Add or Update Testimonial
if (isset($_POST['add-testimonial']) || isset($_POST['update-testimonial'])) {
    $client_name = mysqli_real_escape_string($conn, $_POST['client_name']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $stars = intval($_POST['stars']);
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/testimonials/";
    $unique_name = time() . "_" . basename($image);
    $target_file = $target_dir . $unique_name;

    if ($image && move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $uploaded_file = $target_file;
    }

    if (isset($_POST['update-testimonial']) && $_POST['testimonial_id']) {
        $testimonial_id = $_POST['testimonial_id'];
        $set_clause = "testimonial_client_name = '$client_name', testimonial_message = '$message', testimonial_stars = $stars";
        if ($image) {
            $set_clause .= ", testimonial_client_image = '$uploaded_file'";
        }
        $query = "UPDATE testimonials SET $set_clause WHERE testimonial_id = '$testimonial_id'";
    } else {
        $query = "INSERT INTO testimonials (testimonial_client_name, testimonial_message, testimonial_stars, testimonial_client_image, testimonial_status) VALUES ('$client_name', '$message', $stars, '$uploaded_file', 1)";
    }

    if (mysqli_query($conn, $query)) {
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Operation completed successfully.'];
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to process request.'];
    }
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Delete Testimonial
if (isset($_GET['delete'])) {
    $testimonial_id = $_GET['delete'];
    $query = "DELETE FROM testimonials WHERE testimonial_id = '$testimonial_id'";
    mysqli_query($conn, $query);
    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Testimonial deleted successfully.'];
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Toggle Status
if (isset($_GET['toggle_status'])) {
    $testimonial_id = $_GET['toggle_status'];
    $query = "UPDATE testimonials SET testimonial_status = 1 - testimonial_status WHERE testimonial_id = '$testimonial_id'";
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
    <title>Testimonials</title>
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
                            <h4><?= $edit_testimonial ? 'Edit Testimonial' : 'Add Testimonial' ?></h4>
                            <?php if ($_SESSION['alert']['message']): ?>
                                <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
                                    <?= $_SESSION['alert']['message'] ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php $_SESSION['alert'] = ['type' => '', 'message' => '']; ?>
                            <?php endif; ?>
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" name="testimonial_id" value="<?= $edit_testimonial['testimonial_id'] ?? '' ?>">
                            <div class="card-body pt-1">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="client_name">Client Name</label>
                                        <input type="text" name="client_name" id="client_name" class="form-control" placeholder="Enter client name"
                                            value="<?= htmlspecialchars($edit_testimonial['testimonial_client_name'] ?? '') ?>" required>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="stars">Stars</label>
                                        <select name="stars" id="stars" class="form-select" required>
                                            <option disabled selected>Choose here</option>
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <option value="<?= $i ?>" <?= (isset($edit_testimonial['testimonial_stars']) && $edit_testimonial['testimonial_stars'] == $i) ? 'selected' : '' ?>>
                                                    <?= $i ?> Star<?= $i > 1 ? 's' : '' ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" id="image" class="form-control">
                                        <?php if ($edit_testimonial && $edit_testimonial['testimonial_client_image']): ?>
                                            <img src="<?= $edit_testimonial['testimonial_client_image'] ?>" alt="Client Image" width="50" class="mt-2">
                                        <?php endif; ?>
                                    </div>


                                    <div class="col-md-12 mb-3">
                                        <label for="message">Message</label>
                                        <textarea name="message" rows="5" id="message" class="form-control" placeholder="Enter testimonial message" required><?= htmlspecialchars($edit_testimonial['testimonial_message'] ?? '') ?></textarea>
                                    </div>

                                </div>

                                <div class="d-grid">
                                    <button type="submit" name="<?= $edit_testimonial ? 'update-testimonial' : 'add-testimonial' ?>" class="btn btn-orange w-25 ms-auto d-block">
                                        <?= $edit_testimonial ? 'Update' : 'Add' ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>

                <section>
                    <div class="card">
                        <div class="card-header">Testimonials List</div>
                        <div class="card-body">
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <th>Client Name</th>
                                        <th>Message</th>
                                        <th>Stars</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM testimonials");
                                    while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['testimonial_client_name']) ?></td>
                                            <td><?= htmlspecialchars($row['testimonial_message']) ?></td>
                                            <td><?= str_repeat('⭐', $row['testimonial_stars']) ?></td>
                                            <td><img src="<?= $row['testimonial_client_image'] ?>" alt="Client Image" width="50"></td>
                                            <td>
                                                <span class="badge bg-<?= $row['testimonial_status'] ? 'success' : 'danger' ?>">
                                                    <?= $row['testimonial_status'] ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </td>
                                            <td>

                                                <div class="dropdown">
                                                    <button class="btn btn-orange btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="?edit=<?= $row['testimonial_id'] ?>">Edit</a>
                                                        <a class="dropdown-item" href="?delete=<?= $row['testimonial_id'] ?>">Delete</a>
                                                        <a class="dropdown-item" href="?toggle_status=<?= $row['testimonial_id'] ?>"> <?= $row['testimonial_id'] == 1 ?  'Active' : 'Inactive' ?></a>
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
</body>

</html>