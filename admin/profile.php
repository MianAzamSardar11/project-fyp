<?php
include('auth.php');
include('config.php');

// Fetch admin details
$admin_id = $_SESSION['admin_id']; // Assuming the admin ID is stored in session after login
$query = "SELECT `admin_id`, `admin_name`, `admin_email`, `admin_password`, `admin_mobile`, `admin_image`, `admin_role`, `admin_status` 
          FROM `admin` 
          WHERE `admin_id` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin_data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <?php include("includes/css-links.php"); ?>
</head>

<body>
    <div id="app">
        <?php include("includes/sidebar.php"); ?>
        <div id="main">
            <?php include("includes/navbar.php"); ?>

            <div class="main-content container-fluid">
                <div class="page-title">
                    <h3>Admin Profile</h3>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <img src="<?= htmlspecialchars($admin_data['admin_image'] ?? 'assets/images/avatar/default.png') ?>"
                                    alt="Admin Image"
                                    class="rounded-circle img-fluid"
                                    style="width: 150px;">
                                <h4 class="mt-3"><?= htmlspecialchars($admin_data['admin_name']) ?></h4>
                                <p class="text-muted"><?= htmlspecialchars($admin_data['admin_role']) ?></p>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Personal Information</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Name:</strong> <?= htmlspecialchars($admin_data['admin_name']) ?></p>
                                        <p><strong>Email:</strong> <?= htmlspecialchars($admin_data['admin_email']) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Mobile:</strong> <?= htmlspecialchars($admin_data['admin_mobile']) ?></p>
                                        <p><strong>Role:</strong> <?= htmlspecialchars($admin_data['admin_role']) ?></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php include("includes/javascript-links.php"); ?>
</body>

</html>