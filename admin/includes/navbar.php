<?php
// Include database connection
include('config.php');

// Fetch the last 5 unread messages
$messages_query = "SELECT * FROM `users_messages` 
                   WHERE `message_status` = 'unread' 
                   ORDER BY `message_id` DESC 
                   LIMIT 5";

$message_count = mysqli_num_rows(mysqli_query($conn, "SELECT `message_id` FROM `users_messages` WHERE `message_status` = 'unread'"));
$get_messages = $conn->query($messages_query);

// Check if query is successful
if (!$get_messages) {
    die("Query Error: " . $conn->error);
}

// Fetch messages as an associative array
$unread_messages = $get_messages->fetch_all(MYSQLI_ASSOC);

// Count unread messages
$unread_count = count($unread_messages);
?>

<nav class="navbar navbar-header navbar-expand navbar-light">
    <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
    <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav d-flex align-items-center navbar-light ms-auto">
            <li class="dropdown">
                <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <div class="d-lg-inline-block me-3">
                        <i data-feather="mail"></i>
                        <?php if ($message_count > 0): ?>
                            <span class="badge bg-danger position-absolute" style="top:-10px"><?php echo $message_count; ?></span>
                        <?php endif; ?>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-large">
                    <h6 class="py-2 px-4">Unread Messages</h6>
                    <ul class="list-group rounded-none">
                        <?php if (!empty($unread_messages)): ?>
                            <?php foreach ($unread_messages as $message): ?>
                                <li class="list-group-item border-0 align-items-start">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="text-white bg-success round p-1"><i data-feather="message-square"></i></span>
                                        <h6 class="text-bold"><?php echo htmlspecialchars($message['user_name']); ?></h6>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item border-0 align-items-start">
                                <div>
                                    <p class="text-xs">No unread messages</p>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <div class="px-4 py-2">
                        <a href="users-messages.php" class="btn btn-primary btn-sm w-100">View All</a>
                    </div>
                </div>
            </li>

            <li class="dropdown">
                <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <div class="avatar me-1">
                        <img src="<?= htmlspecialchars($_SESSION['admin_image'] ?? 'assets/images/avatar/avatar-s-1.png') ?>" alt="Admin Image">
                    </div>
                    <div class="d-none d-md-block d-lg-inline-block">Hi, <?= $_SESSION['admin_name'] ?></div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="profile.php"><i data-feather="user"></i> Account</a>
                    <a class="dropdown-item" href="users-messages.php"><i data-feather="mail"></i> Messages</a>
                    <a class="dropdown-item" href="settings.php"><i data-feather="settings"></i> Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php"><i data-feather="log-out"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>