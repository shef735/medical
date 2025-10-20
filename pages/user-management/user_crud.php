<?php
// user_crud.php
require_once 'config.php';

class UserCRUD {
    private $conn;
    private $table;
    
    public function __construct($connection, $table_name) {
        $this->conn = $connection;
        $this->table = $table_name;
    }
    
    // Create new user
    public function create($username, $lastname, $firstname, $middlename, $password, $email) {
        $username = mysqli_real_escape_string($this->conn, $username);
        $lastname = mysqli_real_escape_string($this->conn, $lastname);
        $firstname = mysqli_real_escape_string($this->conn, $firstname);
        $middlename = mysqli_real_escape_string($this->conn, $middlename);
        $email = mysqli_real_escape_string($this->conn, $email);
        
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO {$this->table} (username, lastname, firstname, middlename, password, email) 
                VALUES ('$username', '$lastname', '$firstname', '$middlename', '$hashed_password', '$email')";
        
        if (mysqli_query($this->conn, $sql)) {
            return mysqli_insert_id($this->conn);
        } else {
            return false;
        }
    }
    
    // Read all users with pagination, search, and sort
    public function readAll($page = 1, $per_page = 10, $search = '', $sort_field = 'username', $sort_order = 'ASC') {
        // Validate sort field to prevent SQL injection
        $allowed_fields = ['username', 'lastname', 'firstname', 'email'];
        $sort_field = in_array($sort_field, $allowed_fields) ? $sort_field : 'username';
        $sort_order = $sort_order === 'DESC' ? 'DESC' : 'ASC';
        
        $offset = ($page - 1) * $per_page;
        
        // Build WHERE clause for search
        $where_clause = '';
        if (!empty($search)) {
            $search = mysqli_real_escape_string($this->conn, $search);
            $where_clause = "WHERE username LIKE '%$search%' OR lastname LIKE '%$search%' OR firstname LIKE '%$search%' OR email LIKE '%$search%'";
        }
        
        // Get total count for pagination
        $count_sql = "SELECT COUNT(*) as total FROM {$this->table} $where_clause";
        $count_result = mysqli_query($this->conn, $count_sql);
        $total_rows = mysqli_fetch_assoc($count_result)['total'];
        $total_pages = ceil($total_rows / $per_page);
        
        // Get paginated data (exclude password for security)
        $sql = "SELECT username, lastname, firstname, middlename, email FROM {$this->table} $where_clause 
                ORDER BY $sort_field $sort_order 
                LIMIT $offset, $per_page";
        
        $result = mysqli_query($this->conn, $sql);
        
        $users = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $users[] = $row;
            }
        }
        
        return [
            'users' => $users,
            'total_rows' => $total_rows,
            'total_pages' => $total_pages,
            'current_page' => $page,
            'per_page' => $per_page
        ];
    }
    
    // Read single user by username
    public function read($username) {
        $username = mysqli_real_escape_string($this->conn, $username);
        $sql = "SELECT username, lastname, firstname, middlename, email FROM {$this->table} WHERE username = '$username'";
        $result = mysqli_query($this->conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }
    
    // Update user (with optional password update)
    public function update($username, $lastname, $firstname, $middlename, $email, $password = null) {
        $username = mysqli_real_escape_string($this->conn, $username);
        $lastname = mysqli_real_escape_string($this->conn, $lastname);
        $firstname = mysqli_real_escape_string($this->conn, $firstname);
        $middlename = mysqli_real_escape_string($this->conn, $middlename);
        $email = mysqli_real_escape_string($this->conn, $email);
        
        $sql = "UPDATE {$this->table} 
                SET lastname = '$lastname', firstname = '$firstname', middlename = '$middlename', email = '$email'";
        
        // Update password if provided
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql .= ", password = '$hashed_password'";
        }
        
        $sql .= " WHERE username = '$username'";
        
        return mysqli_query($this->conn, $sql);
    }
    
    // Delete user
    public function delete($username) {
        $username = mysqli_real_escape_string($this->conn, $username);
        $sql = "DELETE FROM {$this->table} WHERE username = '$username'";
        return mysqli_query($this->conn, $sql);
    }
    
    // Check if username already exists
    public function usernameExists($username, $exclude_user = null) {
        $username = mysqli_real_escape_string($this->conn, $username);
        $sql = "SELECT username FROM {$this->table} WHERE username = '$username'";
        
        if ($exclude_user) {
            $exclude_user = mysqli_real_escape_string($this->conn, $exclude_user);
            $sql .= " AND username != '$exclude_user'";
        }
        
        $result = mysqli_query($this->conn, $sql);
        return mysqli_num_rows($result) > 0;
    }
    
    // Check if email already exists
    public function emailExists($email, $exclude_user = null) {
        $email = mysqli_real_escape_string($this->conn, $email);
        $sql = "SELECT username FROM {$this->table} WHERE email = '$email'";
        
        if ($exclude_user) {
            $exclude_user = mysqli_real_escape_string($this->conn, $exclude_user);
            $sql .= " AND username != '$exclude_user'";
        }
        
        $result = mysqli_query($this->conn, $sql);
        return mysqli_num_rows($result) > 0;
    }
    
    // Verify user credentials (for login)
    public function verifyCredentials($username, $password) {
        $username = mysqli_real_escape_string($this->conn, $username);
        $sql = "SELECT password FROM {$this->table} WHERE username = '$username'";
        $result = mysqli_query($this->conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            return password_verify($password, $user['password']);
        }
        
        return false;
    }
}

// Define user table mapping
$user_table = $my_tables . "_resources.user_data";

// Initialize UserCRUD
$userCRUD = new UserCRUD($conn, $user_table);
?>