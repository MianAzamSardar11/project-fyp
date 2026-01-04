<?php
include("auth.php");
include("config.php");

if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = [
        'type' => '',
        'message' => ''
    ];
}

$edit_team_member = null;

// Fetch team member data for editing
if (isset($_GET['edit'])) {
    $team_member_id = $_GET['edit'];
    $query = "SELECT * FROM team WHERE team_member_id = '$team_member_id'";
    $result = mysqli_query($conn, $query);
    $edit_team_member = mysqli_fetch_assoc($result);
}

// Add or Update Team Member
if (isset($_POST['add-team-member']) || isset($_POST['update-team-member'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $profession = mysqli_real_escape_string($conn, $_POST['profession']);
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/team/";
    $unique_name = time() . "_" . basename($image);
    $target_file = $target_dir . $unique_name;

    if ($image && move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $uploaded_file = $target_file;
    }

    if (isset($_POST['update-team-member']) && $_POST['team_member_id']) {
        $team_member_id = $_POST['team_member_id'];
        $set_clause = "team_member_name = '$name', team_member_profession = '$profession'";
        if ($image) {
            $set_clause .= ", team_member_image = '$uploaded_file'";
        }
        $query = "UPDATE team SET $set_clause WHERE team_member_id = '$team_member_id'";
    } else {
        $query = "INSERT INTO team (team_member_name, team_member_profession, team_member_image, team_member_status) VALUES ('$name', '$profession', '$uploaded_file', 1)";
    }

    if (mysqli_query($conn, $query)) {
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Operation completed successfully.'];
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to process request.'];
    }
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Delete Team Member
if (isset($_GET['delete'])) {
    $team_member_id = $_GET['delete'];
    $query = "DELETE FROM team WHERE team_member_id = '$team_member_id'";
    mysqli_query($conn, $query);
    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Team member deleted successfully.'];
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Toggle Status
if (isset($_GET['toggle_status'])) {
    $team_member_id = $_GET['toggle_status'];
    $query = "UPDATE team SET team_member_status = 1 - team_member_status WHERE team_member_id = '$team_member_id'";
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
    <title>Team Members</title>
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
                            <h4><?= $edit_team_member ? 'Edit Team Member' : 'Add Team Member' ?></h4>
                            <?php if ($_SESSION['alert']['message']): ?>
                                <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
                                    <?= $_SESSION['alert']['message'] ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php $_SESSION['alert'] = ['type' => '', 'message' => '']; ?>
                            <?php endif; ?>
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" name="team_member_id" value="<?= $edit_team_member['team_member_id'] ?? '' ?>">
                            <div class="card-body pt-1">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter name"
                                            value="<?= htmlspecialchars($edit_team_member['team_member_name'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="profession">Profession</label>
                                        <input type="text" name="profession" id="profession" class="form-control" placeholder="Enter profession"
                                            value="<?= htmlspecialchars($edit_team_member['team_member_profession'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" id="image" class="form-control">
                                        <?php if ($edit_team_member && $edit_team_member['team_member_image']): ?>
                                            <img src="<?= $edit_team_member['team_member_image'] ?>" alt="Image" width="50" class="mt-2">
                                        <?php endif; ?>
                                    </div>
                                </div>


                                <div class="d-grid">
                                    <button type="submit" name="<?= $edit_team_member ? 'update-team-member' : 'add-team-member' ?>"
                                        class="btn btn-orange ms-auto d-block w-25"><?= $edit_team_member ? 'Update' : 'Add' ?></button>
                                </div>

                            </div>
                        </form>
                    </div>
                </section>

                <section>
                    <div class="card">
                        <div class="card-header">Team Members List</div>
                        <div class="card-body">
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Profession</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM team");
                                    while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['team_member_name']) ?></td>
                                            <td><?= htmlspecialchars($row['team_member_profession']) ?></td>
                                            <td><img src="<?= $row['team_member_image'] ?>" alt="Image" width="50"></td>
                                            <td>
                                                <span class="badge bg-<?= $row['team_member_status'] ? 'success' : 'danger' ?>">
                                                    <?= $row['team_member_status'] ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </td>
                                            <td>


                                                <div class="dropdown">
                                                    <button class="btn btn-orange btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="?edit=<?= $row['team_member_id'] ?>">Edit</a>
                                                        <a class="dropdown-item" href="?delete=<?= $row['team_member_id'] ?>">Delete</a>
                                                        <a class="dropdown-item" href="?toggle_status=<?= $row['team_member_id'] ?>"> <?= $row['team_member_id'] == 1 ?  'Active' : 'Inactive' ?></a>
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