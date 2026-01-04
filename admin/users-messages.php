<?php
include("auth.php");
include("config.php");

if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = [
        'type' => '',
        'message' => ''
    ];
}

// Mark message as read
if (isset($_GET['mark_read'])) {
    $message_id = $_GET['mark_read'];
    $query = "UPDATE users_messages SET message_status = 'read' WHERE message_id = '$message_id'";
    if (mysqli_query($conn, $query)) {
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Message marked as read successfully!'];
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to mark message as read.'];
    }
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Mark all messages as read
if (isset($_POST['mark_all_read'])) {
    $query = "UPDATE users_messages SET message_status = 'read'";
    if (mysqli_query($conn, $query)) {
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'All messages marked as read!'];
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to mark all messages as read.'];
    }
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Fetch messages
$messages_query = "SELECT * FROM users_messages  ORDER BY `message_id` DESC";
$messages_result = mysqli_query($conn, $messages_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <?php include("includes/css-links.php") ?>
    <!-- Include Toastr (for notifications) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
</head>

<body>
    <div id="app">
        <?php include("./includes/sidebar.php") ?>
        <div id="main">
            <?php include("./includes/navbar.php") ?>
            <div class="main-content container-fluid">
                <!-- Messages Section -->
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h4>Messages</h4>
                        </div>
                        <div class="card-body">
                            <?php if ($_SESSION['alert']['message']): ?>
                                <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
                                    <?= $_SESSION['alert']['message'] ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php $_SESSION['alert'] = ['type' => '', 'message' => '']; ?>
                            <?php endif; ?>

                            <!-- Button to mark all messages as read -->
                            <form action="" method="POST">
                                <button type="submit" name="mark_all_read" class="btn btn-primary mb-3">Mark All as Read</button>
                            </form>

                            <table class="table table-md" id="table1">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($messages_result)) {
                                    ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['user_name']) ?></td>
                                            <td><?= htmlspecialchars($row['user_email']) ?></td>
                                            <td><?= htmlspecialchars($row['user_mobile']) ?></td>
                                            <td><button class="btn btn-outline-secondary btn-sm round" data-bs-toggle="modal" data-bs-target="#messageModal"
                                                    data-id="<?= $row['message_id'] ?>"
                                                    data-name="<?= htmlspecialchars($row['user_name']) ?>"
                                                    data-subject="<?= htmlspecialchars($row['user_mobile']) ?>"
                                                    data-message="<?= htmlspecialchars($row['user_message']) ?>">Message</button></td>
                                            <td>
                                                <span class="badge <?= $row['message_status'] == 'read' ? 'bg-success' : 'bg-danger' ?>">
                                                    <?= $row['message_status'] == 'read' ? 'Read' : 'Unread' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#messageModal"
                                                            data-id="<?= $row['message_id'] ?>"
                                                            data-name="<?= htmlspecialchars($row['user_name']) ?>"
                                                            data-message="<?= htmlspecialchars($row['user_message']) ?>">View Message</a>
                                                        <a class="dropdown-item" href="?mark_read=<?= $row['message_id'] ?>">Mark as Read</a>
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

    <!-- Message Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Message Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="modalUserName"></span></p>
                    <p><strong>Message:</strong></p>
                    <div id="modalMessage"></div>
                </div>
            </div>
        </div>
    </div>



    <?php include("./includes/javascript-links.php") ?>

    <script>
        // Modal functionality to show message details
        var messageModal = document.getElementById('messageModal');
        messageModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var messageId = button.getAttribute('data-id');
            var userName = button.getAttribute('data-name');
            var messageSubject = button.getAttribute('data-subject');
            var userMessage = button.getAttribute('data-message');

            // Update the modal's content
            document.getElementById('modalUserName').textContent = userName;
            document.getElementById('modalMessage').innerHTML = userMessage;
        });
    </script>

</body>

</html>