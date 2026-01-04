<?php
include("auth.php");
include("config.php");

if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = [
        'type' => '',
        'message' => ''
    ];
}

$edit_counter = null;

// Fetch counter data for editing
if (isset($_GET['edit'])) {
    $counter_id = $_GET['edit'];
    $query = "SELECT * FROM counter WHERE counter_id = '$counter_id'";
    $result = mysqli_query($conn, $query);
    $edit_counter = mysqli_fetch_assoc($result);
}

// Handle form submission for updating counter data
if (isset($_POST['update-counter']) && $_POST['counter_id']) {
    $counter_id = $_POST['counter_id'];
    $clients = $_POST['clients'];
    $projects = $_POST['projects'];
    $team = $_POST['team'];
    $hours_support = $_POST['hours_support'];

    $query = "UPDATE counter SET clients = '$clients', projects = '$projects', team = '$team', hours_support = '$hours_support' WHERE counter_id = '$counter_id'";
    if (mysqli_query($conn, $query)) {
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Congratulations! Operation completed successfully.'];
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to update counter.'];
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
    <title>Counter Management</title>
    <?php include("includes/css-links.php") ?>
</head>

<body>
    <div id="app">
        <?php include("./includes/sidebar.php") ?>
        <div id="main">
            <?php include("./includes/navbar.php") ?>
            <div class="main-content container-fluid">
                <section class="section">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Counter</h4>
                            <?php if ($_SESSION['alert']['message']): ?>
                                <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
                                    <?= $_SESSION['alert']['message'] ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php $_SESSION['alert'] = ['type' => '', 'message' => '']; ?>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered text-center">

                                <tr class="table-primary">
                                    <th>Clients</th>
                                    <th>Projects</th>
                                    <th>Team</th>
                                    <th>Hours Support</th>
                                    <th>Actions</th>
                                </tr>


                                <?php
                                $result = mysqli_query($conn, "SELECT * FROM counter");
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr class="fs-4">
                                        <td><?= htmlspecialchars($row['clients']) ?></td>
                                        <td><?= htmlspecialchars($row['projects']) ?></td>
                                        <td><?= htmlspecialchars($row['team']) ?></td>
                                        <td><?= htmlspecialchars($row['hours_support']) ?></td>
                                        <td>
                                            <a class="btn btn-orange btn-sm" href="?edit=<?= $row['counter_id'] ?>">Edit</a>
                                        </td>
                                    </tr>
                                <?php } ?>

                            </table>
                        </div>
                    </div>
                </section>

                <?php if ($edit_counter): ?>
                    <section>
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Counter</h4>
                            </div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <input type="hidden" name="counter_id" value="<?= $edit_counter['counter_id'] ?>">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="clients">Clients</label>
                                            <input type="number" class="form-control" id="clients" name="clients" value="<?= htmlspecialchars($edit_counter['clients']) ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="projects">Projects</label>
                                            <input type="number" class="form-control" id="projects" name="projects" value="<?= htmlspecialchars($edit_counter['projects']) ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="team">Team</label>
                                            <input type="number" class="form-control" id="team" name="team" value="<?= htmlspecialchars($edit_counter['team']) ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="hours_support">Hours Support</label>
                                            <input type="number" class="form-control" id="hours_support" name="hours_support" value="<?= htmlspecialchars($edit_counter['hours_support']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" name="update-counter" class="btn btn-orange w-25 ms-auto d-block">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include("./includes/javascript-links.php") ?>
</body>

</html>