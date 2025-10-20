<?php
include 'db.php';
// We must select `id` (for links) AND `user_id` (for display)
$sql = "SELECT id, user_id, last_name, first_name, middle_name, suffix, specialists, phone, email, photo 
        FROM doctor_info 
        ORDER BY last_name, first_name";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 1200px; }
        .card-header { background-color: #007bff; color: white; }
        .table img.doctor-photo {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ddd;
        }
        .table-responsive { margin-top: 20px; }
        .action-icons a { margin: 0 5px; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-user-md"></i> Doctor Management</h4>
                <a href="create.php" class="btn btn-light">
                    <i class="fas fa-plus-circle"></i> Add New Doctor
                </a>
            </div>
            <div class="card-body">
                <?php if (isset($_GET['msg'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($_GET['msg']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Doctor ID</th> <th>Specialty</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $photo_path = "../../uploads/" . (!empty($row['photo']) ? $row['photo'] : 'default.png');
                            ?>
                                <tr>
                                    <td>
                                        <img src="<?php echo $photo_path; ?>" alt="Doctor Photo" class="doctor-photo">
                                    </td>
                                    <td>
                                        <?php 
                                            echo htmlspecialchars($row['last_name']) . ", " . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['middle_name']);
                                            if (!empty($row['suffix'])) {
                                                echo ", " . htmlspecialchars($row['suffix']);
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['specialists']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td class="action-icons">
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete.php?id=<?php echo $row['id']; ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           title="Delete"
                                           onclick="return confirm('Are you sure you want to delete this doctor? This action cannot be undone.');">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>No doctors found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>