<?php
// users.php
require_once 'user_crud.php';

// Handle delete operation
if (isset($_GET['delete_user'])) {
    $delete_user = $_GET['delete_user'];
    if ($userCRUD->delete($delete_user)) {
        $message = "User deleted successfully!";
        $message_type = "success";
    } else {
        $message = "Error deleting user!";
        $message_type = "danger";
    }
}

// Get parameters for pagination, search, and sort
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = isset($_GET['per_page']) ? max(5, intval($_GET['per_page'])) : 10;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sort_field = isset($_GET['sort']) ? $_GET['sort'] : 'username';
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

// Toggle sort order if clicking on the same field
if (isset($_GET['sort']) && $_GET['sort'] === $sort_field) {
    $sort_order = ($_GET['order'] === 'ASC') ? 'DESC' : 'ASC';
}

// Get users with pagination, search, and sort
$result = $userCRUD->readAll($page, $per_page, $search, $sort_field, $sort_order);
$users = $result['users'];
$total_rows = $result['total_rows'];
$total_pages = $result['total_pages'];
$current_page = $result['current_page'];

// Build query string for pagination links
$query_params = [];
if (!empty($search)) $query_params['search'] = $search;
if ($sort_field !== 'username') $query_params['sort'] = $sort_field;
if ($sort_order !== 'ASC') $query_params['order'] = $sort_order;
if ($per_page != 10) $query_params['per_page'] = $per_page;

$query_string = !empty($query_params) ? '&' . http_build_query($query_params) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>User Management</h1>
            <p>Manage system users</p>
        </div>

        <?php if (isset($message)): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="card">
           
            <div class="card-body">
               

                <!-- Search and Filter Form -->
                <div class="search-filter">
                    <form method="GET" action="" class="search-form">
                        <div class="search-group">
                            <label for="search">Search Users</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="<?php echo htmlspecialchars($search); ?>" 
                                   placeholder="Search by username, name, or email...">
                        </div>
                        
                        <div class="search-group">
                            <label for="per_page">Results per page</label>
                            <select class="form-control" id="per_page" name="per_page">
                                <option value="5" <?php echo $per_page == 5 ? 'selected' : ''; ?>>5</option>
                                <option value="10" <?php echo $per_page == 10 ? 'selected' : ''; ?>>10</option>
                                <option value="20" <?php echo $per_page == 20 ? 'selected' : ''; ?>>20</option>
                                <option value="50" <?php echo $per_page == 50 ? 'selected' : ''; ?>>50</option>
                            </select>
                        </div>
                        
                        <div class="search-actions">
                            <button type="submit" class="btn btn-primary">🔎 Search</button>
                            <a href="users.php" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>
                </div>

                <!-- Results Info -->
                <?php if (!empty($search) || $total_rows > 0): ?>
                <div class="results-info">
                    <?php if (!empty($search)): ?>
                        <p>Found <?php echo $total_rows; ?> user(s) matching "<?php echo htmlspecialchars($search); ?>"</p>
                    <?php else: ?>
                        <p>Showing <?php echo count($users); ?> of <?php echo $total_rows; ?> total users</p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
  <a href="../index.php" class="btn btn-success mb-3">🏠 Home</a>
                <a href="create_user.php" class="btn btn-primary mb-3">👩‍💼 Add New User</a>

                  <a href="../manage_access.php" class="btn btn-warning mb-3">🔐 Create User Access</a>
                
                
                <?php if (empty($users)): ?>
                    <div class="text-center">
                        <p>No users found. <a href="create_user.php">Add your first user</a></p>
                    </div>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="<?php echo $sort_field == 'username' ? 'sortable ' . strtolower($sort_order) : 'sortable'; ?>">
                                    <a href="?page=<?php echo $page; ?>&sort=username&order=<?php echo $sort_field == 'username' && $sort_order == 'ASC' ? 'DESC' : 'ASC'; echo $query_string; ?>">
                                        Username
                                    </a>
                                </th>
                                <th class="<?php echo $sort_field == 'lastname' ? 'sortable ' . strtolower($sort_order) : 'sortable'; ?>">
                                    <a href="?page=<?php echo $page; ?>&sort=lastname&order=<?php echo $sort_field == 'lastname' && $sort_order == 'ASC' ? 'DESC' : 'ASC'; echo $query_string; ?>">
                                        Last Name
                                    </a>
                                </th>
                                <th class="<?php echo $sort_field == 'firstname' ? 'sortable ' . strtolower($sort_order) : 'sortable'; ?>">
                                    <a href="?page=<?php echo $page; ?>&sort=firstname&order=<?php echo $sort_field == 'firstname' && $sort_order == 'ASC' ? 'DESC' : 'ASC'; echo $query_string; ?>">
                                        First Name
                                    </a>
                                </th>
                                <th>Middle Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($user['username']); ?></strong></td>
                                <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                                <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                                <td><?php echo htmlspecialchars($user['middlename']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="edit_user.php?username=<?php echo urlencode($user['username']); ?>" class="btn btn-warning">📝 Edit</a>
                                        <a href="users.php?delete_user=<?php echo urlencode($user['username']); echo $query_string; ?>" 
                                           class="btn btn-danger" 
                                           onclick="return confirm('Are you sure you want to delete this user?')">🗑 Delete</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <?php if ($total_pages > 1): ?>
                    <div class="pagination">
                        <!-- First Page -->
                        <?php if ($current_page > 1): ?>
                            <a href="?page=1<?php echo $query_string; ?>">First</a>
                        <?php else: ?>
                            <span class="disabled">First</span>
                        <?php endif; ?>

                        <!-- Previous Page -->
                        <?php if ($current_page > 1): ?>
                            <a href="?page=<?php echo $current_page - 1; echo $query_string; ?>">Previous</a>
                        <?php else: ?>
                            <span class="disabled">Previous</span>
                        <?php endif; ?>

                        <!-- Page Numbers -->
                        <?php
                        $start_page = max(1, $current_page - 2);
                        $end_page = min($total_pages, $current_page + 2);
                        
                        for ($i = $start_page; $i <= $end_page; $i++): ?>
                            <?php if ($i == $current_page): ?>
                                <span class="current"><?php echo $i; ?></span>
                            <?php else: ?>
                                <a href="?page=<?php echo $i; echo $query_string; ?>"><?php echo $i; ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <!-- Next Page -->
                        <?php if ($current_page < $total_pages): ?>
                            <a href="?page=<?php echo $current_page + 1; echo $query_string; ?>">Next</a>
                        <?php else: ?>
                            <span class="disabled">Next</span>
                        <?php endif; ?>

                        <!-- Last Page -->
                        <?php if ($current_page < $total_pages): ?>
                            <a href="?page=<?php echo $total_pages; echo $query_string; ?>">Last</a>
                        <?php else: ?>
                            <span class="disabled">Last</span>
                        <?php endif; ?>
                    </div>

                    <div class="text-center mt-2">
                        <small>Page <?php echo $current_page; ?> of <?php echo $total_pages; ?></small>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>