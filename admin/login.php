<?php
// echo $newHashedPassword = password_hash('123', PASSWORD_DEFAULT);
// // Update in database
// exit;
session_start();
include("config.php");

// Login handler
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // Use MySQLi prepared statements
        $sql = "SELECT admin_id, admin_name, admin_email, admin_role, admin_image, admin_status, admin_password  FROM admin WHERE admin_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            if ($user['admin_status'] === 1) {

                if (password_verify($password, $user['admin_password'])) {
                    // Successful login
                    $_SESSION['admin_id'] = $user['admin_id'];
                    $_SESSION['admin_name'] = $user['admin_name'];
                    $_SESSION['admin_email'] = $user['admin_email'];
                    $_SESSION['admin_role'] = $user['admin_role'];
                    $_SESSION['admin_image'] = $user['admin_image'];
                    $_SESSION['admin_status'] = $user['admin_status'];

                    header('Location: index.php');
                    exit;
                } else {
                    // Incorrect password
                    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid credentials. Please try again.'];
                }
            } else {
                // Inactive account
                $_SESSION['alert'] = ['type' => 'warning', 'message' => 'Your account is inactive. Please contact the administrator.'];
            }
        } else {
            // Email not found
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Invalid credentials. Please try again.'];
        }
    } else {
        $_SESSION['alert'] = ['type' => 'warning', 'message' => 'Please fill in all fields.'];
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/app.css">
    <style>
        .btn-orange {
            background-color: orange !important;
            color: white;
        }

        .btn-orange:hover {
            background-color: rgba(220, 150, 20, 0.945);
            color: white;
        }
    </style>
</head>

<body>
    <div id="auth">

        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12 mx-auto">
                    <?php if (isset($_SESSION['alert'])): ?>
                        <div class="alert alert-<?= htmlspecialchars($_SESSION['alert']['type']) ?>">
                            <?= htmlspecialchars($_SESSION['alert']['message']) ?>
                        </div>
                        <?php unset($_SESSION['alert']); ?>
                    <?php endif; ?>


                    <div class="card pt-3">
                        <div class="card-body">

                            <div class="text-center mb-4">
                                <h3 class="fw-bold text-orange mb-3">Sociavo</h3>
                                <h3>Admin Login</h3>
                            </div>
                            <form action="" method="POST">
                                <div class="form-group position-relative has-icon-left mb-3">
                                    <label for="email">Email</label>
                                    <div class="position-relative">
                                        <input type="email" class="form-control" id="email" name="email" required>
                                        <div class="form-control-icon">
                                            <i data-feather="mail"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left mb-4 ">
                                    <div class="clearfix">
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <div class="form-control-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-orange w-75 d-block mx-auto fw-bold" name="login">Login</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="assets/js/feather-icons/feather.min.js"></script>
    <script src="assets/js/app.js"></script>

    <script src="assets/js/main.js"></script>
</body>

</html>

<script>
    // Automatically hide alert after 3 seconds
    document.addEventListener("DOMContentLoaded", function() {
        const alert = document.querySelector('.alert');
        if (alert) {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500); // Remove element after fade-out
            }, 3000);
        }
    });
</script>